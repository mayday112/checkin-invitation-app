<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('events.show', $event) }}" class="swing-btn swing-btn-toolbar">⬅ Dashboard</a>
        <div class="toolbar-sep"></div>
        <button onclick="document.getElementById('addGuestDialog').style.display='flex'" class="swing-btn swing-btn-toolbar swing-btn-primary">➕ Add Guest</button>
        <button onclick="document.getElementById('importDialog').style.display='flex'" class="swing-btn swing-btn-toolbar">📤 Import CSV/XLSX</button>
        <div class="toolbar-sep"></div>
        <a href="{{ route('checkin.scanner', $event) }}" class="swing-btn swing-btn-toolbar">📷 Open Scanner</a>
        <div class="toolbar-sep"></div>
        <span style="font-size:10px; padding:0 6px; font-weight:bold;">{{ $event->name }} — Guest List</span>
        <span style="font-size:10px; color:var(--swing-text-disabled);">({{ $guests->total() }} records)</span>
    </x-slot>

    {{-- ============================
         DIALOG: Add Guest (hidden)
         ============================ --}}
    <div id="addGuestDialog" class="swing-dialog-overlay" style="display:none;">
        <div class="swing-dialog">
            <div class="dialog-title">
                <span>➕ Add Guest Manually</span>
                <button onclick="document.getElementById('addGuestDialog').style.display='none'" style="background:none;border:none;color:white;cursor:pointer;font-size:14px;">✕</button>
            </div>
            <div class="dialog-body">
                <form method="POST" action="{{ route('guests.store', $event) }}" id="addGuestForm">
                    @csrf

                    <div class="swing-form-row">
                        <label class="swing-label swing-label-bold">Full Name:</label>
                        <input type="text" name="name" class="swing-field" required placeholder="Guest full name">
                    </div>

                    <div class="swing-form-row">
                        <label class="swing-label">WA Phone:</label>
                        <div>
                            <input type="text" name="phone" class="swing-field" required placeholder="628xxxxxxxx">
                            <span style="font-size:9px; color:var(--swing-text-disabled);">Format: 628... (country code)</span>
                        </div>
                    </div>

                    <div class="swing-form-row">
                        <label class="swing-label">Quota:</label>
                        <input type="number" name="quota" class="swing-field" value="1" min="1" style="width:80px;">
                    </div>

                    <div class="swing-separator"></div>
                    <div style="font-size:10px; color:var(--swing-text-disabled);">
                        ⚠ WhatsApp invitation & QR Code will be sent via WA Service after submit.
                    </div>
                </form>
            </div>
            <div class="dialog-footer">
                <button type="submit" form="addGuestForm" class="swing-btn swing-btn-primary">✅ OK</button>
                <button onclick="document.getElementById('addGuestDialog').style.display='none'" class="swing-btn">❌ Cancel</button>
            </div>
        </div>
    </div>

    {{-- ============================
         DIALOG: Import (hidden)
         ============================ --}}
    <div id="importDialog" class="swing-dialog-overlay" style="display:none;">
        <div class="swing-dialog">
            <div class="dialog-title">
                <span>📤 Import Guests — File Chooser</span>
                <button onclick="document.getElementById('importDialog').style.display='none'" style="background:none;border:none;color:white;cursor:pointer;font-size:14px;">✕</button>
            </div>
            <div class="dialog-body">
                <form method="POST" action="{{ route('guests.import', $event) }}" enctype="multipart/form-data" id="importForm">
                    @csrf

                    <div class="swing-panel-titled" style="margin-top:0; padding: 14px 8px 8px;">
                        <div class="panel-title">File Selection</div>
                        <div class="swing-form-row" style="grid-template-columns: 80px 1fr;">
                            <label class="swing-label">File Path:</label>
                            <input type="file" name="file" class="swing-field" accept=".csv,.xlsx,.xls" required>
                        </div>
                    </div>

                    <div class="swing-panel-titled" style="margin-top:8px; padding: 14px 8px 8px;">
                        <div class="panel-title">File Format Requirements</div>
                        <div style="font-size:10px; font-family:var(--swing-mono); line-height:1.8;">
                            <div style="color:var(--swing-text-disabled);">/* Required columns: */</div>
                            <div><span style="color:#000080;">String</span> name;    <span style="color:var(--swing-success);">// required</span></div>
                            <div><span style="color:#000080;">String</span> phone;   <span style="color:var(--swing-success);">// required, e.g. 628xxx</span></div>
                            <div><span style="color:#000080;">int</span>    quota;   <span style="color:var(--swing-text-disabled);">// optional, default=1</span></div>
                        </div>
                    </div>
                    <div style="font-size:10px; color:var(--swing-text-disabled); margin-top:6px;">
                        Supported: .csv, .xlsx, .xls — Duplicates by phone will be skipped.
                    </div>
                </form>
            </div>
            <div class="dialog-footer">
                <button type="submit" form="importForm" class="swing-btn swing-btn-primary">✅ Import</button>
                <button onclick="document.getElementById('importDialog').style.display='none'" class="swing-btn">❌ Cancel</button>
            </div>
        </div>
    </div>

    {{-- ============================
         MAIN CONTENT
         ============================ --}}
    <div style="display:flex; flex-direction:column; height:100%; padding:6px; gap:4px;">

        @if(session('success'))
            <div class="swing-alert swing-alert-success">
                <span class="swing-alert-icon">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="swing-alert swing-alert-error">
                <span class="swing-alert-icon">⚠</span>
                <div>
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Guest Table --}}
        <div class="swing-panel-titled" style="margin-top:0; flex:1; display:flex; flex-direction:column; padding: 14px 8px 8px;">
            <div class="panel-title">Guest Table — {{ $event->name }}</div>
            
            <div class="swing-table-container swing-scroll" style="flex:1; height:calc(100vh - 220px);">
                <table class="swing-table">
                    <thead>
                        <tr>
                            <th style="width:30px;">#</th>
                            <th style="width:140px;">Guest Code</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th class="col-center" style="width:55px;">Quota</th>
                            <th class="col-center" style="width:80px;">Status</th>
                            <th style="width:100px;">Checked In At</th>
                            <th style="width:90px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guests as $i => $guest)
                            <tr>
                                <td class="col-mono col-center" style="color:var(--swing-text-disabled);">{{ ($guests->currentPage() - 1) * $guests->perPage() + $i + 1 }}</td>
                                <td class="col-mono" style="font-size:10px;">{{ $guest->guest_code }}</td>
                                <td><strong>{{ $guest->name }}</strong></td>
                                <td class="col-mono" style="font-size:10px;">{{ $guest->phone }}</td>
                                <td class="col-center">{{ $guest->quota }}</td>
                                <td class="col-center">
                                    @if($guest->status === 'checked_in')
                                        <span class="swing-badge swing-badge-ok">CHECKED_IN</span>
                                    @elseif($guest->status === 'cancelled')
                                        <span class="swing-badge swing-badge-error">CANCELLED</span>
                                    @else
                                        <span class="swing-badge swing-badge-warn">PENDING</span>
                                    @endif
                                </td>
                                <td class="col-mono" style="font-size:9px;">
                                    {{ $guest->checked_in_at ? $guest->checked_in_at->format('d/m/Y H:i') : '—' }}
                                </td>
                                <td>
                                    <div style="display:flex; gap:2px;">
                                        <a href="{{ route('guests.qr', $guest) }}" class="swing-btn swing-btn-toolbar" title="Download QR">🖨️</a>
                                        <form action="{{ route('guests.destroy', $guest) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete {{ $guest->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="swing-btn swing-btn-toolbar" title="Delete" style="color:var(--swing-error);">🗑️</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="padding:20px; text-align:center; color:var(--swing-text-disabled);">
                                    (no guest records) — Add guests manually or import a file.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($guests->hasPages())
            <div style="display:flex; align-items:center; gap:4px; font-size:10px; flex-shrink:0;">
                <span style="color:var(--swing-text-disabled);">Page:</span>
                {{ $guests->links() }}
                <span style="color:var(--swing-text-disabled);">Total: {{ $guests->total() }} records</span>
            </div>
        @endif

    </div>
</x-app-layout>
