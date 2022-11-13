@extends('front.layouts.app')
@section('content')
<div class="container">
    <nav class="text-center py-4 mb-4">
        <a href="{{ route('front.index') }}">
            <img width="132" class="mb-3" src="{{asset('front/assets/images/logo-black.png')}}" alt="..." />
        </a>
    </nav>

    <form action="{{route('user.forgot.submit')}}" method="post" class="ts-contact-form rounded-3 mb-10">
        @csrf
          @include('admin.includes.alerts')
        <h1 class="ts-heading-2 text-center text-white mb-2 fw-bold">
            Forgot Password?
        </h1>
        <p class="text-white">Please enter your registered email address below. We will email you a verification code to reset your password.</p>

        <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" id="useEmail" placeholder="Email" />
            <label for="floatingInput">Email</label>
        </div>

        <button type="submit" class="btn btn-secondary w-100 mb-6">
            Next
        </button>
    </form>
</div>
@endsection