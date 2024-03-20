<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithConsoleEvents;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    // use RefreshDatabase;
    use DatabaseTransactions;
    use WithConsoleEvents;
}
