      <header class="text-center py-4 mb-4 fixed-top">
        <div class="container">
          <nav class="navbar navbar-expand-lg bg-white shadow">
            <div class="container-fluid">
              <a class="navbar-brand" href="{{route('front.index')}}">
                <img
                  width="93"
                  src="{{asset('front/assets/images/logo-black.png')}}"
                  alt="..."
                />
              </a>
              <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
              >
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 me-lg-5 mb-lg-0">
                  @if(!Auth::check() || (Auth::check() && !Auth::user()->userSubscriptions()->exists()))
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('front.index') }}"
                      >Home</a
                    >
                  </li> 
                  @endif                 
                  @if(!Auth::check())
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.login') }}">Login</a>
                  </li>
                  @else
                    @if(Auth::user()->userSubscriptions()->exists())
                    <li class="nav-item">
                      <a class="nav-link" aria-current="page" href="{{ route('front.category') }}">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">       
                          Affiliate Dashboard
                        </a>
                    </li>
                    @endif
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.logout') }}">Logout</a>
                  </li>
                  @endif
                </ul>
                @if(!Auth::check())
                <a class="btn btn-primary fw-bold" href="{{ route('user.register') }}"
                  >Register</a
                >
                @else
                <a class="btn btn-primary fw-bold" href="{{ route('front.pricing') }}"
                  >{{Auth::user()->userSubscriptions()->exists()?'Cancel Subscription':'Start free Trial'}}</a
                >
                @endif
              </div>
            </div>
          </nav>
        </div>
      </header>