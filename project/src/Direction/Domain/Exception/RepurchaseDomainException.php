<?php

declare(strict_types=1);

namespace Direction\Domain\Exception;

class DirectionDomainException extends \DomainException
{
    protected $message;

    public function __construct($message = "")
    {
        $this->message = $message;
        parent::__construct($message);
    }

    public function getCustomMessage()
    {
        return $this->message;
    }
}