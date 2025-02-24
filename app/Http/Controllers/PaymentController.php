<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payment = new Payment();

        $dates = $request->query('dates', []);
        $type = $request->query('type');

        $data = $payment->getPaymentsByDates($dates, $type);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function showDetail($id)
    {
        $payment = Payment::with([
            'feeType',
            'houseResident.resident',
            'houseResident.house'
        ])->where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $payment
        ]);
    }

    public function store(StorePaymentRequest $request)
    {
        $validatedData = $request->validated();
        $houseResidentId = $validatedData['house_resident_id'];
        $paymentDate = $validatedData['payment_date'];
        $feeTypeId = $validatedData['fee_type_id'];

        $payment = new Payment();
        $existingPayment = $payment->checkPaymentExist($houseResidentId, $paymentDate, $feeTypeId);

        if ($existingPayment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pembayaran sudah ada pada tanggal tersebut',
            ], 400);
        }

        $createPayment = Payment::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran berhasil dibuat',
            'data' => $createPayment
        ], 201);
    }

    public function updatePaidStatus($id)
    {
        $payment = Payment::find($id);
        $payment->payment_status = 'paid';
        $payment->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran berhasil diupdate',
            'data' => $payment
        ]);
    }
}
