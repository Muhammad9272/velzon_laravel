@extends('admin.layouts.master')
@section('title')
   {{--  @lang('translation.basic-elements') --}}
   Create Product 
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
              <a href="{{ route('admin.product.index') }}">  Product  </a>
        @endslot
        @slot('title')
            Create
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Create Product </h4>
                    <div class="flex-shrink-0">
                       
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        @include('admin.includes.alerts')
                        <form action="{{ route('admin.product.create') }}" method="post" >
                            @csrf
                            <div class="row gy-4">
                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="sku" class="form-label"> Product Sku Unique Code</label>
                                        <input type="text" name="sku" class="form-control" id="sku" required value="{{substr(time(), 6,8).str_random(3) }}">
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="basiInput" class="form-label"> Name</label>
                                        <input type="text" name="name" class="form-control" id="basiInput">

                                    </div>
                                </div>
                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="category_id" class="form-label"> Category Id</label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="" >Select Category</option>
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}" >{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        
                                       

                                    </div>
                                </div>
                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="website" class="form-label"> Website </label>
                                        <input type="text" name="website" class="form-control" id="website">
                                    </div>
                                </div>

                                      <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="email" class="form-label"> Email </label>
                                        <input type="text" name="email" class="form-control" id="email">

                                    </div>
                                </div>
                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="phone" class="form-label"> Phone </label>
                                        <input type="text" name="phone" class="form-control" id="phone">
                                    </div>
                                </div>

                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="location" class="form-label"> Location </label>
                                        <input type="text" name="location" class="form-control" id="location">
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <label for="revenue" class="form-label"> Revenue </label>
                                        <input type="number" name="revenue" class="form-control" id="revenue">
                                    </div>
                                </div>
                                <div class="col-xxl-12 col-md-12">
                                    <div>
                                        <label for="details" class="form-label"> Add Description </label>
                                        <textarea class="form-control" id="details" name="details" rows="4">
                                               
                                        </textarea>
                                    </div>
                                </div>

                                <hr>
                                  <h4 class="card-title mb-0 flex-grow-1">Social Links </h4>
                                <hr>

                                <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="Facebook" class="form-label"> Facebook </label>
                                        <input type="text" name="facebook" class="form-control" id="Facebook">
                                    </div>
                                </div>
                               {{--  <div class="col-xxl-3 col-md-6">
                                    <div>
                                        <label for="Twitter" class="form-label"> Twitter </label>
                                        <input type="text" name="twitter" class="form-control" id="Twitter">
                                    </div>
                                </div>
                                 <div class="col-xxl-3 col-md-4">
                                    <div>
                                        <label for="Instagram" class="form-label"> Instagram </label>
                                        <input type="text" name="instagram" class="form-control" id="Instagram">
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-md-4">
                                    <div>
                                        <label for="Youtube" class="form-label"> Youtube </label>
                                        <input type="text" name="youtube" class="form-control" id="Youtube">
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-md-4">
                                    <div>
                                        <label for="LinkedIn" class="form-label"> LinkedIn </label>
                                        <input type="text" name="LinkedIn" class="form-control" id="linkedin">
                                    </div>
                                </div> --}}




                                <!--end col-->
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">Submit form</button>
                                </div>
                                <!--end col-->
                            </div>
                        </form>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/prismjs/prismjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
