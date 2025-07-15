<!-- Helper Nominal -->

<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('nominal')) {
    function nominal($number) {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}

if (!function_exists('terbilang')) {
    function terbilang($s) {
        $bilangan = $s;
        $kalimat = "";
        $angka = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
        $kata = array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
        $tingkat = array('','Ribu','Juta','Milyar','Triliun');
        $panjang_bilangan = strlen($bilangan);

        if ($panjang_bilangan > 15) {
            $kalimat = "Diluar Batas";
        } else {
            for ($i = 1; $i <= $panjang_bilangan; $i++) {
                $angka[$i] = substr($bilangan, -$i, 1);
            }

            $i = 1;
            $j = 0;

            while ($i <= $panjang_bilangan) {
                $subkalimat = "";
                $kata1 = "";
                $kata2 = "";
                $kata3 = "";

                if ($angka[$i+2] != "0") {
                    if ($angka[$i+2] == "1") {
                        $kata1 = "Seratus";
                    } else {
                        $kata1 = $kata[$angka[$i+2]] . " Ratus";
                    }
                }

                if ($angka[$i+1] != "0") {
                    if ($angka[$i+1] == "1") {
                        if ($angka[$i] == "0") {
                            $kata2 = "Sepuluh";
                        } elseif ($angka[$i] == "1") {
                            $kata2 = "Sebelas";
                        } else {
                            $kata2 = $kata[$angka[$i]] . " Belas";
                        }
                    } else {
                        $kata2 = $kata[$angka[$i+1]] . " Puluh";
                    }
                }

                if ($angka[$i] != "0") {
                    if ($angka[$i+1] != "1") {
                        $kata3 = $kata[$angka[$i]];
                    }
                }

                if (($angka[$i] != "0") || ($angka[$i+1] != "0") || ($angka[$i+2] != "0")) {
                    $subkalimat = $kata1 . " " . $kata2 . " " . $kata3 . " " . $tingkat[$j] . " ";
                }

                $kalimat = $subkalimat . $kalimat;
                $i = $i + 3;
                $j = $j + 1;
            }

            if (($angka[5] == "0") && ($angka[6] == "0")) {
                $kalimat = str_replace("Satu Ribu", "Seribu", $kalimat);
            }
        }

        return trim($kalimat);
    }
}


// Format Daya
if (!function_exists('format_daya')) {
    function format_daya($daya) {
        return $daya . ' VA';
    }
}

// generator no_meter 
if (!function_exists('generateNoMeter')) {
    function generateNoMeter() {
        // Mengambil tanggal sekarang
        $datePart = date('ymd'); // Tanggal dalam format YYMMDD

        // Menghasilkan 6 digit angka acak
        $randomPart = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Menggabungkan tanggal dan angka acak
        return $datePart . $randomPart;
    }
}

// generator id_pelanggan
if (!function_exists('generate_id_pelanggan')) {
    function generate_id_pelanggan() {
        // Menghasilkan 5 digit angka acak dari 10000 hingga 99999
        $randomPart = rand(10000, 99999);

        // Menggabungkan "PLG-" dengan angka acak
        return 'PLG-' . $randomPart;
    }
}

// nama login
if (!function_exists('get_nama_login')) {
    function get_nama_login($session) {
        $nama_login = "Kamu Siapaa!";
        if ($session->has_userdata('session_akses')) {
            if ($session->userdata('session_akses') == 'Agen') {
                $nama_login = "Agen Pascabayar"; 
            } elseif ($session->userdata('session_akses') == 'Petugas') {
                $nama_login = "Petugas PLN";
            }
        }
        return $nama_login;
    }
}

// 
function foto_profil_url($foto_profil) {
    $CI = get_instance();
    
    if (empty($foto_profil)) {
        return $CI->config->base_url('assets/images/foto_profil/foto-default.png');
    } else {
        return $CI->config->base_url('assets/images/foto_profil/'.$foto_profil);
    }
}


// 
if ( ! function_exists('nama_bulan'))
{
    /**
     * Mengembalikan nama bulan berdasarkan nomor bulan.
     *
     * @param int $bulan Nomor bulan (1-12).
     * @return string Nama bulan atau 'Invalid month' jika nomor bulan tidak valid.
     */
    function nama_bulan($bulan)
    {
        $bulan_arr = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );

        return isset($bulan_arr[$bulan]) ? $bulan_arr[$bulan] : 'Invalid month';
    }
}

?>

