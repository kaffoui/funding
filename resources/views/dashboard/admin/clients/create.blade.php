@extends('dashboard.admin.layouts.app')
@section('title',"Dashboard")
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <a href="/dashboard/clients" type="button" class="btn btn-primary mb-5">
                                            Retour
                                        </a>
                                    </div>

                                </div>
                                <div class="row">
                                    @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @endif
                                    <form id="signupForm" method="post" action="/signup">
                                        @csrf

                                        <div class="form-group">
                                            <label for="nom">Nom</label>
                                            <input type="text" class="form-control" placeholder="Entrez votre nom" name="nom">
                                            @error('nom')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="prenoms">Prénoms</label>
                                            <input type="text" class="form-control" placeholder="Entrez votre prénom" name="prenoms">
                                            @error('prenoms')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="code_postal">Code postal</label>
                                            <input type="text" class="form-control" placeholder="Ex : 0000" name="code_postal">
                                            @error('code_postal')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="ville">Ville</label>
                                            <input type="text" class="form-control" placeholder="Ville de résidence" name="ville">
                                            @error('ville')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" placeholder="Entrez votre adresse email" name="email">
                                            @error('email')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="indicatif">Indicatif</label>
                                            <input type="text" class="form-control" placeholder="Ex : +33" name="indicatif">
                                            @error('indicatif')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="telephone">Téléphone</label>
                                            <input type="text" class="form-control" placeholder="Entrez votre numéro de téléphone (Ex : 00000000)" name="telephone">
                                            @error('telephone')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="password">Mot de passe</label>
                                            <input type="password" class="form-control" placeholder="Entrez un mot de passe" name="password">
                                            @error('password')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="password_confirmation">Confirmez votre mot de passe</label>
                                            <input type="password" class="form-control" placeholder="Tapez à nouveau le mot de passe" name="password_confirmation">
                                            @error('password_confirmation')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button class="btn btn-primary btn-block my-4" type="submit">S'inscrire</button>

                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>

        </div>
    </div>

@endsection



