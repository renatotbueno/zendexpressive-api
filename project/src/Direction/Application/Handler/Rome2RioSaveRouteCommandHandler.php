<?php

declare(strict_types=1);

namespace Direction\Application\Handler;

use Jettyn\Core\ServiceBus\SimpleCommandHandler;
use Direction\Application\Command\Rome2RioSaveRoute;
use Direction\Application\Service\Rome2RioService;

final class Rome2RioSaveRouteCommandHandler extends SimpleCommandHandler
{
    /** @var  Rome2RioService */
    private $rome2RioService;

    public function __construct(Rome2RioService $rome2RioService)
    {
        $this->rome2RioService = $rome2RioService;
    }

    public function handleRome2RioSaveRoute(Rome2RioSaveRoute $command)
    {
        $this->rome2RioService->save($command);
    }
}