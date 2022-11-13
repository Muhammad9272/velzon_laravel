@extends('front.layouts.app')
@section('content')
{{-- @include('front.layouts.header')
--}}
<div class="container">
    <nav class="text-center py-4 mb-4">
        <a href="{{ route('front.index') }}">
            <img width="132" class="mb-3" src="{{asset('front/assets/images/logo-black.png')}}" alt="..." />
        </a>
    </nav>

    <form action="{{ route('user.login.submit') }}" method="post" class="ts-contact-form rounded-3 mb-10">
        @csrf
        @include('admin.includes.alerts')
        <h1 class="ts-heading-1 text-center text-white mb-6 fw-bold">
            Login
        </h1>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="tsEmail" name="email" placeholder="Email" />
            <label for="tsEmail">Email</label>
        </div>
        <div class="form-floating mb-5">
            <input type="password" class="form-control" id="tsPassword" name="password" placeholder="Password" />
            <label for="tsPassword">Password</label>
        </div>

        <button type="submit" class="btn btn-secondary w-100 mb-6 fw-bold">
            Login
        </button>

        <p class="fw-bold text-medium-gray">
            Not Yet registered ?
            <a class="text-decoration-none text-white" href="{{ route('user.register') }}">
                Register now.</a>
        </p>
        <p class="fw-bold text-medium-gray">
            Password not remember me ?
            <a class="text-decoration-none text-white" href="{{ route('user.forgot') }}">
                Forgot Now</a>
        </p>
    </form>
</div>
@endsection
