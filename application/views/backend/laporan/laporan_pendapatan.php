<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Pendapatan Saya</h1>
    </div>
    
    <!-- Summary Row -->
    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pendapatan (Hasil Filter)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= nominal($total_pendapatan); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Transaksi (Hasil Filter)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_transaksi; ?> Transaksi</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Filter and Data Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan & Detail Transaksi</h6>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <form action="<?= site_url('pendapatan'); ?>" method="POST" class="mb-4">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="start_date">Dari Tanggal:</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="<?= htmlspecialchars($start_date ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date">Sampai Tanggal:</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="<?= htmlspecialchars($end_date ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                        <a href="<?= site_url('pendapatan'); ?>" class="btn btn-secondary"><i class="fas fa-sync-alt"></i> Reset</a>
                    </div>
                </div>
            </form>

            <hr>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-bordered rohman-syah" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Bayar</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Pendapatan (Biaya Admin)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($laporan)): ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data untuk periode yang dipilih.</td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($laporan as $row): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['id_tagihan']); ?></td>
                                <td><?= htmlspecialchars($row['nama_pelanggan']); ?></td>
                                <td><?= htmlspecialchars(date('d F Y, H:i', strtotime($row['tanggal_pembayaran']))); ?></td>
                                <td><?= htmlspecialchars(nominal($row['biaya_admin'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->