<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KelolaAkunDinasTest extends TestCase
{
    protected function tearDown(): void
    {
        User::where('username', 'like', 'test_%')->delete();
        parent::tearDown();
    }
    /**
     * Test admin can create a dinas account with selected allowed pages.
     */
    public function test_admin_can_create_dinas_account_with_page_permissions(): void
    {
        // Login as Super Admin
        $adminSession = [
            'id' => 0,
            'isLoggedIn' => true,
            'username' => 'admin_bps',
            'displayName' => 'Admin BPS Bukittinggi',
            'role' => 'admin',
            'allowed_pages' => array_keys(config('simonda.pages', [])),
        ];

        // Clean up test user if exists
        User::where('username', 'test_dinas_pupr')->delete();

        $response = $this->withSession(['user' => $adminSession])
            ->post('/kelola-akun/dinas', [
                'opd_code' => '01',
                'dinas_name' => 'Dinas Pekerjaan Umum dan Penataan Ruang',
                'name' => 'Operator PUPR',
                'username' => 'test_dinas_pupr',
                'email' => 'test_pupr@bukittinggikota.go.id',
                'password' => 'pupr123456',
                'allowed_pages' => ['isi-data-opd', 'monitoring-opd'],
                'is_active' => '1',
            ]);

        $response->assertRedirect('/kelola-akun');
        $response->assertSessionHas('success');

        // Verify DB
        $user = User::where('username', 'test_dinas_pupr')->first();
        $this->assertNotNull($user);
        $this->assertEquals('01', $user->opd_code);
        $this->assertEquals(['isi-data-opd', 'monitoring-opd'], $user->allowed_pages);
        $this->assertTrue(Hash::check('pupr123456', $user->password));
    }

    /**
     * Test dinas user can login and access allowed pages, but blocked from unauthorized pages.
     */
    public function test_dinas_user_login_and_permission_enforcement(): void
    {
        // Ensure test user exists
        $user = User::updateOrCreate(
            ['username' => 'test_dinas_pupr'],
            [
                'name' => 'Operator PUPR',
                'email' => 'test_pupr@bukittinggikota.go.id',
                'password' => Hash::make('pupr123456'),
                'role' => 'opd',
                'opd_code' => '01',
                'dinas_name' => 'Dinas Pekerjaan Umum dan Penataan Ruang',
                'allowed_pages' => ['isi-data-opd', 'monitoring-opd'],
                'is_active' => true,
            ]
        );

        // 1. Test Login
        $loginResponse = $this->post('/login', [
            'username' => 'test_dinas_pupr',
            'password' => 'pupr123456',
        ]);

        $loginResponse->assertRedirect('/');
        $this->assertEquals('opd', session('user.role'));
        $this->assertEquals(['isi-data-opd', 'monitoring-opd'], session('user.allowed_pages'));

        $dinasSession = session('user');

        // 2. Access ALLOWED page (isi-data-opd) -> 200 OK
        $allowedResponse = $this->withSession(['user' => $dinasSession])
            ->get('/isi-data-opd');
        $allowedResponse->assertStatus(200);

        // 3. Access DISALLOWED page (data-bps) -> Redirected to home with error
        $disallowedResponse = $this->withSession(['user' => $dinasSession])
            ->get('/data-bps');
        $disallowedResponse->assertRedirect('/');
        $disallowedResponse->assertSessionHas('error');

        // 4. Access Kelola Akun (Only for Super Admin) -> Redirected with error
        $adminOnlyResponse = $this->withSession(['user' => $dinasSession])
            ->get('/kelola-akun');
        $adminOnlyResponse->assertRedirect('/');
        $adminOnlyResponse->assertSessionHas('error');
    }

    /**
     * Test admin can create an Instansi Vertikal account and permission works.
     */
    public function test_instansi_vertikal_creation_and_access(): void
    {
        $adminSession = [
            'id' => 0,
            'isLoggedIn' => true,
            'username' => 'admin_bps',
            'displayName' => 'Admin BPS Bukittinggi',
            'role' => 'admin',
            'allowed_pages' => array_keys(config('simonda.pages', [])),
        ];

        // 1. Create Instansi Vertikal Account
        $response = $this->withSession(['user' => $adminSession])
            ->post('/kelola-akun/dinas', [
                'role' => 'instansi',
                'opd_code' => '03',
                'dinas_name' => 'Kementerian Agama Kota Bukittinggi',
                'name' => 'Operator Kemenag',
                'username' => 'test_instansi_kemenag',
                'email' => 'test_kemenag@kemenag.go.id',
                'password' => 'kemenag123',
                'allowed_pages' => ['isi-data-instansi', 'monitoring-instansi'],
                'is_active' => '1',
            ]);

        $response->assertRedirect('/kelola-akun');
        $response->assertSessionHas('success');

        $user = User::where('username', 'test_instansi_kemenag')->first();
        $this->assertNotNull($user);
        $this->assertEquals('instansi', $user->role);
        $this->assertEquals('03', $user->opd_code);

        // 2. Login as Instansi Vertikal
        $loginRes = $this->post('/login', [
            'username' => 'test_instansi_kemenag',
            'password' => 'kemenag123',
        ]);
        $loginRes->assertRedirect('/');
        $this->assertEquals('instansi', session('user.role'));

        $instansiSession = session('user');

        // 3. Access Allowed (isi-data-instansi) -> 200 OK
        $instansiPageRes = $this->withSession(['user' => $instansiSession])
            ->get('/isi-data-instansi');
        $instansiPageRes->assertStatus(200);

        // 4. Access Disallowed OPD Page (isi-data-opd) -> Redirected with error
        $blockedOpdRes = $this->withSession(['user' => $instansiSession])
            ->get('/isi-data-opd');
        $blockedOpdRes->assertRedirect('/');
        $blockedOpdRes->assertSessionHas('error');
    }

    /**
     * Test admin can delete an individual dinas or instansi account.
     */
    public function test_admin_can_delete_single_dinas_account(): void
    {
        $adminSession = [
            'id' => 0,
            'isLoggedIn' => true,
            'username' => 'admin_bps',
            'displayName' => 'Admin BPS Bukittinggi',
            'role' => 'admin',
            'allowed_pages' => array_keys(config('simonda.pages', [])),
        ];

        $targetUser = User::create([
            'name' => 'Operator Disdik Delete Test',
            'username' => 'test_disdik_delete',
            'email' => 'test_disdik_del@bukittinggikota.go.id',
            'password' => Hash::make('password123'),
            'role' => 'opd',
            'opd_code' => '02',
            'dinas_name' => 'Dinas Pendidikan dan Kebudayaan',
            'allowed_pages' => ['isi-data-opd'],
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('users', ['id' => $targetUser->id]);

        $deleteResponse = $this->withSession(['user' => $adminSession])
            ->post("/kelola-akun/dinas/{$targetUser->id}/delete");

        $deleteResponse->assertRedirect('/kelola-akun');
        $deleteResponse->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
    }

    /**
     * Test admin can perform bulk deletion of accounts.
     */
    public function test_admin_can_bulk_delete_accounts(): void
    {
        $adminSession = [
            'id' => 0,
            'isLoggedIn' => true,
            'username' => 'admin_bps',
            'displayName' => 'Admin BPS Bukittinggi',
            'role' => 'admin',
            'allowed_pages' => array_keys(config('simonda.pages', [])),
        ];

        // Seed 2 test OPD accounts and 1 test Instansi account
        $opd1 = User::create([
            'name' => 'Test OPD 1',
            'username' => 'test_opd_bulk1',
            'email' => 'test_bulk1@mail.com',
            'password' => Hash::make('pass'),
            'role' => 'opd',
            'dinas_name' => 'Dinas Test 1',
            'allowed_pages' => ['isi-data-opd'],
            'is_active' => true,
        ]);

        $inst1 = User::create([
            'name' => 'Test Instansi 1',
            'username' => 'test_inst_bulk1',
            'email' => 'test_inst_bulk1@mail.com',
            'password' => Hash::make('pass'),
            'role' => 'instansi',
            'dinas_name' => 'Instansi Test 1',
            'allowed_pages' => ['isi-data-instansi'],
            'is_active' => true,
        ]);

        // Bulk delete only OPD
        $resOpd = $this->withSession(['user' => $adminSession])
            ->post('/kelola-akun/dinas/bulk-delete', ['target_type' => 'opd']);

        $resOpd->assertRedirect('/kelola-akun');
        $this->assertDatabaseMissing('users', ['id' => $opd1->id]);
        $this->assertDatabaseHas('users', ['id' => $inst1->id]);

        // Bulk delete instansi
        $resInst = $this->withSession(['user' => $adminSession])
            ->post('/kelola-akun/dinas/bulk-delete', ['target_type' => 'instansi']);

        $resInst->assertRedirect('/kelola-akun');
        $this->assertDatabaseMissing('users', ['id' => $inst1->id]);
    }

    /**
     * Test admin can create a dinas account without email, without pic name, and without nip.
     */
    public function test_admin_can_create_dinas_account_without_email_and_pic(): void
    {
        $adminSession = [
            'id' => 0,
            'isLoggedIn' => true,
            'username' => 'admin_bps',
            'displayName' => 'Admin BPS Bukittinggi',
            'role' => 'admin',
            'allowed_pages' => array_keys(config('simonda.pages', [])),
        ];

        User::where('username', 'test_dinas_kesehatan')->delete();

        $response = $this->withSession(['user' => $adminSession])
            ->post('/kelola-akun/dinas', [
                'role' => 'opd',
                'opd_code' => '12',
                'dinas_name' => 'Dinas Kesehatan Kota Bukittinggi',
                'username' => 'test_dinas_kesehatan',
                'password' => 'bpsbukittinggi',
                'allowed_pages' => ['isi-data-opd', 'monitoring-opd', 'tabel-opd'],
                'is_active' => '1',
            ]);

        $response->assertRedirect('/kelola-akun');
        $response->assertSessionHas('success');

        $user = User::where('username', 'test_dinas_kesehatan')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Dinas Kesehatan Kota Bukittinggi', $user->name);
        $this->assertEquals('12', $user->opd_code);
        $this->assertStringContainsString('test_dinas_kesehatan@', $user->email);
        $this->assertNull($user->nip);
    }

    /**
     * Test logged-in dinas user (e.g. Dinas PUPR) only sees their single OPD card.
     */
    public function test_dinas_pupr_user_only_sees_pupr_card_on_isi_data_opd(): void
    {
        $puprSession = [
            'id' => 999,
            'isLoggedIn' => true,
            'username' => 'dinas_pupr',
            'displayName' => 'Dinas PUPR',
            'role' => 'opd',
            'opd_code' => '01',
            'dinas_name' => 'Dinas Pekerjaan Umum dan Penataan Ruang',
            'allowed_pages' => ['isi-data-opd', 'monitoring-opd', 'tabel-opd'],
        ];

        $response = $this->withSession(['user' => $puprSession])
            ->get('/isi-data-opd');

        $response->assertStatus(200);
        $response->assertSee('Dinas PUPR');
        $response->assertSee('Dinas Pekerjaan Umum dan Penataan Ruang');
        $response->assertSee('Instansi Anda');
        $response->assertSee('KODE OPD: 01');

        // Other OPDs must NOT be displayed
        $response->assertDontSee('Dinas PMPTSP');
        $response->assertDontSee('Disdukcapil');
        $response->assertDontSee('Dinas Perhubungan');
    }

    /**
     * Test admin sees all OPDs on isi-data-opd.
     */
    public function test_admin_sees_all_opds_on_isi_data_opd(): void
    {
        $adminSession = [
            'id' => 0,
            'isLoggedIn' => true,
            'username' => 'admin_bps',
            'displayName' => 'Admin BPS Bukittinggi',
            'role' => 'admin',
            'allowed_pages' => array_keys(config('simonda.pages', [])),
        ];

        $response = $this->withSession(['user' => $adminSession])
            ->get('/isi-data-opd');

        $response->assertStatus(200);
        $response->assertSee('Pilih Instansi');
        $response->assertSee('Dinas PUPR');
        $response->assertSee('Dinas PMPTSP');
        $response->assertSee('Disdukcapil');
        $response->assertSee('Dinas Perhubungan');
    }
}

