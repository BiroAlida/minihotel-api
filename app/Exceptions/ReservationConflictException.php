<?php

namespace App\Exceptions;

use Exception;

class ReservationConflictException extends Exception
{
    public function __construct(
        string $message = 'The room is not available for the selected dates.'
    ) {
        parent::__construct($message);
    }
}