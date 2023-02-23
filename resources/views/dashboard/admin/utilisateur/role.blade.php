@extends('dashboard.admin.layouts.app')
@section('title',"Dashboard")
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="w-100">
                <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
                    <div class="container">
                        <div class="row">
                            <a href="{{ route('users.index') }}" class="bg-primary p-2">
                                Retour
                            </a>
                        </div>
                        <div class="row">
                            <div class="user-infos mt-5 mb-5">
                                <div class="mb-3">User Email: {{ $user->email }}</div>
                                <div>Numero de téléphone {{ $user->telephone }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="content">
                                <span>Rôles actuels</span>
                                <div class="d-flex mt-3">
                                    @if ($user->roles)
                                    @foreach ($user->roles as $user_role)
                                        <form class="mr-3" method="POST"
                                            action="{{ route('users.roles.remove', [$user->id, $user_role->id]) }}"
                                            onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">{{ $user_role->name }}</button>
                                        </form>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                            <div class="add role">
                                <span>Ajouter un rôle</span>
                                    <form method="POST" action="{{ route('users.roles', $user->id) }}">
                                        @csrf
                                        <div>
                                            <label class="">Roles</label>
                                            <div class="d-flex">
                                                <select id="role" name="role" autocomplete="role-name" class="">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @error('role')
                                            <span class="">{{ $message }}</span>
                                        @enderror
                            </div>
                                        <div class="sm:col-span-6 pt-5">
                                            <button type="submit" class="">Attribuer</button>
                                        </div>
                                    </form>
                        </div>

                        <div class="row">
                            <div class="permission">
                                <div class="mt-6 p-2 bg-slate-100">
                                    <h2 class="text-2xl font-semibold">Permissions</h2>
                                    <div class="flex space-x-2 mt-4 p-2">
                                        @if ($user->permissions)
                                            @foreach ($user->permissions as $user_permission)
                                                <form class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" method="POST"
                                                    action="{{ route('users.permissions.revoke', [$user->id, $user_permission->id]) }}"
                                                    onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">{{ $user_permission->name }}</button>
                                                </form>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="max-w-xl mt-6">
                                        <form method="POST" action="{{ route('users.permissions', $user->id) }}">
                                            @csrf
                                            <div class="sm:col-span-6">
                                                <label for="permission" class="block text-sm font-medium text-gray-700">Permission</label>
                                                <select id="permission" name="permission" autocomplete="permission-name"
                                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    @foreach ($permissions as $permission)
                                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('name')
                                                <span class="text-red-400 text-sm">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <div class="sm:col-span-6 pt-5">
                                        <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md">Attribuer</button>
                                    </div>
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
    </div>
@endsection