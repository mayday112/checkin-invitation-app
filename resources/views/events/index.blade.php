<x-app-layout>
    <x-slot name="header">
        {{-- Toolbar buttons --}}
        <a href="{{ route('events.create') }}" class="swing-btn swing-btn-toolbar">
            📁 New Event
        </a>
        <div class="toolbar-sep"></div>
        <span class="swing-btn swing-btn-toolbar" style="cursor:default; font-weight:bold;">
            All Events
        </span>
        <div class="toolbar-sep"></div>
        <span style="font-size:10px; color:var(--swing-text-disabled); padding: 0 6px;">
            {{ $events->count() }} record(s) found
        </span>
    </x-slot>

    <div style="display:flex; flex-direction:column; height:100%; gap:6px;">

        {{-- Panel Title --}}
        <div class="swing-panel-titled" style="margin-top:0; flex-shrink:0;">
            <div class="panel-title">Event List — JTable View</div>

            {{-- Table --}}
            <div class="swing-table-container swing-scroll" style="height:calc(100vh - 200px);">
                <table class="swing-table">
                    <thead>
                        <tr>
                            <th style="width:30px;">#</th>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th class="col-center">Guests</th>
                            <th style="width:200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $i => $event)
                            <tr>
                                <td class="col-mono col-center" style="color:var(--swing-text-disabled);">{{ $i + 1 }}</td>
                                <td>
                                    <strong>{{ $event->name }}</strong>
                                    @if($event->description)
                                        <br><span style="color:var(--swing-text-disabled); font-size:10px;">{{ Str::limit($event->description, 50) }}</span>
                                    @endif
                                </td>
                                <td class="col-mono">
                                    {{ $event->event_date ? $event->event_date->format('d/m/Y H:i') : '—' }}
                                </td>
                                <td>{{ $event->location ?? '—' }}</td>
                                <td class="col-center">
                                    <span class="swing-badge swing-badge-ok">{{ $event->guests_count }}</span>
                                </td>
                                <td>
                                    <div style="display:flex; gap:3px; flex-wrap:wrap;">
                                        <a href="{{ route('events.show', $event) }}" class="swing-btn swing-btn-toolbar">📊 Dashboard</a>
                                        <a href="{{ route('guests.index', $event) }}" class="swing-btn swing-btn-toolbar">👥 Guests</a>
                                        <a href="{{ route('checkin.scanner', $event) }}" class="swing-btn swing-btn-toolbar">📷 Scan</a>
                                        <a href="{{ route('events.edit', $event) }}" class="swing-btn swing-btn-toolbar">✏️ Edit</a>
                                        <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete event: {{ $event->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="swing-btn swing-btn-toolbar" style="color:var(--swing-error);">🗑️ Del</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding:30px; text-align:center; color:var(--swing-text-disabled);">
                                    (no records found)
                                    <br><br>
                                    <a href="{{ route('events.create') }}" class="swing-btn swing-btn-primary">📁 Create First Event</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
