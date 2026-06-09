<x-guest-layout>
    <div class="dialog-title">
        <span>🔐 Confirm Password</span>
    </div>

    <div class="dialog-body">

        <div style="font-size:11px; margin-bottom:12px;">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

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

        <form method="POST" action="{{ route('password.confirm') }}" id="confirmPasswordForm">
            @csrf

            <div class="swing-form-row" style="grid-template-columns: 80px 1fr;">
                <label class="swing-label swing-label-bold" for="password">Password:</label>
                <input id="password" type="password" name="password"
                       class="swing-field" required autocomplete="current-password">
            </div>
        </form>
    </div>

    <div class="dialog-footer">
        <button type="submit" form="confirmPasswordForm" class="swing-btn swing-btn-primary">
            ✅ Confirm
        </button>
    </div>
</x-guest-layout>
