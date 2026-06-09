<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('events.index') }}" class="swing-btn swing-btn-toolbar swing-btn-primary">📁 Go to Events</a>
        <div class="toolbar-sep"></div>
        <span style="font-size:10px; padding:0 6px; font-weight:bold;">Dashboard — Home</span>
    </x-slot>

    <div style="padding:12px;">
        <div class="swing-panel-titled" style="margin-top:0; max-width:600px; padding: 16px 10px 10px;">
            <div class="panel-title">System Information — javax.swing.JPanel</div>
            <div style="font-family:var(--swing-mono); font-size:11px; line-height:2;">
                <div><span style="color:var(--swing-text-disabled);">System</span>.out.println(<span style="color:#006600;">"Welcome, {{ auth()->user()->name }}!"</span>);</div>
                <div><span style="color:var(--swing-text-disabled);">// App:</span> Hadir.in v1.0.0</div>
                <div><span style="color:var(--swing-text-disabled);">// Framework:</span> Laravel {{ app()->version() }}</div>
                <div><span style="color:var(--swing-text-disabled);">// PHP Version:</span> {{ PHP_VERSION }}</div>
                <div><span style="color:var(--swing-text-disabled);">// Environment:</span> {{ config('app.env') }}</div>
            </div>

            <div class="swing-separator"></div>

            <div style="display:flex; gap:6px; margin-top:8px;">
                <a href="{{ route('events.index') }}" class="swing-btn swing-btn-primary">📋 Open Events</a>
                <a href="{{ route('events.create') }}" class="swing-btn">➕ New Event</a>
                <a href="{{ route('profile.edit') }}" class="swing-btn">👤 Profile</a>
            </div>
        </div>
    </div>
</x-app-layout>
