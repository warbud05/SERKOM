<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Display Alerts -->
    <?php if ($this->session->flashdata('alert')): ?>
        <?php 
            $alert = $this->session->flashdata('alert');
            $alert_types = [
                'tambah_penggunaan_berhasil' => 'success',
                'gagal_tambah_penggunaan' => 'danger',
                'hapus_penggunaan_berhasil' => 'success',
                'gagal_hapus_penggunaan' => 'danger'
            ];
            $alert_class = isset($alert_types[$alert]) ? $alert_types[$alert] : 'info';
        ?>
        <div class="alert alert-<?= $alert_class ?> alert-dismissible fade show" role="alert">
            <?php 
                $messages = [
                    'tambah_penggunaan_berhasil' => 'Penggunaan berhasil ditambahkan!',
                    'gagal_tambah_penggunaan' => 'Gagal menambahkan penggunaan!',
                    'hapus_penggunaan_berhasil' => 'Penggunaan berhasil dihapus!',
                    'gagal_hapus_penggunaan' => 'Gagal menghapus penggunaan!'
                ];
                echo isset($messages[$alert]) ? $messages[$alert] : 'Terjadi kesalahan!';
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Penggunaan Listrik Pelanggan</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#CetakLaporanPenggunaan">
            <i class="fas fa-download fa-sm text-white-50"></i> Cetak Penggunaan
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <?php if ($this->session->userdata('session_akses') == 'Petugas') : ?>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalTambahPenggunaan">
                    <i class="fas fa-plus-circle"></i> Tambah Penggunaan
                </button>
            <?php else: ?>
                <h6 class="m-0 font-weight-bold text-primary">Daftar Penggunaan Listrik</h6>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered rohman-syah" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th> <!-- Kolom untuk nomor urut -->
                            <th style="display: none;">ID Penggunaan</th>
                            <th>ID Pelanggan</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Meter Awal</th>
                            <th>Meter Akhir</th>
                            <th>Tanggal Cek</th>
                            <th style="display: none;">ID Petugas</th>
                            <?php if ($this->session->userdata('session_akses') == 'Petugas') : ?>
                                <th class="text-center"><i class="fas fa-cogs"></i></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; // Inisialisasi variabel nomor urut ?>
                        <?php foreach ($penggunaan as $p): ?>
                            <tr>
                                <td><?php echo $no++; // Menampilkan nomor urut ?></td>
                                <td style="display: none;"><?php echo $p['id_penggunaan']; ?></td>
                                <td><?php echo $p['id_pelanggan']; ?></td>
                                <td><?php echo nama_bulan($p['bulan']); ?></td>
                                <td><?php echo $p['tahun']; ?></td>
                                <td><?php echo $p['meter_awal']; ?></td>
                                <td><?php echo $p['meter_akhir']; ?></td>
                                <td><?php echo $p['tgl_cek']; ?></td>
                                <td style="display: none;"><?php echo $p['id_petugas']; ?></td>
                                <?php if ($this->session->userdata('session_akses') == 'Petugas') : ?>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapusPenggunaan<?= htmlspecialchars($p['id_penggunaan']) ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->


