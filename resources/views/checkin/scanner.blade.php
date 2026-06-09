<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('events.show', $event) }}" class="swing-btn swing-btn-toolbar">⬅ Dashboard</a>
        <div class="toolbar-sep"></div>
        <span style="font-size:10px; font-weight:bold; padding:0 6px;">📷 QR Scanner — {{ $event->name }}</span>
        <div class="toolbar-sep"></div>
        <label style="font-size:10px; padding:0 4px;">Gate:</label>
        <select id="gateSelect" class="swing-field" style="width:140px; height:22px; padding:1px 4px;">
            <option value="Main Gate">Main Gate</option>
            <option value="Gate A">Gate A</option>
            <option value="Gate B">Gate B</option>
            <option value="VIP Gate">VIP Gate</option>
        </select>
    </x-slot>

    <div x-data="scannerApp()" style="display:flex; gap:6px; padding:8px; height:100%;">

        {{-- LEFT: Scanner panel --}}
        <div style="flex:1; display:flex; flex-direction:column; gap:6px;">
            
            <div class="swing-panel-titled" style="margin-top:0; flex:1; display:flex; flex-direction:column; padding: 14px 8px 8px;">
                <div class="panel-title">Camera Feed — Html5QrcodeScanner</div>
                
                <div id="reader" style="width:100%;  background:#111; border: 1px solid var(--swing-darker); min-height:240px;"></div>
                
                <div class="swing-separator"></div>

                {{-- Manual Input --}}
                <div class="swing-panel-titled" style="margin-top:0; padding: 14px 8px 8px;">
                    <div class="panel-title">Manual Entry — JTextField</div>
                    <div style="display:flex; gap:4px; align-items:center;">
                        <label class="swing-label" style="margin:0; white-space:nowrap;">Guest Code:</label>
                        <input type="text" x-model="manualCode" id="manualCodeInput"
                               @keydown.enter="manualCheckIn()"
                               class="swing-field" style="flex:1; text-transform:uppercase;"
                               placeholder="e.g. EVT-1-A81XZ9">
                        <button @click="manualCheckIn()" class="swing-btn swing-btn-primary" style="white-space:nowrap;">
                            ▶ Submit
                        </button>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT: Result panel --}}
        <div style="width:300px; flex-shrink:0; display:flex; flex-direction:column; gap:6px;">
            
            {{-- Result Output --}}
            <div class="swing-panel-titled" style="margin-top:0; flex:1; padding: 14px 8px 8px;">
                <div class="panel-title">Scan Result — JTextArea (Output)</div>

                {{-- Idle state --}}
                <template x-if="status === 'idle'">
                    <div style="text-align:center; padding:20px; color:var(--swing-text-disabled);">
                        <div style="font-size:32px; margin-bottom:8px;">📷</div>
                        <div style="font-size:11px;">Waiting for scan...</div>
                        <div style="font-size:10px; font-family:var(--swing-mono); margin-top:6px;">status = IDLE</div>
                    </div>
                </template>

                {{-- Loading --}}
                <template x-if="status === 'loading'">
                    <div style="text-align:center; padding:20px; color:#000080;">
                        <div style="font-size:32px; margin-bottom:8px; animation: pulse 1s infinite;">⏳</div>
                        <div style="font-size:11px; font-weight:bold;">Processing...</div>
                        <div style="font-size:10px; font-family:var(--swing-mono); margin-top:6px;">status = PROCESSING</div>
                    </div>
                </template>

                {{-- Success --}}
                <template x-if="status === 'success'">
                    <div>
                        <div style="background:var(--swing-success); color:white; padding:4px 8px; font-weight:bold; margin-bottom:8px; font-size:11px;">
                            ✓ CHECK-IN SUCCESSFUL
                        </div>
                        
                        <div style="font-family:var(--swing-mono); font-size:10px; background:var(--swing-field-bg); border:1px inset; padding:8px; margin-bottom:6px; border-color: var(--swing-dark) var(--swing-light) var(--swing-light) var(--swing-dark);">
                            <div style="color:var(--swing-text-disabled);">// Guest Object</div>
                            <div>name: "<strong x-text="guest.name"></strong>"</div>
                            <div>code: "<span x-text="guest.guest_code"></span>"</div>
                            <div>quota: <span x-text="guest.quota"></span></div>
                            <div>status: "<span style="color:var(--swing-success);" x-text="guest.status"></span>"</div>
                        </div>

                        <div class="swing-alert swing-alert-success" style="font-size:10px; padding:4px 8px;">
                            <span class="swing-alert-icon">✓</span>
                            <span x-text="message"></span>
                        </div>
                    </div>
                </template>

                {{-- Error --}}
                <template x-if="status === 'error'">
                    <div>
                        <div style="background:var(--swing-error); color:white; padding:4px 8px; font-weight:bold; margin-bottom:8px; font-size:11px;">
                            ✕ CHECK-IN FAILED
                        </div>

                        <template x-if="guest">
                            <div style="font-family:var(--swing-mono); font-size:10px; background:var(--swing-field-bg); border:1px inset; padding:8px; margin-bottom:6px; border-color: var(--swing-dark) var(--swing-light) var(--swing-light) var(--swing-dark);">
                                <div style="color:var(--swing-text-disabled);">// Guest Object</div>
                                <div>name: "<strong x-text="guest.name"></strong>"</div>
                                <div>status: "<span style="color:var(--swing-error);" x-text="guest.status"></span>"</div>
                            </div>
                        </template>

                        <div class="swing-alert swing-alert-error" style="font-size:10px; padding:4px 8px;">
                            <span class="swing-alert-icon">⚠</span>
                            <span x-text="message"></span>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Action Buttons --}}
            <div class="swing-raised" style="padding:6px; display:flex; flex-direction:column; gap:4px;">
                <button @click="reset()" 
                        x-show="status === 'success' || status === 'error'" 
                        class="swing-btn swing-btn-primary" style="width:100%;">
                    🔄 Scan Next Guest
                </button>
                <button @click="reset()" 
                        x-show="status !== 'idle'" 
                        class="swing-btn" style="width:100%;">
                    ↩ Reset
                </button>
            </div>

            {{-- Log Panel --}}
            <div class="swing-panel-titled" style="margin-top:0; padding: 14px 8px 8px;">
                <div class="panel-title">Activity Log — JTextArea</div>
                <div id="logArea" style="height:100px; overflow-y:auto; font-family:var(--swing-mono); font-size:9px; background:var(--swing-field-bg); border-color: var(--swing-dark) var(--swing-light) var(--swing-light) var(--swing-dark); border: 1px solid var(--swing-dark); padding:4px;" x-html="logHtml">
                </div>
            </div>

        </div>

    </div>

    {{-- html5-qrcode --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function scannerApp() {
            return {
                status: 'idle',
                message: '',
                guest: null,
                manualCode: '',
                logHtml: '<span style="color:var(--swing-text-disabled);">[SYS] Scanner initialized.<br>[SYS] Waiting for camera...<br></span>',
                html5QrcodeScanner: null,
                eventId: '{{ $event->id }}',

                init() {
                    if(this.html5QrcodeScanner) this.html5QrcodeScanner.clear();

                    this.html5QrcodeScanner = new Html5QrcodeScanner (
                        "reader",
                        { fps: 10, qrbox: { width: 350, height: 350 } },
                        false
                    );
                    this.html5QrcodeScanner.render(
                        this.onScanSuccess.bind(this),
                        () => {}
                    );
                    this.log('[SYS] Camera started.', '#000080');
                },

                log(msg, color = '#000000') {
                    const now = new Date().toLocaleTimeString('id-ID');
                    this.logHtml += `<span style="color:${color};">[${now}] ${msg}<br></span>`;
                    this.$nextTick(() => {
                        const el = document.getElementById('logArea');
                        if (el) el.scrollTop = el.scrollHeight;
                    });
                },

                onScanSuccess(decodedText) {
                    if (this.status === 'loading' || this.status === 'success') return;
                    this.log(`[SCAN] Code: ${decodedText}`, '#006600');
                    this.processCheckIn(decodedText);
                },

                manualCheckIn() {
                    if (!this.manualCode) return;
                    this.log(`[MANUAL] Code: ${this.manualCode.trim()}`, '#000080');
                    this.processCheckIn(this.manualCode.trim());
                },

                processCheckIn(code) {
                    this.status = 'loading';
                    this.guest = null;

                    const gate = document.getElementById('gateSelect')?.value || 'Main Gate';

                    fetch(`/events/${this.eventId}/checkin`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ guest_code: code, gate: gate })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            this.status = 'success';
                            this.message = data.message;
                            this.guest = data.guest;
                            this.log(`[OK] ${data.guest.name} checked in successfully.`, '#006600');
                            try { this.html5QrcodeScanner.pause(true); } catch(e) {}
                        } else {
                            this.status = 'error';
                            this.message = data.message;
                            this.guest = data.guest || null;
                            this.log(`[ERR] ${data.message}`, '#CC0000');
                        }
                    })
                    .catch(() => {
                        this.status = 'error';
                        this.message = 'Network error — service unavailable.';
                        this.log('[ERR] Network error.', '#CC0000');
                    });
                },

                reset() {
                    this.status = 'idle';
                    this.message = '';
                    this.guest = null;
                    this.manualCode = '';
                    this.log('[SYS] Reset. Ready for next scan.', '#000080');
                    try { this.html5QrcodeScanner.resume(); } catch(e) {}
                }
            }
        }
    </script>

    <style>
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
    </style>
</x-app-layout>
