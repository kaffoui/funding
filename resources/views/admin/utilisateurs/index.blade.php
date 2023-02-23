@extends('admin.layouts.app')
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
                    <div class="col-lg-9"> <p class="card-title mb-0"> <label for="">Liste des utilisateurs</label> </p><br><br></div>
                    <div class="col-lg-3">
                        <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Ajouter un utilisateur
                        </button>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table id="client_datatable" class="display expandable-table dataTable no-footer" style="width: 100%;" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1" aria-label="Quote#" >#</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending">Nom & Prénoms</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1">Email</th>
                                    <!-- <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1">Fonction</th> -->
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 111px;">Téléphone</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 111px;">Pays</th>
                                    <!-- <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 79px;">Code Postal</th> -->
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 111px;">Ville</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 79px;">Modifier</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 79px;">Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($employes as $employe)
                                        <tr>
                                            <td>01</td>
                                            <td>{{$employe->nom}} {{$employe->prenoms}}</td>
                                            <td>{{$employe->email}}</td>
                                            <td>{{$employe->telephone}}</td>
                                            <td>{{$employe->pays->nom}}</td>
                                            <td>{{$employe->ville}}</td>

                                            <td>
                                                <form action="{{route('modification_employe', $employe->id)}}" method="POST">

                                                    @csrf
                                                    
                                                    <button type="submit" class="btn ">
                                                        <i class="fa-solid fa-edit" style="color: blue;"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            
                                            <td>
                                                <form action="{{route('suppression_employe', $employe->id)}}" method="POST">

                                                    @csrf
                                                   
                                                    <button type="submit" class="btn ">
                                                        <i class="fa-solid fa-trash" style="color: red;"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                        <!-- Button trigger modal -->

                        </div>
                    </div>
                    </div>
                </div>



                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un utilisateur</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- <div class="bg-dark p-5" style="color:#ffffff">
                                        <span>Les Accès par niveau</span>
                                        <div>
                                            <p>Editeur :</p>
                                            <p>---</p>
                                            <p>---</p>
                                        </div>
                                        <hr class="w-100">
                                        <div>
                                            <p>Administrateur :</p>
                                            <p>---</p>
                                            <p>---</p>
                                        </div>
                                        <hr class="w-100">
                                        <div>
                                            <p>Super Admin :</p>
                                            <p>---</p>
                                            <p>---</p>
                                        </div>


                                    </div> -->
                                    <form id="signupForm" method="post" action="{{route('ajout_employe')}}">
                                        @csrf
                                        
                                        <div class="form-group">
                                            <label for="nom">Nom</label>
                                            <input type="text" class="form-control" id="nom" required
                                                placeholder="Entrez le nom" name="nom">
                                        </div>
                                        <div class="form-group">
                                            <label for="prenoms">Prénoms</label>
                                            <input type="text" class="form-control" name="prenoms" required
                                                placeholder="Entrez le(s) prénom(s)">
                                        </div>
                                    <!-- <div class="row"> -->
                                        <!-- <div class="form-group col-6">
                                            <label for="code_postal">Code postal</label>
                                            <input type="text" class="form-control" name="code_postal" required
                                                placeholder="Ex : 0000">
                                        </div> -->
                                        <div class="form-group ">
                                            <label for="ville">Ville</label>
                                            <input type="text" class="form-control" name="ville" required
                                                placeholder="Ville de résidence">
                                        </div>
                                    <!-- </div> -->
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" required
                                                placeholder="Entrez l'adresse e-mail">
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="indicatif">Indicatif</label>
                                                <input type="text" class="form-control" name="indicatif" required
                                                    placeholder="Ex : +33">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="telephone">Téléphone</label>
                                                <input type="text" class="form-control" name="telephone" required
                                                    placeholder="Entrez le numéro de téléphone (Ex : 00000000)">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="nom">Rôle</label>
                                            <select class="form-select" aria-label="Default select example" name="role">
                                                <option selected>Selectionnez le rôle</option>
                                                <option value="admin">Administrateur</option>
                                                <option value="agent">Agent</option>
                                                <option value="gestionnaire">Gestionnaire</option>
                                                <option value="guichetier">Guichetier</option>
                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <label for="nom">Permissions</label>
                                            <select class="form-select" aria-label="Default select example" name="role">
                                                <option selected>Selectionnez les permissions</option>
                                                <option value="admin">Consulter la liste des clients</option>
                                                <option value="agent">Ajouter un client</option>
                                                <option value="gestionnaire">Modifier les informations d'un client</option>
                                                <option value="guichetier">Supprimer les informations d'un client </option>
                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <label for="password">Mot de passe</label>
                                            <input type="password" class="form-control" name="password" required
                                                placeholder="Entrez un mot de passe" minlength="8">
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirmez le mot de passe</label>
                                            <input type="password" class="form-control" name="password_confirmation" required
                                                placeholder="Tapez à nouveau le mot de passe" minlength="8">
                                        </div>
                                        <button class="btn btn-primary btn-block my-4" type="submit">Enregistrer</button>
                                    </form>
                                </div>
                                <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                                </div> -->
                            </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection