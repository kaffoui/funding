<?php

namespace App\Http\Controllers;

use App\Models\CarteCredit;
use App\Http\Requests\StoreCarteCreditRequest;
use Illuminate\Http\Request;


class CarteCreditController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCarteCreditRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarteCreditRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarteCredit  $carteCredit
     * @return \Illuminate\Http\Response
     */
    public function show(CarteCredit $carteCredit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarteCredit  $carteCredit
     * @return \Illuminate\Http\Response
     */
    public function edit(CarteCredit $carteCredit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarteCreditRequest  $request
     * @param  \App\Models\CarteCredit  $carteCredit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Bloquage de Carte de Credit
        $request->validate([
            'statut' => 'required',
        ]);

        $update_carte_credit = CarteCredit::findOrFail($id);
        $update_carte_credit->statut = $request->get('statut');

        $update_carte_credit->update();

        return redirect()->back()->with('message', "La Carte à été bloqué");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarteCredit  $carteCredit
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarteCredit $carteCredit)
    {
        //
    }
}
