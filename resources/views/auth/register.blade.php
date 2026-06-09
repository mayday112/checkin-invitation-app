<x-guest-layout>

    <div class="dialog-title">
        <span>📝 Hadir.in — New User Registration</span>
    </div>
    
    <div class="dialog-body">
    
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
    
        <div style="text-align:center; margin-bottom:10px; border-bottom:1px solid var(--swing-dark); padding-bottom:8px;">
            <div style="font-size:30px; margin-bottom:2px;">👤</div>
            <div style="font-weight:bold; font-size:12px;">Create New Account</div>
            <div style="font-size:10px; color:var(--swing-text-disabled); font-family:var(--swing-mono);">UserRegistrationDialog.java</div>
        </div>
    
        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf
    
            <div class="swing-form-row" style="grid-template-columns: 100px 1fr;">
                <label class="swing-label swing-label-bold" for="name">Full Name:</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       class="swing-field" required autofocus autocomplete="name"
                       placeholder="Your full name">
            </div>
    
            <div class="swing-form-row" style="grid-template-columns: 100px 1fr;">
                <label class="swing-label swing-label-bold" for="email">Email:</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="swing-field" required autocomplete="username"
                       placeholder="user@example.com">
            </div>
    
            <div class="swing-form-row" style="grid-template-columns: 100px 1fr;">
                <label class="swing-label swing-label-bold" for="password">Password:</label>
                <input id="password" type="password" name="password"
                       class="swing-field" required autocomplete="new-password"
                       placeholder="Min. 8 characters">
            </div>
    
            <div class="swing-form-row" style="grid-template-columns: 100px 1fr;">
                <label class="swing-label" for="password_confirmation">Confirm:</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="swing-field" required autocomplete="new-password"
                       placeholder="Repeat password">
            </div>
    
            <div class="swing-separator"></div>
    
            <div style="font-size:9px; color:var(--swing-text-disabled); font-family:var(--swing-mono); margin: 4px 0;">
                // By registering, you agree to terms of service.
            </div>
        </form>
    </div>
    
    <div class="dialog-footer" style="justify-content:space-between;">
        <a href="{{ route('login') }}" style="font-size:10px; color:#000080; text-decoration:underline; display:flex; align-items:center;">
            ← Already registered?
        </a>
        <button type="submit" form="registerForm" class="swing-btn swing-btn-primary">
            ✅ Register
        </button>
    </div>
</x-guest-layout>
