<?php

namespace App\Http\Controllers;

use App\Models\User;

class ApiController extends Controller
{
    public function GetUsers() {
         $data = User::all();
        return response()->json($data);
    }
}
