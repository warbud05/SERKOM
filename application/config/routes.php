<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'AuthController'; 


$route['tunggakan'] = 'TagihanController/tunggakan'; 
$route['rpembayaran'] = 'PembayaranController/riwayat_pembayaran'; 
$route['pembayaran'] = 'PembayaranController/index'; 
$route['tagihan'] = 'TagihanController/index'; 

$route['penggunaan'] = 'PenggunaanController/index'; 
$route['pelanggan/ajaxIndex'] = 'PelangganController/AjaxIndex';

$route['pendapatan'] = 'AdminController/laporan_pendapatan'; // Laporan khusus Agen

$route['petag'] = 'PetagController/index'; 
$route['pelanggan'] = 'PelangganController/index'; 
$route['pelanggan/detail/(:any)'] = 'PelangganController/get_detail_json/$1';
$route['tarif'] = 'TarifController/index'; 


$route['admin'] = 'AdminController/index';
$route['login'] = 'AuthController/index'; // Arahkan ke method index
// atau cara yang lebih singkat
// $route['login'] = 'AuthController'; // Ini juga akan memanggil index()
$route['logout'] = 'AuthController/logout';


$route['404_override'] = ''; 
$route['translate_uri_dashes'] = FALSE; 
