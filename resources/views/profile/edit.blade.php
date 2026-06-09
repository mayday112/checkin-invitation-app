<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('dashboard') }}" class="swing-btn swing-btn-toolbar">⬅ Back</a>
        <div class="toolbar-sep"></div>
        <span style="font-size:10px; font-weight:bold; padding:0 6px;">Profile Settings Dialog</span>
    </x-slot>

    <div style="padding:16px; display:flex; justify-content:center; align-items:flex-start;">

        <div class="swing-dialog" style="max-width:600px; width:100%; box-shadow: 4px 4px 8px rgba(0,0,0,0.4);">
            <div class="dialog-title">
                <span>⚙️ User Profile Properties</span>
            </div>
            <div class="dialog-body" style="display:flex; flex-direction:column; gap:16px;">
                
                {{-- Profile Info Form --}}
                <div class="swing-panel-titled" style="margin-top:0;">
                    <div class="panel-title">Profile Information</div>
                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- Update Password Form --}}
                <div class="swing-panel-titled" style="margin-top:0;">
                    <div class="panel-title">Update Password</div>
                    @include('profile.partials.update-password-form')
                </div>

                {{-- Delete User Form --}}
                <div class="swing-panel-titled" style="margin-top:0;">
                    <div class="panel-title">Danger Zone</div>
                    @include('profile.partials.delete-user-form')
                </div>

            </div>
            <div class="dialog-footer">
                <a href="{{ route('dashboard') }}" class="swing-btn">✅ OK</a>
            </div>
        </div>

    </div>
</x-app-layout>
