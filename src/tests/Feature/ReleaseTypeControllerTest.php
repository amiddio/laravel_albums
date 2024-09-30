<?php

namespace Tests\Feature;

use App\Models\ReleaseType;
use Tests\TestCase;

class ReleaseTypeControllerTest extends TestCase
{

    public function testCountReleaseTypesInDataBase(): void
    {
        $this->assertDatabaseCount(ReleaseType::class, self::RELEASE_TYPE_COUNT);
    }

    public function testCheckRequest(): void
    {
        $response = $this->getJson('/api/v1/release_types');

        $response->assertStatus(200);
    }

    public function testCheckExpectedData(): void
    {
        $response = $this->getJson('/api/v1/release_types');

        $this->assertCount(self::RELEASE_TYPE_COUNT, $response->json('data'));
        $this->assertDatabaseHas(ReleaseType::class, ['name' => $response->json('data')[0]['name']]);
        $this->assertArrayHasKey('id', $response->json('data')[0]);
        $this->assertArrayHasKey('name', $response->json('data')[0]);
    }
}
