<?php

namespace FireAZ\Location\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class UpdateLocation extends Command
{
    protected $name = 'local:update';


    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['type', 't', InputOption::VALUE_OPTIONAL, 'Recreate existing symbolic targets.', 'module'],
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {

        return 0;
    }
}
