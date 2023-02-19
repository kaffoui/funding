@extends('dashboard.admin.layouts.app')
@section('title',"Dashboard")
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="table-responsive">
                <table class="table table-striped table-borderless " id="client_datatable">
                    <thead>
                    <tr>
                        <th>Pays</th>
                        <th>Code Postal</th>
                        <th>Ville</th>
                        <th>Nom  du client</th>
                        <th>Email</th>
                        <th>Numero de téléphone</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ( $clients as $client )
                            <tr>
                                <td></td>
                                <td>{{$client->code_postal}}</td>
                                <td>{{$client->ville}}</td>
                                <td>{{$client->nom}} {{$client->prenoms}}</td>
                                <td>{{$client->email}}</td>
                                <td>{{$client->telephone}}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('clients.show',$client->id) }}">
                                        Details <i class="fa-solid fa-eye ml-3"></i>
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


@endsection



