<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberApiTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $owner;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password')
        ]);
        
        $this->owner = User::factory()->create([
            'role' => 'owner',
            'email' => 'owner@test.com',
            'password' => bcrypt('password')
        ]);
    }

    /**
     * TEST 1: Get all members via API
     * - Endpoint: GET /api/members
     * - Auth Required: Yes
     * - Expected: 200 OK, JSON array of members
     */
    public function test_can_get_all_members()
    {
        // Arrange: Create 5 members
        Member::factory()->count(5)->create();

        // Act: Call API
        $response = $this->actingAs($this->admin)
            ->getJson('/api/members');

        // Assert: Check response
        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ])
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['id', 'name', 'email', 'phone', 'address', 'created_at', 'updated_at']
                ]
            ]);
    }

    /**
     * TEST 2: Create member (Admin only)
     * - Endpoint: POST /api/members
     * - Auth Required: Yes (Admin)
     * - Expected: 201 Created
     */
    public function test_admin_can_create_member()
    {
        $memberData = [
            'name' => 'Ahmad Wijaya',
            'email' => 'ahmad@test.com',
            'phone' => '08123456789',
            'address' => 'Jalan Raya No 1'
        ];

        $response = $this->actingAs($this->admin)
            ->postJson('/api/members', $memberData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Member created'
            ]);

        $this->assertDatabaseHas('members', [
            'email' => 'ahmad@test.com',
            'name' => 'Ahmad Wijaya'
        ]);
    }

    /**
     * TEST 3: Validation - Email is required
     * - Endpoint: POST /api/members
     * - Payload: Missing email
     * - Expected: 422 Validation Error
     */
    public function test_member_email_is_required()
    {
        $memberData = [
            'name' => 'Ahmad',
            'phone' => '08123456789',
            'address' => 'Jalan Raya'
        ];

        $response = $this->actingAs($this->admin)
            ->postJson('/api/members', $memberData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    /**
     * TEST 4: Email must be unique
     * - Endpoint: POST /api/members
     * - Issue: Duplicate email
     * - Expected: 422 Validation Error
     */
    public function test_member_email_must_be_unique()
    {
        Member::factory()->create(['email' => 'duplicate@test.com']);

        $memberData = [
            'name' => 'Ahmad',
            'email' => 'duplicate@test.com',
            'phone' => '08123456789'
        ];

        $response = $this->actingAs($this->admin)
            ->postJson('/api/members', $memberData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    /**
     * TEST 5: Get single member
     * - Endpoint: GET /api/members/{id}
     * - Auth Required: Yes
     * - Expected: 200 OK with member data
     */
    public function test_can_get_single_member()
    {
        $member = Member::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@test.com'
        ]);

        $response = $this->actingAs($this->admin)
            ->getJson("/api/members/{$member->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $member->id,
                    'name' => 'Budi Santoso',
                    'email' => 'budi@test.com'
                ]
            ]);
    }

    /**
     * TEST 6: Update member (Admin only)
     * - Endpoint: PUT /api/members/{id}
     * - Auth Required: Yes (Admin)
     * - Expected: 200 OK
     */
    public function test_admin_can_update_member()
    {
        $member = Member::factory()->create();

        $updatedData = [
            'name' => 'Budi Updated',
            'email' => 'budi_updated@test.com',
            'phone' => '08987654321',
            'address' => 'Alamat Baru'
        ];

        $response = $this->actingAs($this->admin)
            ->putJson("/api/members/{$member->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Member updated'
            ]);

        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'name' => 'Budi Updated'
        ]);
    }

    /**
     * TEST 7: Delete member (Admin only)
     * - Endpoint: DELETE /api/members/{id}
     * - Auth Required: Yes (Admin)
     * - Expected: 200 OK, member deleted from DB
     */
    public function test_admin_can_delete_member()
    {
        $member = Member::factory()->create();

        $response = $this->actingAs($this->admin)
            ->deleteJson("/api/members/{$member->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Member deleted'
            ]);

        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    }

    /**
     * TEST 8: Authorization - Owner cannot create member
     * - Endpoint: POST /api/members
     * - Auth: Owner role
     * - Expected: 403 Forbidden
     */
    public function test_owner_cannot_create_member()
{
    $memberData = [
        'name' => 'Test Member',
        'email' => 'test@test.com',
        'phone' => '081234567890'  // ← ADD THIS
    ];

    $response = $this->actingAs($this->owner)
        ->postJson('/api/members', $memberData);

    $response->assertStatus(403);
}


    /**
     * TEST 9: Get non-existent member
     * - Endpoint: GET /api/members/9999
     * - Expected: 404 Not Found
     */
    public function test_get_non_existent_member_returns_404()
    {
        $response = $this->actingAs($this->admin)
            ->getJson('/api/members/9999');

        $response->assertStatus(404);
    }

    /**
     * TEST 10: Unauthenticated access
     * - Endpoint: GET /api/members
     * - Auth Required: Yes
     * - Expected: 401 Unauthorized
     */
    public function test_unauthenticated_cannot_access_api()
    {
        $response = $this->getJson('/api/members');

        $response->assertStatus(401);
    }
}