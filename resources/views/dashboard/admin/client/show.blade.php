use App\Http\Controllers\CarteCreditController;
use App\Http\Controllers\CompteBancaireController;
@extends('dashboard.admin.layouts.app')
@section('title',"Dashboard")
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                <p>{{ $message }}</p>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-6">
                    <h4 class=" mb-3">Les cartes de Crédits</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                            <tr>
                                <th>Numero de la Carte de Credit</th>
                                <th>Expiration</th>
                                <th>Type de Carte</th>
                                <th>Nom du titulaire</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ( $carte_credits as $carte_credit )

                                        <tr>
                                            <td>{{$carte_credit->numero}}</td>
                                            <td>{{$carte_credit->type}}</td>
                                            <td>{{$carte_credit->date_validite}}</td>
                                            <td>{{$carte_credit->titulaire}}</td>

                                            <form  method="POST" action="{{ route('credit_card.update',$carte_credit->id ) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="statut" value="0" >
                                                <td class="font-weight-medium w-100">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Bloquer la Carte') }}
                                                    </button>
                                                </td>
                                            </form>


                                        </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h4 class="mb-3">Les comptes bancaires</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                            <tr>
                                <th>Numéro de compte</th>
                                <th>Nom de la Banque</th>
                                <th>Numero IBAN</th>
                                <th>Numero de la pièce d'identité</th>
                                <th>Domiciliation</th>

                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ( $compte_banques as $compte_banque )
                                    <tr>
                                        <td>{{$compte_banque->num_compte_bancaire}}</td>
                                        <td>{{$compte_banque->nom_banque}}</td>
                                        <td>{{$compte_banque->iban}}</td>
                                        <td>{{$compte_banque->num_piece_identite}}</td>
                                        <td>{{$compte_banque->domiciliation}}</td>
                                        <form  method="POST" action="{{ route('compte_banque.update',$compte_banque->id ) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="statut" value="0" >
                                            <td class="font-weight-medium w-100">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Cloturer le compte') }}
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection