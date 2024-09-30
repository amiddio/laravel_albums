<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Artist;
use App\Models\ReleaseType;
use Database\Factories\AlbumFactory;
use Database\Factories\ArtistFactory;
use Database\Factories\TrackFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class AlbumControllerTest extends TestCase
{
    const ALBUMS_COUNT = 5;

    private Artist $artist;
    private ReleaseType $releaseType;

    public function setUp(): void
    {
        parent::setUp();

        ArtistFactory::new()->count(2)->create();

        $this->releaseType = ReleaseType::first();
        $this->artist = Artist::first();

        AlbumFactory::new()->count(self::ALBUMS_COUNT)->create()->each(function (Album $album) {
            $album->artist_id = $this->artist->id;
            $album->release_type_id = $this->releaseType->id;
            $album->save();
        });
    }

    public function testListAlbumsRequest(): void
    {
        $response = $this->getJson('/api/v1/albums/' . $this->artist->id . '/' . $this->releaseType->id);

        $response->assertStatus(200);
    }

    public function testListAlbumsRequestIfArtistIdNotExist(): void
    {
        $response = $this->getJson('/api/v1/albums/' . PHP_INT_MAX . '/' . $this->releaseType->id);

        $response->assertStatus(200);
        $this->assertEmpty($response->json('data'));
    }

    public function testListAlbumsRequestIfReleaseTypeIdNotExist(): void
    {
        $response = $this->getJson('/api/v1/albums/' . $this->artist->id . '/' . PHP_INT_MAX);

        $response->assertStatus(200);
        $this->assertEmpty($response->json('data'));
    }

    public function testCheckExpectedAlbumData(): void
    {
        $response = $this->getJson('/api/v1/albums/' . $this->artist->id . '/' . $this->releaseType->id);

        $this->assertCount(self::ALBUMS_COUNT, $response->json('data'));
        $this->assertArrayHasKey('id', $response->json('data')[0]);
        $this->assertArrayHasKey('title', $response->json('data')[0]);
        $this->assertArrayHasKey('year', $response->json('data')[0]);
        $this->assertArrayHasKey('duration', $response->json('data')[0]);
    }

    public function testAlbumStore(): void
    {
        $albumCount = Album::count();

        $response = $this->postJson('/api/v1/albums', [
            'artist_id' => $this->artist->id,
            'release_type_id' => $this->releaseType->id,
            'title' => 'Presence',
            'year' => 1976,
            'duration' => '40:27',
            'label' => 'Swan Song',
            'genres' => 'blues, rock',
        ]);

        $response->assertStatus(201);
        $this->assertArrayHasKey('id', $response->json('data'));
        $this->assertDatabaseCount(Album::class, $albumCount + 1);
    }

    public function testAlbumStoreIfTitleNotSent(): void
    {
        $response = $this->postJson('/api/v1/albums', [
            'artist_id' => $this->artist->id,
            'release_type_id' => $this->releaseType->id,
            'year' => 1976,
            'duration' => '40:27',
        ]);

        $response->assertStatus(500);
        $this->assertNotEmpty($response->json('message'));
    }

    public function testAlbumUpdate(): void
    {
        $album = Album::first();

        $response = $this->putJson('/api/v1/albums/' . $album->id, [
            'title' => $album->title . ' (updated)',
            'year' => $album->year,
            'duration' => $album->duration,
        ]);

        $album->refresh();

        $response->assertStatus(200);
        $this->assertEquals($response->json('data.title'), $album->title);
        $this->assertArrayHasKey('id', $response->json('data'));
    }

    public function testAlbumUpdateIfTitleFieldNotSent(): void
    {
        $album = Album::first();

        $response = $this->putJson('/api/v1/albums/' . $album->id, [
            'year' => $album->year,
            'duration' => $album->duration,
        ]);

        $response->assertStatus(500);
        $this->assertNotEmpty($response->json('message'));
    }

    public function testAlbumDelete(): void
    {
        $albumsCount = Album::count();

        $response = $this->postJson('/api/v1/albums', [
            'artist_id' => $this->artist->id,
            'release_type_id' => $this->releaseType->id,
            'title' => 'Presence',
            'year' => 1976,
            'duration' => '40:27',
        ]);

        $this->assertDatabaseCount(Album::class, $albumsCount + 1);

        $response = $this->deleteJson('/api/v1/albums/' . $response->json('data.id'));

        $response->assertStatus(204);
        $this->assertTrue($response->isEmpty());

        $this->assertDatabaseCount(Album::class, $albumsCount);
    }

    public function testAlbumShow(): void
    {
        $album = Album::first();

        TrackFactory::new()->count(7)->state(
            new Sequence(['album_id' => $album->id, 'number' => 1])
        )->create();

        $response = $this->getJson('/api/v1/albums/' . $album->id);

        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('data'));
        $this->assertArrayHasKey('id', $response->json('data'));
        $this->assertArrayHasKey('releaseType', $response->json('data'));
        $this->assertArrayHasKey('artist', $response->json('data'));
        $this->assertArrayHasKey('tracks', $response->json('data'));
        $this->assertCount(7, $response->json('data.tracks'));
    }

    public function testAlbumShowIfAlbumIdNotExist(): void
    {
        $album = Album::latest()->first();

        $response = $this->getJson('/api/v1/albums/' . ($album->id + 10));

        $response->assertStatus(404);
        $this->assertNotEmpty($response->json('message'));
    }
}
