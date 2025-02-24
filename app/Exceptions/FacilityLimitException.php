<?php

namespace App\Exceptions;

class FacilityLimitException extends \Exception
{
    public function getStatusCode()
    {
        return 403;
    }
}
