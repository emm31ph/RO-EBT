<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ __('Release Order') }}
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                @if (Auth::user()->hasPermission(['release-*']))
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Release<span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @if (Auth::user()->hasPermission(['release-read']))
                        <a class="dropdown-item" href="{{ route('ro.index') }}">Dashboard</a>
                        @elseif(Auth::user()->hasPermission(['release-import']))
                        <a class="dropdown-item" href="{{ route('release.import') }}">Import</a>
                        @elseif(Auth::user()->hasPermission(['release-release order list']))
                        <a class="dropdown-item" href="{{ route('release.list') }}">Release Order List</a>
                        @elseif(Auth::user()->hasPermission(['release-delivery list']))
                        <a class="dropdown-item" href="{{ route('release.delivery') }}">Delivered List</a>
                        @endif
                        @if (Auth::user()->hasPermission(['release-create']))
                        <a class="dropdown-item" href="{{ route('ro.create') }}">Create Delivery</a>
                        @endif
                    </div>
                </li>
                @endif
                @if (Auth::user()->hasPermission(['users-read', 'users-create']))
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        Users<span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @if (Auth::user()->hasPermission(['users-read']))
                        <a class="dropdown-item" href="{{ route('manage.user.index') }}">Dashboard</a>
                        @endif
                        @if (Auth::user()->hasPermission(['users-create']))
                        <a class="dropdown-item" href="{{ route('manage.user.create') }}">Create user</a>
                        @endif
                    </div>
                </li>
                @endif
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a href="{{ route('manage.user.edit', auth::user()->id) }}" class="dropdown-item">
                            <span class="icon">
                                <i class="fa fa-fw m-r-15 fa-user-circle-o m-r-5"></i>
                            </span> Profile
                        </a>
                        @if (Auth::user()->hasPermission(['acl-read']))
                        <a class="dropdown-item" href="{{ route('manage.role.index') }}">
                            <span class="icon">
                                <i class="fa fa-fw m-r-15 fa-cog m-r-5"></i>
                            </span>
                            Manage</a>
                        @endif
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                            <span class="icon">
                                <i class="fa fa-fw m-r-15 fa-sign-out m-r-5"></i>
                            </span>
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>