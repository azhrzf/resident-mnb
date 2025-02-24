<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\House;
use App\Models\HouseResident;
use App\Models\Payment;
use App\Http\Controllers\ImageController;

class Resident extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'id_card_photo',
        'resident_status',
        'phone_number',
        'marital_status',
    ];

    public function houseResidents()
    {
        return $this->hasMany(HouseResident::class, 'resident_id', 'id');
    }

    public function getResidentWithLastestHouse()
    {
        return $this->with(['houseResidents' => function ($query) {
            $query->latest('date_of_exit')->limit(1);
        }, 'houseResidents.house'])->get();
    }

    public function createWithHouseResident(array $data)
    {
        $imageHelper = new ImageController();
        $data['id_card_photo'] = $imageHelper->storeImage($data['id_card_photo'], $data['full_name'], 'id-card-photos');

        $resident = self::create($data);
        $houseResident = new HouseResident();

        $houseResidentData = [
            'resident_id' => $resident->id,
            'house_id' => $data['house_id'],
            'date_of_entry' => $data['date_of_entry'],
            'date_of_exit' => $data['date_of_exit'] ?? null,
        ];

        if (!empty($data['house_id'])) {
            $houseResident->assignToHouse($houseResidentData);
        }

        return $resident;
    }

    public function updateWithHouseResident(array $data, $id)
    {
        $resident = self::find($id);
        $imageHelper = new ImageController();

        $houseResident = new HouseResident();
        $data['resident_id'] = $id;
        $houseResident->updateHouseResident($data);

        if (!empty($data['id_card_photo'])) {
            $data['id_card_photo'] = $imageHelper->replaceImage(
                $data['id_card_photo'],
                $resident->id_card_photo,
                $data['full_name'],
                'id-card-photos'
            );
        }

        $resident->update($data);

        return $resident;
    }

    public function getResidentDetail($id)
    {
        $resident = Resident::with([
            'houseResidents.house',
            'houseResidents.payments.feeType'
        ])->where('id', $id)->first();

        return $resident;
    }
}
