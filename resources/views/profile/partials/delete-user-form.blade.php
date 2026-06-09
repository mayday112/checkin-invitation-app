<section>
    <header style="margin-bottom:12px;">
        <h2 style="font-weight:bold; font-size:12px; color:var(--swing-error);">
            Delete Account
        </h2>
        <p style="font-size:10px; color:var(--swing-text-disabled);">
            Once your account is deleted, all of its resources and data will be permanently deleted.
        </p>
    </header>

    <div style="display:flex; justify-content:flex-end;">
        <button onclick="document.getElementById('deleteUserDialog').style.display='flex'" class="swing-btn" style="color:var(--swing-error); font-weight:bold;">
            🗑️ Delete Account...
        </button>
    </div>

    {{-- ============================
         DIALOG: Confirm Delete User
         ============================ --}}
    <div id="deleteUserDialog" class="swing-dialog-overlay" style="display:none;">
        <div class="swing-dialog" style="max-width:400px; box-shadow: 4px 4px 8px rgba(0,0,0,0.6);">
            <div class="dialog-title" style="background:var(--swing-error);">
                <span>⚠ Confirm Account Deletion</span>
                <button onclick="document.getElementById('deleteUserDialog').style.display='none'" style="background:none;border:none;color:white;cursor:pointer;font-size:14px;">✕</button>
            </div>
            <div class="dialog-body">
                <form method="post" action="{{ route('profile.destroy') }}" id="deleteUserForm">
                    @csrf
                    @method('delete')

                    <div class="swing-alert swing-alert-error" style="margin-bottom:12px;">
                        <span class="swing-alert-icon">⚠</span>
                        <span>Are you sure you want to delete your account? This action cannot be undone.</span>
                    </div>

                    <div class="swing-form-row" style="grid-template-columns: 80px 1fr;">
                        <label for="password" class="swing-label swing-label-bold" style="color:var(--swing-error);">Password:</label>
                        <input id="password" name="password" type="password" class="swing-field" placeholder="Verify your password" required />
                        @error('password', 'userDeletion')<span style="color:var(--swing-error); font-size:9px;">{{ $message }}</span>@enderror
                    </div>
                </form>
            </div>
            <div class="dialog-footer">
                <button type="submit" form="deleteUserForm" class="swing-btn" style="color:var(--swing-error); font-weight:bold;">✅ Delete Account</button>
                <button onclick="document.getElementById('deleteUserDialog').style.display='none'" class="swing-btn">❌ Cancel</button>
            </div>
        </div>
    </div>
</section>
