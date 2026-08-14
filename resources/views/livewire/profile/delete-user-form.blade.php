<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Illuminate\Validation\ValidationException;

new class extends Component
{
    public string $password = '';

    public function deleteUser(Logout $logout): void
    {
        try {
            $this->validate([
                'password' => ['required', 'string', 'current_password'],
            ]);

            tap(Auth::user(), $logout(...))->delete();

            $this->redirect('/', navigate: true);

        } catch (ValidationException $e) {
            $this->reset('password');
            throw $e;
        }
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Hapus Akun') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Mohon unduh data atau informasi yang ingin Anda simpan terlebih dahulu.') }}
        </p>
    </header>

    {{-- Pemicu SweetAlert --}}
    <x-danger-button type="button" onclick="konfirmasiHapusAkun()">{{ __('Hapus Akun Permanen') }}</x-danger-button>

    @script
    <script>
        window.konfirmasiHapusAkun = function() {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Langkah ini tidak dapat dibatalkan. Masukkan kata sandi Anda untuk mengonfirmasi:",
                icon: 'warning',
                input: 'password',
                inputAttributes: {
                    autocapitalize: 'off',
                    placeholder: 'Kata Sandi Saat Ini',
                    required: 'true'
                },
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus Permanen!',
                cancelButtonText: 'Batal',
                preConfirm: (password) => {
                    if (!password) {
                        Swal.showValidationMessage('Kata sandi wajib diisi untuk keamanan!');
                    }
                    return password;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Setel property password ke Livewire lalu jalankan fungsi hapus
                    $wire.set('password', result.value);
                    $wire.deleteUser();
                }
            });
        }
    </script>
    @endscript

    {{-- Alert Gagal (Kata Sandi Salah) --}}
    @if($errors->has('password'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak!',
                    text: 'Kata sandi yang Anda masukkan salah. Gagal menghapus akun.',
                    confirmButtonColor: '#dc2626',
                });
            });
        </script>
    @endif
</section>
