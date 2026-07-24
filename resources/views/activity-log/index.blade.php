<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
            Log <span class="text-blue-600">Aktivitas Sistem</span> (CCTV)
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-xl font-extrabold text-gray-900">Riwayat Aktivitas</h3>
                    <p class="text-gray-500 mt-1">Pantau semua perubahan data dan aktivitas mencurigakan secara real-time.</p>
                </div>

                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b-2 border-gray-100">
                                    <th class="pb-4 font-bold text-gray-500 uppercase text-sm">Waktu</th>
                                    <th class="pb-4 font-bold text-gray-500 uppercase text-sm">Pelaku</th>
                                    <th class="pb-4 font-bold text-gray-500 uppercase text-sm">Aktivitas / Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($logs as $log)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="py-4 text-sm text-gray-600 font-medium">
                                            {{ $log->created_at->format('d M Y, H:i:s') }}
                                        </td>
                                        <td class="py-4">
                                            @if($log->causer)
                                                <p class="font-bold text-gray-900">{{ $log->causer->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $log->causer->email }}</p>
                                            @else
                                                <span class="text-gray-400 font-bold italic">Sistem (Otomatis)</span>
                                            @endif
                                        </td>
                                        <td class="py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                                {{ $log->event == 'created' ? 'bg-green-100 text-green-800' :
                                                  ($log->event == 'updated' ? 'bg-blue-100 text-blue-800' :
                                                  ($log->event == 'deleted' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                                {{ strtoupper($log->event ?? 'AKTIVITAS') }}
                                            </span>
                                            <p class="text-gray-800 font-medium mt-2">{{ $log->description }}</p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-12 text-center text-gray-500">Belum ada aktivitas terekam.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
