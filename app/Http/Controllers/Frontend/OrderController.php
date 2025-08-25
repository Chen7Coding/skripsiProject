<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\WhatsAppHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{

    public function store(Request $request)
    {
        // 1. Validasi data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'design_option' => 'required|in:has_design,no_design',
            'design_file' => 'required_if:design_option,has_design|file|mimes:jpg,png,pdf,cdr,psd|max:10240', // max 10MB
            'notes' => 'required_if:design_option,no_design|string',
            'material' => 'required|string',
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Gunakan DB Transaction untuk memastikan semua data tersimpan atau tidak sama sekali
        DB::beginTransaction();
        try {
            // 2. Simpan file desain jika ada
            $filePath = null;
            if ($request->hasFile('design_file')) {
                $filePath = $request->file('design_file')->store('public/designs');
            }

            // 3. Buat pesanan (Order)
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'INV-' . time() . Str::random(5),
                'total_price' => $product->price * $request->quantity, // Kalkulasi harga sederhana
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ]);

            // 4. Buat item pesanan (OrderItem)
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'material' => $request->material,
                'size' => $request->size,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'design_file_path' => $filePath,
                'notes' => $request->notes,
            ]);

            DB::commit();

            // 5. Arahkan ke halaman dashboard dengan pesan sukses
            return redirect()->route('dashboard')->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Arahkan kembali dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.')->withInput();
        }
    }    

     public function downloadInvoice($orderId)
    {
        // Pastikan pengguna yang login memiliki akses ke pesanan ini
        $order = Order::with('orderItems.product')
                      ->where('user_id', Auth::id())
                      ->where('id', $orderId)
                      ->firstOrFail();

        // Buat file PDF dari view
        $pdf = Pdf::loadView('invoices.invoice', compact('order'));

        // Unduh file PDF dengan nama unik
        return $pdf->stream('invoice-' . $order->order_number . '.pdf');
    }

    public function reuploadDesign(Request $request, OrderItem $orderItem)
{
    // Lakukan validasi file unggahan
    $request->validate([
        'new_design_file' => 'required|file|mimes:jpg,jpeg,png,pdf,ai,psd|max:2048',
    ]);

    // Hapus file lama jika ada, ini sangat penting
    if ($orderItem->design_file_path) {
        Storage::disk('public')->delete($orderItem->design_file_path);
    }

    // Simpan file baru
    $newFilePath = $request->file('new_design_file')->store('designs', 'public');

    // Perbarui path file di database
    $orderItem->design_file_path = $newFilePath;
    $orderItem->save(); // Menggunakan save() untuk update

    return redirect()->back()->with('success', 'File desain berhasil diunggah ulang!');
}

     public function uploadPaymentProof(Request $request, Order $order)
    {
        // 1. Pastikan pesanan adalah milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki hak akses untuk pesanan ini.');
        }

        // 2. Pastikan status pembayaran masih 'unpaid'
        if ($order->payment_status !== 'unpaid') {
            return back()->with('error', 'Pembayaran sudah dikonfirmasi atau bukti sudah diunggah.');
        }

        // 3. Validasi file yang diunggah
        $request->validate([
            'payment_proof_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Contoh validasi
        ]);

        DB::beginTransaction();
        try {
            // 4. Simpan file bukti pembayaran ke storage
            // $originalName = $request->file('payment_proof_url')->getClientOriginalName();
            $filePath = $request->file('payment_proof_url')->store('payment_proofs', 'public');

            // 5. Update data di tabel `orders`
            $order->payment_status = 'paid';
            $order->payment_proof_url = $filePath; // Simpan path file
            $order->save();

            DB::commit();

            return back()->with('success', 'Bukti pembayaran berhasil diunggah. Kami akan segera memverifikasinya.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Hapus file yang sudah diupload jika terjadi error
            if (isset($filePath)) {
                Storage::delete($filePath);
            }
            return back()->with('error', 'Terjadi kesalahan saat mengunggah bukti pembayaran. Silakan coba lagi.');
        }
    }

      public function confirmReceived(Order $order)
    {
        // Pastikan pesanan adalah milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki hak akses untuk pesanan ini.');
        }
        
        // Hanya izinkan konfirmasi jika statusnya 'shipping'
        if ($order->status !== 'shipping') {
            return back()->with('error', 'Pesanan tidak dalam status pengiriman.');
        }

        $order->status = 'completed';
        $order->save();

        return back()->with('success', 'Pesanan berhasil dikonfirmasi telah diterima!');
    }

      /**
     * Memproses pembatalan pesanan dari pelanggan.
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki hak akses untuk pesanan ini.');
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak bisa dibatalkan.');
        }

        $order->status = 'cancelled';
        $order->save();

        // Di sini Anda bisa menambahkan notifikasi ke pemilik
        // ...
         // Kirim notifikasi ke admin atau pemilik
        $ownerNumber = config('services.owner.whatsapp_number');
        $ownerMessage = "⚠️ *Pemberitahuan Pembatalan Pesanan* ⚠️\n\n"
        . "Pesanan *#{$order->order_number}* telah dibatalkan oleh pelanggan.";

        WhatsAppHelper::sendNotification($ownerNumber, $ownerMessage);

        return back()->with('success', 'Pesanan berhasil dibatalkan!');
    }
}
