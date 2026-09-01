@extends('layouts.app', ['title' => 'Add User']) @section('content')
    <form method="POST" action="{{ route('users.store') }}" class="bg-white border rounded-xl p-6 max-w-xl">@csrf
@include('users.form', ['button' => 'Create User'])</form>@endsection