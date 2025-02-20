<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Http\Controllers\ImageController;
use App\Http\Requests\StoreResidentRequest;

class ResidentController extends Controller
{
    public function show()
    {
        $residents = Resident::all();

        return response()->json([
            'status' => 'success',
            'data' => $residents
        ]);
    }

    public function showDetail($id)
    {
        $houseResidentsData = Resident::getResidentDetail($id);

        return response()->json([
            'status' => 'success',
            'data' => $houseResidentsData
        ]);
    }

    public function store(StoreResidentRequest $request)
    {
        $resident = Resident::createWithHouseResident($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => $resident->load('houseResidents')
        ], 201);
    }

    public function update(StoreResidentRequest $request, $id)
    {
        $resident = Resident::updateWithHouseResident($request->validated(), $id);

        return response()->json([
            'status' => 'success',
            'data' => $resident->load('houseResidents')
        ]);
    }

    public function showImage($filename)
    {
        return ImageController::getImage($filename, 'id-card-photos');
    }
}
