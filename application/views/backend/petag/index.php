<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Petugas dan Agen </h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#CetakDaftarPetugasAtauAgen">
            <i class="fas fa-download fa-sm text-white-50"></i> Cetak Petugas dan Agen
        </a>
    </div>

    <!-- Pesan alert  -->
    <?php if ($this->session->flashdata('alert')): ?>
        <?php 
        $alertType = '';
        $alertMessage = $this->session->flashdata('alert');

        switch ($alertMessage) {
            case 'tambah_petugas_berhasil':
            $alertType = 'success';
            $alertMessage = 'Petugas berhasil ditambahkan!';
            break;
            case 'hapus_petugas_berhasil':
            $alertType = 'success';
            $alertMessage = 'Petugas berhasil Dihapus!';
            break;
            case 'update_petugas_berhasil':
            $alertType = 'success';
            $alertMessage = 'Data Petugas berhasil Diupdate!';
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalTambahPetugas">
                    <i class="fas fa-plus-circle"></i> Tambah Petugas atau Agen
                </button>
            </div>
        <?php endif; ?>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered rohman-syah" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th> <!-- Kolom untuk nomor urut -->
                            <th style="display: none;">ID Petugas</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
                            <th>Biaya Admin</th>
                            <th>Akses</th>

                            <?php if ($this->session->userdata('session_akses') == 'Petugas') : ?>
                            <th class="text-center"><i class="fas fa-cogs"></i></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; // Inisialisasi nomor urut ?>
                        <?php foreach ($petag as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td> <!-- Menampilkan nomor urut -->
                                <td style="display: none;"><?= htmlspecialchars($p['id_petugas']) ?></td>
                                <td><?= htmlspecialchars($p['nama_petugas']) ?></td>
                                <td><?= htmlspecialchars($p['alamat']) ?></td>
                                <td><?= htmlspecialchars($p['no_telepon']) ?></td>
                                <td><?= htmlspecialchars(nominal($p['biaya_admin'])) ?></td>
                                <td><?= htmlspecialchars($p['akses']) ?></td>
                                
                                    <?php if ($this->session->userdata('session_akses') == 'Petugas') : ?>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalUpdatePetag<?= htmlspecialchars($p['id_petugas']) ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapusPetag<?= htmlspecialchars($p['id_petugas']) ?>">
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



<!-- Modal Tambah Petugas -->
<div class="modal fade" id="ModalTambahPetugas" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPetugasLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTambahPetugasLabel">Tambah Petugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('petagcontroller/tambah') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- Nama Petugas -->
                    <div class="form-group">
                        <label for="nama_petugas">Nama Petugas</label>
                        <input type="text" class="form-control" id="nama_petugas" name="nama_petugas" required>
                    </div>

                    <!-- Alamat -->
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>

                    <!-- No Telepon -->
                    <div class="form-group">
                        <label for="no_telepon">No Telepon</label>
                        <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="form-group">
                        <label for="jk">Jenis Kelamin</label>
                        <select class="form-control" id="jk" name="jk" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <!-- Username -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <!-- Biaya Admin -->
                    <div class="form-group">
                        <label for="biaya_admin">Biaya Admin</label>
                        <input type="number" class="form-control" id="biaya_admin" name="biaya_admin" step="0.01" required>
                    </div>

                    <!-- Akses -->
                    <div class="form-group">
                        <label for="akses">Akses</label>
                        <select class="form-control" id="akses" name="akses" required>
                            <option value="">Pilih Akses</option>
                            <option value="Petugas">Petugas</option>
                            <option value="Agen">Agen</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Update Petugas -->
<?php foreach ($petag as $p): ?>
<div class="modal fade" id="modalUpdatePetag<?= htmlspecialchars($p['id_petugas']) ?>" tabindex="-1" role="dialog" aria-labelledby="modalUpdatePetagLabel<?= htmlspecialchars($p['id_petugas']) ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUpdatePetagLabel<?= htmlspecialchars($p['id_petugas']) ?>">Update Petugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('PetagController/update/' . htmlspecialchars($p['id_petugas'])) ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- Nama Petugas -->
                    <div class="form-group">
                        <label for="nama_petugas_<?= htmlspecialchars($p['id_petugas']) ?>">Nama Petugas</label>
                        <input type="text" class="form-control" id="nama_petugas_<?= htmlspecialchars($p['id_petugas']) ?>" name="nama_petugas" value="<?= htmlspecialchars($p['nama_petugas']) ?>" required>
                    </div>

                    <!-- Alamat -->
                    <div class="form-group">
                        <label for="alamat_<?= htmlspecialchars($p['id_petugas']) ?>">Alamat</label>
                        <textarea class="form-control" id="alamat_<?= htmlspecialchars($p['id_petugas']) ?>" name="alamat" rows="3" required><?= htmlspecialchars($p['alamat']) ?></textarea>
                    </div>

                    <!-- No Telepon -->
                    <div class="form-group">
                        <label for="no_telepon_<?= htmlspecialchars($p['id_petugas']) ?>">No Telepon</label>
                        <input type="text" class="form-control" id="no_telepon_<?= htmlspecialchars($p['id_petugas']) ?>" name="no_telepon" value="<?= htmlspecialchars($p['no_telepon']) ?>" required>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="form-group">
                        <label for="jk_<?= htmlspecialchars($p['id_petugas']) ?>">Jenis Kelamin</label>
                        <select class="form-control" id="jk_<?= htmlspecialchars($p['id_petugas']) ?>" name="jk" required>
                            <option value="" disabled>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" <?= ($p['jk'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= ($p['jk'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>

                    <!-- Username -->
                    <div class="form-group">
                        <label for="username_<?= htmlspecialchars($p['id_petugas']) ?>">Username</label>
                        <input type="text" class="form-control" id="username_<?= htmlspecialchars($p['id_petugas']) ?>" name="username" value="<?= htmlspecialchars($p['username']) ?>" required>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password_<?= htmlspecialchars($p['id_petugas']) ?>">Password</label>
                        <input type="password" class="form-control" id="password_<?= htmlspecialchars($p['id_petugas']) ?>" name="password" placeholder="Biarkan kosong jika tidak diubah">
                    </div>

                    <!-- Biaya Admin -->
                    <div class="form-group">
                        <label for="biaya_admin_<?= htmlspecialchars($p['id_petugas']) ?>">Biaya Admin</label>
                        <input type="number" class="form-control" id="biaya_admin_<?= htmlspecialchars($p['id_petugas']) ?>" name="biaya_admin" value="<?= htmlspecialchars($p['biaya_admin']) ?>" step="0.01" required>
                    </div>

                    <!-- Akses -->
                    <div class="form-group">
                        <label for="akses_<?= htmlspecialchars($p['id_petugas']) ?>">Akses</label>
                        <select class="form-control" id="akses_<?= htmlspecialchars($p['id_petugas']) ?>" name="akses" required>
                            <option value="" disabled>Pilih Akses</option>
                            <option value="Petugas" <?= ($p['akses'] == 'Petugas') ? 'selected' : '' ?>>Petugas</option>
                            <option value="Agen" <?= ($p['akses'] == 'Agen') ? 'selected' : '' ?>>Agen</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>


<!-- Modal Hapus Petugas atau agen -->
<?php foreach ($petag as $p): ?>
<div class="modal fade" id="modalHapusPetag<?= htmlspecialchars($p['id_petugas']) ?>" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHapusLabel">Konfirmasi Penghapusan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus <?= htmlspecialchars($p['nama_petugas']) ?>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <form action="<?= site_url('PetagController/hapus/' . htmlspecialchars($p['id_petugas'])) ?>" method="post">
          <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>


<!-- Modal Cetak Petugas dan Agen -->
<div class="modal fade" id="CetakDaftarPetugasAtauAgen" tabindex="-1" role="dialog" aria-labelledby="CetakDaftarPetugasAtauAgenLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="CetakDaftarPetugasAtauAgenLabel">Cetak Daftar Petugas dan Agen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th> <!-- Kolom untuk nomor urut -->
                            <th style="display: none;">ID Petugas</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
                            <th>Biaya Admin</th>
                            <th>Akses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; // Inisialisasi nomor urut ?>
                        <?php foreach ($petag as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td> <!-- Menampilkan nomor urut -->
                                <td style="display: none;"><?= htmlspecialchars($p['id_petugas']) ?></td>
                                <td><?= htmlspecialchars($p['nama_petugas']) ?></td>
                                <td><?= htmlspecialchars($p['alamat']) ?></td>
                                <td><?= htmlspecialchars($p['no_telepon']) ?></td>
                                <td><?= htmlspecialchars(nominal($p['biaya_admin'])) ?></td>
                                <td><?= htmlspecialchars($p['akses']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="printTable()">Cetak</button>
            </div>
        </div>
    </div>
</div>

<script>
    function printTable() {
        var printWindow = window.open('', '', 'height=600,width=800');
        var tableHTML = document.querySelector('#CetakDaftarPetugasAtauAgen .modal-body').innerHTML;
        printWindow.document.write('<html><head><title>Cetak Petugas dan Agen</title>');
        printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');
        printWindow.document.write('</head><body >');
        printWindow.document.write('<h4>Cetak Daftar Petugas dan Agen</h4>');
        printWindow.document.write(tableHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
    }
</script>
