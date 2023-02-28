@extends('dashboard.admin.layouts.app')
@section('title',"Dashboard")
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

        <div class="row">
            @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                        <p>{{ $message }}</p>
                        </div>
                    @endif
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                    <div class="card-body">

                    <div class="row">
                    <div class="col-lg-9"> <p class="card-title mb-0"> <label for="">Liste des clients</label> </p><br><br></div>
                    <div class="col-lg-3">
                        <a href="{{ route('clients.create')}}" type="button" class="btn btn-primary mb-5" >
                            Ajouter un Client
                        </a>
                    </div>

                </div>

            <div class="table-responsive">
                <table class="table table-striped table-borderless display expandable-table dataTable no-footer " id="client_datatable">
                    <thead>
                    <tr>
                        <!-- <th>Pays</th> -->
                        <!-- <th>Code Postal</th> -->
                        <!-- <th>Ville</th> -->
                        <th>Nom et Prénom(s)</th>
                        <th>Email</th>
                        <th>Numero de téléphone</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ( $clients as $client )
                            <tr>
                                <!-- <td></td> -->
                                <!-- <td>{{$client->code_postal}}</td> -->
                                <!-- <td>{{$client->ville}}</td> -->
                                <td>{{$client->nom}} {{$client->prenoms}}</td>
                                <td>{{$client->email}}</td>
                                <td>{{$client->telephone}}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('clients.show',$client->id) }}">
                                        Détails <i class="fa-solid fa-eye ml-3"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                {{-- <div class="d-flex">
                    {{$clients->links()}}
                </div> --}}
            </div>

            </div>
                    </div>
                    </div>
                </div>

        </div>
    </div>


@endsection



