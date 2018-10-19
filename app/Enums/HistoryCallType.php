<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class HistoryCallType extends Enum
{
    public const MANUAL = 1;
    public const HISTORY = 2;
    public const CALLBACK = 3;
    public const APPOINTMENT = 4;
}
