<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\CityRepository;
use App\Repository\DataRepository;
use App\Service\WeatherUtil;

#[AsCommand(
    name: 'weather:location-id',
    description: 'Zwraca dane po id lokacji',
)]
class WeatherLocationIdCommand extends Command
{
    
    // public function __construct(CityRepository $cityRepository, DataRepository $dataRepository, $name = null){
    //     $this->cityRepository = $cityRepository;
    //     $this->dataRepository = $dataRepository;
    //     parent::__construct($name);
    // }
    private WeatherUtil $weatherU;
    public function __construct(WeatherUtil $weatherU, string $name = null)
    {
        parent::__construct($name);
        $this->weatherU = $weatherU;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Lokacja do sprawdzenia')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // $io = new SymfonyStyle($input, $output);
        // $arg1 = $input->getArgument('arg1');

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        $locationId = $input->getArgument('id');

        $results = $this->weatherU->getWeatherForCommand($locationId);

        $output->writeln(json_encode($results, JSON_PRETTY_PRINT));

        return Command::SUCCESS;
    }
}
