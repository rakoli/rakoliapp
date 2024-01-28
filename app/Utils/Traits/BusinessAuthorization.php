<?php

namespace App\Utils\Traits;

use App\Models\User;

trait BusinessAuthorization
{
    public function isUserAllowed(User $user): bool
    {
        return $user->business_code === $this->business_code;
    }
}
