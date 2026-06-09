<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hadir.in — Guest Check-In System</title>
        @vite(['resources/css/app.css'])
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
                <span class="title-text">Hadir.in — Welcome</span>
                <div class="title-buttons">
                    <div class="title-btn">&#x2014;</div>
                    <div class="title-btn">&#x25A1;</div>
                    <div class="title-btn" style="background:#FF4444; color:white; font-weight:bold;">&#x2715;</div>
                </div>
            </div>

            {{-- Main content area --}}
            <div style="flex:1; display:flex; align-items:center; justify-content:center; background:var(--swing-bg); padding:20px;">

                <div class="swing-dialog" style="max-width:400px; box-shadow: 4px 4px 8px rgba(0,0,0,0.5);">
                    <div class="dialog-title">
                        <span>📋 About Hadir.in System</span>
                    </div>
                    
                    <div class="dialog-body" style="text-align:center; padding:20px;">
                        
                        <div style="font-size:48px; margin-bottom:8px;">🏢</div>
                        
                        <h1 style="font-weight:bold; font-size:16px; margin-bottom:4px; color:#000080;">Hadir.in System</h1>
                        <p style="font-size:11px; color:var(--swing-text-disabled); font-family:var(--swing-mono); margin-bottom:16px;">v1.0.0 — Build 2026</p>

                        <div class="swing-panel-titled" style="margin-top:0; text-align:left; margin-bottom:16px;">
                            <div class="panel-title">System Features</div>
                            <ul style="font-size:11px; padding-left:16px; margin:8px 0; color:var(--swing-text);">
                                <li>Event Management Database</li>
                                <li>Guest List Import/Export</li>
                                <li>QR Code Generation</li>
                                <li>WhatsApp Integration</li>
                                <li>Html5Qrcode Scanner Interface</li>
                            </ul>
                        </div>

                        @if (Route::has('login'))
                            <div style="display:flex; justify-content:center; gap:8px;">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="swing-btn swing-btn-primary">
                                        ▶ Launch Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="swing-btn swing-btn-primary">
                                        🔑 Login
                                    </a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="swing-btn">
                                            📝 Register
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif

                    </div>
                </div>

            </div>

            {{-- Status bar --}}
            <div class="swing-statusbar">
                <div class="status-panel" style="flex:1;">
                    System ready.
                </div>
                <div class="status-panel" style="min-width:160px;">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </div>
            </div>
        </div>

    </body>
</html>
