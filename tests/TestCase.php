<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
// use Illuminate\Support\Facades\Broadcast;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        // Broadcast::fake(); 
    }
}