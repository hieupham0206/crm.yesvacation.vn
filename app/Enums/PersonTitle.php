<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PersonTitle extends Enum
{
    public const MR = 1;
    public const MRS = 2;

    public static function getDescription($value): string
    {
        if ($value === self::MR) {
            return __('Mr');
        }

        if ($value === self::MRS) {
            return __('Mrs');
        }

        return parent::getDescription($value);
    }
}
