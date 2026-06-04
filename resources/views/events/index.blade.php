<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-neon-pink to-neon-purple">
                {{ __('My Events') }}
            </h2>
            <a href="{{ route('events.create') }}" class="px-4 py-2 bg-gradient-to-r from-neon-pink to-neon-purple hover:from-neon-purple hover:to-neon-cyan text-white rounded-lg font-medium shadow-neon-pink transition-all transform hover:scale-105">
                + Create Event
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                    <div class="bg-glass-dark border border-white/10 rounded-xl p-6 backdrop-blur-md shadow-lg hover:shadow-neon-cyan transition-all duration-300 transform hover:-translate-y-1 group">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-white group-hover:text-neon-cyan transition-colors">{{ $event->name }}</h3>
                        </div>
                        <p class="text-gray-400 mb-4 text-sm line-clamp-2">{{ $event->description ?? 'No description.' }}</p>
                        <div class="space-y-2 text-sm text-gray-300 mb-6">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-neon-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $event->event_date ? $event->event_date->format('d M Y, H:i') : 'TBA' }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-neon-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $event->location ?? 'TBA' }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-neon-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                {{ $event->guests_count }} Guests
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('events.show', $event) }}" class="flex-1 text-center py-2 bg-white/5 hover:bg-neon-cyan hover:text-slate-900 text-neon-cyan rounded-lg transition-colors text-sm font-semibold border border-neon-cyan/50">
                                Dashboard
                            </a>
                            <a href="{{ route('guests.index', $event) }}" class="flex-1 text-center py-2 bg-white/5 hover:bg-neon-pink hover:text-white text-neon-pink rounded-lg transition-colors text-sm font-semibold border border-neon-pink/50">
                                Guests
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-glass-dark border border-white/10 rounded-xl">
                        <p class="text-gray-400 mb-4">You don't have any events yet.</p>
                        <a href="{{ route('events.create') }}" class="px-6 py-2 bg-neon-pink text-white rounded-lg font-medium shadow-neon-pink">Create your first event</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
