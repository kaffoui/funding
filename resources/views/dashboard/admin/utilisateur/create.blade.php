@extends('dashboard.admin.layouts.app')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <a href="{{ route('users.create') }}" class="px-4 py-2 bg-green-700 hover:bg-green-500 rounded-md">Create Permission</a>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href=""> Back</a>
                </div>
            </div>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="signupForm" method="post" action="{{route('users.store')}}">
            @csrf
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
</div>
@endsection