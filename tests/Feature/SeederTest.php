<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeederTest extends TestCase
{
    /**
     * Test seeders.
     *
     * @return void
     */
    public function test_if_seeders_working()
    {
        $this->seed();
    }
}
