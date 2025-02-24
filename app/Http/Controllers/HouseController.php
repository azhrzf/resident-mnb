<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;
use App\Models\HouseResident;
use App\Http\Requests\StoreHouseRequest;

class HouseController extends Controller
{
    public function index()
    {
        $houses = House::all();

        return response()->json([
            'status' => 'success',
            'data' => $houses
        ]);
    }

    public function showDetail($id)
    {
        $house = new House();
        $houseResidentsData = $house->getHouseDetail($id);

        return response()->json([
            'status' => 'success',
            'data' => $houseResidentsData
        ]);
    }

    public function store(StoreHouseRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['occupancy_status'] = 'vacant';

        $house = House::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Rumah berhasil dibuat',
            'data' => $house
        ], 201);
    }

    public function update(StoreHouseRequest $request, $id)
    {
        $house = House::findOrFail($id);
        $house->update($request->validated());

        $houseResident = new HouseResident();
        $occupancyStatus = $request->validated()['occupancy_status'];

        if ($occupancyStatus == 'vacant') {
            $houseResident->setVacantHouse($id);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Rumah berhasil diupdate',
            'data' => $house
        ]);
    }
}
