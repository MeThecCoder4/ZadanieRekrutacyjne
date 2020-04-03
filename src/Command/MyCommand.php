<?php

namespace App\Command;

use App\Entity\RecruitmentTask;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MyCommand extends Command
{
    protected static $defaultName = 'app:comp-series-max';

    protected function configure()
    {
        $this->setDescription("Computes max element value of recruitment task series.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputValues = [];

        // Read input data
        while($value = (int)(trim(fgets(STDIN)))) {
            $inputValues[] = $value;
        }

        $output->writeln("Output:");

        // Print result
        foreach($inputValues as $v) {
            $maxOfSeq = (new RecruitmentTask())->getMaxOfSeries($v);

            $output->writeln("S(".$v.") = "
                .($maxOfSeq == -1 ? "undefined" : $maxOfSeq));
        }

        return 0;
    }
}