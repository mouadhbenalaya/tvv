<?php

declare(strict_types=1);

namespace App\Common\Enum;

enum ApiStatusEnum: string
{
    case SUPPORTED = 'supported';

    case UNSUPPORTED = 'unsupported';

    case SUNSET = 'sunset';
}
