@extends('front.layouts.app')
@section('css')
  <link rel="stylesheet" href="{{asset('front/styles/pricing.css')}}" />
  <link rel="stylesheet" href="{{asset('front/payment.css')}}" />
  <script type="text/javascript">
      
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

<div class="ts-video mb-8">
    <video id="videoDesktop" controls crossorigin playsinline
        poster="{{asset('front/assets/images/register-video-poster.jpg')}}">
        <source type="video/mp4" src="https://vjs.zencdn.net/v/oceans.mp4" />
        <a>Video not supported</a>
    </video>
</div>    
<div class="pricing form-wizard" id="form-wizard">
    <div class="row">
        <div class="col-md-6 m-auto text-center">
            <div class="d-inline-flex tab-span">
                <a href="javascript:;" onclick="infomsg('You are already registered please choose a plan to continue!')" class="tab-btn">Register</a>
                <a href="{{route('front.pricing')}}" class="tab-btn active">Pricing</a>
            </div> 
        </div>    
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-4 m-auto text-center">
           @include('front.includes.alerts') 
        </div>       
    </div>
    <div class="pricing-group row row-cols-lg-3 mb-7 gap-5 gap-lg-0 w-100 mx-auto">
        @foreach ($datas as $data)

            <div class="pricing-table m-auto {{$data->is_featured==1?'pricing-table--primary':''}}">
                <div class="d-flex justify-content-between align-items-baseline"> 
                    <h6 class="ts-heading-6 mb-3 fw-bold">{{$data->second_name}}</h6>
                    @if (isset($checkSubscription) && $data->name==$checkSubscription->stripe_price)  
                    <span class="badge bg-success">Active Plan</span>
                    @endif
                </div>
              
                <p class="mb-4">
                   {{$data->details}}
                </p>
                @if($data->free_trial>0)   
                <div class="d-flex flex-wrap align-items-center gap-2 mb-0">            
                    <h1 class="fw-bold">Free</h1>
                    <p class="mb-0"> {{$data->free_trial}} days Free Trial</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2 mb-4">            
                    <p class="fw-bold mb-0">{{AppHelper::setCurrency($data->price)}}</p>
                    <p class="mb-0">/ {{AppHelper::setInterval($data->interval)}}</p>
                </div>

                @else
                <div class="d-flex flex-wrap align-items-center gap-2 mb-4">            
                    <h1 class="fw-bold">{{AppHelper::setCurrency($data->price)}}</h1>
                    <p class="mb-0">/ {{AppHelper::setInterval($data->interval)}}</p>
                </div>
                @endif

                @if (isset($checkSubscription) && $data->name==$checkSubscription->stripe_price)                    
                        <a href="javascript:;" data-planName="{{$data->second_name}}" data-bs-toggle="modal" data-bs-target="#cancelSubscription" data-cancelhref="{{route('front.subplan.cancel',$checkSubscription->id)}}" class="btn btn-outline-primary w-100 mb-5 fw-bold packagedetails">
                            Cancel Subscription
                        </a>
                @else
                 <button type="button" data-planName="{{$data->second_name}}" data-bs-toggle="modal" data-bs-target="#subplanModal" data-href="{{route('front.subplan.detail',$data->id)}}" class="btn btn-outline-primary w-100 mb-5 fw-bold packagedetails">
                        Get Started Now
                    </button>
                @endif

                <ul class="pricing-table__list">                   
                    <?php $arr=json_decode($data->features);?>
                    @foreach($subfeatures as $key=>$subfeature)
                        @if(in_array($subfeature->id,$arr))
                        <li class="yes">{{$subfeature->name}}</li>
                        @else
                        <li class="not">{{$subfeature->name}}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endforeach
        


        <!-- The Modal For Subscription -->
        <div class="modal fade" id="subplanModal">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h6 class="modal-title ts-heading-6  fw-bold">Subscribe</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <!-- Modal body -->
              <div class="jq-loader mt-1">
                <div class="d-flex justify-content-center">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
              </div>
              <div class="modal-body">
                
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
              </div>

            </div>
          </div>
        </div>

         <!-- The Modal For SubscriptionCancel -->
        <div class="modal fade" id="cancelSubscription">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h6 class="modal-title ts-heading-6  fw-bold">Cancel Subscription</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <!-- Modal body -->
              
              <div class="modal-body">
                 <h6 class="ts-heading-6  fw-bold">You are going to unsubscribe this package! Are u sure?</h6>
              </div>

   
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href=""  class="btn btn-primary btn-ok">Continue</a>
              </div>

            </div>
          </div>
        </div>

    </div>
</div>
@endsection
@section('script')
   <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        function infomsg(msg) {
            toastr.info(msg);
        }
    </script>
@endsection