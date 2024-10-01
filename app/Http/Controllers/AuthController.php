<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pharmacy;
use Doctrine\Common\Lexer\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\CssSelector\Parser\Token as ParserToken;

class AuthController extends Controller
{

    public function checkToken(Request $request)
    {
        $pharmacy_id = $request->user()->currentAccessToken()->tokenable_id;

        $pharmacy = Pharmacy::where('id', $pharmacy_id)->first();

        return response([
            'token_status' => true,
            'pharmacy' => $pharmacy
        ]);
    }

    public function signup(Request $request)
    {

        $fields = $request->validate([
            'name' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'map_url' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:pharmacies',
            'phone_number' => 'required|string',
            'password' => 'required|string'
        ]);


        $pharmacy = Pharmacy::create(
            [
                'name' => $fields['name'],
                'city' => $fields['city'],
                'address' => $fields['address'],
                'map_url' => $fields['map_url'],
                'first_name' => $fields['first_name'],
                'last_name' =>  $fields['last_name'],
                'email' => $fields['email'],
                'phone_number' => $fields['phone_number'],
                'password' => bcrypt($fields['password'])
            ]
        );


        $token = $pharmacy->createToken('pharmacy-token')->plainTextToken;

        $response = [
            'status' => true,
            'pharmacy' => $pharmacy,
            'token' => $token
        ];

        return response($response);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $pharmacy = Pharmacy::where('email', $fields['email'])->first();

        if (!$pharmacy || !Hash::check($fields['password'], $pharmacy->password)) {

            return response([
                'status' => false,
                'message' => 'bad creds'
            ], 401);
        }

        $token = $pharmacy->createToken('pharmacy-token')->plainTextToken;

        $response = [
            'status' => true,
            'pharmacy' => $pharmacy,
            'token' => $token
        ];

        return response()->json($response, 200);
    }


    public function loginAdmin(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $admin = Admin::where("email", $fields['email'])->first();

        if ($admin && $fields['password'] == $admin->password) {
            $pharmacies = Pharmacy::select("id", "name", "full_name", "map_url", "status", "city", "email", "phone_number", "address")->get();
            $token = $admin->createToken('admin-token')->plainTextToken;
            return response(['pharmacies' => $pharmacies, 'token' => $token,  'status' => true]);
        } else {
            return response([
                'message' => "error account not exist"
            ]);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $response = [
            'status' => true,
            'message' => 'logged out '
        ];
        return response($response);
    }
}
