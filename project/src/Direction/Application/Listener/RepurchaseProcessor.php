<?php

declare(strict_types=1);

namespace Direction\Application\Listener;

use Queuer\Builder\MessageBuilder;
use Direction\Console\DirectionProtheusCreateCommand;
use Direction\Domain\Event\DirectionCreated;
use Broadway\Processor\Processor;
use Direction\Domain\Event\DirectionItemsCreated;
use Direction\Domain\Event\DirectionStatusChanged;

final class DirectionProcessor extends Processor
{
    private $messageBuilder;

    private $config;

    public function __construct(MessageBuilder $messageBuilder, $config)
    {
        $this->config = $config;
        $this->messageBuilder = $messageBuilder;
    }

    public function handleDirectionCreated(DirectionCreated $event)
    {
    }

    public function handleDirectionItemsCreated(DirectionItemsCreated $event)
    {
    }

    public function handleDirectionStatusChanged(DirectionStatusChanged $event)
    {
    }
}