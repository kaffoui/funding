@extends('dashboard.admin.layouts.app')
@section('title',"Dashboard")
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="py-12 w-full">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <div class="row mb-5"><a href="users/create" type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            Ajouter un utilisateur
                                        </a></div>
                                        <table class="table table-striped table-borderless">
                                            <thead>
                                            <tr>
                                                <th>Email</th>
                                                <th>Telephone</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td class="font-weight-bold">{{ $user->email }}</td>
                                                        <td>{{ $user->telephone }}</td>
                                                        <td class="d-flex">
                                                            <a href="{{ route('users.show', $user->id) }}"
                                                            class="bg-secondary text-white mr-3">Attribuer un role
                                                            </a>
                                                            <a href=""
                                                            class="bg-secondary text-white mr-3">Editer
                                                            </a>
                                                            <form
                                                                class="bg-danger text-white "
                                                                method="POST"
                                                                action="{{ route('users.destroy', $user->id) }}"
                                                                onsubmit="return confirm('Etes vous sur de vouloir supprimer ?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit">Supprimer</button>
                                                            </form>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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