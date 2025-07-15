<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran Listrik PLN</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .struk {
            width: 100%;
            max-width: 280px;
            margin: 20px auto;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .struk img {
            max-width: 80px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .line {
            border-bottom: 1px dashed #ddd;
            margin: 5px 0;
        }
        .mt-2 {
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="struk bg-light">
            <div class="text-center mb-3">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/97/Logo_PLN.png/438px-Logo_PLN.png" alt="PLN Logo">
                <h6 class="mb-0">PT PLN (Persero)</h6>
                <p class="mb-1">Jl. Jenderal Sudirman No. 1</p>
                <p class="mb-0">Jakarta, Indonesia</p>
            </div>
            <h6 class="text-center mb-2">Struk Pembayaran Listrik Pascabayar</h6>
            <div class="line"></div>
            <p><strong>ID Tagihan:</strong> <?= $id_tagihan ?></p>
            <p><strong>Nama Pelanggan:</strong> <?= $nama_pelanggan ?></p>
            <p><strong>No Meter:</strong> <?= $no_meter ?></p>
            <p><strong>Meter Awal:</strong> <?= $meter_awal ?></p>
            <p><strong>Meter Akhir:</strong> <?= $meter_akhir ?></p>
            <p><strong>Tarif Per KWh:</strong> Rp <?= number_format($tarif_perkwh, 0, ',', '.') ?></p>
            <p><strong>Tagihan Listrik:</strong> Rp <?= number_format($tagihan_listrik, 0, ',', '.') ?></p>
            <p><strong>Biaya Admin:</strong> Rp <?= number_format($biaya_admin, 0, ',', '.') ?></p>
            <p><strong>Denda:</strong> Rp <?= number_format($denda, 0, ',', '.') ?></p>
            <div class="line"></div>
            <p><strong>Total Bayar:</strong> Rp <?= number_format($total_bayar, 0, ',', '.') ?></p>
            <p><strong>Jumlah Uang:</strong> Rp <?= number_format($jumlah_uang, 0, ',', '.') ?></p>
            <p><strong>Uang Kembali:</strong> Rp <?= number_format($uang_kembali, 0, ',', '.') ?></p>
            <div class="line mt-2"></div>
            <p class="text-center text-muted mt-2"><em>Terima kasih atas pembayaran Anda.</em></p>
            <p class="text-center text-muted mt-2"><em><?= date('d-m-Y') ?></em></p>

        </div>
    </div>

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
