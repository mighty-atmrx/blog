<?php

namespace App\Application\User\Exception;

use Exception;

class UserNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('user_not_found');
    }
}
