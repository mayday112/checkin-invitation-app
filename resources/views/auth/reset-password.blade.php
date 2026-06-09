<x-guest-layout>
    <div class="dialog-title">
        <span>🔑 Reset Password</span>
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

        <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm">
            @csrf
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="swing-form-row" style="grid-template-columns: 100px 1fr;">
                <label class="swing-label swing-label-bold" for="email">Email:</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                       class="swing-field" required autofocus autocomplete="username">
            </div>

            <div class="swing-form-row" style="grid-template-columns: 100px 1fr;">
                <label class="swing-label swing-label-bold" for="password">New Password:</label>
                <input id="password" type="password" name="password"
                       class="swing-field" required autocomplete="new-password">
            </div>

            <div class="swing-form-row" style="grid-template-columns: 100px 1fr;">
                <label class="swing-label" for="password_confirmation">Confirm:</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="swing-field" required autocomplete="new-password">
            </div>
        </form>
    </div>

    <div class="dialog-footer">
        <button type="submit" form="resetPasswordForm" class="swing-btn swing-btn-primary">
            💾 Reset Password
        </button>
    </div>
</x-guest-layout>
