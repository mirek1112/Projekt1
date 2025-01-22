<?php

namespace App\Http\Controllers;

use App\Models\Zaznamy;
use App\Models\Country;
use App\Models\Hobby;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date|before_or_equal:today',
            'country_id' => 'required|exists:countries,id',
            'hobbies' => 'required|array',
        ]);


        $userId = Str::uuid()->toString();
        $zaznamy = Zaznamy::create([
            'id' => $userId,
            'jmeno' => $validated['first_name'],
            'prijmeni' => $validated['last_name'],
            'datum' => $validated['birth_date'],
            'country_id' => $validated['country_id'],
        ]);

        $zaznamy->hobbies()->sync($validated['hobbies']);
        return Inertia::location('/');

    }

    public function delete (Request $request){

        $ids = $request->input('ids');

        if (!empty($ids)) {
            Zaznamy::whereIn('id', $ids)->delete();

            return response()->json([
                'message' => 'Items deleted successfully',
                'deletedIds' => $ids
            ]);
        }

        return response()->json([
         'message' => 'error'
        ]);

    }

}
