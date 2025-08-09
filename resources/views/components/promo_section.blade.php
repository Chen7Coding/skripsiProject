@if($promo)
<div id="promo" class="bg-gray-900 scroll-mt-16">
    <div class="container mx-auto max-w-7xl px-6 py-16 lg:px-8">
        <div class="flex flex-wrap items-center overflow-hidden rounded-lg bg-white shadow-2xl">
            <div class="w-full md:w-1/2">
                <img class="w-full h-auto" src="{{ asset($promo->image) }}" alt="{{ $promo->title }}">
            </div>
            <div class="w-full md:w-1/2 p-8 md:p-12">
                <h2 class="text-sm font-bold uppercase tracking-widest text-amber-700">Promo Spesial</h2>
                <p class="mt-4 text-3xl font-extrabold tracking-tight text-gray-900">{{ $promo->title }}</p>
                <p class="mt-4 text-lg text-gray-600">{{ $promo->description }}</p>
                <p class="mt-4 text-sm font-medium text-gray-500">
                    Berlaku sampai: {{ \Carbon\Carbon::parse($promo->end_date)->format('d F Y') }}
                </p>
                <div class="mt-8">
                    <a href="#produk" class="inline-block rounded-md border border-transparent bg-gray-900 py-3 px-8 text-center font-medium text-white hover:bg-amber-700">
                        Belanja Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif