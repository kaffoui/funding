<?php

namespace App\Http\Controllers\API;

use App\Models\Depot;
use App\Models\Solde;
use App\Models\Retrait;
use App\Http\Traits\SoldesTrait;
use App\Models\CommissionRetire;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreSoldeRequest;
use App\Http\Requests\UpdateSoldeRequest;

class SoldeController extends Controller
{
    use SoldesTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $solde = $this->get_solde();

            if($solde == null){
                return response()->json([
                    "success" => true,
                    'solde' => 0,
                ], 200);
            }
            // $solde->ancien = round_somme($solde->ancien);
            $solde->actuel = round_somme($solde->actuel);
            return response()->json([

                "success" => true, 

                'solde' => $solde->actuel,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                'solde' => 0,
            ], 400);
        }
     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSoldeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSoldeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Solde  $solde
     * @return \Illuminate\Http\Response
     */
    public function show(Solde $solde)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSoldeRequest  $request
     * @param  \App\Models\Solde  $solde
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSoldeRequest $request, Solde $solde)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Solde  $solde
     * @return \Illuminate\Http\Response
     */
    public function destroy(Solde $solde)
    {
        //
    }
}