<?php

namespace App\Http\Controllers;

use App\Models\Transfert;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Traits\TauxTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Traits\LocalisationTrait;
use App\Http\Requests\StoreTransfertRequest;
use App\Http\Requests\UpdateTransfertRequest;

class TransfertController extends Controller
{
    use LocalisationTrait, TauxTrait;

    public function __construct()
    {
        // $this->middleware('code.confirmation')->only(['create', 'store']);
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $transferts_from = auth()->user()->client->transferts_from;

        $transferts_to = auth()->user()->client->transferts_to;

        $transferts = collect($transferts_from)->merge($transferts_to)->sortByDesc('created_at');

        return view('client.transfert.index', compact('transferts'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('client.transfert.create');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \App\Http\Requests\StoreTransfertRequest  $request
    * @return \Illuminate\Http\Response
    */
    public function store(StoreTransfertRequest $request)
    {
        
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Transfert  $transfert
    * @return \Illuminate\Http\Response
    */
    public function show(Transfert $transfert)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Transfert  $transfert
    * @return \Illuminate\Http\Response
    */
    public function edit(Transfert $transfert)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \App\Http\Requests\UpdateTransfertRequest  $request
    * @param  \App\Models\Transfert  $transfert
    * @return \Illuminate\Http\Response
    */
    public function update(UpdateTransfertRequest $request, Transfert $transfert)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Transfert  $transfert
    * @return \Illuminate\Http\Response
    */
    public function destroy(Transfert $transfert)
    {
        //
    }


    public function send(Request $request){
         
        try {
            $apiUrl = request()->getHttpHost() . "/api";
            $request->merge([
                'paymentMethod' => "Lisocash",
            ]);
            $data = $request->all();
            // dd($data);
            $req = Request::create('/api/transferts','POST',$data);
    
            $response = Route::dispatch($req);
            $response = json_decode($response->getContent(),true);
            // dd($req,$response,$data);
            if($response["success"]){
                return redirect()->back()->with([
                    "success" => true,
                    "message" => "Transfert réussi",
                ]);
            }else if(!$response["success"]){
                return redirect()->back()->with([
                    "success" => false,
                    "message" => $response["message"],
                ]);
            }
            else{
                return redirect()->back()->with([
                    "success" => false,
                    "message" => "Impossible d'effectuer le transfert. Assurez-vous que le destinataire spécifié est un client Lisocash ou réessayez plus tard.",
                ]);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                "success" => false,
                "message" => "Impossible d'effectuer le transfert. Assurez-vous que le destinataire spécifié est un client Lisocash ou réessayez plus tard.",
            ]);
        }
        
      
        // return $response;
        // dd($request->all());
    }
}
