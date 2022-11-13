@extends('front.layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('front/payment.css')}}" />
<link rel="stylesheet" href="{{asset('front/styles/pricing.css')}}" />
  <script type="text/javascript">
      var key_stripe = "{{ $key }}";
      var full_name_user = '{{ auth()->user()->name }}';
      var payment_card_error="An error has occurred, try again";
  </script>
@endsection
@section('content')


<nav class="text-center py-4 mb-6">
    <a href="{{ route('front.index') }}">
        <img width="132" class="mb-3" src="{{asset('front/assets/images/logo-black.png')}}" alt="..." />
    </a>
</nav>
<div class="container">
    <div class="row mx-auto">
        <div class="col-md-6">
            {{-- <input id="card-holder-name" type="text">--}}
            <form action="{{ route('front.subplan.submit',$data->id) }}" method="post" id="activateplan">
                @csrf
                @include('admin.includes.alerts')
                <!-- Stripe Elements Placeholder -->
                <div id="card-element"></div>
                <div id="card-errors" class="alert alert-danger display-none" role="alert"></div>
                 
                <button id="card-button" data-route="{{ route('front.subplan.submit',$data->id) }}" class="btn btn-primary btn-lg" data-secret="{{ $intent->client_secret }}">
                    Update Payment Method
                </button>
               
            </form>


            <div class="btn-block text-center mt-2">
            <small><i class="fa fa-lock text-success mr-1"></i>  Your private card number will never touch our servers.</small>
          </div>
        </div>
        <div class="col-md-6">
            <h3>Plan Details</h3>
            <p>{{$data->name}}</p>
            <p>{{$data->price}}</p>
        </div>
    </div>
</div>
@endsection
@section('script')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('common_assets/js/add-payment-card.js') }}"></script>
@endsection