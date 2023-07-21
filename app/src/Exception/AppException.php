<?php

namespace App\Exception;

use Exception;

class AppException extends Exception
{
    private readonly array $context;

    public function setContext(array $context): void
    {
        $this->context = $context;
    }

    protected function getContext(): array
    {
        return $this->context;
    }
}
