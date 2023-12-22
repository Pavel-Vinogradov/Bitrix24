<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Tests\Components\Faker;

use Faker\Generator as FakerGenerator;
use Illuminate\Support\Carbon;
use Tizix\Bitrix24Laravel\Model\User\User;

final class Generator extends FakerGenerator
{
    public function user(): User
    {
        $user = new User();
        $user->fill([
            'name' => $this->name(),
            'email' => $this->unique()->safeEmail(),
            'phone' => $this->phoneNumber(),
            'work_position' => $this->word(),
            'is_active' => $this->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $user;
    }
}
