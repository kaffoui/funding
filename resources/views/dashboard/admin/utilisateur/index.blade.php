@extends('dashboard.admin.layouts.app')
@section('title',"Dashboard")
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Ajouter un utilisateur
                        </button>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table id="example" class="display expandable-table dataTable no-footer" style="width: 100%;" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1" aria-label="Quote#" >#</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending">Nom & Prénoms</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1">Email</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1">Fonction</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 111px;">Téléphone</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 111px;">Pays</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 79px;">Code Postal</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 111px;">Ville</th>
                                    <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 79px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($administrateurs as $administrateur)
                                        <tr>
                                            <td>01</td>
                                            <td>{{$administrateur->nom}} {{$administrateur->prenoms}}</td>
                                            <td>{{$administrateur->email}}</td>
                                            <td>{{$administrateur->telephone}}</td>
                                            <td>{{$administrateur->code_postal}}</td>
                                            <td>
                                                <form action="{{-- {{ route('client.destroy',$liste_client->id) }} --}}" method="Post">

                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fa-solid fa-trash" style="color: red;"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                        <!-- Button trigger modal -->


                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="bg-dark p-5" style="color:#ffffff">
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


                                    </div>
                                    <form id="signupForm" method="post" action="">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nom">Niveau D'accès</label>
                                            <select class="form-select" aria-label="Default select example" name="role">
                                                <option selected>Selectionner le niveau</option>
                                                <option value="1">Editeur</option>
                                                <option value="2">Administrateur</option>
                                                <option value="3">Super Admin</option>
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label for="nom">Nom</label>
                                            <input type="text" class="form-control" id="nom" required
                                                placeholder="Entrez votre nom" name="nom">
                                        </div>
                                        <div class="form-group">
                                            <label for="prenoms">Prénoms</label>
                                            <input type="text" class="form-control" name="prenoms" required
                                                placeholder="Entrez votre prénom">
                                        </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="code_postal">Code postal</label>
                                            <input type="text" class="form-control" name="code_postal" required
                                                placeholder="Ex : 0000">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="ville">Ville</label>
                                            <input type="text" class="form-control" name="ville" required
                                                placeholder="Ville de résidence">
                                        </div>
                                    </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" name="email" required
                                                placeholder="Entrez votre adresse email">
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
                                                    placeholder="Entrez votre numéro de téléphone (Ex : 00000000)">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password">Mot de passe</label>
                                            <input type="password" class="form-control" name="password" required
                                                placeholder="Entrez un mot de passe" minlength="8">
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirmez votre mot de passe</label>
                                            <input type="password" class="form-control" name="password_confirmation" required
                                                placeholder="Tapez à nouveau le mot de passe" minlength="8">
                                        </div>
                                        <button class="btn btn-primary btn-block my-4" type="submit">S'inscrire</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
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