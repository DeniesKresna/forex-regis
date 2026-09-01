@extends('layouts.app', ['title' => 'Users']) @section('content')
    <div class="flex justify-between mb-4">
        <h2 class="text-lg font-semibold">Users</h2><a href="{{ route('users.create') }}"
            class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm">Add User</a>
    </div>
    <div class="bg-white border rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Role</th>
                    <th class="p-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody>@foreach($users as $u)
                <tr class="border-t">
                    <td class="p-3">{{ $u->name }}</td>
                    <td class="p-3">{{ $u->email }}</td>
                    <td class="p-3">{{ $u->roles->pluck('name')->join(', ') }}</td>
                    <td class="p-3 text-right"><a class="text-blue-600" href="{{ route('users.edit', $u) }}">Edit</a>
                        <form class="inline" method="POST" action="{{ route('users.destroy', $u) }}">@csrf
                            @method('DELETE')<button class="text-red-600 ml-3"
                                onclick="return confirm('Delete user?')">Delete</button></form>
                    </td>
            </tr>@endforeach
            </tbody>
        </table>
    </div>
<div class="mt-4">{{ $users->links() }}</div>@endsection