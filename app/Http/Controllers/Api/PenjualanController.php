<?php

namespace App\Http\Controllers\Api;

use App\Models\TransaksiPenjualanModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    public function index()
    {
        // All penjualan
        $penjualan = TransaksiPenjualanModel::all();

        // Return Json Response
        return response()->json([
            'penjualan' => $penjualan
        ], 200);
    }

    public function store(Request $request)
    {
        // Validate request data
        $validator = validator($request->all(), [
            'user_id' => 'required|integer',
            'pembeli' => 'required|string|max:50',
            'penjualan_kode' => 'required|string|max:20|unique:t_penjualans,penjualan_kode',
            'penjualan_tanggal' => 'required|date_format:Y-m-d H:i:s',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {

            // Create penjualan
            $penjualan = TransaksiPenjualanModel::create([
                'user_id' => $request->user_id,
                'pembeli' => $request->pembeli,
                'penjualan_kode' => $request->penjualan_kode,
                'penjualan_tanggal' => $request->penjualan_tanggal,
                'image' => $request->image->hashName()
            ]);

            // Return Json Response
            return response()->json([
                'success' => true,
                'penjualan' => $penjualan,
            ], 200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'success' => false,
            ], 500);
        }
    }

    public function show($id)
    {
        $penjualan = TransaksiPenjualanModel::find($id);
        if ($penjualan) {
            return response()->json($penjualan, 200);
        } else {
            return response()->json(['message' => 'penjualan tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // Validate request data
        $validator = validator($request->all(), [
            'user_id' => 'required|integer',
            'pembeli' => 'required|string|max:50',
            'penjualan_kode' => 'required|string|max:20|unique:t_penjualans,penjualan_kode',
            'penjualan_tanggal' => 'required|date_format:Y-m-d H:i:s',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 400);
        }

        try {
            // Find penjualan
            $penjualan = TransaksiPenjualanModel::find($id);
            if (!$penjualan) {
                return response()->json([
                    'message' => 'penjualan tidak ditemukan'
                ], 404);
            }

            $penjualan->user_id = $request->user_id;
            $penjualan->pembeli = $request->pembeli;
            $penjualan->penjualan_kode = $request->penjualan_kode;
            $penjualan->penjualan_tanggal = $request->penjualan_tanggal;
            $penjualan->image = $request->image->hashName();

            // Update penjualan
            $penjualan->save();

            // Return Json Response
            return response()->json([
                'success' => true,
                'penjualan' => $penjualan,
            ], 200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'success' => false,
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Detail
            $penjualan = TransaksiPenjualanModel::find($id);
            if (!$penjualan) {
                return response()->json([
                    'message' => 'penjualan tidak ditemukan'
                ], 404);
            }

            // Delete penjualan
            $penjualan->delete();

            // Return Json Response
            return response()->json([
                'success' => true,
                'message' => 'Data terhapus',
            ], 200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'success' => false,
            ], 500);
        }
    }



    // public function index()
    // {
    //     return TransaksiPenjualanModel::all();
    // }

    // public function store(Request $request)
    // {
    //     $penjualan = TransaksiPenjualanModel::create($request->all());
    //     return response()->json($penjualan, 201);
    // }

    // public function show(TransaksiPenjualanModel $penjualan)
    // {
    //     return TransaksiPenjualanModel::find($penjualan);
    // }

    // public function update(Request $request, TransaksiPenjualanModel $penjualan)
    // {
    //     $penjualan->update($request->all());
    //     return TransaksiPenjualanModel::find($penjualan);
    // }

    // public function destroy(TransaksiPenjualanModel $penjualan)
    // {
    //     $penjualan->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data terhapus',
    //     ]);
    // }


}
