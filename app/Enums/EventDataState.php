<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class EventDataState extends Enum
{
    public const NOT_DEAL = 1;
    public const DEAL = 2;
    public const BUSY = 3;
    public const OVERFLOW = 4;

    public static function getDescription($value): string
    {
        if ($value === self::NOT_DEAL) {
            return __('Not deal');
        }

        if ($value === self::DEAL) {
            return __('Deal');
        }

        if ($value === self::BUSY) {
            return __('Busy');
        }

        if ($value === self::OVERFLOW) {
            return __('Overflow');
        }

        return parent::getDescription($value);
    }
}
