
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$gs->name}}</title>
    @if($gs->ngrok==1)
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    @endif
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="{{ asset('front/styles/index.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/styles/common.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/styles/forms.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/custom.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @yield('css')
  </head>
  <body>
    <div class="ts-wrapper">
      
       @yield('content')      
       @include('front.layouts.footer')

    </div>
    


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
      crossorigin="anonymous"
    ></script>
    <script type="text/javascript" src="{{ asset('front/custom.js') }}"></script>

    @yield('script')
  </body>
</html>
