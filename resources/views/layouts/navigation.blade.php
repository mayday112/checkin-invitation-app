{{-- Java Swing JMenuBar --}}
<nav class="swing-menubar" x-data="{ userMenu: false }">
    {{-- App Icon & name --}}
    <span class="menu-item" style="font-weight:bold; color:#000080; letter-spacing:0; cursor:default;">
        📋 Hadir.in
    </span>
    <div class="menu-separator"></div>
    
    {{-- File Menu --}}
    <a href="{{ route('events.index') }}" 
       class="menu-item {{ request()->routeIs('events.*') ? 'active' : '' }}">
        File
    </a>
    
    {{-- Events submenu trigger --}}
    <a href="{{ route('events.create') }}" 
       class="menu-item {{ request()->is('events/create') ? 'active' : '' }}">
        New Event
    </a>

    <div class="menu-separator"></div>

    {{-- View Menu --}}
    <a href="{{ route('events.index') }}" 
       class="menu-item {{ request()->routeIs('events.index') ? 'active' : '' }}">
        View
    </a>

    <div class="menu-separator"></div>

    {{-- Tools --}}
    <span class="menu-item" style="cursor:default; color:var(--swing-text-disabled);">Tools</span>
    <span class="menu-item" style="cursor:default; color:var(--swing-text-disabled);">Help</span>

    {{-- Right Side: User Info --}}
    <div class="menu-right">
        @auth
            <div class="menu-separator"></div>
            <div class="menu-user" style="display:flex; align-items:center; gap:6px;">
                <span style="color:#000080; font-weight:bold;">👤</span>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <div class="menu-separator"></div>
            <a href="{{ route('profile.edit') }}" class="menu-item">Profile</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="menu-item" style="background:none; border:none; cursor:pointer; font-family:inherit; font-size:11px;">
                    Logout
                </button>
            </form>
        @endauth
    </div>
</nav>
