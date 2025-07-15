<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Riwayat Pembayaran </h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#CetakRiwayatPembayaran">
            <i class="fas fa-download fa-sm text-white-50"></i> Cetak Riwayat Pembayaran
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Riwayat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered rohman-syah" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Bayar</th>
                            <th>Nama Pelanggan</th>
                            <th>Total Bayar</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

<tbody>
    <?php $no = 1; foreach ($pembayaran as $row): ?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo htmlspecialchars($row['id_tagihan'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($row['nama_pelanggan'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars(nominal($row['total_bayar'])); ?></td>
<td><?php echo htmlspecialchars(date('d F Y, H:i', strtotime($row['tanggal_pembayaran']))); ?></td>
        <td>
            <a href="<?= site_url('PembayaranController/bukti_bayar/' . htmlspecialchars($row['id_tagihan'], ENT_QUOTES, 'UTF-8')) ?>" class="btn btn-primary btn-sm" target="_blank">Print</a>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
            </table>
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->



<!-- Modal Cetak Laporan -->
<div class="modal fade" id="CetakRiwayatPembayaran" tabindex="-1" role="dialog" aria-labelledby="CetakLaporanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CetakLaporanLabel">Cetak Laporan Tarif Listrik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Bayar</th>
                            <th>Nama Pelanggan</th>
                            <th>Total Bayar</th>
                            <th>Tanggal Pembayaran</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1; foreach ($pembayaran as $row): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['id_tagihan'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_pelanggan'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars(nominal($row['total_bayar'], ENT_QUOTES, 'UTF-8')); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal_pembayaran'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="printReport()">Cetak</button>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript to Print the Report -->
<script>
    function printReport() {
        var printContent = document.querySelector('#CetakRiwayatPembayaran .modal-body').innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();  
    }
</script>