<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pays;
use Illuminate\Http\Request;

class PaysController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        try {
            // $recordsCount = isset($request->records_count) ? $request->records_count : 20;
            $recordsCount = isset($request->records_count) ? $request->records_count : 20;
            $pays = Pays::paginate(sizeof(Pays::all()));
            $data["status"] = "ok";
            $data["data"] = $pays;
        } catch (\Throwable $e) {
            $data["status"] = "ok";
            $data["message"] = $e->getMessage();
        }
        return response()->json($data, 200);
    }

    public function show(Request $request)
    {
        $countryName = $request->name;
        $country = Pays::where("nom", $countryName)->get();
        return response()->json($country);

    }
}
