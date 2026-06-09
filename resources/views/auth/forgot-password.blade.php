<x-guest-layout>
    <div class="dialog-title">
        <span>🔑 Forgot Password</span>
    </div>

    <div class="dialog-body">

        <div style="font-size:11px; margin-bottom:12px;">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </div>

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

        <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
            @csrf

            <div class="swing-form-row" style="grid-template-columns: 80px 1fr;">
                <label class="swing-label swing-label-bold" for="email">Email:</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="swing-field" required autofocus
                       placeholder="user@example.com">
            </div>
        </form>
    </div>

    <div class="dialog-footer" style="justify-content:space-between;">
        <a href="{{ route('login') }}" class="swing-btn">⬅ Back to Login</a>
        <button type="submit" form="forgotPasswordForm" class="swing-btn swing-btn-primary">
            ✉ Email Reset Link
        </button>
    </div>
</x-guest-layout>
