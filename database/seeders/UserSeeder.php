<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run database seeds for all agency accounts with numeric passwords.
     */
    public function run(): void
    {
        // 1. Akun 20 OPD Dinas (Sandi Angka: 137501 s.d 137520)
        // Pola: Kode BPS Bukittinggi (1375) + 2 digit Kode OPD (01 - 20)
        $opdList = config('sibingka.opd_list', []);
        $defaultOpdPages = ['isi-data-opd', 'monitoring-opd', 'tabel-opd', 'edit-tabel-opd'];

        foreach ($opdList as $code => $opd) {
            $padCode = str_pad($code, 2, '0', STR_PAD_LEFT);
            $numericPassword = '1375' . $padCode;

            User::updateOrCreate(
                [
                    'opd_code' => $padCode,
                    'role' => 'opd',
                ],
                [
                    'name' => 'Operator ' . $opd['short_name'],
                    'username' => $opd['default_username'],
                    'email' => $opd['email'],
                    'password' => Hash::make($numericPassword),
                    'dinas_name' => $opd['name'],
                    'allowed_pages' => $defaultOpdPages,
                    'is_active' => true,
                ]
            );
        }

        // 2. Akun 37 Instansi Vertikal (Sandi Angka: 137101 s.d 137137)
        // Pola: Prefix Angka (1371) + 2 digit Kode Instansi (01 - 37)
        $instansiList = config('sibingka.instansi_list', []);
        $defaultInstansiPages = ['isi-data-instansi', 'monitoring-instansi', 'tabel-opd', 'edit-tabel-opd'];

        foreach ($instansiList as $code => $inst) {
            $padCode = str_pad($code, 2, '0', STR_PAD_LEFT);
            $numericPassword = '1371' . $padCode;

            User::updateOrCreate(
                [
                    'opd_code' => $padCode,
                    'role' => 'instansi',
                ],
                [
                    'name' => 'Operator ' . $inst['short_name'],
                    'username' => $inst['default_username'],
                    'email' => $inst['email'],
                    'password' => Hash::make($numericPassword),
                    'dinas_name' => $inst['name'],
                    'allowed_pages' => $defaultInstansiPages,
                    'is_active' => true,
                ]
            );
        }

        // 3. Akun Wali Data Diskominfo (Sandi Angka: 137500)
        User::updateOrCreate(
            ['username' => 'walidata_kominfo'],
            [
                'name' => 'Wali Data Statistik Sektoral (Diskominfo)',
                'email' => 'diskominfo@bukittinggikota.go.id',
                'password' => Hash::make('137500'),
                'role' => 'walidata',
                'opd_code' => '00',
                'dinas_name' => 'Dinas Komunikasi dan Informatika',
                'allowed_pages' => ['monitoring-opd', 'monitoring-instansi', 'tabel-opd'],
                'is_active' => true,
            ]
        );

        // 4. Akun Operator BPS (Sandi Angka: 137590)
        User::updateOrCreate(
            ['username' => 'operator_bps'],
            [
                'name' => 'Operator Data BPS Kota Bukittinggi',
                'email' => 'bps1375@bps.go.id',
                'password' => Hash::make('137590'),
                'role' => 'bps',
                'opd_code' => 'bps',
                'dinas_name' => 'BPS Kota Bukittinggi',
                'allowed_pages' => ['data-bps', 'monitoring-bps', 'tabel-opd', 'edit-tabel-opd'],
                'is_active' => true,
            ]
        );
    }
}
