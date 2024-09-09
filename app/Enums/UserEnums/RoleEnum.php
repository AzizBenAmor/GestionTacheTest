<?php

namespace App\Enums\UserEnums;

use Spatie\Enum\Enum;

/**
 * @method static self admin()
 * @method static self user()
 */
class RoleEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'admin' => 'admin',
            'user' => 'user',
        ];
    }
}
