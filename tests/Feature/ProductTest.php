<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $owner;

    protected function setUp(): void
    {
        parent::setUp();
        
        Storage::fake('public');
        
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com'
        ]);
        
        $this->owner = User::factory()->create([
            'role' => 'owner',
            'email' => 'owner@test.com'
        ]);
    }

    /**
     * TEST 1: View all products
     * - Endpoint: GET /products
     * - Auth: Any authenticated user
     * - Expected: 200 OK
     */
    public function test_can_view_products_page()
    {
        $response = $this->actingAs($this->admin)
            ->get('/products');

        $response->assertStatus(200)
            ->assertViewIs('products.index');
    }

    /**
     * TEST 2: Admin can view create product page
     * - Endpoint: GET /products/create
     * - Auth: Admin only
     * - Expected: 200 OK
     */
    public function test_admin_can_view_create_product_page()
    {
        $response = $this->actingAs($this->admin)
            ->get('/products/create');

        $response->assertStatus(200)
            ->assertViewIs('products.create');
    }

    /**
     * TEST 3: Owner cannot view create product page
     * - Endpoint: GET /products/create
     * - Auth: Owner
     * - Expected: 403 Forbidden
     */
    public function test_owner_cannot_view_create_product_page()
    {
        $response = $this->actingAs($this->owner)
            ->get('/products/create');

        $response->assertStatus(403);
    }

    /**
     * TEST 4: Admin can create product
     * - Endpoint: POST /products
     * - Auth: Admin only
     * - Expected: 302 Redirect to /products with success message
     */
    public function test_admin_can_create_product()
    {
        $productData = [
            'name' => 'T-Shirt Premium',
            'price' => 150000,
            'size' => 'M,L,XL',
            'stock' => 50,
            'description' => 'T-Shirt berkualitas premium'
        ];

        $response = $this->actingAs($this->admin)
            ->post('/products', $productData);

        $response->assertRedirect('/products')
            ->assertSessionHas('success', 'Produk berhasil ditambahkan');

        $this->assertDatabaseHas('products', [
            'name' => 'T-Shirt Premium',
            'price' => 150000
        ]);
    }

    /**
     * TEST 5: Product name validation
     * - Endpoint: POST /products
     * - Payload: Missing name
     * - Expected: Back with validation error
     */
    public function test_product_name_is_required()
    {
        $productData = [
            'price' => 150000,
            'stock' => 50,
            'size' => 'M'
        ];

        $response = $this->actingAs($this->admin)
            ->post('/products', $productData);

        $response->assertSessionHasErrors('name');
    }

    /**
     * TEST 6: Price must be numeric
     * - Endpoint: POST /products
     * - Payload: Price is string
     * - Expected: Validation error
     */
    public function test_product_price_must_be_numeric()
    {
        $productData = [
            'name' => 'T-Shirt',
            'price' => 'harga mahal',
            'stock' => 50,
            'size' => 'M'
        ];

        $response = $this->actingAs($this->admin)
            ->post('/products', $productData);

        $response->assertSessionHasErrors('price');
    }

    /**
     * TEST 7: Stock must be numeric
     * - Endpoint: POST /products
     * - Payload: Stock is string
     * - Expected: Validation error
     */
    public function test_product_stock_must_be_numeric()
    {
        $productData = [
            'name' => 'T-Shirt',
            'price' => 150000,
            'stock' => 'banyak',
            'size' => 'M'
        ];

        $response = $this->actingAs($this->admin)
            ->post('/products', $productData);

        $response->assertSessionHasErrors('stock');
    }

    /**
     * TEST 8: Admin can update product
     * - Endpoint: PUT /products/{id}
     * - Auth: Admin only
     * - Expected: 302 Redirect with success
     */
    public function test_admin_can_update_product()
    {
        $product = Product::factory()->create([
            'name' => 'Old Name',
            'price' => 100000
        ]);

        $updatedData = [
            'name' => 'T-Shirt Updated',
            'price' => 200000,
            'size' => 'XL',
            'stock' => 100,
            'description' => 'Updated'
        ];

        $response = $this->actingAs($this->admin)
            ->put("/products/{$product->id}", $updatedData);

        $response->assertRedirect('/products')
            ->assertSessionHas('success', 'Produk berhasil diupdate');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'T-Shirt Updated'
        ]);
    }

    /**
     * TEST 9: Admin can delete product
     * - Endpoint: DELETE /products/{id}
     * - Auth: Admin only
     * - Expected: 302 Redirect with success, product deleted
     */
    public function test_admin_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete("/products/{$product->id}");

        $response->assertRedirect('/products')
            ->assertSessionHas('success', 'Produk dihapus');

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /**
     * TEST 10: Owner cannot delete product
     * - Endpoint: DELETE /products/{id}
     * - Auth: Owner
     * - Expected: 403 Forbidden
     */
    public function test_owner_cannot_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->owner)
            ->delete("/products/{$product->id}");

        $response->assertStatus(403);
    }
}