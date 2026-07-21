<?php

namespace Tests\Feature;

use Tests\TestCase;

class DbIsolationTest extends TestCase
{
    public function test_tests_run_against_sqlite_in_memory(): void
    {
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
    }
}
