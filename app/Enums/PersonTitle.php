<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PersonTitle extends Enum
{
    public const MR = 1;
    public const MRS = 2;
    public const MR_ = 3;
    public const MS = 4;

    public static function getDescription($value): string
    {
        if ($value === self::MR) {
            return __('Mr');
        }

        if ($value === self::MRS) {
            return __('Mrs');
        }

        if ($value === self::MR_) {
            return __('Mr.');
        }

        if ($value === self::MS) {
            return __('Ms');
        }

        return parent::getDescription($value);
    }
}
