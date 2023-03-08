@extends('dashboard.admin.layouts.app')
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
                    <div class="col-lg-3">
                        <a href="/dashboard/employes" type="button" class="btn btn-primary mb-5">
                            Retour
</a>
                    </div>

                </div>



        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Oups ! Quelques choses c'est mal passé</strong><br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
        <p>{{ $message }}</p>
        </div>
        @endif

        <form id="signupForm" method="post" action="{{route('employes.store')}}">
            @csrf
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" required placeholder="Entrez le nom" name="nom">
                @error('nom')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="prenoms">Prénoms</label>
                <input type="text" class="form-control" name="prenoms" required placeholder="Entrez le prénom">
                @error('prenoms')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
          <div class="row">
            <div class="form-group col-6">
                <label for="code_postal">Code postal</label>
                <input type="text" class="form-control" name="code_postal" required placeholder="Ex : 0000">
                @error('code_postal')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="pays">Pays</label>


                    <select class="form-control" name="pays" id="">
                    @foreach ($payss as $pays)
                        <option value="{{ $pays->id }}"> {{ $pays->nom }} </option>
                        @endforeach
                    </select>
            </div>
            <div class="form-group col-6">
                <label for="ville">Ville</label>
                <input type="text" class="form-control" name="ville" required placeholder="Ville de résidence">
                @error('ville')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
          </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" required placeholder="Entrez l'adresse email">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
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
                {{-- @foreach ($permissions as $permission)
                        <option value="{{ $permission->name }}"> {{ $permission->name }} </option>
                        @endforeach --}}
                        </select>
            </div> -->

            <div class="row">
                <div class="form-group col-6">
                    <label for="indicatif">Indicatif</label>
                    <input type="text" class="form-control" name="indicatif" required placeholder="Ex : +33">
                    @error('indicatif')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-6">
                    <label for="telephone">Téléphone</label>
                    <input type="text" class="form-control" name="telephone" required placeholder="Entrez le numéro de téléphone (Ex : 00000000)">
                    @error('telephone')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" name="password" required placeholder="Entrez un mot de passe" minlength="8">
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirmez votre mot de passe</label>
                <input type="password" class="form-control" name="password_confirmation" required placeholder="Tapez à nouveau le mot de passe" minlength="8">
                @error('password_confirmation')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-primary btn-block my-4" type="submit">Enregistrer</button>
        </form>

    </div>
</div>
@endsection