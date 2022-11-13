@extends('front.layouts.app')
@section('content')
@include('front.layouts.header')
<section class="ts-hero text-white">
    <div class="container">
        <div class="ts-hero__main">
            <div class="ts-hero__text mw-1000 mx-auto">
                <h1 class="ts-page__title fw-bold">Welcome to Agency Bridge</h1>
                <p class="ts-page__subtitle">Your hunt for a client ends here…</p>

                <p class="ts-desc-lg">
                    Agency Bridge connects Agency owners to their potential clients
                    with extreme efficiency. Our technology sources thousands of
                    verified leads weekly. Staying a step ahead of the competition
                    by making outreach simple.
                </p>

                <button class="btn btn-secondary btn-xl">
                    CLICK TO LEARN MORE
                </button>
            </div>
        </div>
    </div>
    <img class="ts-hero__bottom-img" src="{{asset('front/assets/images/curved_SVG_section.svg')}}" alt="..." />
</section>

<div class="ts-products text-center">
    <div class="container">
        <div class="row row-cols-lg-3 gap-4 gap-lg-0 mb-5">
            <div>
                <img class="rounded-3 w-100 mb-4" src="{{asset('front/assets/images/image-placeholder.png')}}" alt="..." />

                <p class="ts-desc-lg">5000+ New VERIFIED Leads Added Weekly.</p>
            </div>
            <div class="mt-lg-10">
                <img class="rounded-3 w-100 mb-4" src="{{asset('front/assets/images/image-placeholder.png')}}" alt="..." />

                <p class="ts-desc-lg">
                    Perfect for agency owners serving Brick and Mortar Businesses or
                    Ecommerce Businesses.
                </p>
            </div>
            <div class="mt-lg-20">
                <img class="rounded-3 w-100 mb-4" src="{{asset('front/assets/images/image-placeholder.png')}}" alt="..." />

                <p class="ts-desc-lg">All Information Verified and Valid.</p>
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-secondary btn-xl">
                START A FREE TRIAL TODAY!
            </button>
        </div>
    </div>
</div>
@endsection