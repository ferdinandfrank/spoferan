<?php

namespace App\Console\Commands;

use App\Mail\TestMail;
use Exception;

/**
 * SendTestEmail
 * -----------------------
 * Console command to send a test email to an email address.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Console\Commands
 */
class SendTestEmail extends BaseCommand {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send 
                            {email? : Specify the receiver email address.}
                            {--queue : Specify if the email shall be sent within a queue.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to an email address';

    /**
     * Executes the console command.
     */
    public function handle() {
        $emailAddress = $this->argument('email') ?? config('mail.from.address');
        $mail = new TestMail();

        $onQueue = $this->option('queue');
        try {
            if ($onQueue) {
                \Mail::to($emailAddress)->queue($mail->onQueue('emails'));
                $this->logger->success("A test email has been successfully put on the queue 'emails' and 
                will be sent to $emailAddress as soon as the queue worker has processed the email.");
            } else {
                \Mail::to($emailAddress)->send($mail);
                $this->logger->success("A test email has been successfully sent to $emailAddress.");
            }
        } catch (Exception $exception) {
            $this->logger->error("The following error occurred while trying to send a test email to $emailAddress: "
                                 . $exception->getMessage());
        }
    }
}
