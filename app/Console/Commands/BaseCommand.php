<?php

namespace App\Console\Commands;

use App\Console\ConsoleLogger;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * BaseCommand
 * -----------------------
 * Base console command class to define methods and vars, that every console class shall share.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Console\Commands
 */
abstract class BaseCommand extends Command {

    /**
     * The logger to print information on the console.
     *
     * @var ConsoleLogger
     */
    protected $logger;

    /**
     * Execute the console command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->logger = new ConsoleLogger($this, $this->output);

        return parent::execute($input, $output);
    }

}