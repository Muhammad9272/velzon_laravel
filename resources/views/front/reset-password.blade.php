@extends('front.layouts.app')
@section('content')
<div class="container">
    <nav class="text-center py-4 mb-4">
        <a href="{{ route('front.index') }}">
            <img width="132" class="mb-3" src="{{asset('front/assets/images/logo-black.png')}}" alt="..." />
        </a>
    </nav>

    <form action="{{route('user.password.rreset.sub')}}" method="post" class="ts-contact-form rounded-3 mb-10">
        @csrf
            @include('admin.includes.alerts')
        <input type="hidden" name="token" value="{{ $token }}">
    
        <h1 class="ts-heading-2 text-center text-white mb-6 fw-bold">
            Forget Password
        </h1>

        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="useEmail" placeholder="Email"  name="email" readonly value="{{$email}}" />
            <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingInput" placeholder="New Password" name="password" />
            <label for="floatingInput">New Password</label>
        </div>
        <div class="form-floating mb-5">
            <input type="password" class="form-control" id="tsConfirmPassword" placeholder="Confirm New Password" name="password_confirmation" required />
            <label for="floatingInput">Confirm New Password</label>
        </div>

        <button type="submit" class="btn btn-secondary w-100 mb-6">
            Confirm Reset
        </button>
    </form>
</div>
@endsection