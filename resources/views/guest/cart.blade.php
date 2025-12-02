@extends('layouts.guest')

@section('content')
<div class="container mt-5">
    <h3>Selesaikan Booking</h3>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Kamera</th>
                    <th>Harga/Hari</th>
                    <th>Jumlah Unit</th>
                    <th>Subtotal (Per Hari)</th>
                    <th style="width: 10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPerDay = 0; @endphp
                
                @if(session('cart'))
                    @foreach(session('cart') as $id => $details)
                        @php 
                            $subtotal = $details['price'] * $details['quantity']; 
                            $totalPerDay += $subtotal; 
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/'.$details['photo']) }}" width="50" class="me-2 rounded">
                                    {{ $details['name'] }}
                                </div>
                            </td>
                            <td>Rp {{ number_format($details['price']) }}</td>
                            <td>{{ $details['quantity'] }}</td>
                            <td>Rp {{ number_format($subtotal) }}</td>
                            <td class="text-center">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan sewa kamera ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">Keranjang masih kosong.</td>
                    </tr>
                @endif
            </tbody>
            @if(session('cart'))
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total per Hari</td>
                    <td colspan="2" class="fw-bold">Rp {{ number_format($totalPerDay) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

    <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" class="card p-4">
        @csrf
        <h4 class="mb-4"><i class="fas fa-user-edit me-2"></i>Data Penyewa</h4>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nama Lengkap (Sesuai KTP)</label>
                <input type="text" name="client_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nomor WhatsApp / HP</label>
                <input type="number" name="client_contact" class="form-control" required>
            </div>
        </div>

        <hr class="border-white opacity-50 my-4">

        <h4 class="mb-4"><i class="fas fa-calendar-alt me-2"></i>Detail Sewa</h4>

        <div class="mb-3">
            <label>Tanggal Pengambilan</label>
            <input type="date" name="pickup_date" class="form-control" 
                min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                max="{{ date('Y-m-d', strtotime('+3 days')) }}" 
                required>
            <small class="text-muted">
                *Maksimal booking untuk 3 hari ke depan (sampai {{ date('d M', strtotime('+3 days')) }}).
            </small>
        </div>
        <div class="mb-3">
            <label>Durasi Sewa (Hari)</label>
            <input type="number" name="duration" class="form-control" min="1" value="1" required>
        </div>
        <div class="mb-3">
            <label>Upload Foto KTP</label>
            <input type="file" name="ktp_image" class="form-control" required>
            <small class="text-muted">Format: JPG, PNG. Max 2MB.</small>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100">Booking Sekarang</button>
    </form>
</div>
@endsection