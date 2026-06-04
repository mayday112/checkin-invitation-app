<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <a href="{{ route('events.show', $event) }}" class="text-neon-cyan hover:text-white text-sm flex items-center mb-1 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Dashboard
                </a>
                <h2 class="font-semibold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-neon-pink to-neon-purple">
                    Guests for {{ $event->name }}
                </h2>
            </div>
            
            <div class="flex space-x-3" x-data="{ openImport: false, openAdd: false }">
                <button @click="openImport = true" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white border border-white/20 rounded-lg font-medium transition-all">
                    Import CSV/XLSX
                </button>
                <button @click="openAdd = true" class="px-4 py-2 bg-gradient-to-r from-neon-pink to-neon-purple hover:from-neon-purple hover:to-neon-cyan text-white rounded-lg font-medium shadow-neon-pink transition-all transform hover:scale-105">
                    + Add Guest
                </button>

                <!-- Import Modal -->
                <div x-show="openImport" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
                    <div @click.away="openImport = false" class="bg-glass-dark border border-white/10 rounded-xl p-6 w-full max-w-md shadow-2xl relative">
                        <button @click="openImport = false" class="absolute top-4 right-4 text-gray-400 hover:text-white">&times;</button>
                        <h3 class="text-xl font-bold text-white mb-4">Import Guests</h3>
                        <p class="text-sm text-gray-400 mb-4">Upload a CSV or XLSX file containing 'name' and 'phone' columns.</p>
                        
                        <form action="{{ route('guests.import', $event) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" accept=".csv, .xlsx, .xls" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-neon-pink file:text-white hover:file:bg-neon-purple transition-all mb-4" required>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-neon-cyan text-slate-900 rounded-lg font-medium hover:bg-white transition-colors">Import Now</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Add Guest Modal -->
                <div x-show="openAdd" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display: none;">
                    <div @click.away="openAdd = false" class="bg-glass-dark border border-white/10 rounded-xl p-6 w-full max-w-md shadow-2xl relative">
                        <button @click="openAdd = false" class="absolute top-4 right-4 text-gray-400 hover:text-white">&times;</button>
                        <h3 class="text-xl font-bold text-white mb-4">Add Manual Guest</h3>
                        
                        <form action="{{ route('guests.store', $event) }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm text-gray-300">Name</label>
                                    <input type="text" name="name" class="block mt-1 w-full bg-slate-800 border-white/20 text-white focus:border-neon-pink focus:ring-neon-pink rounded-md" required>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-300">WhatsApp Phone (e.g., 628...)</label>
                                    <input type="text" name="phone" class="block mt-1 w-full bg-slate-800 border-white/20 text-white focus:border-neon-pink focus:ring-neon-pink rounded-md" required>
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-300">Quota</label>
                                    <input type="number" name="quota" value="1" min="1" class="block mt-1 w-full bg-slate-800 border-white/20 text-white focus:border-neon-pink focus:ring-neon-pink rounded-md">
                                </div>
                            </div>
                            
                            <div class="flex justify-end mt-6">
                                <button type="submit" class="px-4 py-2 bg-neon-pink text-white rounded-lg font-medium hover:bg-neon-purple transition-colors">Add & Send WA</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-neon-cyan/20 border border-neon-cyan text-neon-cyan rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Guests Table -->
            <div class="bg-glass-dark border border-white/10 rounded-xl overflow-hidden backdrop-blur-md">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/10 bg-white/5 text-gray-300 text-sm">
                                <th class="p-4 font-semibold">Code</th>
                                <th class="p-4 font-semibold">Name</th>
                                <th class="p-4 font-semibold">Phone</th>
                                <th class="p-4 font-semibold text-center">Quota</th>
                                <th class="p-4 font-semibold">Status</th>
                                <th class="p-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($guests as $guest)
                                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors group">
                                    <td class="p-4 text-neon-cyan font-mono">{{ $guest->guest_code }}</td>
                                    <td class="p-4 text-white font-medium">{{ $guest->name }}</td>
                                    <td class="p-4 text-gray-400">{{ $guest->phone }}</td>
                                    <td class="p-4 text-gray-300 text-center">{{ $guest->quota }}</td>
                                    <td class="p-4">
                                        @if($guest->status === 'checked_in')
                                            <span class="px-2 py-1 bg-neon-cyan/20 text-neon-cyan rounded text-xs font-bold border border-neon-cyan/30">Checked In</span>
                                        @elseif($guest->status === 'cancelled')
                                            <span class="px-2 py-1 bg-red-500/20 text-red-400 rounded text-xs font-bold border border-red-500/30">Cancelled</span>
                                        @else
                                            <span class="px-2 py-1 bg-neon-pink/20 text-neon-pink rounded text-xs font-bold border border-neon-pink/30">Pending</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right space-x-2">
                                        <a href="{{ route('guests.qr', $guest) }}" class="inline-block p-2 bg-white/10 hover:bg-neon-purple text-white rounded transition-colors" title="Download QR">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a>
                                        <form action="{{ route('guests.destroy', $guest) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this guest?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-white/10 hover:bg-red-500 text-white rounded transition-colors" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-500">
                                        No guests found. Try importing or adding one manually.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($guests->hasPages())
                    <div class="p-4 border-t border-white/10 bg-black/20">
                        {{ $guests->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
