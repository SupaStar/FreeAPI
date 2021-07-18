<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Server extends Command
{
    protected $nombreComando = 'server';
    protected $descripcionComando = "Iniciar el servidor";

    protected function configure()
    {
        $this
            ->setName($this->nombreComando)
            ->setDescription($this->descripcionComando);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        exec('php -S 127.0.0.1:8000');
        return Command::SUCCESS;
    }
}