<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-neon-pink to-neon-purple">
                {{ $event->name }} - Dashboard
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('checkin.scanner', $event) }}" class="px-4 py-2 bg-neon-cyan hover:bg-white text-slate-900 rounded-lg font-medium shadow-neon-cyan transition-all transform hover:scale-105">
                    📷 Open Scanner
                </a>
                <a href="{{ route('guests.index', $event) }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white border border-white/20 rounded-lg font-medium transition-all">
                    Manage Guests
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Guests -->
                <div class="bg-glass-dark border border-white/10 rounded-xl p-6 backdrop-blur-md">
                    <div class="text-gray-400 text-sm font-medium mb-1">Total Guests</div>
                    <div class="text-3xl font-bold text-white">{{ $totalGuests }}</div>
                </div>
                
                <!-- Checked In -->
                <div class="bg-glass-dark border border-neon-cyan/30 rounded-xl p-6 backdrop-blur-md shadow-neon-cyan/10">
                    <div class="text-neon-cyan text-sm font-medium mb-1">Checked In</div>
                    <div class="text-3xl font-bold text-neon-cyan">{{ $checkedIn }}</div>
                </div>
                
                <!-- Pending -->
                <div class="bg-glass-dark border border-neon-pink/30 rounded-xl p-6 backdrop-blur-md shadow-neon-pink/10">
                    <div class="text-neon-pink text-sm font-medium mb-1">Pending</div>
                    <div class="text-3xl font-bold text-neon-pink">{{ $pending }}</div>
                </div>
                
                <!-- Attendance % -->
                <div class="bg-glass-dark border border-neon-purple/30 rounded-xl p-6 backdrop-blur-md shadow-neon-purple/10">
                    <div class="text-neon-purple text-sm font-medium mb-1">Attendance Rate</div>
                    <div class="text-3xl font-bold text-neon-purple">{{ $attendancePercentage }}%</div>
                </div>
            </div>

            <!-- Attendance Progress -->
            <div class="bg-glass-dark border border-white/10 rounded-xl p-6 backdrop-blur-md">
                <h3 class="text-lg font-medium text-white mb-4">Check-in Progress</h3>
                <div class="w-full bg-slate-800 rounded-full h-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-neon-cyan to-neon-purple h-4 rounded-full" style="width: {{ $attendancePercentage }}%"></div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
