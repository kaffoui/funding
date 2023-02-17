@extends('dashboard.admin.layouts.app')
@section('title',"Dashboard")
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="table-responsive">
                <table class="table table-striped table-borderless">
                    <thead>
                    <tr>
                        <th>Nom  du client</th>
                        <th>Email</th>
                        <th>Numero de téléphone</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ( $clients as $client )
                            <tr>
                                <td>{{$client->nom}} {{$client->prenoms}}</td>
                                <td>{{$client->email}}</td>
                                <td>{{$client->telephone}}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('clients.show',$client->id) }}">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection



