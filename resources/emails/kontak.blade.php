@component('mail::message')
    # Pesan Baru dari Kontak Kami

    Anda menerima pesan dari formulir kontak.

    **Nama:** {{ $nama }}
    **Email:** {{ $email }}
    **No Tlp/WA:** {{ $telepon ?? 'Tidak ada' }}
    **Topik:** {{ $topik }}

    ---

    **Isi Pesan:**
    {{ $deskripsi }}

    Terima kasih,
    {{ config('app.name') }}
@endcomponent
