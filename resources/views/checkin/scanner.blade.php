<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ route('events.show', $event) }}" class="text-neon-cyan hover:text-white text-sm flex items-center mb-1 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Dashboard
                </a>
                <h2 class="font-semibold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-neon-pink to-neon-purple">
                    Check-in Scanner
                </h2>
            </div>
            <div class="text-gray-400">
                Gate: <span class="text-white font-medium">Main Gate</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="scannerComponent()">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Scanner Section -->
                <div class="bg-glass-dark border border-white/10 rounded-xl p-4 backdrop-blur-md shadow-lg flex flex-col items-center justify-center relative overflow-hidden">
                    <div class="absolute inset-0 border-4 border-transparent border-t-neon-cyan border-b-neon-pink rounded-xl opacity-20 animate-pulse pointer-events-none"></div>
                    
                    <h3 class="text-lg font-bold text-white mb-4 text-center">Scan QR Code</h3>
                    
                    <div id="reader" class="w-full bg-black rounded-lg overflow-hidden border border-white/10 shadow-inner"></div>
                    
                    <div class="mt-6 w-full px-4">
                        <p class="text-center text-sm text-gray-400 mb-2">Or enter guest code manually</p>
                        <form @submit.prevent="manualCheckIn" class="flex space-x-2">
                            <input type="text" x-model="manualCode" placeholder="EVT-..." class="flex-1 bg-slate-800 border-white/20 text-white focus:border-neon-cyan focus:ring-neon-cyan rounded-md text-sm uppercase">
                            <button type="submit" class="px-4 py-2 bg-neon-cyan text-slate-900 font-bold rounded-md hover:bg-white transition-colors text-sm">Submit</button>
                        </form>
                    </div>
                </div>

                <!-- Result Section -->
                <div class="bg-glass-dark border border-white/10 rounded-xl p-6 backdrop-blur-md shadow-lg flex flex-col">
                    <h3 class="text-lg font-bold text-white mb-4 border-b border-white/10 pb-2">Scan Result</h3>
                    
                    <div class="flex-1 flex flex-col items-center justify-center text-center p-4">
                        <template x-if="status === 'idle'">
                            <div class="text-gray-500 flex flex-col items-center">
                                <svg class="w-16 h-16 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                Waiting for scan...
                            </div>
                        </template>

                        <template x-if="status === 'loading'">
                            <div class="text-neon-cyan animate-pulse">
                                Processing...
                            </div>
                        </template>

                        <template x-if="status === 'success'">
                            <div class="w-full text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-500/20 text-green-400 mb-4 border border-green-500/50 shadow-[0_0_15px_rgba(34,197,94,0.5)]">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <h4 class="text-2xl font-bold text-white mb-2" x-text="guest.name"></h4>
                                <div class="bg-white/5 rounded-lg p-4 inline-block text-left mb-4 border border-white/10">
                                    <div class="text-sm text-gray-400">Code: <span class="text-neon-cyan font-mono" x-text="guest.guest_code"></span></div>
                                    <div class="text-sm text-gray-400 mt-1">Quota: <span class="text-white font-bold" x-text="guest.quota"></span> Person(s)</div>
                                </div>
                                <p class="text-green-400 font-medium" x-text="message"></p>
                            </div>
                        </template>

                        <template x-if="status === 'error'">
                            <div class="w-full text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-500/20 text-red-400 mb-4 border border-red-500/50 shadow-[0_0_15px_rgba(239,68,68,0.5)]">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                                <h4 class="text-xl font-bold text-white mb-2" x-show="guest" x-text="guest?.name"></h4>
                                <p class="text-red-400 font-medium mt-2" x-text="message"></p>
                            </div>
                        </template>
                    </div>

                    <div class="mt-4 pt-4 border-t border-white/10 text-center">
                        <button @click="reset()" x-show="status === 'success' || status === 'error'" class="px-6 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-colors border border-white/20">
                            Scan Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- html5-qrcode library -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function scannerComponent() {
            return {
                status: 'idle', // idle, loading, success, error
                message: '',
                guest: null,
                manualCode: '',
                html5QrcodeScanner: null,
                eventId: '{{ $event->id }}',

                init() {
                    // Initialize Scanner
                    this.html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader", { fps: 10, qrbox: {width: 250, height: 250} }, /* verbose= */ false);
                    
                    this.html5QrcodeScanner.render(this.onScanSuccess.bind(this), this.onScanFailure.bind(this));
                    
                    // Tailwind styles for scanner elements
                    setTimeout(() => {
                        const readerButton = document.getElementById('html5-qrcode-button-camera-permission');
                        if (readerButton) {
                            readerButton.className = 'px-4 py-2 bg-neon-cyan text-slate-900 rounded font-medium my-2';
                        }
                    }, 500);
                },

                onScanSuccess(decodedText, decodedResult) {
                    if (this.status === 'loading' || this.status === 'success') return; // Prevent double scan
                    this.processCheckIn(decodedText);
                },

                onScanFailure(error) {
                    // handle scan failure, usually better to ignore and keep scanning
                },

                manualCheckIn() {
                    if (!this.manualCode) return;
                    this.processCheckIn(this.manualCode.trim());
                },

                processCheckIn(code) {
                    this.status = 'loading';
                    this.guest = null;
                    
                    fetch(`/events/${this.eventId}/checkin`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            guest_code: code,
                            gate: 'Main Gate'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.status = 'success';
                            this.message = data.message;
                            this.guest = data.guest;
                            this.html5QrcodeScanner.pause(true); // pause scanner on success
                        } else {
                            this.status = 'error';
                            this.message = data.message;
                            this.guest = data.guest || null;
                        }
                    })
                    .catch(error => {
                        this.status = 'error';
                        this.message = 'Network error occurred.';
                    });
                },

                reset() {
                    this.status = 'idle';
                    this.message = '';
                    this.guest = null;
                    this.manualCode = '';
                    try {
                        this.html5QrcodeScanner.resume();
                    } catch (e) {}
                }
            }
        }
    </script>
</x-app-layout>
