<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WishNote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoardsTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_tree_persists_ornament_and_message(): void
    {
        $this->post('/register', ['name' => 'Demo User', 'email' => 'demo@example.com', 'password' => 'demo-password'])->assertRedirect('/dashboard');
        $this->post('/boards', ['judul' => 'Holiday wishes', 'deskripsi_singkat' => 'Notes for friends', 'tipe_wadah' => 'tree', 'privasi' => 'public'])->assertRedirect();
        $board = WishNote::firstOrFail();
        $this->get('/dashboard')->assertOk()->assertSee('Holiday wishes');
        $this->post('/logout')->assertRedirect('/login');
        $url = route('boards.show', $board);
        $this->post("$url/messages", ['body' => 'Happy holidays!', 'ornament' => 'Kado', 'x' => 44, 'y' => 61])->assertRedirect($url);
        $this->get($url)->assertOk()->assertSee('Happy holidays!')->assertSee('Tanpa nama')->assertSee('left:44%;top:61%', false);
    }

    public function test_private_board_is_only_visible_to_its_owner(): void
    {
        $owner = User::factory()->create();
        $board = WishNote::create(['judul' => 'Private', 'deskripsi_singkat' => 'Only for me', 'tipe_wadah' => 'mailbox', 'privasi' => 'private', 'users_id' => $owner->id]);
        $url = route('boards.show', $board);
        $this->get($url)->assertForbidden();
        $this->actingAs($owner)->get($url)->assertOk()->assertSee('Kotak surat');
        $this->delete($url)->assertRedirect('/dashboard');
        $this->get($url)->assertNotFound();
    }
}
