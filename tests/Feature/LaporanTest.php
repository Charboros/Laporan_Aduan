<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    public function test_laporan_page_exposes_summary_data_to_the_view(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($user);

        $response = $this->get('/rekap');

        $response->assertOk();
        $response->assertViewHas('listTahun');
    }
}
