<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Gender extends Enum
{
    public const MALE = 1;
    public const FEMALE = 2;

    public static function getDescription($value): string
    {
        if ($value === self::MALE) {
            return __('Male');
        }

        if ($value === self::FEMALE) {
            return __('Female');
        }

        return parent::getDescription($value);
    }
}
