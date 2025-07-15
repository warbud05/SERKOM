<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-1">
        <h1 class="h3 mb-4 text-gray-800"><?php echo htmlspecialchars($title); ?></h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm float-right" data-toggle="modal" data-target="#CetakRiwayatPembayaran">
            <i class="fas fa-download fa-sm text-white-50"></i> Cetak Tunggakan
        </a>
    </div>

    <?php if (!empty($tunggakan)) : ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pelanggan Menunggak</h6>
            </div>
            <div class="card-body">
               
                
                <div class="table-responsive">
                    <table class="table table-bordered rohman-syah" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Pelanggan</th>
                                <th>Nama Pelanggan</th>
                                <th>Jumlah Tagihan</th>
                                <th>Denda (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; // Initialize counter ?>
                            <?php foreach ($tunggakan as $pelanggan) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($no++); ?></td>
                                    <td><?php echo htmlspecialchars($pelanggan['id_pelanggan']); ?></td>
                                    <td><?php echo htmlspecialchars($pelanggan['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($pelanggan['jumlah_tagihan']); ?> Bulan Belum Dibayar</td>
                                    <td><?php echo nominal($pelanggan['denda']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="alert alert-warning" role="alert">
            Tidak ada pelanggan yang menunggak.
        </div>
    <?php endif; ?>
</div>


<!-- Modal for Print -->
<div class="modal fade" id="CetakRiwayatPembayaran" tabindex="-1" role="dialog" aria-labelledby="CetakRiwayatPembayaranLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CetakRiwayatPembayaranLabel">Cetak Riwayat Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="printArea">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Pelanggan</th>
                                <th>Nama Pelanggan</th>
                                <th>Jumlah Tagihan</th>
                                <th>Denda (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; // Initialize counter ?>
                            <?php foreach ($tunggakan as $pelanggan) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($no++); ?></td>
                                    <td><?php echo htmlspecialchars($pelanggan['id_pelanggan']); ?></td>
                                    <td><?php echo htmlspecialchars($pelanggan['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($pelanggan['jumlah_tagihan']); ?> Bulan Belum Dibayar</td>
                                    <td><?php echo nominal($pelanggan['denda']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="printButton">Cetak</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('printButton').addEventListener('click', function() {
    var printContents = document.getElementById('printArea').innerHTML;
    var printWindow = window.open('', '', 'height=600,width=800');

    printWindow.document.write('<html><head><title>Cetak Pelanggan Menunggak</title>');
    printWindow.document.write('<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">'); // Include Bootstrap CSS
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h4>Riwayat Pembayaran</h4>');
    printWindow.document.write('<table class="table table-bordered">');
    printWindow.document.write('<tbody>' + printContents + '</tbody>');
    printWindow.document.write('</table>');
    printWindow.document.write('</body></html>');

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
});
</script>
