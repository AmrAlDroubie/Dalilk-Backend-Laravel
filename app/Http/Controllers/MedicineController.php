<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request, $pharmacy_id)
    {
        if ($request->user()->currentAccessToken()->tokenable_id != $pharmacy_id) {
            return response([
                'message' => 'Access Denied',
            ], 403);
        }
        $meds = Medicine::where('pharmacy_id', $pharmacy_id)->get();
        if (!$meds) {
            return response(['message' => 'no medicines exists']);
        }
        return $meds;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        if ($request->user()->currentAccessToken()->tokenable_id != $id) {
            return response([
                'message' => 'Access Denied',
            ], 403);
        }

        $fields = $request->validate(
            [
                'med_name' => 'required|string|unique:medcines',
                'quantity' => 'required',
                'price' => 'required',
            ]
        );
        // Storage::put('avatars/1', );
        $pharmacy = Pharmacy::where("id", $id)->first();
        if (!$pharmacy) {
            return response(
                ['message' => 'issue with pharmacy id']
            );
        }

        Medicine::create(
            [
                'med_name'      => $fields['med_name'],
                'quantity'  => $fields['quantity'],
                'price'  => $fields['price'],
                'pharmacy_id' => $id,
            ]
        );

        return response(['message' => 'done', 'status' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    // Search for Medicine By Name

    public function search(string $name, string $city = null)
    {
        if ($city) {
            $meds =  Pharmacy::join('medcines', "medcines.pharmacy_id", "=", "pharmacies.id")
                ->where('medcines.med_name', 'like', '%' . $name . '%')
                ->where('pharmacies.status', true)
                ->where('pharmacies.city', $city)
                ->select("name", "price", "med_name", "map_url", "map_iframe", "quantity", "address")->get();
        } else {
            $meds =  Pharmacy::join('medcines', "medcines.pharmacy_id", "=", "pharmacies.id")
                ->where('medcines.med_name', 'like', '%' . $name . '%')
                ->where('pharmacies.status', true)
                ->select("name", "price", "med_name", "map_url", "map_iframe",  "quantity", "address")->get();
        }

        return response(['data' => $meds]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, string $medicine_id)
    {
        if ($request->user()->currentAccessToken()->tokenable_id != $id) {
            return response([
                'message' => 'Access Denied',
            ], 403);
        }
        $fields = $request->validate(
            [
                'med_name' => 'required|string',
                'quantity' => 'required',
                'price' => 'required'
            ]
        );

        $medicine = Medicine::where('id', $medicine_id)->where('pharmacy_id', $id)->update(
            [
                'med_name' => $fields['med_name'],
                'quantity' => $fields['quantity'],
                'price' => $fields['price'],
                'pharmacy_id' => $id
            ]
        );

        if (!$medicine) {
            return response(['message' => 'Update Failed'], 401);
        } else {
            return response(['message' => 'Done...']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id, string $medicine_id)
    {
        if ($request->user()->currentAccessToken()->tokenable_id != $id) {
            return response([
                'message' => 'Access Denied',
            ], 403);
        }

        $medicine = Medicine::where('id', $medicine_id)->where('pharmacy_id', $id)->first();
        if (!$medicine) {
            return response(['message' => 'Medicine Not Found']);
        }

        if (Medicine::where('id', $medicine->id)->delete() > 0) {
            return response(['message' => 'done...']);
        }
    }
}
