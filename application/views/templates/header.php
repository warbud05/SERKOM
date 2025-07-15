<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?></title>

    <link href="<?= base_url() ?>assets/fontawesome-free-6.6.0-web/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="<?= base_url() ?>assets/backend/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/backend/css/pembayaran_listrik.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/tables/datatable/datatables.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>assets/easy-autocomplete/easy-autocomplete.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/easy-autocomplete/easy-autocomplete.themes.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php

        $current_segment = $this->uri->segment(1) ?? 'admin'; 
        $user_role = $this->session->userdata('session_akses');

        $sidebar_title = 'Kamu Siapaa!'; 
        if ($user_role === 'Agen') {
            $sidebar_title = 'Agen PLN <i class="fa-solid fa-circle-check"></i>';
        } elseif ($user_role === 'Petugas') {
            $sidebar_title = 'Petugas PLN';
        }

        $data_utama_segments = ['tarif', 'pelanggan', 'petag'];
        $pembayaran_segments = ['pembayaran', 'rpembayaran', 'tunggakan'];

        $is_data_utama_active = in_array($current_segment, $data_utama_segments);
        $is_pembayaran_active = in_array($current_segment, $pembayaran_segments);

        ?>

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('admin') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa-solid fa-bolt-lightning"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?= $sidebar_title ?></div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item <?= $current_segment === 'admin' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('admin') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Antar Muka
            </div>

            <li class="nav-item <?= $is_data_utama_active ? 'active' : '' ?>">
                <a class="nav-link <?= $is_data_utama_active ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseDataUtama" aria-expanded="<?= $is_data_utama_active ? 'true' : 'false' ?>" aria-controls="collapseDataUtama">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Data Utama</span>
                </a>
                <div id="collapseDataUtama" class="collapse <?= $is_data_utama_active ? 'show' : '' ?>" aria-labelledby="headingDataUtama" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Komponen Data Utama:</h6>
<a class="collapse-item <?= $current_segment === 'tarif' ? 'active' : '' ?>" href="<?= site_url('tarif') ?>">Harga Tarif Listrik</a>
<a class="collapse-item <?= $current_segment === 'pelanggan' ? 'active' : '' ?>" href="<?= site_url('pelanggan') ?>">Pelanggan Terdaftar</a>
<?php if ($user_role === 'Petugas'): ?> <!-- SUDAH BENAR -->
    <a class="collapse-item <?= $current_segment === 'petag' ? 'active' : '' ?>" href="<?= site_url('petag') ?>">Kelola Petugas/Agen</a>
<?php endif; ?>
                    </div>
                </div>
            </li>

            <li class="nav-item <?= $current_segment === 'penggunaan' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('penggunaan') ?>">
                    <i class="fa-solid fa-user-clock"></i>
                    <span>Penggunaan Listrik</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Pembayaran Listrik
            </div>

            <li class="nav-item <?= $current_segment === 'tagihan' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('tagihan') ?>">
                    <i class="fa-solid fa-money-bills"></i>
                    <span>Tagihan Listrik</span>
                </a>
            </li>

            <li class="nav-item <?= $is_pembayaran_active ? 'active' : '' ?>">
                <a class="nav-link <?= $is_pembayaran_active ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapsePembayaran" aria-expanded="<?= $is_pembayaran_active ? 'true' : 'false' ?>" aria-controls="collapsePembayaran">
                    <i class="fa-solid fa-wallet"></i>
                    <span>Bayar Tagihan Listrik</span>
                </a>
                <div id="collapsePembayaran" class="collapse <?= $is_pembayaran_active ? 'show' : '' ?>" aria-labelledby="headingPembayaran" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Komponen Pembayaran:</h6>
                        <a class="collapse-item <?= $current_segment === 'pembayaran' ? 'active' : '' ?>" href="<?= site_url('pembayaran') ?>">Pembayaran Tagihan</a>
                        <a class="collapse-item <?= $current_segment === 'rpembayaran' ? 'active' : '' ?>" href="<?= site_url('rpembayaran') ?>">Riwayat Pembayaran</a>
                        <a class="collapse-item <?= $current_segment === 'tunggakan' ? 'active' : '' ?>" href="<?= site_url('tunggakan') ?>">Pelanggan Menunggak</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

                        <!-- Divider -->
            
            <!-- HANYA TAMPIL UNTUK AGEN -->
            <?php if ($user_role === 'Agen'): ?>
            <div class="sidebar-heading">
                Laporan
            </div>
            
            <li class="nav-item <?= $current_segment === 'pendapatan' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= site_url('pendapatan') ?>">
                    <i class="fas fa-fw fa-chart-line"></i>
                    <span>Pendapatan Saya</span>
                </a>
            </li>
                        <hr class="sidebar-divider d-none d-md-block">
            <?php endif; ?>

            <!-- Divider -->


            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <h5>Pembayaran Listrik Pascabayar</h5>
                        </div>
                    </form>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                        </li>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    Akses Sebagai <?= isset($cek_login['akses']) ? htmlspecialchars($cek_login['akses']) : '' ?> 
                                    | <?= isset($cek_login['nama_petugas']) ? htmlspecialchars($cek_login['nama_petugas']) : '' ?>  
                                </span>
                                <img class="img-profile rounded-circle" src="<?= isset($cek_login['foto_profil']) ? htmlspecialchars($cek_login['foto_profil']) : '' ?>">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>


                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-primary" href="<?=site_url('logout')?>">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>