<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;
use App\Http\Requests\StoreHouseRequest;

class HouseController extends Controller
{
    public function show()
    {
        $houses = House::all();

        return response()->json([
            'status' => 'success',
            'data' => $houses
        ]);
    }

    public function showDetail($id)
    {
        $houseResidentsData = House::getHouseDetail($id);

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
            'data' => $house
        ], 201);
    }

    public function update(StoreHouseRequest $request, $id)
    {
        $house = House::findOrFail($id);
        $house->update($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => $house
        ]);
    }
}
