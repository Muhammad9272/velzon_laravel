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

</div>
@endsection
