<?php

namespace Tests;

use Database\Factories\ReleaseTypeFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    const RELEASE_TYPE_COUNT = 5;

    public function setUp(): void
    {
        parent::setUp();

        ReleaseTypeFactory::new()->count(self::RELEASE_TYPE_COUNT)->create();
    }
}
