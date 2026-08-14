<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-blue-50/50 p-4 sm:p-6 backdrop-blur-sm overflow-hidden">

        <div class="flex w-full max-w-5xl bg-white sm:rounded-[2rem] shadow-2xl overflow-hidden relative z-10 max-h-[95vh] flex-col md:flex-row my-auto">

            <div class="w-full md:w-1/2 p-6 md:p-8 lg:p-10 flex flex-col justify-center bg-white relative z-20 overflow-y-auto custom-scrollbar">

                <div class="flex items-center gap-3 mb-5">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Aplikasi" class="w-14 h-auto object-contain drop-shadow-sm">
                    <span class="font-bold text-lg text-gray-800 tracking-tight">{{ config('app.name', 'CBT App') }}</span>
                </div>

                <div class="mb-6">
                    <p class="text-gray-500 text-xs md:text-sm font-medium mb-1">Join us at</p>
                    <h1 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">Create Account</h1>
                </div>

                <form wire:submit="register" class="space-y-4">

                    <div>
                        <label for="name" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">{{ __('Full Name') }}</label>
                        <input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name"
                            class="block w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Masukkan nama lengkap Anda" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <label for="email" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">{{ __('Email Address') }}</label>
                        <input wire:model="email" id="email" type="email" name="email" required autocomplete="username"
                            class="block w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Masukkan email Anda" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">{{ __('Password') }}</label>
                            <input wire:model="password" id="password" type="password" name="password" required autocomplete="new-password"
                                class="block w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">{{ __('Confirm') }}</label>
                            <input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                class="block w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-md shadow-blue-200 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                            {{ __('REGISTER') }}
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-xs text-gray-500">
                            Already registered?
                            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 transition-colors" wire:navigate>Log in here</a>
                        </p>
                    </div>
                </form>
            </div>

            <div class="hidden md:flex w-1/2 bg-blue-600 relative flex-col justify-center text-white overflow-hidden p-8 lg:p-12">

                <svg class="absolute left-0 top-0 h-full text-white w-12 -ml-1 z-10" preserveAspectRatio="none" viewBox="0 0 100 100" fill="currentColor">
                    <path d="M0 0 C 100 20 100 80 0 100 Z"></path>
                </svg>
                <div class="relative z-20">
                    <h2 class="text-xl font-bold mb-3">Mulai Perjalanan Anda</h2>
                    <p class="text-blue-100 text-xs mb-6 leading-relaxed">
                        Daftarkan diri Anda untuk mengakses sistem ujian terpadu kami. Sistem ini didesain khusus untuk memberikan pengalaman ujian yang lancar, aman, dan tanpa kendala.
                    </p>

                    <h3 class="text-lg font-bold mb-3">Keunggulan CBT Kami</h3>
                    <ul class="space-y-3 text-xs text-blue-100">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Akses instan ke berbagai mata pelajaran dan bank soal interaktif.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Sistem auto-save pintar agar jawaban Anda tidak pernah hilang.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Laporan hasil belajar dan rekap nilai otomatis secara real-time.</span>
                        </li>
                    </ul>
                </div>

                <div class="absolute bottom-0 right-0 w-full flex justify-end opacity-90 pointer-events-none z-10">
                </div>
            </div>

        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
    </style>
</div>
