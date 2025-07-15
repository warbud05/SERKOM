<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Tarif Listrik</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#CetakLaporanTarif">
            <i class="fas fa-download fa-sm text-white-50"></i> Cetak Tarif Listrik
        </a>
    </div>

    <!-- Pesan alert  -->
    <?php if ($this->session->flashdata('alert')): ?>
        <?php 
        $alertType = '';
        $alertMessage = $this->session->flashdata('alert');

        switch ($alertMessage) {
            case 'tambah_tarif_berhasil':
            $alertType = 'success';
            $alertMessage = 'Tarif berhasil ditambahkan!';
            break;
            case 'tambah_tarif_gagal':
            $alertType = 'danger';
            $alertMessage = 'Gagal menambahkan tarif. Silakan coba lagi.';
            break;
            case 'update_tarif_berhasil':
            $alertType = 'success';
            $alertMessage = 'Tarif berhasil diperbarui!';
            break;
            case 'update_tarif_gagal':
            $alertType = 'danger';
            $alertMessage = 'Gagal memperbarui tarif. Silakan coba lagi.';
            break;
            case 'hapus_tarif_berhasil':
            $alertType = 'success';
            $alertMessage = 'Tarif berhasil dihapus!';
            break;
            case 'hapus_tarif_gagal':
            $alertType = 'danger';
            $alertMessage = 'Gagal menghapus tarif. Silakan coba lagi.';
            break;
            case 'belum_login':
            $alertType = 'warning';
            $alertMessage = 'Anda harus login terlebih dahulu.';
            break;
            default:
            $alertType = 'info';
            $alertMessage = 'Terjadi sesuatu yang tidak diketahui.';
            break;
        }
        ?>
        <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
            <?php echo $alertMessage; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>


    <!-- Data Table -->
    <div class="card shadow mb-4">
        <?php if ($this->session->userdata('session_akses') == 'Petugas') : ?>
            <div class="card-header py-3">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalTambahTarif">
                    <i class="fas fa-plus-circle"></i> Tambah Tarif
                </button>
            </div>
        <?php endif; ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered rohman-syah" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Tarif</th>
                            <th>Golongan</th>
                            <th>Daya Listrik</th>
                            <th>Tarif Per KWH</th>
                            <?php if ($this->session->userdata('session_akses') == 'Petugas') : ?>
                                <th class="text-center"><i class="fas fa-cogs"></i></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tarif as $key => $value) : ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($value['kode_tarif']) ?></td>
                                <td><?= htmlspecialchars($value['golongan']) ?></td>
                                <td class="text-center"><?= htmlspecialchars(format_daya($value['daya'])) ?></td>
                                <td><?= htmlspecialchars(nominal($value['tarif_perkwh'])) ?></td>

                                <?php if ($this->session->userdata('session_akses') == 'Petugas') : ?>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalUpdateTarif<?= htmlspecialchars($value['id_tarif']) ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapusTarif<?= htmlspecialchars($value['id_tarif']) ?>">
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


<!-- Modal Tambah Tarif -->
<div class="modal fade" id="ModalTambahTarif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tarif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form Tambah Tarif -->
                <form action="<?php echo site_url('TarifController/tambah'); ?>" method="post" required>
                    <div class="form-group">
                        <label for="kode_tarif">Kode Tarif</label>
                        <input type="text" class="form-control" id="kode_tarif" name="kode_tarif" required>
                    </div>
                    <div class="form-group">
                        <label for="golongan">Golongan</label>
                        <input type="text" class="form-control" id="golongan" name="golongan" required>
                    </div>
                    <div class="form-group">
                        <label for="daya">Daya (kVA)</label>
                        <input type="number" class="form-control" id="daya" name="daya" required>
                    </div>
                    <div class="form-group">
                        <label for="tarif_perkwh">Tarif per kWh (Rp)</label>
                        <input type="number" class="form-control" id="tarif_perkwh" name="tarif_perkwh" required>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Tarif</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Update Tarif -->
<?php foreach ($tarif as $key => $value) : ?>
    <div class="modal fade" id="modalUpdateTarif<?= htmlspecialchars($value['id_tarif']) ?>" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel<?= htmlspecialchars($value['id_tarif']) ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateLabel<?= htmlspecialchars($value['id_tarif']) ?>">Update Tarif - <?= htmlspecialchars($value['kode_tarif']) ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Update Tarif -->
                    <form action="<?= site_url('TarifController/update/' . htmlspecialchars($value['id_tarif'])) ?>" method="post">
                        <div class="form-group">
                            <label for="kode_tarif">Kode Tarif</label>
                            <input type="text" class="form-control" id="kode_tarif" name="kode_tarif" value="<?= htmlspecialchars($value['kode_tarif']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="golongan">Golongan</label>
                            <input type="text" class="form-control" id="golongan" name="golongan" value="<?= htmlspecialchars($value['golongan']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="daya">Daya (kVA)</label>
                            <input type="number" class="form-control" id="daya" name="daya" value="<?= htmlspecialchars($value['daya']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tarif_perkwh">Tarif per kWh (Rp)</label>
                            <input type="number" class="form-control" id="tarif_perkwh" name="tarif_perkwh" value="<?= htmlspecialchars($value['tarif_perkwh']) ?>" required>
                        </div>
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<!-- Modal Hapus Tarif -->
<?php foreach ($tarif as $key => $value) : ?>
    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="modalHapusTarif<?= htmlspecialchars($value['id_tarif']) ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus tarif <?= htmlspecialchars($value['kode_tarif']) ?>?
                </div>
                <div class="modal-footer">
                    <!-- Tombol Batalkan -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <!-- Form untuk Menghapus Tarif -->
                    <form action="<?= site_url('TarifController/hapus/' . htmlspecialchars($value['id_tarif'])) ?>" method="post">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<!-- Modal Cetak Laporan -->
<div class="modal fade" id="CetakLaporanTarif" tabindex="-1" role="dialog" aria-labelledby="CetakLaporanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CetakLaporanLabel">Cetak Laporan Tarif Listrik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tabel yang akan dicetak -->
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Tarif</th>
                            <th>Golongan</th>
                            <th>Daya Listrik</th>
                            <th>Tarif Per KWH</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tarif as $key => $value) : ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($value['kode_tarif']) ?></td>
                                <td><?= htmlspecialchars($value['golongan']) ?></td>
                                <td class="text-center"><?= htmlspecialchars(format_daya($value['daya'])) ?></td>
                                <td><?= htmlspecialchars(nominal($value['tarif_perkwh'])) ?></td>
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
        var printContent = document.querySelector('#CetakLaporanTarif .modal-body').innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();  
    }
</script>