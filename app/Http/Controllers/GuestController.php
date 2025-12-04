<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camera;
use App\Models\Booking;
use App\Models\BookingDetail;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class GuestController extends Controller
{
    public function index(Request $request) {
        // 1. Mulai Query Kosong
        $query = Camera::query();

        // 2. Filter Search (Jika user mengetik sesuatu)
        if($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // 3. Filter Kategori (Jika user klik tombol kategori)
        if($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // 4. Eksekusi Query
        $cameras = $query->get();

        // 5. Kirim juga daftar kategori agar bisa diloop di View (Optional, bisa hardcode juga)
        $categories = ['DSLR', 'Mirrorless', 'Action Cam', 'Drone'];

        return view('guest.index', compact('cameras', 'categories'));
    }

    // Menambah ke Session Cart
    public function addToCart(Request $request, $id) {
        $camera = Camera::find($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $camera->name,
                "quantity" => 1,
                "price" => $camera->price_per_day,
                "photo" => $camera->image_path,
                "max_stock" => $camera->quantity
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Kamera ditambahkan ke list!');
    }

    public function viewCart() {
        return view('guest.cart');
    }

    // Proses Final "Booking Sekarang"
    public function storeBooking(Request $request) {
        $request->validate([
            'pickup_date' => 'required|date|after:today|before_or_equal:+3 days',
            'duration' => 'required|integer|min:1',
            'ktp_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'client_name' => 'required|string|max:255',
            'client_contact' => 'required|string|max:20',
        ]);

        $cart = session()->get('cart');
        if(!$cart) return redirect()->back()->with('error', 'Keranjang kosong!');

        // PERUBAHAN DI SINI:
        // Tambahkan '$booking =' di depan DB::transaction untuk menangkap hasil return
        $booking = DB::transaction(function() use ($request, $cart) {
            
            $ktpPath = $request->file('ktp_image')->store('ktp_uploads', 'public');

            $grandTotal = 0;
            foreach($cart as $id => $details) {
                $grandTotal += $details['price'] * $details['quantity'] * $request->duration;
            }

            $newBooking = Booking::create([
                'client_name' => $request->client_name,
                'client_contact' => $request->client_contact,
                'ktp_image_path' => $ktpPath,
                'pickup_date' => $request->pickup_date,
                'return_date' => date('Y-m-d', strtotime($request->pickup_date. ' + '.$request->duration.' days')),
                'total_days' => $request->duration,
                'grand_total' => $grandTotal,
                'status' => 'pending'
            ]);

            foreach($cart as $id => $details) {
                BookingDetail::create([
                    'booking_id' => $newBooking->id,
                    'camera_id' => $id,
                    'qty' => $details['quantity'],
                    'subtotal' => $details['price'] * $details['quantity'] * $request->duration
                ]);
            }

            // PENTING: Kembalikan objek booking ke luar transaksi
            return $newBooking;
        });

        session()->forget('cart');

        // Sekarang $booking sudah dikenali di sini
        return redirect()->route('home')->with([
            'success' => 'Booking berhasil! Silakan download bukti sewa Anda.',
            'booking_id' => $booking->id 
        ]);
    }

    // FUNGSI HAPUS ITEM DARI KERANJANG
    public function removeFromCart($id)
    {
        // 1. Ambil data keranjang saat ini
        $cart = session()->get('cart');

        // 2. Cek apakah barang dengan ID tersebut ada di keranjang?
        if(isset($cart[$id])) {
            
            // 3. Hapus item dari array PHP (unset adalah perintah delete variabel di PHP)
            unset($cart[$id]);

            // 4. Simpan kembali array yang sudah diupdate ke dalam Session
            session()->put('cart', $cart);
        }

        // 5. Kembali ke halaman keranjang dengan pesan sukses
        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang!');
    }

    public function help() {
        return view('guest.help');
    }

    // FUNGSI CETAK PDF
    public function printInvoice($id) {
        // Ambil data booking beserta detail item dan kameranya
        $booking = Booking::with('details.camera')->findOrFail($id);

        // Load view khusus PDF (nanti kita buat)
        $pdf = Pdf::loadView('guest.invoice_pdf', compact('booking'));

        // Download file dengan nama otomatis
        return $pdf->download('Invoice-RentCam-'.$booking->id.'.pdf');
    }
}