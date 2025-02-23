<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resident;
use App\Http\Controllers\ImageController;
use App\Http\Requests\StoreResidentRequest;

class ResidentController extends Controller
{
    public function index()
    {
        $resident = new Resident();
        $residentsWithLatestHouse = $resident->getResidentWithLastestHouse();

        return response()->json([
            'status' => 'success',
            'data' => $residentsWithLatestHouse
        ]);
    }

    public function showDetail($id)
    {
        $resident = new Resident();
        $houseResidentsData = $resident->getResidentDetail($id);

        return response()->json([
            'status' => 'success',
            'data' => $houseResidentsData
        ]);
    }

    public function store(StoreResidentRequest $request)
    {
        $resident = new Resident();
        $storeResident = $resident->createWithHouseResident($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => $storeResident->load('houseResidents')
        ], 201);
    }

    public function update(StoreResidentRequest $request, $id)
    {
        $resident = new Resident();
        $updateResident = $resident->updateWithHouseResident($request->validated(), $id);

        return response()->json([
            'status' => 'success',
            'data' => $updateResident->load('houseResidents')
        ]);
    }

    public function showImage($filename)
    {
        $imageHelpher = new ImageController();
        return $imageHelpher->getImage($filename, 'id-card-photos');
    }
}
