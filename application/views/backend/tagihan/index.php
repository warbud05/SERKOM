<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Tagihan Listrik</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#ModalCetakTagihan">
            <i class="fas fa-download fa-sm text-white-50"></i> Cetak Tagihan
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Data Table -->
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List Tagihan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered rohman-syah" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th> <!-- Menambahkan kolom nomor urut -->
                                    <th>Kode Bayar</th>
                                    <th>ID Pelanggan</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Jumlah Meter</th>
                                    <th style="display: none;">Tarif per kWh</th>
                                    <th>Biaya Listrik</th>
                                    <th>Status</th>
                                    <th style="display: none;">ID Petugas</th>
                                    <th style="display: none;">ID Penggunaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($tagihan as $item): ?>
    <tr>
                                        <td><?php echo $no++; ?></td> <!-- Menampilkan nomor urut -->
                                        <td><?php echo $item['id_tagihan']; ?></td>
                                        <td><?php echo $item['id_pelanggan']; ?></td>
                                        <td><?php echo nama_bulan($item['bulan']); ?></td>
                                        <td><?php echo $item['tahun']; ?></td>
                                        <td><?php echo $item['jumlah_meter']; ?></td>
                                        <td style="display: none;"><?php echo $item['tarif_perkwh']; ?></td>
                                        <td><?php echo nominal($item['jumlah_bayar']); ?></td>
                                        <td><?php echo $item['status']; ?></td>
                                        <td style="display: none;"><?php echo $item['id_petugas']; ?></td>
                                        <td style="display: none;"><?php echo $item['id_penggunaan']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>


<!-- Modal Cetak Tagihan -->
<div class="modal fade" id="ModalCetakTagihan" tabindex="-1" role="dialog" aria-labelledby="ModalCetakTagihanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCetakTagihanLabel">Cetak Tagihan Listrik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTablePrint" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Bayar</th>
                                <th>ID Pelanggan</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Jumlah Meter</th>
                                <th style="display: none;">Tarif per kWh</th>
                                <th>Biaya Listrik</th>
                                <th>Status</th>
                                <th style="display: none;">ID Petugas</th>
                                <th style="display: none;">ID Penggunaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($tagihan as $item): ?>
                                <?php if ($this->session->userdata('session_akses') == 'Agen' && $item['id_petugas'] != 
                $this->session->userdata('session_id')) {continue;}?>  
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $item['id_tagihan']; ?></td>
                                    <td><?php echo $item['id_pelanggan']; ?></td>
                                    <td><?php echo nama_bulan($item['bulan']); ?></td>
                                    <td><?php echo $item['tahun']; ?></td>
                                    <td><?php echo $item['jumlah_meter']; ?></td>
                                    <td style="display: none;"><?php echo $item['tarif_perkwh']; ?></td>
                                    <td><?php echo nominal($item['jumlah_bayar']); ?></td>
                                    <td><?php echo $item['status']; ?></td>
                                    <td style="display: none;"><?php echo $item['id_petugas']; ?></td>
                                    <td style="display: none;"><?php echo $item['id_penggunaan']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printModal()">Print</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Print Modal -->
<script>
function printModal() {
    var printWindow = window.open('', '', 'height=600,width=800');
    var content = document.getElementById('dataTablePrint').outerHTML;
    var css = `
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            @media print {
                body {
                    font-family: Arial, sans-serif;
                }
            }
        </style>
    `;
    printWindow.document.write('<html><head><title>Cetak Tagihan</title>' + css + '</head><body>');
    printWindow.document.write('<h1>Cetak Tagihan Listrik</h1>');
    printWindow.document.write(content);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
</script>