<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tizix\Bitrix24Laravel\Model\Auth\AccessToken;
use Tizix\Bitrix24Laravel\Tests\TestCase;

final class AccessTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testAccessTokenFields(): void
    {
        $user = $this->faker()->user();
        $tokenValue = 'test_token';
        $expiresAt = Carbon::now()->addHour();

        $token = new AccessToken([
            'user_id' => $user->getId(),
            'access_token' => $tokenValue,
            'expires_at' => $expiresAt,
        ]);

        $token->save();

        $retrievedToken = AccessToken::find($token->getId());
        $this->assertSame($user->id, $retrievedToken->user_id);
        $this->assertSame($tokenValue, $retrievedToken->access_token);
        $this->assertSame($expiresAt->format('Y-m-d H:i:s'), $retrievedToken->expires_at);
    }
}
