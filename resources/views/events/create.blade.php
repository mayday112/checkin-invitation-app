<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-neon-pink to-neon-purple">
            {{ __('Create Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-glass-dark border border-white/10 rounded-xl p-8 backdrop-blur-md shadow-neon-purple/20">
                <form method="POST" action="{{ route('events.store') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Event Name')" class="text-gray-300" />
                        <x-text-input id="name" class="block mt-1 w-full bg-slate-800 border-white/20 text-white focus:border-neon-pink focus:ring-neon-pink" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Date -->
                    <div class="mt-4">
                        <x-input-label for="event_date" :value="__('Event Date & Time')" class="text-gray-300" />
                        <x-text-input id="event_date" class="block mt-1 w-full bg-slate-800 border-white/20 text-white focus:border-neon-cyan focus:ring-neon-cyan" type="datetime-local" name="event_date" :value="old('event_date')" />
                        <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                    </div>

                    <!-- Location -->
                    <div class="mt-4">
                        <x-input-label for="location" :value="__('Location')" class="text-gray-300" />
                        <x-text-input id="location" class="block mt-1 w-full bg-slate-800 border-white/20 text-white focus:border-neon-purple focus:ring-neon-purple" type="text" name="location" :value="old('location')" />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <x-input-label for="description" :value="__('Description')" class="text-gray-300" />
                        <textarea id="description" name="description" rows="4" class="block mt-1 w-full bg-slate-800 border-white/20 text-white rounded-md shadow-sm focus:border-neon-pink focus:ring-neon-pink">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-8 space-x-4">
                        <a href="{{ route('events.index') }}" class="text-gray-400 hover:text-white transition-colors">Cancel</a>
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-neon-pink to-neon-purple hover:from-neon-purple hover:to-neon-cyan text-white rounded-lg font-medium shadow-neon-pink transition-all transform hover:scale-105">
                            Create Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
