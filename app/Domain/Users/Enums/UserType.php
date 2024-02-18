<?php

namespace App\Domain\Users\Enums;

enum UserType: string
{
    case TVTC_OPERATOR = 'TvtcOperator';
    case ESTABLISHMENT_OPERATOR = 'EstablishmentOperator';
    case TRAINER = 'Trainer';
    case TRAINEE = 'Trainee';
    case INVESTOR = 'Investor';
}
