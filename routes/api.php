<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacyController;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get("/search/{name}/{city?}/", [MedicineController::class, 'search'])->name('search');
Route::post("/signup", [AuthController::class, 'signup'])->name('signup');
Route::post("/login", [AuthController::class, 'login'])->name('login');
Route::post("/login/admin", [AuthController::class, 'loginAdmin']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/checktoken', [AuthController::class, 'checkToken']);
    Route::get('{id}/editinfo/', [PharmacyController::class, 'show']);
    Route::patch('{id}/editinfo/update', [PharmacyController::class, 'update']);
    Route::delete('{id}/delete', [PharmacyController::class, 'destroy']);
    Route::post("logout", [AuthController::class, 'logout']);
    // Medicines
    Route::get('{id}/medicine/', [MedicineController::class, 'index']);
    Route::post('{id}/medicine/add', [MedicineController::class, 'store']);
    Route::patch('{id}/medicine/{medicine_id}/update', [MedicineController::class, 'update']);
    Route::delete("{id}/medicine/{medicine_id}/delete", [MedicineController::class, 'destroy']);
});
