<nav class="navbar">
    <div class="container">
        <div class="nav-left nav-menu">
            <a href="{{ route('index') }}" class="nav-item is-tab @if (isRoute('index')) is-active @endif">
                {{ trans('label.home') }}
            </a>
            <a class="nav-item is-tab @if (isRoute('events.index', true)) is-active @endif">
                {{ trans('label.events') }}
            </a>
        </div>

        <div class="nav-center">
            <a href="{{ route('index') }}" class="nav-item">
                <img class="logo" src="{{ Settings::logo() }}" alt="{{ Settings::title() }}">
            </a>
        </div>

        <!-- This "nav-toggle" hamburger menu is only visible on mobile -->
        <!-- You need JavaScript to toggle the "is-active" class on "nav-menu" -->
        <span class="nav-toggle">
            <span></span>
            <span></span>
            <span></span>
        </span>

        <!-- This "nav-menu" is hidden on mobile -->
        <!-- Add the modifier "is-active" to display it on mobile -->
        <div class="nav-right nav-menu">

            @if($loggedUser)
                <div class="nav-item">
                    <dropdown v-on:click="markNotifications" activate="#notifications-menu" :constrain-width="false" class="icon"
                              :class="!notificationsMarked ? '{{ count($loggedUser->unreadNotifications) ? 'with-badge' : '' }}' : ''">
                        <icon icon="{{ config('icons.notifications') }}">@if(count($loggedUser->unreadNotifications))
                                <span v-if="!notificationsMarked"
                                      class="badge">{{ count($loggedUser->unreadNotifications) }}</span>@endif
                        </icon>
                    </dropdown>
                    <div id="notifications-menu" class="dropdown-menu">
                        <ul class="notification-list">@if(count($loggedUser->notifications))@foreach ($loggedUser->notifications as $notification)@include('notifications.' . snake_case(class_basename($notification->type)))@endforeach@else
                                <li class="no-data">{{ trans('messages.no_notifications') }}</li>@endif</ul>
                    </div>
                </div>
                <div class="nav-item">
                    <dropdown activate="#user-menu" alignment="none" class="button is-large user-button">
                        <div class="avatar x-small"
                             style="background-image: url({{ $loggedUser->avatar }})"></div>
                        <div class="profile-info"><span class="name">{{ $loggedUser->getDisplayName() }}</span><span
                                    class="role">{{ $loggedUser->getTypeAsString() }}</span></div>
                        <i class="fa custom-caret"></i>
                    </dropdown>

                    <div id="user-menu" class="dropdown-menu user-menu">
                        <ul class="list-unstyled">
                            <li class="divider"></li>
                            <li @if (Request::is('user')) class="active" @endif><a
                                        href="{{ $loggedUser->getEditPath() }}">
                                    <icon icon="{{ config('icons.user') }}"></icon>{{ trans('label.profile') }}</a></li>
                            <li @if (Request::is('admin/profile/*')) class="active" @endif><a
                                        href="{{ $loggedUser->getEditPath() }}">
                                    <icon icon="{{ config('icons.edit') }}"></icon>{{ trans('action.edit_profile') }}
                                </a></li>
                            <li id="logout-button">
                                <form-link :alert="false" redirect="{{ route('login') }}" action="{{ route('logout') }}"
                                           method="POST">
                                    <icon icon="{{ config('icons.logout') }}"></icon>{{ trans('action.logout') }}
                                </form-link>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <div class="nav-item">
                    <a href="{{ route('login') }}" class="button">
                        <span>{{ trans('action.login') }}</span>
                    </a>
                    <a href="{{ route('register') }}" class="button is-primary">
                        <span>{{ trans('action.register') }}</span>
                    </a>
                </div>
            @endif

        </div>
    </div>
</nav>