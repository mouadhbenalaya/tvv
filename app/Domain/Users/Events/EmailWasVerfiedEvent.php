<?php

namespace App\Domain\Users\Events;

use App\Domain\Users\Models\User;
use Illuminate\Queue\SerializesModels;

class EmailWasVerfiedEvent
{
    use SerializesModels;

    public function __construct(public User $user)
    {
    }
}
