

    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-bell"></i>

            <span class="badge badge-danger">
              {{ auth()->user()?->unreadNotifications?->count() ?? 0 }}            </span>
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

            {{-- Header --}}
            <span class="dropdown-item dropdown-header">
                {{ auth()->user()?->unreadNotifications?->count() ?? 0 }} Notifications
            </span>

            <div class="dropdown-divider"></div>

            {{-- Notifications List --}}
            @auth
                @forelse(auth()->user()->unreadNotifications->take(5) as $notification)

                    <a href="#" class="dropdown-item">

                        <i class="fas fa-briefcase mr-2"></i>

                        {{ $notification->data['message'] ?? 'New Notification' }}

                        <span class="float-right text-muted text-sm">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>

                    </a>

                    <div class="dropdown-divider"></div>

                @empty

                    <span class="dropdown-item text-muted text-center">
                        No Notifications
                    </span>

                @endforelse
            @endauth
            {{-- Footer --}}
            <a href="#" class="dropdown-item dropdown-footer">
                View All Notifications
            </a>

        </div>
    </li>
