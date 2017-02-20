<?php

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Console\OutputStyle;

/**
 * ConsoleLogger
 * -----------------------
 * Prints messages to the console.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Console
 */
class ConsoleLogger {

    /**
     * The console for ConsoleLogger.
     *
     * @var Command
     */
    private $console;

    /**
     * The output style for ConsoleLogger.
     *
     * @var OutputStyle
     */
    private $output;

    /**
     * Creates a new ConsoleLogger instance.
     *
     * @param Command     $console
     * @param OutputStyle $output
     */
    public function __construct(Command $console, OutputStyle $output) {
        $this->console = $console;
        $this->output = $output;
    }

    /**
     * Prints a success message on the console with the specified text.
     *
     * @param $message
     */
    public function success($message) {
        $this->console->info(PHP_EOL . "✔ Success! $message");
    }

    /**
     * Prints an error message on the console with the specified text.
     *
     * @param $message
     */
    public function error($message) {
        $this->console->error(PHP_EOL . "Sorry! $message");
    }

    /**
     * Prints a message on the console with the specified text.
     *
     * @param $message
     */
    public function line($message) {
        $this->console->line(PHP_EOL . $message);
    }

    /**
     * Prints a comment message on the console with the specified text.
     *
     * @param $message
     */
    public function comment($message) {
        $this->console->comment(PHP_EOL . $message);
    }

    /**
     * Prints an info message on the console with the specified text.
     *
     * @param $message
     */
    public function info($message) {
        $this->console->info(PHP_EOL . "Info: $message");
    }

    /**
     * Prints a progress bar on the console with the specified length.
     *
     * @param $length
     */
    public function progress($length) {
        $bar = $this->output->createProgressBar($length);

        for ($i = 0; $i < $length; $i++) {
            time_nanosleep(0, 200000000);
            $bar->advance();
        }

        $bar->finish();
    }

    /**
     * Prints a table with the specified header and the specified data on the console.
     *
     * @param array $header
     * @param array $data
     */
    public function table(array $header, array $data) {
        $this->console->table($header, $data);
    }

}