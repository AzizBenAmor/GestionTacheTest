<?php

namespace App\Enums\TaskEnums;

use Spatie\Enum\Enum;

/**
 * @method static self waiting()
 * @method static self inProgress()
 * @method static self Finished()
 */
class TaskStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'waiting' => 0,
            'inProgress' => 1,
            'Finished' => 2,
        ];
    }
}
