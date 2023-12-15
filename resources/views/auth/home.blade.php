@extends('layouts.app')

@section('content')
		<main id="success-page">
        <font color="black">
            <h1>YOU ARE!</h1>
            <div>
                @if (session('error'))
                    {{ session('error') }}
                @endif
            </div>
            <a href={{ route('logout') }}>Logout</a>
        </font>
		</main>
    @endsection
