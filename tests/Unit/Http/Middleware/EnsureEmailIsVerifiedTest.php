<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\EnsureEmailIsVerified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class EnsureEmailIsVerifiedTest extends TestCase
{
    protected $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new EnsureEmailIsVerified();
    }

    public function testHandleWithNoUser()
    {
        $request = new Request();
        $request->setUserResolver(function () {
            return null;
        });

        $response = $this->middleware->handle($request, function () {
            $this->fail('Next middleware should not be called');
        });

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(409, $response->getStatusCode());
        $this->assertEquals(['message' => 'Your email address is not verified.'], json_decode($response->getContent(), true));
    }

    public function testHandleWithVerifiedUser()
    {
        $user = Mockery::mock(MustVerifyEmail::class);
        $user->shouldReceive('hasVerifiedEmail')->andReturn(true);

        $request = new Request();
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $response = $this->middleware->handle($request, function () {
            return new Response('Next middleware called');
        });

        $this->assertEquals('Next middleware called', $response->getContent());
    }

    public function testHandleWithUnverifiedUser()
    {
        $user = Mockery::mock(MustVerifyEmail::class);
        $user->shouldReceive('hasVerifiedEmail')->andReturn(false);

        $request = new Request();
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $response = $this->middleware->handle($request, function () {
            $this->fail('Next middleware should not be called');
        });

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(409, $response->getStatusCode());
        $this->assertEquals(['message' => 'Your email address is not verified.'], json_decode($response->getContent(), true));
    }

    public function testHandleWithNonMustVerifyEmailUser()
    {
        $user = Mockery::mock('User');

        $request = new Request();
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $response = $this->middleware->handle($request, function () {
            return new Response('Next middleware called');
        });

        $this->assertEquals('Next middleware called', $response->getContent());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
