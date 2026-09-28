<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Akun Administrator SiMonDa BPS Kota Bukittinggi
    |--------------------------------------------------------------------------
    |
    | Anda dapat mengubah username dan password login Admin di file `.env`:
    | ADMIN_USERNAME=username_anda
    | ADMIN_PASSWORD=password_anda
    |
    */
    'admin_username' => env('ADMIN_USERNAME', 'admin_bps'),
    'admin_password' => env('ADMIN_PASSWORD', 'bpsbukittinggi'),
    'admin_name'     => env('ADMIN_NAME', 'Admin BPS Bukittinggi'),
];
