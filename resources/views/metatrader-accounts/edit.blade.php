@extends('layouts.app', ['title' => 'Edit MetaTrader Account']) @section('content')
    <form method="POST" action="{{ route('metatrader-accounts.update', $account) }}"
        class="bg-white border rounded-xl p-6 max-w-xl">@csrf @method('PUT')
@include('metatrader-accounts.form', ['button' => 'Save Changes'])</form>@endsection