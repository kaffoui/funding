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
                                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                                        class="bg-secondary text-white ">Attribuer un role
                                                        </a>
                                                        <form
                                                            class="bg-danger text-white "
                                                            method="POST"
                                                            action="{{ route('admin.users.destroy', $user->id) }}"
                                                            onsubmit="return confirm('Etes vous sur de vouloir supprimer ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit">Supprimer</button>
                                                        </form>
                                                    </td>

                                                    {{-- <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            {{ $user->email }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            {{ $user->telephone }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="flex justify-end">
                                                            <div class="flex space-x-2">
                                                                <a href="{{ route('admin.users.show', $user->id) }}"
                                                                    class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">Roles</a>
                                                                <form
                                                                    class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md"
                                                                    method="POST"
                                                                    action="{{ route('admin.users.destroy', $user->id) }}"
                                                                    onsubmit="return confirm('Are you sure?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr> --}}
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