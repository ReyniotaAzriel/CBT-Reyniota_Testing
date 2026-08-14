<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
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
                    <p class="text-gray-500 text-xs md:text-sm font-medium mb-1">Welcome to</p>
                    <h1 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">{{ config('app.name', 'CBT App') }}</h1>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form wire:submit="login" class="space-y-4">

                    <div>
                        <label for="email" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">{{ __('Email / Username') }}</label>
                        <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username"
                            class="block w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Masukkan email Anda" />
                        <x-input-error :messages="$errors->get('form.email')" class="mt-1" />
                    </div>

                    <div>
                        <label for="password" class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">{{ __('Password') }}</label>
                        <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password"
                            class="block w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('form.password')" class="mt-1" />
                    </div>

                    <div class="flex items-center justify-between mt-2">
                        <label for="remember" class="inline-flex items-center cursor-pointer group">
                            <input wire:model="form.remember" id="remember" type="checkbox" class="w-3.5 h-3.5 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 cursor-pointer" name="remember">
                            <span class="ms-2 text-xs text-gray-500 group-hover:text-gray-800 transition-colors">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-md shadow-blue-200 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                            {{ __('LOGIN') }}
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-xs text-gray-500">
                            Don't have an account?
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800" wire:navigate>Sign up</a>
                            @else
                                <a href="#" class="font-bold text-blue-600 hover:text-blue-800">Sign up</a>
                            @endif
                        </p>
                    </div>
                </form>

                <div class="mt-6 text-center text-[10px] font-medium text-gray-400 space-x-3">
                    <a href="#" class="hover:text-gray-800 transition-colors">FAQ</a>
                    <span>|</span>
                    <a href="#" class="hover:text-gray-800 transition-colors">Features</a>
                    <span>|</span>
                    <a href="#" class="hover:text-gray-800 transition-colors">Support</a>
                </div>
            </div>

            <div class="hidden md:flex w-1/2 bg-blue-600 relative flex-col justify-center text-white overflow-hidden p-8 lg:p-12">

                <svg class="absolute left-0 top-0 h-full text-white w-12 -ml-1 z-10" preserveAspectRatio="none" viewBox="0 0 100 100" fill="currentColor">
                    <path d="M0 0 C 100 20 100 80 0 100 Z"></path>
                </svg>


                <div class="relative z-20">
                    <h2 class="text-xl font-bold mb-3">About {{ config('app.name', 'CBT App') }}</h2>
                    <p class="text-blue-100 text-xs mb-6 leading-relaxed">
                        Sistem ujian berbasis komputer (CBT) yang dirancang untuk memudahkan manajemen ujian, evaluasi otomatis, dan rekapitulasi nilai. Dilengkapi dengan keamanan anti-curang dan fitur rekapitulasi real-time.
                    </p>

                    <h3 class="text-lg font-bold mb-3">Features</h3>
                    <ul class="space-y-3 text-xs text-blue-100">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Real-time Auto-save & Timer yang akurat untuk mencegah kecurangan.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Sistem Token (PIN) & Peringatan Pindah Tab untuk menjaga integritas ujian.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Penilaian Pilihan Ganda instan dan Koreksi Essay interaktif oleh Guru.</span>
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
