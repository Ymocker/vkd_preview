<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FrontendControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSessionContent()
    {
        $response = $this->get('/');
        $response->assertSessionHas('numberId')
                 ->assertSessionHas('numberGod')
                 ->assertSessionHas('numberGaz')
                 ->assertSessionHas('_token')
                 ->assertSessionHas('dataVyh')
                 ->assertSessionHas('back');
    }
}
