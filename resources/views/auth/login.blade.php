<x-guest-layout>
    <div class="dialog-title">
    <span>🔐 Hadir.in — Authentication Required</span>
</div>

<div class="dialog-body">

    <!-- Session Status -->
    @if (session('status'))
        <div class="swing-alert swing-alert-success" style="margin-bottom:8px;">
            <span class="swing-alert-icon">✓</span>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="swing-alert swing-alert-error" style="margin-bottom:8px;">
            <span class="swing-alert-icon">⚠</span>
            <div>
                @foreach ($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Window icon + title area --}}
    <div style="text-align:center; margin-bottom:12px; border-bottom:1px solid var(--swing-dark); padding-bottom:10px;">
        <div style="font-size:36px; margin-bottom:4px;">📋</div>
        <div style="font-weight:bold; font-size:13px;">Hadir.in System</div>
        <div style="font-size:10px; color:var(--swing-text-disabled); font-family:var(--swing-mono);">v1.0.0 — Event Guest Check-In</div>
    </div>

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div class="swing-form-row" style="grid-template-columns: 80px 1fr;">
            <label class="swing-label swing-label-bold" for="email">Email:</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="swing-field" required autofocus autocomplete="username"
                   placeholder="user@example.com">
        </div>

        <div class="swing-form-row" style="grid-template-columns: 80px 1fr;">
            <label class="swing-label swing-label-bold" for="password">Password:</label>
            <input id="password" type="password" name="password"
                   class="swing-field" required autocomplete="current-password"
                   placeholder="••••••••">
        </div>

        <div style="display:flex; align-items:center; gap:6px; margin-bottom:8px; padding-left:84px;">
            <input id="remember_me" type="checkbox" name="remember" style="width:12px; height:12px; accent-color:#000080;">
            <label for="remember_me" class="swing-label" style="margin:0; cursor:pointer;">Remember me on this computer</label>
        </div>

        <div class="swing-separator"></div>

        <div style="font-size:9px; color:var(--swing-text-disabled); font-family:var(--swing-mono); margin: 6px 0;">
            // Secure authentication via Laravel Breeze
        </div>
    </form>
</div>

<div class="dialog-footer" style="justify-content:space-between;">
    <div>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" style="font-size:10px; color:#000080; text-decoration:underline;">
                Forgot password?
            </a>
        @endif
    </div>
    <div style="display:flex; gap:4px;">
        <button type="submit" form="loginForm" class="swing-btn swing-btn-primary">
            🔓 Login
        </button>
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="swing-btn">
                📝 Register
            </a>
        @endif
    </div>
</div>

</x-guest-layout>