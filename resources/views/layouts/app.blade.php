<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hadir.in') }} - Event Check-In System</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="swing-window" style="display:flex; flex-direction:column; min-height:100vh; overflow:hidden;">

        {{-- MAIN WINDOW FRAME --}}
        <div style="display:flex; flex-direction:column; height:100vh; overflow:hidden;">
            
            {{-- TITLE BAR --}}
            <div class="swing-titlebar">
                <svg class="title-icon" viewBox="0 0 16 16" fill="white" xmlns="http://www.w3.org/2000/svg">
                    <rect x="1" y="2" width="14" height="12" rx="1" fill="none" stroke="white" stroke-width="1.5"/>
                    <path d="M1 5h14" stroke="white" stroke-width="1.5"/>
                    <circle cx="4" cy="8.5" r="1" fill="white"/>
                    <circle cx="8" cy="8.5" r="1" fill="white"/>
                    <circle cx="12" cy="8.5" r="1" fill="white"/>
                </svg>
                <span class="title-text">Hadir.in - Event Guest Check-In System</span>
                <div class="title-buttons">
                    <div class="title-btn" title="Minimize">&#x2014;</div>
                    <div class="title-btn" title="Maximize">&#x25A1;</div>
                    <div class="title-btn" title="Close" style="background:#FF4444; color:white; font-weight:bold;">&#x2715;</div>
                </div>
            </div>

            {{-- MENU BAR --}}
            @include('layouts.navigation')

            {{-- PAGE HEADING TOOLBAR --}}
            @isset($header)
                <div class="swing-toolbar">
                    {{ $header }}
                </div>
            @endisset

            {{-- MAIN CONTENT --}}
            <main class="swing-content-area swing-scroll" style="flex:1;">
                {{ $slot }}
            </main>

            {{-- STATUS BAR --}}
            <div class="swing-statusbar">
                <div class="status-panel" style="flex:1;">
                    @if(auth()->check())
                        Ready &bull; Logged in as: {{ auth()->user()->name }}
                    @else
                        Ready
                    @endif
                </div>
                <div class="status-panel" style="min-width:120px;">
                    {{ now()->format('d/m/Y H:i:s') }}
                </div>
                <div class="status-panel" style="min-width:80px;">
                    @php
                        $totalEvents = auth()->check() ? \App\Models\Event::count() : 0;
                    @endphp
                    Events: {{ $totalEvents }}
                </div>
            </div>
        </div>
        
    </body>
</html>
