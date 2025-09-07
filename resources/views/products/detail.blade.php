@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="bg-gray-100 py-12 antialiased">
        <div class="container mx-auto px-4 py-12 sm:py-16">
            {{-- Notifikasi Sukses/Error --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-400 bg-green-100 px-6 py-4 text-green-700 text-center shadow-sm"
                    role="alert">
                    <p class="font-semibold text-lg">{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 rounded-lg border border-red-400 bg-red-100 px-6 py-4 text-red-700 text-center shadow-sm"
                    role="alert">
                    <p class="font-semibold text-lg">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Menampilkan semua error validasi di atas form --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-400 bg-red-100 px-6 py-4 text-red-700 shadow-sm" role="alert">
                    <h3 class="font-bold">Terjadi kesalahan:</h3>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-y-10 lg:grid-cols-2 lg:gap-x-12">
                {{-- Kolom Kiri: Gambar dan Deskripsi --}}
                <div>
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-100 shadow-xl">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="h-full w-full object-cover object-center">
                    </div>
                    <div class="mt-10 p-6 bg-white rounded-lg shadow-xl">
                        <h2 class="text-xl font-extrabold text-gray-900">Deskripsi Produk</h2>
                        <div class="prose mt-4 max-w-none text-gray-700">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Form Pemesanan --}}
                <div class="flex flex-col p-6 bg-white rounded-lg shadow-xl" x-data="{
                    // --- Variabel Alpine.js ---
                    attributes: @js($attributes), // Kirim semua data atribut
                    basePrice: {{ $product->price }},
                    pricePerSqm: {{ $product->price_per_sqm ?? 0 }},
                    quantity: {{ old('quantity', $cartItem->quantity ?? 1) }},
                
                    sizeOptionType: '{{ old('size_option_type', $cartItem->length ?? null ? 'custom' : 'predefined') }}',
                    // Perbaikan di sini: Ambil nilai awal dari data atribut
                    selectedMaterial: '{{ old('material', $cartItem->material ?? '') }}',
                    selectedSize: '{{ old('size', $cartItem->size ?? '') }}',
                    customLength: {{ old('custom_length', $cartItem->length ?? null) ?? 'null' }},
                    customWidth: {{ old('custom_width', $cartItem->width ?? null) ?? 'null' }},
                
                    designOption: '{{ old('design_option', isset($cartItem) && $cartItem->design_file_path ? 'has_design' : 'no_design') }}',
                
                    // Perbaikan di sini: Ambil harga awal dari atribut pertama
                    finalPrice: {{ old('price', $cartItem->price ?? ($attributes->first()->price_modifier ?? 0)) }},
                
                    // --- Fungsi Alpine.js ---
                    updatePrice() {
                        let newPrice = 0;
                
                        // Logika untuk ukuran standar
                        if (this.sizeOptionType === 'predefined' && this.selectedMaterial && this.selectedSize) {
                            // Mencari atribut yang cocok di array 'attributes' secara lokal
                            const selectedAttribute = this.attributes.find(attr =>
                                attr.material === this.selectedMaterial && attr.size === this.selectedSize
                            );
                            newPrice = selectedAttribute ? selectedAttribute.price_modifier : this.basePrice;
                        } else if (this.sizeOptionType === 'custom' && this.customLength > 0 && this.customWidth > 0) {
                            // Logika untuk ukuran kustom
                            const areaInSqm = (this.customLength * this.customWidth) / 10000;
                
                            // cari data atribut berdasarkan material
                            const materialAttribute = this.attributes.find(attr =>
                                attr.material === this.selectedMaterial && attr.size === '1x1 meter'
                            );
                            const pricePerSqm = materialAttribute ? materialAttribute.price_modifier : this.pricePerSqm;
                
                            newPrice = areaInSqm * pricePerSqm; //Hitung harga = luas x harga price perm2
                        } else {
                            // Jika tidak ada opsi yang dipilih, kembali ke harga dasar
                            newPrice = this.basePrice;
                        }
                        this.finalPrice = newPrice;
                    },
                
                    get subtotal() {
                        return this.finalPrice * this.quantity;
                    },
                    formatRupiah(value) {
                        return 'Rp' + new Intl.NumberFormat('id-ID').format(Math.round(value));
                    }
                }">

                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">{{ $product->name }}</h1>
                    <div class="mt-3">
                        <p class="text-4xl tracking-tight font-extrabold text-amber-600" x-text="formatRupiah(subtotal)">
                        </p>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-10">
                        <form action="{{ $cartItem ? route('cart.update', $cartItem->id) : route('cart.store') }}"
                            method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @if (isset($cartItem))
                                @method('PATCH')
                            @endif

                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="price" x-bind:value="finalPrice">

                            {{-- Opsi Desain --}}
                            <div>
                                <label class="text-base font-bold text-gray-900">Opsi Desain</label>
                                <p class="mt-4 text-xs text-gray-500 mb-2">(Hanya format JPG, JPEG, dan PNG yang
                                    diperbolehkan).</p>
                                <fieldset class="mt-4">
                                    <div class="flex items-center gap-x-6">
                                        <label
                                            class="flex cursor-pointer items-center text-sm font-medium text-gray-700 transition-colors duration-200 hover:text-gray-500">
                                            <input type="radio" name="design_option" value="has_design"
                                                x-model="designOption"
                                                class="h-4 w-4 border-gray-300 text-gray-700 focus:ring-amber-700"
                                                @checked(old('design_option', isset($cartItem) && $cartItem->design_file_path ? 'has_design' : 'no_design') == 'has_design')>
                                            <span class="ml-2">Sudah Punya Desain</span>
                                        </label>
                                        <label
                                            class="flex cursor-pointer items-center text-sm font-medium text-gray-700 transition-colors duration-200 hover:text-gray-500">
                                            <input type="radio" name="design_option" value="no_design"
                                                x-model="designOption"
                                                class="h-4 w-4 border-gray-300 text-gray-700 focus:ring-gray-700"
                                                @checked(old('design_option', isset($cartItem) && $cartItem->design_file_path ? 'has_design' : 'no_design') == 'no_design')>
                                            <span class="ml-2">Belum Punya Desain</span>
                                        </label>
                                    </div>
                                </fieldset>
                            </div>

                            <div x-show="designOption === 'has_design'" x-transition>
                                <label for="design_file_path" class="block text-sm font-bold text-gray-900">Upload File
                                    Desain</label>
                                <input id="design_file_path" name="design_file_path" type="file"
                                    class="mt-2 block w-full cursor-pointer text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-amber-100 file:py-2 file:px-4 file:text-sm file:font-semibold file:text-amber-600 hover:file:bg-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                    accept=".jpg,.jpeg,.png" />
                                @error('design_file_path')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                @if (isset($cartItem) && $cartItem->design_file_path)
                                    <p class="mt-2 text-xs text-gray-500">File saat ini: <a
                                            href="{{ asset('storage/' . $cartItem->design_file_path) }}" target="_blank"
                                            class="text-amber-600 hover:underline font-medium">Lihat File</a>. Unggah baru
                                        untuk mengganti.</p>
                                @endif
                            </div>

                            <div x-show="designOption === 'no_design'" x-transition>
                                <label for="notes" class="block text-sm font-bold text-gray-900">Catatan untuk
                                    Desain</label>
                                <textarea id="notes" name="notes" rows="4"
                                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm placeholder-gray-400"
                                    placeholder="Jelaskan desain yang Anda inginkan...">{{ old('notes', $cartItem->notes ?? '') }}</textarea>
                                @error('notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                {{-- Jenis Bahan --}}
                                <div>
                                    <label for="material" class="block text-sm font-bold text-gray-900">Jenis Bahan</label>
                                    <select id="material" name="material" x-model="selectedMaterial"
                                        @change="updatePrice()"
                                        class="mt-2 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                                        <option value="" disabled selected>-- Pilih Bahan --</option>
                                        @foreach ($materials as $material)
                                            <option value="{{ $material }}"
                                                @if (old('material', $cartItem->material ?? '') == $material) selected @endif>{{ $material }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('material')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Hybrid Ukuran --}}
                                <div>
                                    <label class="block text-sm font-bold text-gray-900">Ukuran</label>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center">
                                            <input id="predefined_size_option" name="size_option_type" type="radio"
                                                value="predefined" x-model="sizeOptionType" @change="updatePrice()"
                                                class="h-4 w-4 border-gray-300 text-amber-600 focus:ring-amber-500"
                                                @checked(old('size_option_type', $cartItem->length ?? null ? 'custom' : 'predefined') == 'predefined')>
                                            <label for="predefined_size_option"
                                                class="ml-2 block text-sm text-gray-900">Pilih Ukuran</label>
                                        </div>
                                        @if (!in_array($cartItem?->product->unit ?? $product->unit, ['book', 'sheet']))
                                            <div class="flex items-center">
                                                <input id="custom_size_option" name="size_option_type" type="radio"
                                                    value="custom" x-model="sizeOptionType" @change="updatePrice()"
                                                    class="h-4 w-4 border-gray-300 text-amber-600 focus:ring-amber-500"
                                                    @checked(old('size_option_type', $cartItem->length ?? null ? 'custom' : 'predefined') == 'custom')>
                                                <label for="custom_size_option"
                                                    class="ml-2 block text-sm text-gray-900">Ukuran Kustom</label>
                                            </div>
                                        @endif
                                    </div>
                                    <div x-show="sizeOptionType === 'predefined'" x-transition>
                                        <select id="size" name="size"
                                            x-bind:name="sizeOptionType === 'predefined' ? 'size' : ''"
                                            x-model="selectedSize" @change="updatePrice()"
                                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm placeholder-gray-400">
                                            <option value="" disabled selected>Pilih Ukuran</option>
                                            <option value="" disabled selected>-- Pilih Ukuran --</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size }}"
                                                    @if (old('size', $cartItem->size ?? '') == $size) selected @endif>{{ $size }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('size')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div x-show="sizeOptionType === 'custom'" x-transition>
                                        <div class="mt-2 grid grid-cols-2 gap-2">
                                            <input type="number" name="custom_length"
                                                x-bind:name="sizeOptionType === 'custom' ? 'custom_length' : ''"
                                                x-model.number="customLength" @input.debounce.500ms="updatePrice()"
                                                placeholder="Panjang (cm)" class="rounded-md border-gray-300 shadow-sm"
                                                value="{{ old('custom_length', $cartItem->length ?? '') }}"
                                                min="1">
                                            <input type="number" name="custom_width"
                                                x-bind:name="sizeOptionType === 'custom' ? 'custom_width' : ''"
                                                x-model.number="customWidth" @input.debounce.500ms="updatePrice()"
                                                placeholder="Lebar (cm)" class="rounded-md border-gray-300 shadow-sm"
                                                value="{{ old('custom_width', $cartItem->width ?? '') }}" min="1">
                                        </div>
                                        @error('custom_length')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                        @error('custom_width')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Jumlah --}}
                            <div>
                                <label for="quantity" class="block text-sm font-bold text-gray-900">Jumlah</label>
                                <input type="number" id= "quantity" name="quantity" x-model.number="quantity"
                                    @input.debounce.500ms="updatePrice()" min="1"
                                    class="mt-2 block w-full max-w-[120px] rounded-md border-gray-300 shadow-sm focus:border-amber-600 focus:ring-amber-700 sm:text-sm">
                                @error('quantity')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @if (auth()->check() && auth()->user()->role === 'pelanggan')
                                <button type="submit"
                                    class="mt-8 w-full rounded-md border border-transparent bg-amber-600 py-3 px-8 flex items-center justify-center text-base font-bold text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-colors duration-200">
                                    {{ isset($cartItem) ? 'Update Keranjang' : 'Tambahkan ke Keranjang' }}
                                </button>
                            @else
                                <p class="mt-8 text-center text-gray-500">Anda harus login sebagai pelanggan untuk memesan.
                                </p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
