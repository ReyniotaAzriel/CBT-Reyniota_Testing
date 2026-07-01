<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block h-20 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- Menu Admin & Guru (Desktop) --}}
                    @hasanyrole('admin|guru')
                        <x-nav-link :href="route('mata-pelajaran.index')" :active="request()->routeIs('mata-pelajaran.*')" wire:navigate>
                            {{ __('Mata Pelajaran') }}
                        </x-nav-link>
                        <x-nav-link :href="route('ujian.index')" :active="request()->routeIs('ujian.*')" wire:navigate>
                            {{ __('Jadwal Ujian') }}
                        </x-nav-link>
                        <x-nav-link :href="route('soal.index')" :active="request()->routeIs('soal.*')" wire:navigate>
                            {{ __('Bank Soal') }}
                        </x-nav-link>
                        <x-nav-link :href="route('koreksi.index')" :active="request()->routeIs('koreksi.*')" wire:navigate>
                            {{ __('Koreksi Essay') }}
                        </x-nav-link>
                        <x-nav-link :href="route('rekap.index')" :active="request()->routeIs('rekap.*')" wire:navigate>
                            {{ __('Rekap Nilai') }}
                        </x-nav-link>
                    @endhasanyrole

                    {{-- Menu Siswa (Desktop) --}}
                    @hasanyrole('admin|siswa')
                        <x-nav-link :href="route('siswa.ujian.index')" :active="request()->routeIs('siswa.ujian.*')" wire:navigate>
                            {{ __('Ujian Saya') }}
                        </x-nav-link>
                        <x-nav-link :href="route('siswa.hasil.index')" :active="request()->routeIs('siswa.hasil.*')" wire:navigate>
                            {{ __('Hasil Ujian') }}
                        </x-nav-link>
                    @endhasanyrole
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                x-on:profile-updated.window="name = $event.detail.name"></div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            {{-- Menu Admin & Guru (Mobile) --}}
            @hasanyrole('admin|guru')
                <x-responsive-nav-link :href="route('mata-pelajaran.index')" :active="request()->routeIs('mata-pelajaran.*')" wire:navigate>
                    {{ __('Mata Pelajaran') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('ujian.index')" :active="request()->routeIs('ujian.*')" wire:navigate>
                    {{ __('Jadwal Ujian') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('soal.index')" :active="request()->routeIs('soal.*')" wire:navigate>
                    {{ __('Bank Soal') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('rekap.index')" :active="request()->routeIs('rekap.*')" wire:navigate>
                {{ __('Rekap Nilai') }}
            </x-responsive-nav-link>
            @endhasanyrole

            {{-- Menu Siswa (Mobile) --}}
            @hasanyrole('admin|siswa')
                <x-responsive-nav-link :href="route('siswa.ujian.index')" :active="request()->routeIs('siswa.ujian.*')" wire:navigate>
                    {{ __('Ujian Saya') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('siswa.hasil.index')" :active="request()->routeIs('siswa.hasil.*')" wire:navigate>
                {{ __('Hasil Ujian') }}
            </x-responsive-nav-link>
            @endhasanyrole
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ auth()->user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
