<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Model extends Command
{
    protected $nombreComando = 'make:model';
    protected $descripcionComando = "Crear un modelo";

    protected $argumentoComando = "nombre";
    protected $argumentoComandoDescripcion = "Nombre del modelo";

    protected function configure()
    {
        $this
            ->setName($this->nombreComando)
            ->setDescription($this->descripcionComando)
            ->addArgument(
                $this->argumentoComando,
                InputArgument::REQUIRED,
                $this->argumentoComandoDescripcion
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nombreModelo = $input->getArgument($this->argumentoComando);
        $modelo = fopen('app/Models/' . $nombreModelo . ".php", "w");
        if ($modelo == null) {
            $output->writeln("<error>Ocurrio un error al crear el modelo.</error>");
            return Command::FAILURE;
        }
        $contenido = "<?php
        
namespace Models;

use \Illuminate\Database\Eloquent\Model;

class " . $nombreModelo . " extends Model
{
    protected \$table = '" . $nombreModelo . "';
}";
        fwrite($modelo, $contenido);
        fclose($modelo);
        $output->writeln("<info>Modelo creado con exito.</info>");
        return Command::SUCCESS;
    }
}