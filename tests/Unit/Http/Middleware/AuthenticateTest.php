<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\Authenticate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    use RefreshDatabase;

    protected $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new Authenticate($this->app['auth']);
    }

    public function test_redirect_to_returns_null_for_json_request()
    {
        $response = $this->getJson('/api/tickets');

        $this->assertEquals(401, $response->status());
        $this->assertEquals('Unauthenticated.', $response->json('message'));
    }

    public function test_redirect_to_returns_login_route_for_non_json_request()
    {
        $response = $this->get('/api/tickets');

        $this->assertEquals(302, $response->status());
        $this->assertEquals(route('login'), $response->headers->get('Location'));
    }
}
