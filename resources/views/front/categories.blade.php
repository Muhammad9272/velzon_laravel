@extends('front.layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('front/styles/category.css')}}" />
@endsection
@section('content')
@include('front.layouts.header')
<div class="ts-wrapper">


    <main class="ts-category-main">
        <div class="container">
            <h1 class="ts-heading-1 text-uppercase text-center fw-bold mb-6">
                Categories
            </h1>

            <div class="mw-1000 mx-auto">
                <div class="ts-categories">
                    @foreach ($categories as $data)
                    <a class="text-dark nounderline" href="{{ route('front.category.detail',$data->slug) }}">
                    <div class="ts-category px-0">
                        <img class="w-100 rounded-3" src="{{$data->photo?asset('/assets/images/category/'.$data->photo):URL::asset('front/assets/images/CategoryCart.png')}}" alt="..." />
                        <div class="ts-category__category">
                            <img src="{{ asset('front/assets/icons/icon-globe.svg')}}" alt="..." />
                        </div>

                        <h3 class="text-center fw-bold mt-3">
                            {{$data->name}}
                           {{--  <a class="text-center fw-bold mt-3 text-dark nounderline" href="{{ route('front.category.detail',$data->slug) }}"> </a> --}}
                        </h3>
                    </div>
                    </a>
                    @endforeach
                    

                </div>
            </div>
        </div>
    </main>

</div>
@endsection