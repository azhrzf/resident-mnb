<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class HouseResident extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'house_id',
        'resident_id',
        'date_of_entry',
        'date_of_exit',
    ];

    public function house()
    {
        return $this->belongsTo(House::class, 'house_id', 'id');
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'house_resident_id', 'id');
    }

    public static function assignToHouse($houseResidentData)
    {
        return self::create($houseResidentData);
    }

    public static function updateHouseResident($data)
    {
        $residentId = $data['resident_id'];
        $newDateOfEntry = Carbon::parse($data['date_of_entry']);
        $newDateOfExit = isset($data['date_of_exit']) ? Carbon::parse($data['date_of_exit']) : null;

        $existingHouseResidents = self::where('resident_id', $residentId)->get();

        foreach ($existingHouseResidents as $houseResident) {
            $existingDateOfEntry = Carbon::parse($houseResident->date_of_entry);
            $existingDateOfExit = Carbon::parse($houseResident->date_of_exit);

            if (
                $newDateOfEntry->between($existingDateOfEntry, $existingDateOfExit) ||
                ($newDateOfExit && $newDateOfExit->between($existingDateOfEntry, $existingDateOfExit))
            ) {
                throw new \Exception('Resident is already assigned to a house within the specified date range');
            }
        }

        $latestHouseResident = $existingHouseResidents->last();
        $latestHouseId = $latestHouseResident->house_id;

        if ($latestHouseId == $data['house_id']) {
            $latestHouseResident->update($data);
        } else {
            self::create($data);
        }
    }
}
