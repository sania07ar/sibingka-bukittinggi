<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('SiAngka');
        $response->assertSee('MASUK KE AKUN ANDA');
    }

    public function test_admin_bps_can_login(): void
    {
        $response = $this->post('/login', [
            'username' => 'admin_bps',
            'password' => 'bpsbukittinggi',
        ]);

        $response->assertRedirect('/portal');
        $this->assertTrue(session()->has('user'));
        $this->assertEquals('admin', session('user.role'));
        $this->assertEquals('Admin BPS Bukittinggi', session('user.displayName'));
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        $response = $this->post('/login', [
            'username' => 'unknown_user',
            'password' => 'wrongpassword123',
        ]);

        $response->assertSessionHas('error');
        $this->assertFalse(session()->has('user'));
    }

    public function test_authenticated_admin_can_access_dashboard(): void
    {
        $response = $this->withSession([
            'user' => [
                'isLoggedIn' => true,
                'username' => 'admin_bps',
                'displayName' => 'Admin BPS Bukittinggi',
                'role' => 'admin',
                'roleLabel' => 'Admin BPS Bukittinggi',
            ]
        ])->get('/');

        $response->assertStatus(200);
        $response->assertSee('Admin BPS Bukittinggi');
        $response->assertSee('Keluar');
    }

    public function test_admin_can_logout(): void
    {
        $response = $this->withSession([
            'user' => [
                'isLoggedIn' => true,
                'username' => 'admin_bps',
            ]
        ])->post('/logout');

        $response->assertRedirect('/login');
        $this->assertFalse(session()->has('user'));
    }
}
