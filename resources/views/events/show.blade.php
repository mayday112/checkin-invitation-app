<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('events.index') }}" class="swing-btn swing-btn-toolbar">⬅ Back</a>
        <div class="toolbar-sep"></div>
        <a href="{{ route('guests.index', $event) }}" class="swing-btn swing-btn-toolbar">👥 Manage Guests</a>
        <a href="{{ route('checkin.scanner', $event) }}" class="swing-btn swing-btn-toolbar swing-btn-primary">📷 Open Scanner</a>
        <a href="{{ route('events.edit', $event) }}" class="swing-btn swing-btn-toolbar">✏️ Edit Event</a>
        <div class="toolbar-sep"></div>
        <span style="font-size:10px; padding:0 6px; font-weight:bold;">{{ $event->name }} — Dashboard</span>
    </x-slot>

    <div style="display:flex; flex-direction:column; gap:6px; padding:8px;">

        {{-- Event Info Banner --}}
        <div class="swing-panel-titled" style="margin-top:0; flex-shrink:0; padding: 12px 10px 8px;">
            <div class="panel-title">Event Properties</div>
            <div style="display:flex; gap:24px; flex-wrap:wrap; font-size:11px;">
                <div>
                    <span style="color:var(--swing-text-disabled);">Name:</span>
                    <strong style="margin-left:4px;">{{ $event->name }}</strong>
                </div>
                <div>
                    <span style="color:var(--swing-text-disabled);">Date:</span>
                    <span class="col-mono" style="margin-left:4px;">{{ $event->event_date ? $event->event_date->format('d/m/Y H:i') : 'TBA' }}</span>
                </div>
                <div>
                    <span style="color:var(--swing-text-disabled);">Location:</span>
                    <span style="margin-left:4px;">{{ $event->location ?? 'TBA' }}</span>
                </div>
            </div>
        </div>

        {{-- Stats Row: 4 StatCards --}}
        <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:6px; flex-shrink:0;">
            
            <div class="swing-stat-card">
                <div class="swing-stat-label">Total Guests</div>
                <div class="swing-stat-value" style="color:#000080;">{{ $totalGuests }}</div>
                <div style="font-size:9px; color:var(--swing-text-disabled); margin-top:4px;">int totalGuests = {{ $totalGuests }}</div>
            </div>

            <div class="swing-stat-card">
                <div class="swing-stat-label">Checked In</div>
                <div class="swing-stat-value" style="color:var(--swing-success);">{{ $checkedIn }}</div>
                <div style="font-size:9px; color:var(--swing-text-disabled); margin-top:4px;">status = "checked_in"</div>
            </div>

            <div class="swing-stat-card">
                <div class="swing-stat-label">Pending</div>
                <div class="swing-stat-value" style="color:var(--swing-warning);">{{ $pending }}</div>
                <div style="font-size:9px; color:var(--swing-text-disabled); margin-top:4px;">status = "pending"</div>
            </div>

            <div class="swing-stat-card">
                <div class="swing-stat-label">Attendance Rate</div>
                <div class="swing-stat-value" style="color:{{ $attendancePercentage >= 80 ? 'var(--swing-success)' : ($attendancePercentage >= 50 ? 'var(--swing-warning)' : 'var(--swing-error)') }};">
                    {{ $attendancePercentage }}%
                </div>
                <div style="font-size:9px; color:var(--swing-text-disabled); margin-top:4px;">checkedIn / totalGuests * 100</div>
            </div>

        </div>

        {{-- JProgressBar section --}}
        <div class="swing-panel-titled" style="margin-top:0; padding: 16px 8px 8px;">
            <div class="panel-title">Check-in Progress — JProgressBar</div>

            <div class="swing-progress-container">
                <div class="swing-progress-bar" style="width:{{ $attendancePercentage }}%;"></div>
                <div class="swing-progress-text">{{ $attendancePercentage }}% — {{ $checkedIn }}/{{ $totalGuests }} Guests</div>
            </div>

            {{-- Attendance breakdown --}}
            <div style="display:flex; gap:16px; margin-top:8px; font-size:10px;">
                <span style="color:var(--swing-success);">■ Checked In: {{ $checkedIn }}</span>
                <span style="color:var(--swing-warning);">■ Pending: {{ $pending }}</span>
                <span style="color:var(--swing-error);">■ Cancelled: {{ $event->guests()->where('status','cancelled')->count() }}</span>
            </div>
        </div>

        {{-- Recent Check-ins Table --}}
        <div class="swing-panel-titled" style="margin-top:0; padding: 14px 8px 8px;">
            <div class="panel-title">Recent Check-ins — JTable</div>
            <div class="swing-table-container swing-scroll" style="max-height:200px;">
                <table class="swing-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Guest Name</th>
                            <th>Guest Code</th>
                            <th>Gate</th>
                            <th>Check-in Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $recentCheckins = \App\Models\Checkin::whereHas('guest', fn($q) => $q->where('event_id', $event->id))
                                ->with('guest')
                                ->latest('checked_in_at')
                                ->take(10)
                                ->get();
                        @endphp
                        @forelse($recentCheckins as $i => $checkin)
                            <tr>
                                <td class="col-mono col-center" style="color:var(--swing-text-disabled);">{{ $i + 1 }}</td>
                                <td><strong>{{ $checkin->guest->name }}</strong></td>
                                <td class="col-mono" style="font-size:10px;">{{ $checkin->guest->guest_code }}</td>
                                <td>{{ $checkin->gate ?? 'Main Gate' }}</td>
                                <td class="col-mono" style="font-size:10px;">{{ $checkin->checked_in_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; color:var(--swing-text-disabled); padding:16px;">
                                    (no check-ins yet)
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
