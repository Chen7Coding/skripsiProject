@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Promosi Khusus</h1>

        @foreach ($promos as $promo)
            @include('components.promo_section', ['promo' => $promo])
        @endforeach

    </div>
@endsection
