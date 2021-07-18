<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Controller extends Command
{
    protected $nombreComando = 'make:controller';
    protected $descripcionComando = "Crear un controlador";

    protected $argumentoComando = "nombre";
    protected $argumentoComandoDescripcion = "Nombre del controlador";

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
        $nombreControlador = $input->getArgument($this->argumentoComando);
        $modelo = fopen('app/Controllers/' . $nombreControlador . "Controller.php", "w");
        if ($modelo == null) {
            $output->writeln("<error>Ocurrio un error al crear el controlador.</error>");
            return Command::FAILURE;
        }
        $contenido = "<?php

namespace Controllers;

class " . $nombreControlador . "Controller
{

}

?>
";
        fwrite($modelo, $contenido);
        fclose($modelo);
        $output->writeln("<info>Controlador creado con exito.</info>");
        return Command::SUCCESS;
    }
}