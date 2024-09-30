<?php

namespace Tests\Feature;

use App\Models\Artist;
use Database\Factories\ArtistFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ArtistControllerTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

        ArtistFactory::new()->count(2)->state(
            new Sequence(
                ['genres' => 'rock, blues', 'decades' => '1970-1981'],
                ['genres' => null, 'decades' => null],
            )
        )->create();
    }

    public function testListArtistRequest(): void
    {
        $response = $this->getJson('/api/v1/artists');

        $response->assertStatus(200);
    }

    public function testCheckExpectedListArtistsData(): void
    {
        $response = $this->getJson('/api/v1/artists');

        $this->assertCount(2, $response->json('data'));

        $this->assertArrayHasKey('data', $response->json());
        $this->assertArrayHasKey('links', $response->json());
        $this->assertArrayHasKey('meta', $response->json());
        $this->assertArrayHasKey('id', $response->json('data')[0]);
        $this->assertArrayHasKey('name', $response->json('data')[0]);
    }

    public function testArtistStore(): void
    {
        $response = $this->postJson('/api/v1/artists', [
            'name' => 'Red Hot Chili Peppers',
            'genres' => 'hard-rock',
            'decades' => 'some decades',
        ]);

        $response->assertStatus(201);
        $this->assertArrayHasKey('id', $response->json('data'));
        $this->assertDatabaseCount(Artist::class, 3);
    }

    public function testArtistStoreRequiredNameFieldValidation(): void
    {
        $response = $this->postJson('/api/v1/artists', [
            'genres' => 'hard-rock',
            'decades' => 'some decades',
        ]);

        $response->assertStatus(500);
        $this->assertNotEmpty($response->json('message'));
    }

    public function testArtistUpdate()
    {
        $artist = Artist::first();

        $response = $this->putJson('/api/v1/artists/' . $artist->id, [
            'name' => $artist->name . ' (updated)',
            'genres' => $artist->genres . ' (updated)',
            'decades' => $artist->decades . ' (updated)',
        ]);
        $artist->refresh();

        $response->assertStatus(200);
        $this->assertEquals($response->json('data.name'), $artist->name);
        $this->assertEquals($response->json('data.genres'), $artist->genres);
        $this->assertEquals($response->json('data.decades'), $artist->decades);
        $this->assertArrayHasKey('id', $response->json('data'));
    }

    public function testArtistUpdateRequiredNameFieldValidation(): void
    {
        $artist = Artist::first();

        $response = $this->putJson('/api/v1/artists/' . $artist->id, [
            'genres' => $artist->genres . ' (updated)',
            'decades' => $artist->decades . ' (updated)',
        ]);

        $response->assertStatus(500);
        $this->assertNotEmpty($response->json('message'));
    }

    public function testArtistDelete(): void
    {
        $artistCount = Artist::count();

        $response = $this->postJson('/api/v1/artists', ['name' => 'Muse']);

        $this->assertDatabaseCount(Artist::class, $artistCount + 1);

        $response = $this->deleteJson('/api/v1/artists/' . $response->json('data.id'));

        $response->assertStatus(204);
        $this->assertTrue($response->isEmpty());

        $this->assertDatabaseCount(Artist::class, $artistCount);
    }

    public function testArtistShow(): void
    {
        $artist = Artist::first();

        $response = $this->getJson('/api/v1/artists/' . $artist->id);

        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('data'));
        $this->assertArrayHasKey('name', $response->json('data'));
    }

    public function testArtistShowIfArtistIdNotExist(): void
    {
        $artist = Artist::latest()->first();

        $response = $this->getJson('/api/v1/artists/' . ($artist->id + 10));

        $response->assertStatus(404);
        $this->assertNotEmpty($response->json('message'));
    }
}
