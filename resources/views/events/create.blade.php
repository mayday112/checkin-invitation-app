<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('events.index') }}" class="swing-btn swing-btn-toolbar">⬅ Back</a>
        <div class="toolbar-sep"></div>
        <span style="font-size:10px; padding:0 6px; font-weight:bold;">New Event — Create Dialog</span>
    </x-slot>

    <div style="display:flex; align-items:flex-start; justify-content:center; padding:16px;">

        {{-- Simulate a JDialog window --}}
        <div class="swing-dialog" style="max-width:480px; width:100%; box-shadow: 4px 4px 8px rgba(0,0,0,0.4);">
            <div class="dialog-title">
                <span>📋 New Event — Create Event Dialog</span>
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

                <form method="POST" action="{{ route('events.store') }}" id="create-event-form">
                    @csrf

                    {{-- Event Name --}}
                    <div class="swing-form-row">
                        <label class="swing-label swing-label-bold" for="name">Event Name:</label>
                        <div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" 
                                   class="swing-field" required autofocus placeholder="e.g. Annual Gathering 2025">
                        </div>
                    </div>

                    {{-- Event Date --}}
                    <div class="swing-form-row">
                        <label class="swing-label" for="event_date">Date & Time:</label>
                        <div>
                            <input id="event_date" type="datetime-local" name="event_date" value="{{ old('event_date') }}" 
                                   class="swing-field">
                        </div>
                    </div>

                    {{-- Location --}}
                    <div class="swing-form-row">
                        <label class="swing-label" for="location">Location:</label>
                        <div>
                            <input id="location" type="text" name="location" value="{{ old('location') }}" 
                                   class="swing-field" placeholder="e.g. Jakarta Convention Center">
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="swing-form-row" style="align-items:flex-start;">
                        <label class="swing-label" for="description" style="padding-top:2px;">Description:</label>
                        <div>
                            <textarea id="description" name="description" rows="4" 
                                      class="swing-field" style="resize:vertical;" 
                                      placeholder="Optional event description...">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="swing-separator"></div>
                    
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:4px; font-size:10px; color:var(--swing-text-disabled);">
                        <span>* Fields without label are optional</span>
                    </div>
                </form>
            </div>
            <div class="dialog-footer">
                <button type="submit" form="create-event-form" class="swing-btn swing-btn-primary">
                    ✅ OK
                </button>
                <a href="{{ route('events.index') }}" class="swing-btn">
                    ❌ Cancel
                </a>
            </div>
        </div>

    </div>
</x-app-layout>
