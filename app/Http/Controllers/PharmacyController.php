<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "sign in";
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        if ($request->user()->currentAccessToken()->tokenable_id != $id) {
            return response([
                'message' => 'Access Denied',
            ], 403);
        }



        $pharmacy = Pharmacy::where('id', $id)->first();
        if (!$pharmacy) {
            return response([
                'message' => 'error not found',
            ], 401);
        }

        return $pharmacy;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (($request->user()->currentAccessToken()->tokenable_id != $id) && ($request->user()->currentAccessToken()->name != 'admin-token')) {
            return response([
                'message' => 'Access Denied',
            ], 403);
        }
        // $keys =  array_keys($request->input());
        // $arr = $request->input();

        // $fields = $request->validate([
        //     'name' => 'required|string',
        //     'city' => 'required|string',
        //     'map_url' => 'required|string',
        //     'first_name' => 'required|string',
        //     'last_name' => 'required|string',
        //     'email' => 'required|string',
        //     'phone_number' => 'required|string',
        // ]);
        $updated = Pharmacy::where('id', $id)->update($request->input());
        // $updated = Pharmacy::where('id', $id)->update(['status' => false]);

        return response([
            'status' => $updated > 0 ? true : false,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if ($request->user()->currentAccessToken()->tokenable_id != $id && ($request->user()->currentAccessToken()->name != 'admin-token')) {
            return response([
                'message' => 'Access Denied',
            ], 403);
        }

        Medicine::where('pharmacy_id', $id)->delete();
        $pharmacy = Pharmacy::where('id', $id)->delete();
        if (!$pharmacy) {
            return response(['message' => 'Delete Account Failed']);
        }

        return response(['message' => 'Done...', 'status' => true]);
    }
}
