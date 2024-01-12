<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Tests\Repository\Token;

use Illuminate\Http\Request;
use Tizix\Bitrix24Laravel\Repository\Token\HeaderAuthenticationTokenRepository;
use Tizix\Bitrix24Laravel\Tests\TestCase;

final class HeaderAuthenticationTokenRepositoryTest extends TestCase
{
    private HeaderAuthenticationTokenRepository $repository;

    private Request $request;

    protected function setUp(): void
    {
        $this->repository = new HeaderAuthenticationTokenRepository();
        $this->request = new Request();
    }

    public function testSetAccessToken(): void
    {
        $this->assertNull($this->repository->getAccessToken());

        $this->repository->setAccessToken('new-access-token');

        $this->assertEquals('new-access-token', $this->repository->getAccessToken());
    }

    public function testSetRefreshToken(): void
    {
        $this->assertNull($this->repository->getRefreshToken());

        $this->repository->setRefreshToken('new-refresh-token');

        $this->assertEquals('new-refresh-token', $this->repository->getRefreshToken());
    }

    public function testGetAccessToken(): void
    {
        $_SERVER['X-Access-Token'] = 'test-access-token';
        $_GET['AUTH_ID'] = 'test-query-token';

        $this->assertEquals('test-access-token', $this->repository->getAccessToken());

        unset($_SERVER['HTTP_X_ACCESS_TOKEN']);

        $this->assertEquals('test-query-token', $this->repository->getAccessToken());

        unset($_GET['AUTH_ID']);

        $this->assertNull($this->repository->getAccessToken());
    }

    public function testGetRefreshToken(): void
    {
        $_SERVER['HTTP_X_REFRESH_TOKEN'] = 'test-refresh-token';
        $_GET['REFRESH_ID'] = 'test-query-token';

        $this->assertEquals('test-refresh-token', $this->repository->getRefreshToken());

        unset($_SERVER['HTTP_X_REFRESH_TOKEN']);

        $this->assertEquals('test-query-token', $this->repository->getRefreshToken());

        unset($_GET['REFRESH_ID']);

        $this->assertNull($this->repository->getRefreshToken());
    }
}
