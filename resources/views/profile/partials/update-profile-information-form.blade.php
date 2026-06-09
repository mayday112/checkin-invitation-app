<section>
    <header style="margin-bottom:12px;">
        <h2 style="font-weight:bold; font-size:12px;">
            Update Profile
        </h2>
        <p style="font-size:10px; color:var(--swing-text-disabled);">
            Update your account's profile information and email address.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="display:flex; flex-direction:column; gap:8px;">
        @csrf
        @method('patch')

        <div class="swing-form-row" style="grid-template-columns: 120px 1fr;">
            <label for="name" class="swing-label swing-label-bold">Name:</label>
            <input id="name" name="name" type="text" class="swing-field" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')<span style="color:var(--swing-error); font-size:9px;">{{ $message }}</span>@enderror
        </div>

        <div class="swing-form-row" style="grid-template-columns: 120px 1fr;">
            <label for="email" class="swing-label swing-label-bold">Email:</label>
            <input id="email" name="email" type="email" class="swing-field" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')<span style="color:var(--swing-error); font-size:9px;">{{ $message }}</span>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p style="font-size:10px; color:var(--swing-text-disabled); margin-top:4px;">
                        Your email address is unverified.
                        <button form="send-verification" class="swing-btn swing-btn-toolbar" style="color:#000080;">
                            Click here to re-send the verification email.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="font-size:10px; color:var(--swing-success); font-weight:bold; margin-top:4px;">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display:flex; justify-content:flex-end; align-items:center; gap:8px;">
            @if (session('status') === 'profile-updated')
                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" style="font-size:10px; color:var(--swing-success); font-weight:bold;">
                    ✓ Saved.
                </span>
            @endif
            <button type="submit" class="swing-btn swing-btn-primary">💾 Save</button>
        </div>
    </form>
</section>
