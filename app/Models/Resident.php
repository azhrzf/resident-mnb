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

    public static function createWithHouseResident(array $data)
    {
        $data['id_card_photo'] = ImageController::storeImage($data['id_card_photo'], $data['full_name'], 'id-card-photos');
        $resident = self::create($data);

        $houseResidentData = [
            'resident_id' => $resident->id,
            'house_id' => $data['house_id'],
            'date_of_entry' => $data['date_of_entry'],
            'date_of_exit' => $data['date_of_exit'],
        ];

        if (!empty($data['house_id'])) {
            HouseResident::assignToHouse($houseResidentData);
        }

        return $resident;
    }

    public static function updateWithHouseResident(array $data, $id)
    {
        $resident = self::find($id);
        HouseResident::updateHouseResident($data);

        if (!empty($data['id_card_photo'])) {
            $data['id_card_photo'] = ImageController::replaceImage(
                $data['id_card_photo'],
                $resident->id_card_photo,
                $data['full_name'],
                'id-card-photos'
            );
        }

        $resident->update($data);

        return $resident;
    }

    public static function getResidentDetail($id)
    {
        $resident = Resident::with([
            'houseResidents.house', 
            'houseResidents.payments.feeType'
        ])->where('id', $id)->first();
    
        return $resident;
    }
}
