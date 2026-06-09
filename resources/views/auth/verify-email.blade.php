<x-guest-layout>
    <div class="dialog-title">
        <span>✉ Verify Email Address</span>
    </div>

    <div class="dialog-body">

        <div style="font-size:11px; margin-bottom:12px;">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="swing-alert swing-alert-success" style="margin-bottom:8px;">
                <span class="swing-alert-icon">✓</span>
                <span>A new verification link has been sent to the email address you provided during registration.</span>
            </div>
        @endif

        <div style="display:flex; justify-content:space-between; align-items:center;">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="swing-btn swing-btn-primary">
                    ✉ Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="swing-btn">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
