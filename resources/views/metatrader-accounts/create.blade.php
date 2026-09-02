@extends('layouts.app', ['title' => 'Add MetaTrader Account']) @section('content')
    <form method="POST" action="{{ route('metatrader-accounts.store', [], false) }}" class="bg-white border rounded-xl p-6 max-w-xl">
@csrf @include('metatrader-accounts.form', ['button' => 'Create Account'])</form>@endsection