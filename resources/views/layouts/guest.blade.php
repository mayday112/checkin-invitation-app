<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hadir.in') }} — Login</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="swing-window" style="display:flex; flex-direction:column; height:100vh; overflow:hidden;">

        {{-- Outer window frame --}}
        <div style="display:flex; flex-direction:column; height:100vh;">

            {{-- Title bar --}}
            <div class="swing-titlebar">
                <svg class="title-icon" viewBox="0 0 16 16" fill="white" xmlns="http://www.w3.org/2000/svg">
                    <rect x="1" y="2" width="14" height="12" rx="1" fill="none" stroke="white" stroke-width="1.5"/>
                    <path d="M1 5h14" stroke="white" stroke-width="1.5"/>
                    <circle cx="4" cy="8.5" r="1" fill="white"/>
                    <circle cx="8" cy="8.5" r="1" fill="white"/>
                    <circle cx="12" cy="8.5" r="1" fill="white"/>
                </svg>
                <span class="title-text">Hadir.in — Event Guest Check-In System</span>
                <div class="title-buttons">
                    <div class="title-btn">&#x2014;</div>
                    <div class="title-btn">&#x25A1;</div>
                    <div class="title-btn" style="background:#FF4444; color:white; font-weight:bold;">&#x2715;</div>
                </div>
            </div>

            {{-- Main content area --}}
            <div style="flex:1; display:flex; align-items:center; justify-content:center; background:var(--swing-bg);">

                {{-- Login dialog window --}}
                <div class="swing-dialog" style="min-width:380px; box-shadow: 4px 4px 8px rgba(0,0,0,0.5);">
                    {{ $slot }}
                </div>

            </div>

            {{-- Status bar --}}
            <div class="swing-statusbar">
                <div class="status-panel" style="flex:1;">
                    Please log in to continue.
                </div>
                <div class="status-panel" style="min-width:160px;">
                    {{ now()->format('d/m/Y H:i:s') }}
                </div>
            </div>
        </div>

    </body>
</html>
