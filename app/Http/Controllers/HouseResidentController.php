<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use App\Models\HouseResident;

class HouseResidentController extends Controller
{
    public function index()
    {
        $houseResident = HouseResident::with([
            'house',
            'resident',
        ])->orderBy('updated_at', 'desc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $houseResident
        ]);
    }

    public function showDetail($id)
    {
        $houseResident = HouseResident::with([
            'house',
            'resident',
            'payments'
        ])->where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $houseResident
        ]);
    }
}
