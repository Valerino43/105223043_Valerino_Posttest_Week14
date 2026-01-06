<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
        @endif
        
        <h3 class="font-bold text-lg mb-4 text-gray-800">Katalog Barang Lab</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            @foreach($items as $item)
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-xl text-gray-900">{{ $item->name }}</h4>
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                {{ $item->category->name ?? 'Umum' }}
                            </span>
                        </div>
                        
                        <p class="text-gray-500 text-sm mb-3">{{ $item->description }}</p>
                        <p class="text-gray-600 mb-4 font-medium">Sisa Stok: <span class="{{ $item->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $item->stock }}</span></p>
                    </div>
                    
                    @if($item->stock > 0)
                        <form action="{{ route('loans.store', $item) }}" method="POST" class="mt-auto">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                                Pinjam Barang
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full bg-gray-200 text-gray-500 font-bold py-2 px-4 rounded cursor-not-allowed mt-auto">
                            Stok Habis
                        </button>
                    @endif
                </div>
            @endforeach
        </div>

        <h3 class="font-bold text-lg mb-4 text-gray-800">Barang yang Saya Pinjam</h3>
        
        <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm font-light">
                    <thead class="border-b font-medium bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-6 py-4">Barang</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4 text-center">Tgl Pinjam</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @forelse($loans as $loan)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $loan->item->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded">
                                        {{ $loan->item->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">{{ $loan->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-bold {{ $loan->status == 'borrowed' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($loan->status == 'borrowed')
                                        <form action="{{ route('loans.update', $loan) }}" method="POST" onsubmit="return confirm('Yakin ingin mengembalikan barang?')">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-blue-600 hover:text-blue-800 font-bold hover:underline">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 italic">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">
                                    Belum ada barang yang sedang kamu pinjam.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>