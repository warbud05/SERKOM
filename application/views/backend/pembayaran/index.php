<!-- Display flash messages -->
<?php if ($this->session->flashdata('success') || $this->session->flashdata('error')): ?>
    <div class="container-fluid">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Pembayaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered rohman-syah" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Bayar</th>
                            <th>Nama Pelanggan</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th style="display: none;">Jumlah Meter</th>
                            <th style="display: none;">Tarif PerkWh</th>
                            <th>Tagihan Listrik</th>
                            <th style="display: none;">Status</th>
                            <th style="display: none;">ID Petugas</th>
                            <th style="display: none;">ID Penggunaan</th>
                            <th class="text-center"><i class="fas fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($pembayaran as $item): ?>
                        
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $item->id_tagihan; ?></td>
                                <td><?php echo $item->nama_pelanggan; ?></td>
                                <td><?php echo nama_bulan($item->bulan); ?></td>
                                <td><?php echo $item->tahun; ?></td>
                                <td style="display: none;"><?php echo $item->jumlah_meter; ?></td>
                                <td style="display: none;"><?php echo $item->tarif_perkwh; ?></td>
                                <td><?php echo nominal($item->jumlah_bayar); ?></td>
                                <td style="display: none;"><?php echo $item->status; ?></td>
                                <td style="display: none;"><?php echo $item->id_petugas; ?></td> <!-- Ini ID pembuat tagihan, biarkan saja -->
                                <td style="display: none;"><?php echo $item->id_penggunaan; ?></td>
                                <td class="text-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPembayaran<?php echo $item->id_tagihan; ?>">
                                        Bayar
                                    </button>
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


<!-- Modal Pembayaran -->
<?php foreach ($pembayaran as $item): ?>
<div class="modal fade" id="modalPembayaran<?php echo $item->id_tagihan; ?>" tabindex="-1" role="dialog" aria-labelledby="modalPembayaranLabel<?php echo $item->id_tagihan; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPembayaranLabel<?php echo $item->id_tagihan; ?>">Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                <form action="<?php echo site_url('PembayaranController/bayar'); ?>" method="POST">
                    <input type="hidden" name="id_tagihan" value="<?php echo $item->id_tagihan; ?>">
        <input type="hidden" name="id_penggunaan" value="<?php echo $item->id_penggunaan; ?>">
        <input type="hidden" name="id_pelanggan" value="<?php echo $item->id_pelanggan; ?>">
        <input type="hidden" name="no_meter" value="<?php echo $item->no_meter; ?>">
        
        <!-- === TAMBAHKAN BARIS INI === -->
        <input type="hidden" name="nama_pelanggan" value="<?php echo $item->nama_pelanggan; ?>"> 
        <!-- ============================== -->

        <input type="hidden" name="meter_awal" value="<?php echo $item->meter_awal; ?>">
        <input type="hidden" name="meter_akhir" value="<?php echo $item->meter_akhir; ?>">
        <input type="hidden" name="kode_tarif" value="<?php echo $item->kode_tarif; ?>">
        <input type="hidden" name="bulan" value="<?php echo $item->bulan; ?>">
        <input type="hidden" name="tahun" value="<?php echo $item->tahun; ?>">
        <input type="hidden" name="jumlah_meter" value="<?php echo $item->jumlah_meter; ?>">
        <input type="hidden" name="tarif_perkwh" value="<?php echo nominal($item->tarif_perkwh); ?>">
        <input type="hidden" name="tagihan_listrik" value="<?php echo nominal($item->jumlah_bayar); ?>">
        <input type="hidden" name="denda" value="<?php echo nominal($item->denda ?? 0); ?>">

        <!-- Informasi Pembayaran -->
        <p><strong>Nama Pelanggan:</strong> <?php echo $item->nama_pelanggan; ?></p>
                    <p><strong>Bulan/Tahun:</strong> <?php echo nama_bulan($item->bulan) . ' ' . $item->tahun; ?></p>
                    <hr>

                    <div class="row">
                        <div class="col-6"><p>Tagihan Listrik</p></div>
                        <div class="col-6 text-right"><p><?php echo nominal($item->jumlah_bayar); ?></p></div>
                    </div>

                    <?php if (isset($item->denda) && $item->denda > 0): ?>
                    <div class="row">
                        <div class="col-6"><p>Denda</p></div>
                        <div class="col-6 text-right"><p><?php echo nominal($item->denda); ?></p></div>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-6"><p>Biaya Admin</p></div>
                        <div class="col-6 text-right"><p><?php echo nominal($cek_login['biaya_admin']); ?></p></div>
                    </div>
                    
                    <hr style="border-top: 1px dashed #ccc;">
                    
                    <div class="row font-weight-bold">
                        <div class="col-6"><p>Total Bayar</p></div>
                        <?php
                        // Hitung ulang total bayar berdasarkan biaya admin agen yang login
                        $total_bayar_aktual = $item->jumlah_bayar + $cek_login['biaya_admin'];
                        if (isset($item->denda) && $item->denda > 0) {
                            $total_bayar_aktual += $item->denda;
                        }
                        ?>
                        <div class="col-6 text-right"><p><?php echo nominal($total_bayar_aktual); ?></p></div>
                        <input type="hidden" name="total_bayar" value="<?php echo nominal($total_bayar_aktual); ?>">
                    </div>

                    <hr>

                    <div class="form-group mt-3">
                        <label for="jumlah_uang_<?php echo $item->id_tagihan; ?>">Jumlah Uang</label>
                        <input type="text" class="form-control form-control-lg jumlah-uang" id="jumlah_uang_<?php echo $item->id_tagihan; ?>" placeholder="Masukan nominal uang" name="jumlah_uang" required autocomplete="off">
                    </div>

                    <button type="submit" class="btn btn-success btn-block mt-3">Bayar Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>  
<?php endforeach; ?>

<script>
    function formatRupiah(angka, prefix) {
        let number_string = angka.replace(/[^,\d]/g, '').toString();
        let split = number_string.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        
        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix === undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }

    function formatNumber(angka) {
        return angka.replace(/[^0-9]/g, '');
    }

    document.addEventListener('keyup', function (e) {
        if (e.target.classList.contains('jumlah-uang')) {
            e.target.value = formatRupiah(e.target.value, '');
        }
    });

    // Menangani form submit
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function () {
            // Menghapus format Rupiah sebelum mengirim data
            const jumlahUangField = form.querySelector('input[name="jumlah_uang"]');
            jumlahUangField.value = formatNumber(jumlahUangField.value);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah ada flashdata 'open_receipt' dari PHP
        <?php if ($this->session->flashdata('open_receipt')): ?>
            // Ambil ID tagihan dari flashdata
            var idTagihan = '<?php echo $this->session->flashdata('open_receipt'); ?>';
            
            // Buat URL untuk bukti bayar
            var receiptUrl = '<?= site_url('PembayaranController/bukti_bayar/') ?>' + idTagihan;
            
            // Buka URL di tab baru
            window.open(receiptUrl, '_blank');
        <?php endif; ?>
    });
</script>