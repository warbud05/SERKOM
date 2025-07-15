<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Pelanggan </h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#CetakDaftarPelanggan">
            <i class="fas fa-download fa-sm text-white-50"></i> Cetak Pelanggan
        </a>
    </div>

    <!-- Alert Messages -->
    <?php if (!empty($alert)) : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?php
                switch ($alert) {
                    case 'tambah_sukses':
                        echo 'Pelanggan berhasil ditambahkan.';
                        break;
                    case 'update_sukses':
                        echo 'Pelanggan berhasil diperbarui.';
                        break;
                    case 'hapus_sukses':
                        echo 'Pelanggan berhasil dihapus.';
                        break;
                    case 'belum_login':
                        echo 'Anda harus login terlebih dahulu.';
                        break;
                    default:
                        echo 'Terjadi kesalahan.';
                        break;
                }
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <?php if ($this->session->userdata('session_akses') == 'Petugas') : ?>
            <div class="card-header py-3">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalTambahPelanggan">
                    <i class="fas fa-plus-circle"></i> Tambah Pelanggan
                </button>
            </div>
        <?php endif; ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered rohman-syah" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th> <!-- Kolom untuk nomor urut -->
                            <th>ID Pel.</th>
                            <th>No Meter</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Tenggang</th>
                            <th class="text-nowrap">K. Tarif</th>
                            <?php if ($this->session->userdata('session_akses') == 'Petugas') : ?>
                            <th class="text-center"><i class="fas fa-cogs"></i></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; // Inisialisasi nomor urut ?>
                        <?php foreach ($pelanggan as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td> <!-- Menampilkan nomor urut -->
                                <td class="text-nowrap"><?= htmlspecialchars($p['id_pelanggan']) ?></td>
                                <td><?= htmlspecialchars($p['no_meter']) ?></td>
                                <td><?= htmlspecialchars($p['nama']) ?></td>
                                <td><?= htmlspecialchars($p['alamat']) ?></td>
                                <td><?= htmlspecialchars($p['tenggang']) ?></td>
                                <td><?= htmlspecialchars($p['kode_tarif']) ?></td>
                                
                                    <?php if ($this->session->userdata('session_akses') == 'Petugas') : ?>
                                    <td class="text-center text-nowrap">
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalUpdatePelanggan<?= htmlspecialchars($p['id_pelanggan']) ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapusPelanggan<?= htmlspecialchars($p['id_pelanggan']) ?>">
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

<!-- Modal Tambah Pelanggan -->
<div class="modal fade" id="ModalTambahPelanggan" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('PelangganController/tambah') ?>" method="post">
                    <div class="form-group">
                        <label for="id_pelanggan">ID Pelangan</label>
                        <input type="text" class="form-control" id="id_pelanggan" name="id_pelanggan" value="<?= generate_id_pelanggan() ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="no_meter">No Meter</label>
                        <input type="text" class="form-control" id="no_meter" name="no_meter" value="<?= generateNoMeter() ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="form-group">
                        <label for="tenggang">Tenggang (Hari Ini)</label>
                        <input type="text" class="form-control" id="tenggang" name="tenggang" value="<?= date('d') ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="id_tarif">Tarif ID</label>
                        <select class="form-control" id="id_tarif" name="id_tarif" required>
                            <?php foreach ($tarif as $t): ?>
                                <option value="<?= $t['id_tarif'] ?>"><?= $t['kode_tarif'] ?> - <?= $t['golongan'] ?> (<?= $t['tarif_perkwh'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Pelanggan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Update Pelanggan -->
<?php foreach ($pelanggan as $p): ?>
    <div class="modal fade" id="modalUpdatePelanggan<?= htmlspecialchars($p['id_pelanggan']) ?>" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel<?= htmlspecialchars($p['id_pelanggan']) ?>" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalUpdateLabel<?= htmlspecialchars($p['id_pelanggan']) ?>">Update Pelanggan - <?= htmlspecialchars($p['id_pelanggan']) ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <form action="<?= site_url('PelangganController/perbarui/' . htmlspecialchars($p['id_pelanggan'])) ?>" method="post">
          <div class="form-group">
            <label for="no_meter">No Meter</label>
            <input type="text" class="form-control" id="no_meter" name="no_meter" value="<?= htmlspecialchars($p['no_meter']) ?>" required>
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($p['nama']) ?>" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="<?= htmlspecialchars($p['alamat']) ?>" required>
        </div>
        <div class="form-group">
            <label for="tenggang">Tenggang</label>
            <input type="text" class="form-control" id="tenggang" name="tenggang" value="<?= htmlspecialchars($p['tenggang']) ?>" required>
        </div>
        <div class="form-group">
            <label for="id_tarif">Tarif ID</label>
            <select class="form-control" id="id_tarif" name="id_tarif" required>
                <option value="">Pilih Tarif</option>
                <?php foreach ($tarif as $t): ?>
                    <option value="<?= htmlspecialchars($t['id_tarif']) ?>"
                        <?= $t['id_tarif'] == htmlspecialchars($p['id_tarif']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($t['kode_tarif']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
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



<!-- Modal Hapus Pelanggan -->
<?php foreach ($pelanggan as $p): ?>
<div class="modal fade" id="modalHapusPelanggan<?= htmlspecialchars($p['id_pelanggan']) ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Penghapusan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus pelanggan dengan ID <?= htmlspecialchars($p['id_pelanggan']) ?>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <form action="<?= site_url('PelangganController/hapus/' . htmlspecialchars($p['id_pelanggan'])) ?>" method="post">
          <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>


<!-- Modal Cetak Daftar Pelanggan -->
<div class="modal fade" id="CetakDaftarPelanggan" tabindex="-1" role="dialog" aria-labelledby="modalCetakLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCetakLabel">Cetak Daftar Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="printdaftarpelanggan">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Pelanggan</th>
                                <th>No Meter</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Tenggang</th>
                                <th>Tarif ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($pelanggan as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($p['id_pelanggan']) ?></td>
                                    <td><?= htmlspecialchars($p['no_meter']) ?></td>
                                    <td><?= htmlspecialchars($p['nama']) ?></td>
                                    <td><?= htmlspecialchars($p['alamat']) ?></td>
                                    <td><?= htmlspecialchars($p['tenggang']) ?></td>
                                    <td><?= htmlspecialchars($p['kode_tarif']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="printDaftarPelanggan('printdaftarpelanggan')">Cetak</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk mencetak konten -->
<script>
    function printDaftarPelanggan(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;

        // Buat jendela baru untuk cetak
        var newWindow = window.open('', '', 'height=600,width=800');
        
        // Buat konten HTML untuk jendela baru
        newWindow.document.write('<html><head><title>Print</title>');
        newWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');
        newWindow.document.write('</head><body >');
        newWindow.document.write(printContents);
        newWindow.document.write('</body></html>');

        // Selesai memuat konten
        newWindow.document.close();

        // Tunggu hingga jendela baru selesai memuat konten, lalu cetak
        newWindow.onload = function() {
            newWindow.focus();
            newWindow.print();
            newWindow.close();
        };
    }
</script>
