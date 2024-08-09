<?php

namespace App\Command;

use App\Application\GetAvailabilityPrice;
use App\Infrastructure\Controller\TestAPIClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'lleego:avail',
    description: 'Get flights availability'
)]
class AvailCommand extends Command
{
    private GetAvailabilityPrice $getAvailabilityPrice;
    private TestAPIClient $testAPIClient;

    public function __construct(GetAvailabilityPrice $getAvailabilityPrice, TestAPIClient $testAPIClient)
    {
        parent::__construct();
        $this->getAvailabilityPrice = $getAvailabilityPrice;
        $this->testAPIClient = $testAPIClient;
    }

    protected function configure(): void
    {
        $this->setDescription('Get flights availability')
            ->addArgument('origin', InputArgument::REQUIRED, 'Origin airport code')
            ->addArgument('destination', InputArgument::REQUIRED, 'Destination airport code')
            ->addArgument('date', InputArgument::REQUIRED, 'Flight date (YYYY-MM-DD)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $origin      = $input->getArgument('origin');
        $destination = $input->getArgument('destination');
        $date        = $input->getArgument('date');

        try {
            $segmentsData = $this->getAvailabilityPrice->get($this->testAPIClient, $origin, $destination, $date);
            $this->renderTable($segmentsData, $output);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('<error>Error: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }
    }

    /**
     * @param array $segmentsData The flight data to render.
     * @param OutputInterface $output The console output interface.
     *
     *  Renders the flight data as a table in the console output.
     */
    private function renderTable(array $segmentsData, OutputInterface $output): void
    {
        $table = new Table($output);
        $table->setHeaders([
            'Origin Code',
            'Origin Name',
            'Destination Code',
            'Destination Name',
            'Start',
            'End',
            'Transport Number',
            'Company Code',
            'Company Name'
        ]);

        foreach ($segmentsData as $segment) {
            $table->addRow([
                $segment['originCode'],
                $segment['originName'],
                $segment['destinationCode'],
                $segment['destinationName'],
                $segment['start'],
                $segment['end'],
                $segment['transportNumber'],
                $segment['companyCode'],
                $segment['companyName'],
            ]);
        }

        $table->render();
    }
}
