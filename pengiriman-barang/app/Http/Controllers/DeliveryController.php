<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function search(Request $request)
    {
        $search = $request->resi;

        if (!$search) {
            return response()->json(['error' => 'No resi provided'], 400);
        }

        $delivery = Delivery::with(
            'deliveryEvents.deliveryStatus',
            'deliveryEvents.checkpoints.districts',
            'deliveryEvents.users',
        ) // kalau kamu punya relasi
            ->where('delivery_code', $search)
            ->first();

        if (!$delivery) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            //status di ambil dari last deliveryEvent (deliveryEvent terbaru)
            'status' => $delivery->deliveryEvents->isNotEmpty() ? $delivery->deliveryEvents->last()->deliveryStatus->delivery_status : 'Status tidak tersedia',
            // 'status' => $delivery->deliveryEvents->last()->deliveryStatus->delivery_status,

            // 'lokasi' => $delivery->deliveryEvents->last()->checkpoints->checkpoint_name,
            'lokasi' => $delivery->deliveryEvents->isNotEmpty() && $delivery->deliveryEvents->last()->checkpoints? $delivery->deliveryEvents->last()->checkpoints->checkpoint_name: "-",
            'barang' => $delivery->delivery_items,
            'kurir' => $delivery->deliveryEvents->last()->users->name,
            'riwayat' => $delivery->deliveryEvents->map(function ($item) {
                return [
                    'status' => $item->deliveryStatus->delivery_status,
                    'kurir' => $item->users->name,
                    'distrik' => $item->checkpoints && $item->checkpoints->districts? $item->checkpoints->districts->district_name: '-',
                    // 'distrik' => $item->checkpoints->districts->district_name,
                    'checkpoint' => $item->checkpoints ? $item->checkpoints->checkpoint_name : '-',
                    // 'checkpoint' => $item->checkpoints->checkpoint_name,
                ];
            }),
        ]);
    }
}
