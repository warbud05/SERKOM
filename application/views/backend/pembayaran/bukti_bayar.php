<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran Listrik - PLN</title>
    <style>
        :root {
            --pln-blue: #0073e6;
            --pln-blue-dark: #005bb7;
            --text-primary: #1a1a1a;
            --text-secondary: #6c757d;
            --bg-light: #f8f9fa;
            --border-color: #dee2e6;
            --success-color: #28a745;
        }

        body {
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .receipt-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            max-width: 700px;
            width: 100%;
            padding: 2.5rem;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        /* --- Header --- */
        .receipt__header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .receipt__header .logo-container img {
            max-width: 120px;
        }
        .receipt__header .company-info {
            text-align: left;
        }
        .receipt__header h2 {
            margin: 0;
            font-size: 1.5rem;
            color: var(--pln-blue);
        }
        .receipt__header p {
            margin: 2px 0;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        /* --- Status LUNAS --- */
        .status-paid {
            position: absolute;
            top: 25px;
            right: -25px;
            background-color: var(--success-color);
            color: #fff;
            padding: 8px 30px;
            font-weight: bold;
            font-size: 1.2rem;
            text-transform: uppercase;
            transform: rotate(45deg);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }


        /* --- Body --- */
        .receipt__body h1 {
            text-align: center;
            font-size: 1.8rem;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }
        .transaction-details {
            font-size: 0.9rem;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 2.5rem;
        }

        /* --- Sections & Tables --- */
        .receipt__section {
            margin-bottom: 2rem;
        }
        .receipt__section-title {
            font-size: 1.2rem;
            color: var(--pln-blue);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 8px;
            margin-bottom: 1rem;
        }
        .receipt__table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1rem;
        }
        .receipt__table td {
            padding: 10px 5px;
            border-bottom: 1px solid #f0f0f0;
        }
        .receipt__table td:first-child {
            color: var(--text-secondary);
            width: 40%;
        }
        .receipt__table td:last-child {
            font-weight: 600;
            color: var(--text-primary);
            text-align: right;
        }
        .receipt__table tr:last-child td {
            border-bottom: none;
        }


        /* --- Total Section --- */
        .receipt__total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--pln-blue);
            color: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 2rem;
        }
        .receipt__total span {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .receipt__total span:last-child {
            font-size: 1.8rem;
            font-weight: 700;
        }

        /* --- Footer --- */
        .receipt__footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 2px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 0.85rem;
        }
        .footer-text {
            text-align: left;
            flex-grow: 1;
        }
        .qr-placeholder {
            width: 80px;
            height: 80px;
            border: 2px dashed var(--border-color);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 0.7rem;
            color: #ccc;
        }

        /* --- Action Buttons --- */
        .actions-container {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.1s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .btn-print {
            background-color: var(--success-color);
        }
        .btn-print:hover {
            background-color: #218838;
        }
        .btn-back {
            background-color: var(--pln-blue);
        }
        .btn-back:hover {
            background-color: var(--pln-blue-dark);
        }

        /* --- CSS for Printing --- */
        @media print {
            body {
                background-color: #fff;
                padding: 0;
                margin: 0;
            }
            .receipt-container {
                box-shadow: none;
                border-radius: 0;
                border: 1px solid #000;
                max-width: 100%;
                padding: 1.5cm; /* Sesuaikan margin untuk kertas A4 */
            }
            .status-paid {
                border: 2px solid #000;
                color: #000;
                background-color: #fff !important;
            }
            .receipt__total {
                background-color: #ddd !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            .actions-container {
                display: none;
            }
            .receipt__footer .qr-placeholder {
                border: 2px dashed #000;
            }
        }
    </style>
</head>
<body>

    <div class="receipt-container">
        
        <div class="status-paid">LUNAS</div>

        <header class="receipt__header">
            <div class="logo-container">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/97/Logo_PLN.png/438px-Logo_PLN.png" alt="Logo PLN">
            </div>
            <div class="company-info">
                <h2>PT PLN (Persero)</h2>
                <p>Jl. Jendral Sudirman Kav. 52-53, Jakarta</p>
                <p>Layanan Pelanggan: 123</p>
            </div>
        </header>

        <main class="receipt__body">
            <h1>Struk Pembayaran Listrik</h1>
            <p class="transaction-details">
                Kode Bayar: <?php echo htmlspecialchars($pembayaran->id_tagihan); ?> | Tgl Transaksi: <?php echo date('d-m-Y H:i'); ?>
            </p>

            <section class="receipt__section">
                <h2 class="receipt__section-title">Data Pelanggan</h2>
                <table class="receipt__table">
                    <tbody>
                        <tr>
                            <td>ID Pelanggan</td>
                            <td><?php echo htmlspecialchars($pembayaran->id_pelanggan); ?></td>
                        </tr>
                        <tr>
                            <td>Nama Pelanggan</td>
                            <td><?php echo htmlspecialchars($pembayaran->nama_pelanggan); ?></td>
                        </tr>
                        <tr>
                            <td>Nomor Meter</td>
                            <td><?php echo htmlspecialchars($pembayaran->no_meter); ?></td>
                        </tr>
                        <tr>
                            <td>Kode Tarif / Daya</td>
                            <td><?php echo htmlspecialchars($pembayaran->kode_tarif); ?></td>
                        </tr>
                    </tbody>
                </table>
            </section>
            
            <section class="receipt__section">
                <h2 class="receipt__section-title">Rincian Penggunaan</h2>
                <table class="receipt__table">
                    <tbody>
                        <tr>
                            <td>Periode Tagihan</td>
                            <td><?php echo nama_bulan($pembayaran->bulan);?> <?php echo htmlspecialchars($pembayaran->tahun); ?></td>
                        </tr>
                        <tr>
                            <td>Stand Meter Awal</td>
                            <td><?php echo htmlspecialchars($pembayaran->meter_awal); ?></td>
                        </tr>
                        <tr>
                            <td>Stand Meter Akhir</td>
                            <td><?php echo htmlspecialchars($pembayaran->meter_akhir); ?></td>
                        </tr>
                        <tr>
                            <td>Total Pemakaian (kWh)</td>
                            <td><?php echo htmlspecialchars($pembayaran->jumlah_meter); ?> kWh</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        
            <section class="receipt__section">
                <h2 class="receipt__section-title">Rincian Tagihan</h2>
                <table class="receipt__table">
                    <tbody>
                        <tr>
                            <td>Tagihan Listrik (Pemakaian x Tarif)</td>
                            <td>Rp <?php echo number_format($pembayaran->tagihan_listrik, 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td>Biaya Admin Bank</td>
                            <td>Rp <?php echo number_format($pembayaran->biaya_admin, 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td>Denda</td>
                            <td>Rp <?php echo number_format($pembayaran->denda, 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <div class="receipt__total">
                <span>Total Bayar</span>
                <span>Rp <?php echo number_format($pembayaran->total_bayar, 0, ',', '.'); ?></span>
            </div>

        </main>
        
        <footer class="receipt__footer">
            <div class="footer-text">
                <p>Terima kasih atas pembayaran Anda. Harap simpan struk ini sebagai bukti pembayaran yang sah.</p>
                <p>© <?php echo date('Y'); ?> PT PLN (Persero). Dioperasikan oleh Petugas: <?php echo htmlspecialchars($pembayaran->id_petugas); ?></p>
            </div>
            <div class="qr-placeholder">
                QR
            </div>
        </footer>

    </div>

    <div class="actions-container">
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak Struk</button>
        <a href="<?= site_url('rpembayaran') ?>" class="btn btn-back">⬅️ Kembali</a>
    </div>

</body>
</html>