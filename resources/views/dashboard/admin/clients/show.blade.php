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
                <div class="col-lg-7">
                    <button class="btn btn-primary"><a href="{{route('liste_clients')}}" style="color : white; text-decoration : none">Retour</a></button>

                    </div>
                <div class="col-lg-5">
                <button class="btn btn-danger"><a href="#" style="color : white; text-decoration : none">Clôturer ce compte</a></button>

                <button class="btn btn-info"><a href="#" style="color : white; text-decoration : none">Bloquer la carte </a></button>

                </div>
            </div> <br><br>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">Informations personnelles </p><br>

            <div class="row mb-5">
                <div class="content ">
                    <!-- <h3 class="fw-bold mb-3">Infos du titulaire</h3> -->
                        @foreach ( $clients_infos as $clients_info )
                             <p>Nom et prénoms : <span class="fw-bold"> {{$clients_info->nom}} {{$clients_info->prenoms}}</span></p>
                             <p>Email : <span class="fw-bold"> {{$clients_info->email}}</span></p>
                             <p>Numéro de téléphone : <span class="fw-bold"> {{$clients_info->telephone}}</span></p>
                             <p>Pays : <span class="fw-bold">{{$clients_info->nom_pays}}</span></p>
                            <p>Code postal : <span class="fw-bold"> {{$clients_info->code_postal}}</span></p>
                            <p>Ville : <span class="fw-bold"> {{$clients_info->ville}}</span ></p>


                            <p>Date de création du compte : <span class="fw-bold"> {{$clients_info->created_at}}</span></p>
                        @endforeach
                </div>
            </div>

            </div>
                    </div>
                    </div>
                </div>

                <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">Cartes de Crédits </p><br>

            <div class="row mb-5">
                <div class="col-lg-6 mb-5">
                    <!-- <h4 class="fw-bold mb-3"></h4> -->
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                            <tr>
                                <th>Carte de Credit</th>
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

                </div>
                    </div>
                    </div>
                </div>

                <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">Comptes bancaires </p><br>


                <div class="col-lg-6 mb-3">
                    <!-- <h4 class="fw-bold mb-3"></h4> -->
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
                    </div>
                </div>


        </div>
    </div>
@endsection