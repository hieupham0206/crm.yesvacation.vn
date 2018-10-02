<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Confirmation extends Enum
{
    public const NO = -1;
    public const YES = 1;

    public static function getDescription($value): string
    {
        if ($value === self::NO) {
            return __('No');
        }

        if ($value === self::YES) {
            return __('Yes');
        }

        return parent::getDescription($value);
    }
}
