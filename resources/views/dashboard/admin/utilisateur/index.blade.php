@extends('dashboard.admin.layouts.app')
@section('title',"Dashboard")
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="container d-flex justify-content-center align-items-center">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
                            <table id="example" class="display expandable-table dataTable no-footer" style="width: 100%;" role="grid">
                                <thead>
                                    <tr role="row">
                                        <th class="select-checkbox sorting_disabled" rowspan="1" colspan="1" aria-label="Quote#" >#</th>
                                        <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-sort="ascending">Nom & Prénoms</th>
                                        <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1">Email</th>
                                        <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 111px;">Téléphone</th>
                                        <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 79px;">Code Postal</th>
                                        <th  tabindex="0" aria-controls="example" rowspan="1" colspan="1" style="width: 79px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach ($administrateurs as $administrateur)
                                            <tr>
                                                <td>01</td>
                                                <td>{{$administrateur->nom}} {{$liste_client->prenoms}}</td>
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
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="signupForm" method="post" action="">
                @csrf
                <div class="form-group">
                    <label for="nom">Niveau D'accès</label>
                    <input type="text" class="form-control" id="role" value="2" required
                        placeholder="Entrez votre nom" name="role">
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

                           {{--  <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div>
                                    <x-jet-label for="name" value="{{ __('Name') }}" />
                                    <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                </div>

                                <div class="mt-4">
                                    <x-jet-label for="email" value="{{ __('Email') }}" />
                                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                </div>

                                <div class="mt-4">
                                    <x-jet-label for="password" value="{{ __('Password') }}" />
                                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                </div>

                                <div class="mt-4">
                                    <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                    <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                                </div>

                                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                    <div class="mt-4">
                                        <x-jet-label for="terms">
                                            <div class="flex items-center">
                                                <x-jet-checkbox name="terms" id="terms"/>

                                                <div class="ml-2">
                                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </x-jet-label>
                                    </div>
                                @endif

                                <div class="flex items-center justify-end mt-4">
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                        {{ __('Already registered?') }}
                                    </a>

                                    <x-jet-button class="ml-4">
                                        {{ __('Register') }}
                                    </x-jet-button>
                                </div>
                            </form> --}}
                        </div>

                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection