<section>
    <header style="margin-bottom:12px;">
        <h2 style="font-weight:bold; font-size:12px;">
            Update Password
        </h2>
        <p style="font-size:10px; color:var(--swing-text-disabled);">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" style="display:flex; flex-direction:column; gap:8px;">
        @csrf
        @method('put')

        <div class="swing-form-row" style="grid-template-columns: 120px 1fr;">
            <label for="update_password_current_password" class="swing-label swing-label-bold">Current Password:</label>
            <input id="update_password_current_password" name="current_password" type="password" class="swing-field" autocomplete="current-password" />
            @error('current_password', 'updatePassword')<span style="color:var(--swing-error); font-size:9px;">{{ $message }}</span>@enderror
        </div>

        <div class="swing-form-row" style="grid-template-columns: 120px 1fr;">
            <label for="update_password_password" class="swing-label swing-label-bold">New Password:</label>
            <input id="update_password_password" name="password" type="password" class="swing-field" autocomplete="new-password" />
            @error('password', 'updatePassword')<span style="color:var(--swing-error); font-size:9px;">{{ $message }}</span>@enderror
        </div>

        <div class="swing-form-row" style="grid-template-columns: 120px 1fr;">
            <label for="update_password_password_confirmation" class="swing-label">Confirm Password:</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="swing-field" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')<span style="color:var(--swing-error); font-size:9px;">{{ $message }}</span>@enderror
        </div>

        <div style="display:flex; justify-content:flex-end; align-items:center; gap:8px;">
            @if (session('status') === 'password-updated')
                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" style="font-size:10px; color:var(--swing-success); font-weight:bold;">
                    ✓ Password updated.
                </span>
            @endif
            <button type="submit" class="swing-btn swing-btn-primary">💾 Save Password</button>
        </div>
    </form>
</section>
