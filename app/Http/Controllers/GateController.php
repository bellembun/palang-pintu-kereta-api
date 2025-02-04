<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GateController extends Controller
{
    private $arduinoIp = 'http://192.168.100.140';

    public function openGate(Request $request)
    {
        try {
            $response = Http::get("{$this->arduinoIp}/open");

            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Palang pintu dibuka']);
            }

            return response()->json(['status' => 'error', 'message' => 'Gagal membuka palang'], 500);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Tidak dapat menghubungi perangkat'], 500);
        }
    }

    public function closeGate(Request $request)
    {
        try {
            $response = Http::get("{$this->arduinoIp}/close");

            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Palang pintu ditutup']);
            }

            return response()->json(['status' => 'error', 'message' => 'Gagal menutup palang'], 500);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Tidak dapat menghubungi perangkat'], 500);
        }
    }
}
