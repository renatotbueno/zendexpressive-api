<?php

namespace Direction\Console;

ini_set('memory_limit', '-1');

use Jettyn\Core\Console\AbstractConsole;
use Jettyn\Core\ServiceBus\CommandBusInterface;
use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\ColorInterface;
use ZF\Console\Route;

class Rome2RioSaveRoute extends AbstractConsole
{
    const NAME = 'rome2rio:save-route';

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Teste de comando salvar rotas rome2rio')
            ->setRoute('--payload=');
    }

    /**
     * @param Route $route
     * @param AdapterInterface $console
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function execute(Route $route, AdapterInterface $console)
    {
        //$console->writeLine('Comando executado com sucesso via sqs', ColorInterface::GREEN);

        //$console->writeLine('Seu payload: ' . $route->getMatchedParam('payload'), ColorInterface::YELLOW);

        $commandBus = $this->serviceLocator->get(CommandBusInterface::NAME);

        $payload = json_decode($route->getMatchedParam('payload'), true);

        $command = \Direction\Application\Command\Rome2RioSaveRoute::fromArray($payload);
        $commandBus->dispatch($command);
    }
}