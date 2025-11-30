<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * TEST 1: Dashboard statistik produk
     * - Expected: totalProducts = 5
     */
    public function test_dashboard_calculates_total_products_correctly()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        Product::factory()->count(5)->create();

        $response = $this->actingAs($admin)
            ->get('/dashboard');

        $response->assertViewHas('totalProducts', 5);
    }

    /**
     * TEST 2: Dashboard total stok
     * - Expected: totalStock = 250 (5 products * 50 stock each)
     */
    public function test_dashboard_calculates_total_stock_correctly()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        Product::factory()->count(5)->create(['stock' => 50]);

        $response = $this->actingAs($admin)
            ->get('/dashboard');

        $response->assertViewHas('totalStock', 250);
    }

    /**
     * TEST 3: Dashboard rata-rata harga
     * - Expected: averagePrice = 150000
     */
    public function test_dashboard_calculates_average_price()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        Product::factory()->create(['price' => 100000]);
        Product::factory()->create(['price' => 200000]);

        $response = $this->actingAs($admin)
            ->get('/dashboard');

        $response->assertViewHas('averagePrice', 150000);
    }

    /**
     * TEST 4: Dashboard total member
     * - Expected: totalMembers = 10
     */
    public function test_dashboard_shows_total_members()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        Member::factory()->count(10)->create();

        $response = $this->actingAs($admin)
            ->get('/dashboard');

        $response->assertViewHas('totalMembers', 10);
    }

    /**
     * TEST 5: Dashboard requires login
     * - Expected: 302 Redirect to login
     */
    public function test_dashboard_requires_authentication()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }
}