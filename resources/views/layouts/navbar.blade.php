<header class="header">
    <div class="container">
        <div class="header-left">
            <a href="{{ route('index') }}">
                <img src="{{ Settings::logo() }}" height="55"/>
            </a>
        </div>

        <div class="header-right">


            <ul class="header-buttons">
                <li>
                    <a href="{{ route('index') }}">
                        {{ trans('label.events') }}
                    </a>
                </li>
                @if($loggedUser)
                    <li class="separator sm-hidden"></li>
                    <li v-on:click="markNotifications" class="xs-hidden">
                        <dropdown activate="#notifications-menu" :constrain-width="false"
                                  :class="!notificationsMarked ? '{{ count($loggedUser->unreadNotifications) ? 'with-badge' : '' }}' : ''">
                            <icon icon="{{ config('icons.notifications') }}">
                                @if(count($loggedUser->unreadNotifications))
                                    <span v-if="!notificationsMarked"
                                          class="badge">{{ count($loggedUser->unreadNotifications) }}</span>
                                @endif
                            </icon>
                        </dropdown>

                        <div id="notifications-menu" class="dropdown-menu">
                            <ul class="notification-list">
                                @if(count($loggedUser->notifications))
                                    @foreach ($loggedUser->notifications as $notification)
                                        @include('notifications.' . snake_case(class_basename($notification->type)))
                                    @endforeach
                                @else
                                    <li class="no-data">{{ trans('messages.no_notifications') }}</li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>

            <span class="separator sm-hidden"></span>
            @if($loggedUser)
                <div class="userbox">
                    <dropdown activate="#user-menu" :below-origin="false" alignment="none">
                        <div class="avatar x-small"
                             style="background-image: url({{ $loggedUser->getAvatarLink() }})"></div>
                        <div class="profile-info">
                            <span class="name">{{ $loggedUser->getDisplayName() }}</span>
                            <span class="role">{{ $loggedUser->getTypeAsString() }}</span>
                        </div>

                        <i class="fa custom-caret"></i>
                    </dropdown>

                    <div id="user-menu" class="dropdown-menu user-menu">
                        <ul class="list-unstyled">
                            <li class="divider"></li>
                            <li @if (Request::is('user')) class="active" @endif>
                                <a href="{{ $loggedUser->getEditPath() }}">
                                    <icon icon="{{ config('icons.user') }}"></icon>
                                    {{ trans('label.profile') }}
                                </a>
                            </li>
                            <li @if (Request::is('admin/profile/*')) class="active" @endif>
                                <a href="{{ $loggedUser->getEditPath() }}">
                                    <icon icon="{{ config('icons.edit') }}"></icon>
                                    {{ trans('action.edit_profile') }}
                                </a>
                            </li>
                            <li id="logout-button">
                                <form-link :alert="false" redirect="{{ route('login') }}" action="{{ route('logout') }}"
                                           method="POST">
                                    <icon icon="{{ config('icons.logout') }}"></icon>
                                    {{ trans('action.logout') }}
                                </form-link>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <ul class="header-buttons">
                    <li>
                        <a href="{{ route('login') }}">{{ trans('action.login') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">{{ trans('action.register') }}</a>
                    </li>
            @endif
        </div>
    </div>
</header>