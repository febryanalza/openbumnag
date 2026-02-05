@extends('admin.layouts.app')

@section('title', 'Database Management')
@section('header', 'Database Management')

@section('content')
<div class="space-y-6">
    <!-- Database Info Card -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-linear-to-r from-red-600 to-red-800">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                </svg>
                Informasi Database
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Driver</p>
                    <p class="text-lg font-semibold text-gray-900">{{ strtoupper($databaseInfo['driver']) }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Database</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $databaseInfo['database'] }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Versi</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $databaseInfo['version'] }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Ukuran</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $databaseInfo['size'] }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Host</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $databaseInfo['host'] }}:{{ $databaseInfo['port'] }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Charset</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $databaseInfo['charset'] }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Collation</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $databaseInfo['collation'] }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-500">Total Tabel</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $statistics['total_tables'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Export Database -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                </div>
                <h4 class="ml-3 text-lg font-medium text-gray-900">Export Database</h4>
            </div>
            <p class="text-sm text-gray-600 mb-4">Backup seluruh database ke file SQL</p>
            <form action="{{ route('admin.database.export') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="compress" value="1" class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                        <span class="ml-2 text-sm text-gray-600">Kompres (GZIP)</span>
                    </label>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                    Export Sekarang
                </button>
            </form>
        </div>

        <!-- Upload Backup -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                </div>
                <h4 class="ml-3 text-lg font-medium text-gray-900">Upload Backup</h4>
            </div>
            <p class="text-sm text-gray-600 mb-4">Upload file backup dari komputer</p>
            <form action="{{ route('admin.database.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="file" name="sql_file" accept=".sql,.gz,.zip,.txt" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <div class="mb-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="confirm_upload" value="1" required class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                        <span class="ml-2 text-sm text-gray-600">Konfirmasi upload</span>
                    </label>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                    Upload File
                </button>
            </form>
        </div>

        <!-- Clear Cache -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <h4 class="ml-3 text-lg font-medium text-gray-900">Clear Cache</h4>
            </div>
            <p class="text-sm text-gray-600 mb-4">Bersihkan semua cache aplikasi</p>
            <form action="{{ route('admin.database.clear-cache') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-yellow-600 text-white py-2 px-4 rounded-lg hover:bg-yellow-700 transition-colors">
                    Clear Cache
                </button>
            </form>
        </div>

        <!-- Optimize Database -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h4 class="ml-3 text-lg font-medium text-gray-900">Optimize</h4>
            </div>
            <p class="text-sm text-gray-600 mb-4">Optimasi semua tabel database</p>
            <form action="{{ route('admin.database.optimize') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                    Optimize Sekarang
                </button>
            </form>
        </div>
    </div>

    <!-- Backup Files -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-linear-to-r from-amber-500 to-amber-600">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </svg>
                File Backup ({{ count($backups) }})
            </h3>
        </div>
        <div class="p-6">
            @if(count($backups) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ukuran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($backups as $backup)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">{{ $backup['name'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $backup['size'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $backup['date'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $backup['type'] === 'gz' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ strtoupper($backup['type']) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.database.download', $backup['name']) }}" class="text-blue-600 hover:text-blue-900" title="Download">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </a>
                                    <button type="button" onclick="confirmImport('{{ $backup['name'] }}')" class="text-green-600 hover:text-green-900" title="Import">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.database.delete', $backup['name']) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus file backup ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </svg>
                <p class="text-gray-500">Belum ada file backup. Klik tombol "Export Sekarang" untuk membuat backup.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Table Statistics -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-linear-to-r from-gray-600 to-gray-800">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Statistik Tabel
            </h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tabel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Baris</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ukuran Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ukuran Index</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Engine</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($statistics['tables'] as $table)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">{{ $table['table_name'] ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($table['table_rows'] ?? 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $table['data_size_mb'] ?? 0 }} MB</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $table['index_size_mb'] ?? 0 }} MB</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $table['size_mb'] ?? 0 }} MB</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">{{ $table['engine'] ?? 'Unknown' }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Warning Notice -->
    <div class="bg-red-50 border-l-4 border-red-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Peringatan Penting</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>Selalu backup database sebelum melakukan import atau perubahan besar.</li>
                        <li>Import database akan menimpa data yang ada. Pastikan Anda memiliki backup terbaru.</li>
                        <li>Fitur ini hanya tersedia untuk Super Admin.</li>
                        <li>Jangan hapus file backup yang masih diperlukan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Import Confirmation Modal -->
<div id="importModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="ml-3 text-lg font-semibold text-gray-900">Konfirmasi Import Database</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4">
                Anda akan mengimpor file: <strong id="importFileName" class="text-gray-900"></strong>
            </p>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-yellow-800">
                    <strong>PERINGATAN:</strong> Proses ini akan menimpa data yang ada di database. Pastikan Anda sudah memiliki backup terbaru sebelum melanjutkan.
                </p>
            </div>
            <form id="importForm" action="" method="POST">
                @csrf
                <input type="hidden" name="backup_file" id="backupFileInput">
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="confirm" value="1" required class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <span class="ml-2 text-sm text-gray-600">Saya mengerti dan ingin melanjutkan proses import</span>
                    </label>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeImportModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Import Database
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmImport(filename) {
    document.getElementById('importFileName').textContent = filename;
    document.getElementById('backupFileInput').value = filename;
    document.getElementById('importForm').action = "{{ route('admin.database.import') }}";
    document.getElementById('importModal').classList.remove('hidden');
}

function closeImportModal() {
    document.getElementById('importModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('importModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImportModal();
    }
});
</script>
@endpush
