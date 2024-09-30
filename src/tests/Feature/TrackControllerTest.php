<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Artist;
use App\Models\ReleaseType;
use App\Models\Track;
use Database\Factories\AlbumFactory;
use Database\Factories\ArtistFactory;
use Database\Factories\TrackFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class TrackControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        ArtistFactory::new()->count(1)->create();

        $this->releaseType = ReleaseType::first();
        $this->artist = Artist::first();

        AlbumFactory::new()->count(1)->create()->each(function (Album $album) {
            $album->artist_id = $this->artist->id;
            $album->release_type_id = $this->releaseType->id;
            $album->save();
        });

        $album = Album::first();
        TrackFactory::new()->count(1)->state(
            new Sequence(['album_id' => $album->id, 'number' => 1])
        )->create();
    }

    public function testTrackStore()
    {
        $album = Album::first();
        $tracksCount = Track::count();

        $response = $this->postJson('/api/v1/tracks', [
            'album_id' => $album->id,
            'disc' => 1,
            'number' => 1,
            'title' => 'Achilles Last Stand',
            'duration' => '09:28',
            'composers' => 'Led Zeppelin',
        ]);

        $response->assertStatus(201);
        $this->assertArrayHasKey('id', $response->json('data'));
        $this->assertDatabaseCount(Track::class, $tracksCount + 1);
    }

    public function testTrackStoreIfAlbumIdNotSent()
    {
        $response = $this->postJson('/api/v1/tracks', [
            'disc' => 1,
            'number' => 1,
            'title' => 'Achilles Last Stand',
            'duration' => '09:28',
            'composers' => 'Led Zeppelin',
        ]);

        $response->assertStatus(500);
        $this->assertNotEmpty($response->json('message'));
    }

    public function testAlbumUpdate(): void
    {
        $track = Track::first();

        $response = $this->putJson('/api/v1/tracks/' . $track->id, [
            'disc' => $track->disc,
            'title' => $track->title . ' (updated)',
            'number' => $track->number,
            'duration' => $track->duration,
        ]);
        $track->refresh();

        $response->assertStatus(200);
        $this->assertEquals($response->json('data.title'), $track->title);
        $this->assertArrayHasKey('id', $response->json('data'));
    }

    public function testAlbumUpdateIfTitleNotSent(): void
    {
        $track = Track::first();

        $response = $this->putJson('/api/v1/tracks/' . $track->id, [
            'disc' => $track->disc,
            'number' => $track->number,
            'duration' => $track->duration,
        ]);

        $response->assertStatus(500);
        $this->assertNotEmpty($response->json('message'));
    }

    public function testTrackDelete(): void
    {
        $album = Album::first();
        $tracksCount = Track::count();

        $response = $this->postJson('/api/v1/tracks', [
            'album_id' => $album->id,
            'disc' => 1,
            'number' => 1,
            'title' => 'Achilles Last Stand',
            'duration' => '09:28',
            'composers' => 'Led Zeppelin',
        ]);

        $this->assertDatabaseCount(Track::class, $tracksCount + 1);

        $response = $this->deleteJson('/api/v1/tracks/' . $response->json('data.id'));

        $response->assertStatus(204);
        $this->assertTrue($response->isEmpty());

        $this->assertDatabaseCount(Track::class, $tracksCount);
    }
}
