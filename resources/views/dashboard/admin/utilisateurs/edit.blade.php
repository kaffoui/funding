@extends('dashboard.admin.layouts.app')
@section('title',"Dashboard")
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

        <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-harder">

                        </div>
                    <div class="card-body">


            <div class="container">

                <div class="row">
                    <div class="col-lg-12">
                        <form method="POST" action="{{ route('employes.update',$employe->id) }}" enctype="multipart/form-data" >
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="">Nom</label>
                                <input type="text" name="nom" value="{{$employe->nom}}">
                            </div>
                            <div class="form-group">
                                <label for="">Prenoms</label>
                                <input type="text" name="prenoms" value="{{$employe->prenoms}}">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" name="nom" value="{{$employe->email}}">
                            </div>
                            <div class="form-group">
                                <label for="">Nom</label>
                                <input type="text" name="nom" value="{{$employe->pays->nom}}">
                            </div>
                            <div class="row mb-0 mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Mettre à jour') }}
                                    </button>
                                    <a  href="{{route('employes.index')}}" class="btn btn-danger">
                                        {{ __('Retour') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                       {{--  <table id="client_datatable" class="display expandable-table dataTable no-footer" style="width: 100%;" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1" aria-label="Quote#" >#</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending">Nom & Prénoms</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1">Email</th>
                                    <!-- <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1">Fonction</th> -->
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 111px;">Pays</th>
                                    <!-- <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 111px;">Pays</th> -->
                                    <!-- <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 79px;">Code Postal</th> -->
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 111px;">Rôle</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 79px;">Modifier</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 79px;">Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $num=1 @endphp
                                    @foreach ($employes as $employe)
                                        <tr>
                                            <td>{{ $num++ }} </td>
                                            <td>{{$employe->nom}} {{$employe->prenom}}</td>
                                            <td>{{$employe->email}}</td>
                                            <td>{{$employe->pays->nom}}</td>
                                            <td></td>

                                            <td>
                                                <form action="{{ route('modification_employe', $employe->id) }}" method="GET">

                                                    @csrf

                                                    <button type="submit" class="btn ">
                                                        <i class="fa-solid fa-edit" style="color: green;"></i>
                                                    </button>
                                                </form>
                                            </td>

                                            <td>
                                            <form

                                                                method="POST"
                                                                action="{{ route('suppression_employe', $employe->id) }}"
                                                                onsubmit="return confirm('Etes vous sur de vouloir supprimer ?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn " type="submit"><i class="fa-solid fa-trash" style="color: red;"></i></button>
                                                            </form>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table> --}}
                        <!-- Button trigger modal -->

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