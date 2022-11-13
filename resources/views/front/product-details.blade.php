@extends('front.layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('front/styles/products.css')}}" />
@endsection
@section('content')
@include('front.layouts.header')
<div class="ts-wrapper">

    <main class="ts-listing-details mw-1000 mx-auto">
        <div class="container">
            <h1 class="ts-heading-1 text-uppercase text-center fw-bold mb-6">
               {{$product->name}}
            </h1>

            <h2 class="ts-heading-4 fw-bold mb-6">DETAILS</h2>
            <div class="mb-10">
                <div class="row row-cols-lg-2">
                    <div class="mb-4">
                        <p class="ts-heading-5 mb-0">EMAIL :  {{$product->email}}</p>
                    </div>
                    <div class="mb-4">
                        <p class="ts-heading-5 mb-0">
                            LOCATION :  {{$product->location}},
                        </p>
                    </div>
                </div>
                <div class="row row-cols-lg-2">
                    <div class="mb-4">
                        <p class="ts-heading-5 mb-0">WEBSITE LINK :  {{$product->website}}</p>
                    </div>
                    {{-- <div class="mb-4">
                        <p class="ts-heading-5 mb-0">OF EMPLOYEES : www.google.com</p>
                    </div> --}}
                </div>
                <div class="row row-cols-lg-2">
                    <div class="mb-4">
                        <p class="ts-heading-5 mb-0">YEARLY REVENUE : {{AppHelper::setCurrency($product->revenue)}}</p>
                    </div>
                    @if($product->facebook)
                    <div class="d-flex flex-wrap gap-4 mb-4">
                        <p class="ts-heading-5 mb-0">SOCIAL LINK :</p>
                        <nav class="ts-footer__footer d-flex justify-content-center gap-4">
                            <a href="{{$product->facebook}}">
                                <img width="15" src="{{ asset('front/assets/icons/facebook.svg')}}" alt="..." />
                            </a>
                            {{-- <a href="#">
                                <img width="30" src="./assets/icons/twitter.svg" alt="..." />
                            </a>
                            <a href="#">
                                <img width="30" src="./assets/icons/instagram.svg" alt="..." />
                            </a>
                            <a href="#">
                                <img width="30" src="./assets/icons/youtube.svg" alt="..." />
                            </a> --}}
                        </nav>
                    </div>
                    @endif
                </div>
            </div>

            {{-- <nav class="ts-pagination mb-8" aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" href="#"> Previous</a>
                    </li>

                    <li class="page-item">
                        <a class="page-link" href="./product-listing.html">Products</a>
                    </li>

                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav> --}}
        </div>
    </main>

</div>
@endsection