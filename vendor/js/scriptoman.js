// Membungkus semua kode dalam satu $(document).ready() untuk memastikan DOM sudah dimuat.
$(document).ready(function() {

    /**
     * =================================================================
     * Fungsionalitas untuk Modal Tambah Penggunaan
     * -----------------------------------------------------------------
     * Kode ini hanya akan berjalan jika elemen-elemen dari modal
     * '#ModalTambahPenggunaan' terdeteksi di halaman.
     * =================================================================
     */
    const modalTambahPenggunaan = $('#ModalTambahPenggunaan');

    if (modalTambahPenggunaan.length > 0) {

        // Menggunakan event 'shown.bs.modal' untuk inisialisasi plugin autocomplete.
        // Ini memastikan semua elemen di dalam modal sudah siap saat kode dijalankan.
        modalTambahPenggunaan.on('shown.bs.modal', function () {
            
            // Mencegah inisialisasi ganda jika modal dibuka beberapa kali.
            if (modalTambahPenggunaan.data('autocomplete-initialized')) {
                return;
            }
            modalTambahPenggunaan.data('autocomplete-initialized', true);

            // Definisikan semua elemen jQuery yang akan digunakan.
            const inputPelanggan = modalTambahPenggunaan.find('#nama_pelanggan');
            const inputIdPelanggan = modalTambahPenggunaan.find('#id_pelanggan');
            const inputIdTarif = modalTambahPenggunaan.find('#id_tarif');
            const inputMeterAwal = modalTambahPenggunaan.find('#meter_awal');
            const inputMeterAkhir = modalTambahPenggunaan.find('#meter_akhir');

            // Ambil URL yang diperlukan dari atribut data-*.
            const autocompleteUrl = inputPelanggan.data('autocomplete-url');
            const detailUrl = inputPelanggan.data('detail-url');
            
            let dayaPelanggan = 0;

            // Konfigurasi untuk plugin EasyAutocomplete.
            const options = {
                url: autocompleteUrl,
                getValue: item => `${item.id_pelanggan} - ${item.nama} - ${item.no_meter}`, // Arrow function
                list: {
                    match: { enabled: true },
                    onSelectItemEvent: function() {
                        const selectedItem = inputPelanggan.getSelectedItemData();
                        if (selectedItem) {
                            inputIdPelanggan.val(selectedItem.id_pelanggan).trigger('change');
                            inputIdTarif.val(selectedItem.id_tarif);
                        }
                    }
                },
                template: {
                    type: "custom",
                    method: (value, item) => `${item.id_pelanggan} - ${item.nama} (${item.no_meter})` // Arrow function
                },
                adjustWidth: false
            };
            
            // Inisialisasi plugin.
            inputPelanggan.easyAutocomplete(options);

            // Fungsi untuk menghitung meter akhir.
            function hitungMeterAkhir() {
                const meterAwal = parseInt(inputMeterAwal.val(), 10) || 0;
                if (meterAwal > 0 && dayaPelanggan > 0) {
                    const meterAkhir = meterAwal + dayaPelanggan;
                    inputMeterAkhir.val(meterAkhir);
                }
            }

            // Event listener saat id_pelanggan berubah (setelah item dipilih).
            inputIdPelanggan.on('change', function() {
                const idPelanggan = $(this).val();
                if (idPelanggan) {
                    $.ajax({
                        url: `${detailUrl}${idPelanggan}`, // Template literal
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success' && response.data.daya) {
                                dayaPelanggan = parseInt(response.data.daya, 10);
                                hitungMeterAkhir();
                            } else {
                                dayaPelanggan = 0;
                            }
                        },
                        error: function() {
                            dayaPelanggan = 0;
                            console.error("AJAX Error: Gagal mengambil detail pelanggan.");
                        }
                    });
                }
            });

            // Event listener saat pengguna mengetik di input meter awal.
            inputMeterAwal.on('input keyup', hitungMeterAkhir);
        });

        // Event listener untuk mereset form saat modal ditutup.
        modalTambahPenggunaan.on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            // Reset flag inisialisasi agar bisa berjalan lagi jika modal dibuka kembali.
            $(this).data('autocomplete-initialized', false);
        });
    }


    /**
     * =================================================================
     * Tempat untuk Fungsionalitas Halaman Lain
     * =================================================================
     * if ($('#element_unik_halaman_lain').length > 0) {
     *     // ... kode javascript untuk halaman lain ...
     * }
     */

});