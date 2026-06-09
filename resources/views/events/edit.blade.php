<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('events.show', $event) }}" class="swing-btn swing-btn-toolbar">⬅ Back</a>
        <div class="toolbar-sep"></div>
        <span style="font-size:10px; padding:0 6px; font-weight:bold;">✏️ Edit Event — Properties Dialog</span>
    </x-slot>

    <div style="display:flex; align-items:flex-start; justify-content:center; padding:16px;">

        <div class="swing-dialog" style="max-width:480px; width:100%; box-shadow: 4px 4px 8px rgba(0,0,0,0.4);">
            <div class="dialog-title">
                <span>✏️ Edit Event — {{ $event->name }}</span>
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

                <form method="POST" action="{{ route('events.update', $event) }}" id="edit-event-form">
                    @csrf
                    @method('PUT')

                    <div class="swing-form-row">
                        <label class="swing-label swing-label-bold">Event Name:</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $event->name) }}"
                               class="swing-field" required autofocus>
                    </div>

                    <div class="swing-form-row">
                        <label class="swing-label">Date & Time:</label>
                        <input id="event_date" type="datetime-local" name="event_date"
                               value="{{ old('event_date', $event->event_date?->format('Y-m-d\TH:i')) }}"
                               class="swing-field">
                    </div>

                    <div class="swing-form-row">
                        <label class="swing-label">Location:</label>
                        <input id="location" type="text" name="location" value="{{ old('location', $event->location) }}"
                               class="swing-field">
                    </div>

                    <div class="swing-form-row" style="align-items:flex-start;">
                        <label class="swing-label" style="padding-top:2px;">Description:</label>
                        <textarea id="description" name="description" rows="4"
                                  class="swing-field" style="resize:vertical;">{{ old('description', $event->description) }}</textarea>
                    </div>

                    <div class="swing-separator"></div>
                    <div style="font-size:10px; color:var(--swing-text-disabled);">
                        ID: {{ $event->id }} | Created: {{ $event->created_at->format('d/m/Y H:i') }}
                    </div>
                </form>
            </div>
            <div class="dialog-footer">
                <button type="submit" form="edit-event-form" class="swing-btn swing-btn-primary">💾 Save</button>
                <a href="{{ route('events.show', $event) }}" class="swing-btn">❌ Cancel</a>
            </div>
        </div>

    </div>
</x-app-layout>
