<div class="overflow-x-auto">
    <table class="w-full text-sm text-left border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-3">No</th> {{-- Tambah kolom No --}}
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Username</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Kontak</th>
                <th class="px-4 py-3">Alamat</th>
                <th class="px-4 py-3">Role</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
                <tr class="border-t hover:bg-gray-50">
                    {{-- Nomor otomatis sesuai halaman pagination --}}
                    <td class="px-4 py-3">
                        {{ ($employees->currentPage() - 1) * $employees->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-4 py-3">{{ $employee->name }}</td>
                    <td class="px-4 py-3">{{ $employee->username ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $employee->email }}</td>
                    <td class="px-4 py-3">{{ $employee->phone ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $employee->address ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">
                            {{ ucfirst($employee->role) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="{{ route('owner.employee.edit', $employee->id) }}"
                            class="text-blue-600 font-medium hover:underline">Edit</a>
                        <form action="{{ route('owner.employee.destroy', $employee->id) }}" method="POST"
                            class="inline-block"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 font-medium hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                        Tidak ada data karyawan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $employees->links() }}
</div>
