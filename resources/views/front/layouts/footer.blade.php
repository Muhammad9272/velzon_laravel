      <footer class="ts-footer">
        <div class="container">
          <div class="ts-footer__main text-center">
            <a href="{{route('front.index')}}">
              <img
                class="mb-4"
                width="132"
                src="{{asset('front/assets/images/logo-white.png')}}"
                alt="..."
              />
            </a>
            <hr />
            <nav
              class="ts-footer__links d-flex gap-4 justify-content-center mb-5"
            >
              <a href="{{ route('front.index') }}" class="ts-footer__link">Home</a>
              <a href="{{route('front.category')}}" class="ts-footer__link">Category</a>
              <a href="{{ route('front.pricing') }}" class="ts-footer__link">Membership</a>
            </nav>
          </div>
        </div>

        <nav class="ts-footer__footer d-flex justify-content-center gap-5 py-4">
          @if($gs->facebook)
          <a href="{{$gs->facebook}}">
            <img width="15" src="{{asset('front/assets/icons/facebook.svg')}}" alt="..." />
          </a>
          @endif
          @if($gs->twitter)
          <a href="{{$gs->twitter}}">
            <img width="30" src="{{asset('front/assets/icons/twitter.svg')}}" alt="..." />
          </a>
          @endif
          @if($gs->instagram)
          <a href="{{$gs->instagram}}">
            <img width="30" src="{{asset('front/assets/icons/instagram.svg')}}" alt="..." />
          </a>
          @endif
          @if($gs->youtube)
          <a href="{{$gs->youtube}}">
            <img width="30" src="{{asset('front/assets/icons/youtube.svg')}}" alt="..." />
          </a>
          @endif
        </nav>
      </footer>