<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hobby;

class HobbyController extends Controller
{
    public function index()
    {
        $hobbies = Hobby::all();

        return response()->json($hobbies);
    }
}
