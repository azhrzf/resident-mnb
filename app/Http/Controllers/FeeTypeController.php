<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeeType;

class FeeTypeController extends Controller
{
    public function index()
    {
        $feeTypes = FeeType::all();

        return response()->json([
            'status' => 'success',
            'data' => $feeTypes
        ]);
    }
}
