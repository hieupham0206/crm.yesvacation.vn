<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserPosition extends Enum
{
    public const TELE_MARKETER = 1;
    public const LEADER = 2;
    public const MANAGER = 3;

    public static function getDescription($value): string
    {
        if ($value === self::TELE_MARKETER) {
            return __('Tele Marketer');
        }

        if ($value === self::LEADER) {
            return __('Leader');
        }

        if ($value === self::MANAGER) {
            return __('Manager');
        }

        return parent::getDescription($value);
    }
}
