<div class="sidebar" data-color="classic" data-background-color="black" data-image="{{ asset('material') }}">
    <div class="logo">
        <a href="" class="simple-text logo-normal">
            {{ __('Saha-Yatri') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="material-icons">dashboard</i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li class="nav-item {{ $activePage == 'client-app' || $activePage == 'driver-app' ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#appExample" aria-expanded="true">
                    <i class="material-icons">apps</i>
                    <p>{{ __('Applications') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="appExample">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'client-app' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('client.app') }}">
                                <i class="material-icons">account_box</i>
                                <span class="sidebar-normal">{{ __('Client App') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'driver-app' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('driver.app') }}">
                                <i class="material-icons">engineering</i>
                                <span class="sidebar-normal"> {{ __('Driver App') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li
                class="nav-item {{ $activePage == 'update-rate' || $activePage == 'update-driver' || $activePage == 'add-driver'? ' active': '' }}">
                <a class="nav-link" data-toggle="collapse" href="#driver" aria-expanded="true">
                    <i class="material-icons">engineering</i>
                    <p>{{ __('Drivers') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse show" id="driver">
                    <ul class="nav">
                        <li class="nav-item{{ $activePage == 'add-driver' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('add.driver') }}">
                                <i class="material-icons">person_add_alt_1</i>
                                <span class="sidebar-normal">{{ __('Add Driver') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'update-driver' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('manage.driver') }}">
                                <i class="material-icons">manage_accounts</i>
                                <span class="sidebar-normal"> {{ __('Manage Drivers') }} </span>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'update-rate' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('add.vehicleType') }}">
                                <i class="material-icons">trending_up</i>
                                <span class="sidebar-normal"> {{ __('Update Fare Rates') }} </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <i class="material-icons">person</i>
                    <p>{{ __('Users') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'rides' ? ' active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="material-icons">taxi_alert</i>
                    <p>{{ __('Rides') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('profile.edit') }}">
                    <i class="material-icons">admin_panel_settings</i>
                    <p>{{ __('Update Profile') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'settings' ? ' active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="material-icons">settings</i>
                    <p>{{ __('Settings') }}</p>
                </a>
            </li>
            <li class="nav-item{{ $activePage == 'logout' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="material-icons">logout</i>
                    <p>{{ __('Log Out') }}</p>
                </a>
            </li>
            {{-- <li class="nav-item{{ $activePage == 'user-mgmt' ? ' active' : '' }}">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <span class="sidebar-mini"> UM </span>
                    <span class="sidebar-normal"> {{ __('User Management') }} </span>
                </a>
            </li> --}}
        </ul>
    </div>
</div>
