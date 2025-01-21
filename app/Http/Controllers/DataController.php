<?php

namespace App\Http\Controllers;

use App\Models\Zaznamy;
use App\Models\Country;
use App\Models\Hobby;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DataController extends Controller
{
    public function index()
    {
        $data = $this->getZaznamy();

           return Inertia::render('MainPage', [
               'data' => $data,
               'hobbyUsageCount' => $this->getUsageCount(),
           ]);
        }


    public function reloadData(){
        $this->deleteData();
        $response = $this->loadData();
        if ($response && $response->successful()) {
            $data = $response->json();


            foreach ($data as $record) {
                $country = Country::firstOrCreate([
                    'name' => $record['country'],
                ]);

                $fullName = explode(' ', $record['name']);
                $firstName = array_shift($fullName);
                $lastName = implode(' ', $fullName);

                $zaznam = Zaznamy::create([
                    'id' => $record['uid'],
                    'jmeno' => $firstName,
                    'prijmeni' => $lastName,
                    'datum' => \Carbon\Carbon::createFromFormat('d.m.Y', $record['birth_date'])->format('Y-m-d'),
                    'country_id' => $country->id,
                ]);


                    foreach ($record['hobbies'] as $hobbyName) {
                        $hobby = Hobby::firstOrCreate([
                            'name' => $hobbyName,
                        ]);
                        $zaznam->hobbies()->attach($hobby->id);

                    }

            }

        }

    }
   private function deleteData()
  {
 
    if (DB::table('zaznamy_hobby')->count() > 0) {
        DB::table('zaznamy_hobby')->delete();
        
    }
    if (DB::table('zaznamy')->count() > 0) {
        DB::table('zaznamy')->delete();
    }
  }
    private function getUsageCount()
    {

        $hobbyUsageCount = [];
        $hobbiesWithCount = DB::table('zaznamy_hobby')
            ->join('hobbies', 'zaznamy_hobby.hobby_id', '=', 'hobbies.id')
            ->select('hobbies.name', DB::raw('COUNT(zaznamy_hobby.hobby_id) as usage_count'))
            ->groupBy('hobbies.name')
            ->get();
        $hobbiesWithCount = $hobbiesWithCount->pluck('usage_count', 'name')->toArray();
        $hobbyUsageCount = array_merge($hobbyUsageCount, $hobbiesWithCount);


        return $hobbyUsageCount;
    }

    private function loadData()
    {
        return Http::get(env('API_URL'));
    }

    private function getZaznamy()
    {
        return Zaznamy::with(['country', 'hobbies'])->get();
    }
}
