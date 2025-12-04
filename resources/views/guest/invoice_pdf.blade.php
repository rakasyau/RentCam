<!DOCTYPE html>
<html>
<head>
    <title>Bukti Booking - RentCam</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .logo { font-size: 24px; font-weight: bold; color: #2563eb; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .items-table th { background-color: #f3f4f6; padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        .items-table td { padding: 10px; border-bottom: 1px solid #eee; }
        .total-section { margin-top: 20px; text-align: right; }
        .total-label { font-weight: bold; font-size: 16px; }
        .total-amount { font-size: 20px; color: #2563eb; font-weight: bold; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo"><i class="fas fa-camera-retro me-2 text-primary"></i>RentCam</div>
        <div>Jalan Pajajaran, No. sekian</div>
        <div>WhatsApp: 0812-3456-7890</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>No. Invoice</strong></td>
            <td>: #{{ $booking->id }}</td>
            <td width="15%"><strong>Tanggal</strong></td>
            <td>: {{ $booking->created_at->format('d M Y') }}</td>
        </tr>
        <tr>
            <td><strong>Penyewa</strong></td>
            <td>: {{ $booking->client_name }}</td>
            <td><strong>Kontak</strong></td>
            <td>: {{ $booking->client_contact }}</td>
        </tr>
        <tr>
            <td><strong>Ambil</strong></td>
            <td>: {{ date('d M Y', strtotime($booking->pickup_date)) }}</td>
            <td><strong>Kembali</strong></td>
            <td>: {{ date('d M Y', strtotime($booking->return_date)) }}</td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga/Hari</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($booking->details as $detail)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $detail->camera->name }}</td>
                <td>Rp {{ number_format($detail->camera->price_per_day) }}</td>
                <td>{{ $detail->qty }}</td>
                <td>Rp {{ number_format($detail->subtotal) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-label">Total Durasi Sewa: {{ $booking->total_days }} Hari</div>
        <br>
        <span class="total-label">Biaya Total:</span>
        <span class="total-amount">Rp {{ number_format($booking->grand_total) }}</span>
    </div>

    <div class="footer">
        <p>Harap membawa bukti ini dan 3 jaminan (seperti KTP, SIM, KK, dsb.) saat pengambilan barang.</p>
        <p>Terima kasih telah menyewa di RentCam!</p>
    </div>

</body>
</html>