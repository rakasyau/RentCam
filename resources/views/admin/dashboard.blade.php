@extends('layouts.guest')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard Admin</h2>
        
        <div>
            <a href="{{ route('cameras.index') }}" class="btn btn-primary me-2">
                <i class="fas fa-camera"></i> Kelola Inventaris Kamera
            </a>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <div class="card mb-4 border-warning">
        <div class="card-header bg-warning text-dark fw-bold">Permintaan Sewa Baru (Pending)</div>
        <div class="card-body">
            <div class="table-responsive"><table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th> 
                        <th>Penyewa</th>
                        <th width="30%">Item yang Disewa</th>
                        <th>Total Biaya</th>
                        <th>Bukti KTP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingBookings as $booking)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        
                        <td>
                            <div class="fw-bold">{{ $booking->client_name }}</div>
                            <div class="text-muted small">
                                <i class="fab fa-whatsapp text-success"></i> {{ $booking->client_contact }}
                            </div>
                            <small class="d-block fw-bold">Ambil: {{ date('d M Y', strtotime($booking->pickup_date)) }}</small>
                            <small class="text-muted">Durasi: {{ $booking->total_days }} Hari</small>
                        </td>
                        
                        <td>
                            <ul class="list-unstyled mb-0">
                                @foreach($booking->details as $detail)
                                    <li class="d-flex justify-content-between">
                                        <span>• {{ $detail->camera->name }}</span>
                                        <span class="fw-bold">x{{ $detail->qty }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>Rp {{ number_format($booking->grand_total) }}</td>
                        <td>
                            <a href="{{ asset('storage/'.$booking->ktp_image_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-id-card"></i> Cek KTP
                            </a>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <form action="{{ route('booking.approve', $booking->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-sm" onclick="return confirm('Stok akan berkurang. Lanjut?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('booking.reject', $booking->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Tolak pesanan?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada permintaan baru</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div></div>
    </div>

    <div class="card mb-4 border-primary">
        <div class="card-header bg-primary text-white fw-bold">Sedang Disewa (Approved)</div>
        <div class="card-body">
            <div class="table-responsive"><table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        
                        <th>Penyewa</th>
                        
                        <th>Tanggal Kembali</th>
                        <th width="30%">Item yang Disewa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeBookings as $booking)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        
                        <td>
                            <div class="fw-bold">{{ $booking->client_name }}</div>
                            <div class="text-muted small">
                                <i class="fab fa-whatsapp text-success"></i> {{ $booking->client_contact }}
                            </div>
                        </td>

                        <td>
                            <span class="fw-bold">{{ date('d M Y', strtotime($booking->return_date)) }}</span>
                            @php
                                $hari_ini = new DateTime();
                                $tgl_kembali = new DateTime($booking->return_date);
                                $selisih = $hari_ini->diff($tgl_kembali);
                            @endphp
                            
                            @if($tgl_kembali < $hari_ini)
                                <small class="d-block text-danger fw-bold">Terlambat {{ $selisih->days }} Hari!</small>
                            @else
                                <small class="d-block text-muted">Sisa {{ $selisih->days }} Hari lagi</small>
                            @endif
                        </td>

                        <td>
                            <ul class="list-unstyled mb-0">
                                @foreach($booking->details as $detail)
                                    <li class="d-flex justify-content-between">
                                        <span>• {{ $detail->camera->name }}</span>
                                        <span class="fw-bold">x{{ $detail->qty }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <form action="{{ route('booking.complete', $booking->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-dark btn-sm" onclick="return confirm('Pastikan barang sudah dicek dan kembali lengkap. Stok akan bertambah. Lanjutkan?')">
                                    <i class="fas fa-box-open me-1"></i> Barang Kembali
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted">Tidak ada barang yang sedang keluar</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div></div>
    </div>
</div>
@endsection