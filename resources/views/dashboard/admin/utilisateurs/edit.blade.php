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
                        <form id="" method="POST" action="{{route('employes.update',$employes->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" id="nom" required
                                    placeholder="Entrez le nom" name="nom" value="{{ $employes->nom }}">
                            </div>
                            <div class="form-group">
                                <label for="prenoms">Prénoms</label>
                                <input type="text" class="form-control" name="prenoms" required
                                    placeholder="Entrez le prénom" value="{{ $employes->nom }}">
                            </div>
                          <div class="row">
                            <div class="form-group col-6">
                                <label for="code_postal">Code postal</label>
                                <input type="text" class="form-control" name="code_postal" required
                                    placeholder="Ex : 0000" value="{{ $employes->nom }}">
                            </div>
                            <div class="form-group">
                                <label for="pays">Pays</label>


                                    <select class="form-control" name="pays" id="">
                                    @foreach ($payss as $pays)
                                        <option value="{{ $pays->id }}" name="pays_id"> {{ $pays->nom }} </option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="ville">Ville</label>
                                <input type="text" class="form-control" name="ville" required
                                    placeholder="Ville de résidence" value="{{ $employes->nom }}">
                            </div>
                          </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" required
                                    placeholder="Entrez l'adresse email" value="{{ $employes->nom }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="role">Rôle</label>


                                    <select class="form-control" name="role" id="">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"> {{ $role->name }} </option>
                                        @endforeach
                                    </select>
                            </div>

                            <!-- <div class="form-group">
                                <label for="permissions">Permissions</label>


                                <select multiple data-live-search="true" multiple="multiple" class="form-control selectpicker" name="permissions[]" id="permissions">
                                @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}"> {{ $permission->name }} </option>
                                        @endforeach
                                        </select>
                            </div> -->

                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="indicatif">Indicatif</label>
                                    <input type="text" class="form-control" name="indicatif" required
                                        placeholder="Ex : +33" value="{{ $employes->nom }}" >
                                </div>
                                <div class="form-group col-6">
                                    <label for="telephone">Téléphone</label>
                                    <input type="text" class="form-control" name="telephone" required
                                        placeholder="Entrez le numéro de téléphone (Ex : 00000000)" value="{{ $employes->nom }}">
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
                            <button class="btn btn-primary btn-block my-4" type="submit">Enregistrer</button>
                        </form>

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