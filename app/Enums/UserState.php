<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserState extends Enum
{
    public const INACTIVE = -1;
    public const ACTIVE = 1;

    public static function getDescription($value): string
    {
        if ($value === self::ACTIVE) {
            return __('Active');
        }

        if ($value === self::INACTIVE) {
            return __('Inactive');
        }

        return parent::getDescription($value);
    }
}
