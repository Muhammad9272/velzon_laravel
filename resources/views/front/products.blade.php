@extends('front.layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('front/styles/products.css')}}" />
@endsection
@section('content')
@include('front.layouts.header')
<div class="ts-wrapper">


    <main class="ts-category-main">
        <div class="container">
            <h1 class="ts-heading-1 text-uppercase text-center fw-bold mb-6">
                Our Listings
            </h1>

            <div class="mw-1000 mx-auto">
                <div class="ts-category-filter d-flex flex-column-reverse flex-md-row justify-content-between mb-6">
                    <form action="{{ route('front.category.detail',[Request::route('category')]) }}" method="get" id="searchlistForm" class="ts-category-filter__search">
                        <div>
                            <input type="text" class="form-control form-control-lg rounded-pill" id="tsProductSearch"
                                placeholder="Search for your listing" name="name" />
                        </div>

                        <button type="submit" class="btn p-0">
                            <img src="{{asset('front/assets/icons/search-icon-circle.svg')}}" alt="..." />
                        </button>
                    </form>
                    <div>
                        <select class="form-select form-select-lg rounded-pill" aria-label="Default select example" id="category_select">
                            <option selected disabled value="">Category Filter</option>
                            @foreach ($categories as $category)
                                <option {{Request::route('category')==$category->slug?'selected':''}} value="{{$category->slug}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="ts-product-listing mb-10">
                    @foreach ($products as $data)
                    <div>
                        <a class="text-decoration-none text-dark-gray" href="{{ route('front.product.detail',$data->slug) }}">
                            <div class="ts-product-card shadow-sm rounded-3 overflow-hidden">
                                <div class="ts-product-card__header">
                                    <img src="{{($data->category && $data->category->photo)?asset('/assets/images/category/'.$data->category->photo):URL::asset('front/assets/images/product-card-image.png')}}" alt="..." />
                                </div>
                                <div class="ts-product-card__body">
                                    <div class="ts-product-card__content my-auto">
                                        <div class="row row-cols-lg-2 mb-lg-3">
                                            <h5 class="fw-bold ts-heading-6">
                                                COMPANY NAME : {{$data->name}}
                                            </h5>
                                            <h5 class="fw-bold ts-heading-6">
                                                WEBSITE : {{$data->website}}
                                            </h5>
                                        </div>
                                        <div class="row row-cols-lg-2">
                                            <h5 class="fw-bold ts-heading-6">NICHE : {{$data->category?$data->category->name:''}}</h5>
                                            @if($data->facebook)
                                            <div class="d-flex flex-nowrap">
                                                <h5 class="fw-bold ts-heading-6 text-nowrap">
                                                    SOCIAL MEDIA :
                                                </h5>
                                                <div class="d-flex gap-2">
                                                    <nav class="ts-footer__footer d-flex justify-content-center gap-2">
                                                        <a href="{{$data->facebook}}">
                                                            <img width="10" src="{{asset('front/assets/icons/facebook.svg')}}"
                                                                alt="..." />
                                                        </a>
                                                        {{-- <a href="#">
                                                            <img width="20" src="./assets/icons/twitter.svg"
                                                                alt="..." />
                                                        </a>
                                                        <a href="#">
                                                            <img width="20" src="./assets/icons/instagram.svg"
                                                                alt="..." />
                                                        </a>
                                                        <a href="#">
                                                            <img width="20" src="./assets/icons/youtube.svg"
                                                                alt="..." />
                                                        </a> --}}
                                                    </nav>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                   {{--  <div class="ts-product-card__icon-list d-flex gap-4 flex-wrap">
                                        <div class="d-flex align-items-center gap-2">
                                            <a class="text-decoration-none" href="#">
                                                <img width="25" src="./assets/icons/bx_bed.svg" alt="..." />
                                            </a>
                                            <span>12</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a class="text-decoration-none" href="#">
                                                <img width="25" src="./assets/icons/fa_bath.svg" alt="..." />
                                            </a>
                                            <span>12</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a class="text-decoration-none" href="#">
                                                <img width="25" src="./assets/icons/ant-design_car-filled.svg"
                                                    alt="..." />
                                            </a>
                                            <span>12</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <a class="text-decoration-none" href="#">
                                                <img width="25" src="./assets/icons/bi_image.svg" alt="..." />
                                            </a>
                                            <span>12</span>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    
                </div>

                <nav class="ts-pagination" aria-label="Page navigation example">
                     {{ $products->Oneachside(2)->appends($returndata)->links('front.pagination.default') }}
                </nav>
            </div>

        </div>
    </main>

</div>
@endsection
@section('script')
<script type="text/javascript">
 $('#category_select').on('change',function(){
  var val = $(this).val();
  let url='{{ route('front.category.detail',':category') }}';
  url=url.replace(':category',val);
  $('#searchlistForm').attr('action',url);
  $('#searchlistForm').submit();
});
</script>
@endsection