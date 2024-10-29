<div id="content">
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar static-top">
        <div class="container">
        <div class="toggle_button d-md-inline">
            <button id="sidebarToggle" class="" type="button">
                <i class="fa fa-bars-staggered"></i>
            </button>
        </div>

        <ul class="navbar-nav ml-auto ms-md-auto align-items-center">
            <!-- Authentication Links -->
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown no-arrow user_prof">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                        <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                       
                        <a class="dropdown-item" href="{{ route('settings') }}">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            Settings
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
                            
                            <i class="fa-solid fa-power-off fa-sm fa-fw mr-2 text-gray-400"></i>
                            {{ __('Log Off') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
		</div>
    </nav>
    <!-- End of Topbar -->