<!-- Modal Tambah Penggunaan -->
<div class="modal fade" id="ModalTambahPenggunaan" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPenggunaanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTambahPenggunaanLabel">Tambah Penggunaan Listrik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('PenggunaanController/tambah') ?>" method="POST">
                <div class="modal-body">
  <div class="form-group">
      <label for="nama_pelanggan">Pelanggan</label>
      <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" 
             placeholder="Cari ID, nama, atau nomor meter..." required 
             data-autocomplete-url="<?= site_url('pelanggan/ajaxIndex') ?>" 
             data-detail-url="<?= site_url('pelanggan/detail/') ?>">
      <input type="hidden" id="id_pelanggan" name="id_pelanggan">
      <input type="hidden" id="id_tarif" name="id_tarif">
  </div>

                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <select class="form-control" id="bulan" name="bulan" required>
                            <?php
                            $bulan_list = [
                                '1' => 'Januari',
                                '2' => 'Februari',
                                '3' => 'Maret',
                                '4' => 'April',
                                '5' => 'Mei',
                                '6' => 'Juni',
                                '7' => 'Juli',
                                '8' => 'Agustus',
                                '9' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember'
                            ];
                            foreach ($bulan_list as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <select class="form-control" id="tahun" name="tahun" required>
                            <?php
                            $current_year = date('Y');
                            for ($i = $current_year; $i >= $current_year - 10; $i--): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="meter_awal">Meter Awal</label>
                        <input type="number" class="form-control" id="meter_awal" name="meter_awal" required>
                    </div>
                    <div class="form-group">
                        <label for="meter_akhir">Meter Akhir</label>
                        <input type="number" class="form-control" id="meter_akhir" name="meter_akhir" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_cek">Tanggal Cek</label>
                        <input type="date" class="form-control" id="tgl_cek" name="tgl_cek" required>
                    </div>
                    <div class="form-group">
                        <label for="id_petugas"><?= get_nama_login($this->session) ?></label>
                        <input type="text" name="id_petugas" id="id_petugas" class="form-control" value="<?= isset($cek_login['id_petugas']) ? htmlspecialchars($cek_login['id_petugas']) : '' ?>" required readonly style="display: none;">
                        <input type="text" class="form-control" value="<?= isset($cek_login['nama_petugas']) ? htmlspecialchars($cek_login['nama_petugas']) : '' ?>" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Hapus Penggunaan -->
<?php foreach ($penggunaan as $p): ?>
<div class="modal fade" id="modalHapusPenggunaan<?= htmlspecialchars($p['id_penggunaan']) ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusPenggunaanLabel<?= htmlspecialchars($p['id_penggunaan']) ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHapusPenggunaanLabel<?= htmlspecialchars($p['id_penggunaan']) ?>">Hapus Penggunaan Listrik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('PenggunaanController/hapus/' . htmlspecialchars($p['id_penggunaan'])) ?>" method="POST">
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data penggunaan listrik <?= htmlspecialchars($p['id_pelanggan']) ?>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>

<!-- Modal for Cetak Laporan Penggunaan -->
<div class="modal fade" id="CetakLaporanPenggunaan" tabindex="-1" role="dialog" aria-labelledby="CetakLaporanPenggunaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CetakLaporanPenggunaanLabel">Cetak Laporan Penggunaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="printTable">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="display: none;">ID Penggunaan</th>
                                <th>ID Pelanggan</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Meter Awal</th>
                                <th>Meter Akhir</th>
                                <th>Tanggal Cek</th>
                                <th style="display: none;">ID Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; // Inisialisasi variabel nomor urut ?>
                            <?php foreach ($penggunaan as $p): ?>
                                <?php if ($this->session->userdata('session_akses') == 'Agen' && $p['id_petugas'] != 
                                $this->session->userdata('session_id')) {continue;}?>  
                                <tr>
                                    <td><?php echo $no++; // Menampilkan nomor urut ?></td>
                                    <td style="display: none;"><?php echo $p['id_penggunaan']; ?></td>
                                    <td><?php echo $p['id_pelanggan']; ?></td>
                                    <td><?php echo nama_bulan($p['bulan']); ?></td>
                                    <td><?php echo $p['tahun']; ?></td>
                                    <td><?php echo $p['meter_awal']; ?></td>
                                    <td><?php echo $p['meter_akhir']; ?></td>
                                    <td><?php echo $p['tgl_cek']; ?></td>
                                    <td style="display: none;"><?php echo $p['id_petugas']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printTable()">Print</button>
            </div>
        </div>
    </div>
</div>

<script>
function printTable() {
    // Open a new window
    var printWindow = window.open('', '', 'height=600,width=800');

    // Add the HTML content to the new window
    printWindow.document.write('<html><head><title>Print Laporan Penggunaan</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">'); // Link ke Bootstrap 4 via CDN
    printWindow.document.write('</head><body>');
    
    // Add the title
    printWindow.document.write('<h1 class="text-center">Laporan Penggunaan</h1>'); // Add your title here
    
    // Add the table content
    printWindow.document.write(document.getElementById('printTable').outerHTML);
    
    printWindow.document.write('</body></html>');

    // Close the document to finish loading
    printWindow.document.close();

    // Wait for the document to finish loading, then trigger the print dialog
    printWindow.onload = function() {
        printWindow.focus();
        printWindow.print();
    };
}
</script>
