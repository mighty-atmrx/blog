<?php

namespace App\Application\Post\Exception;

use Exception;

final class PostNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("post_not_found");
    }
}
