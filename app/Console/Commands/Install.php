<?php

namespace App\Console\Commands;

use App\Console\ConsoleLogger;
use App\Models\Admin;
use App\Models\Settings;
use App\Models\User;
use Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

/**
 * Install Command
 * -----------------------
 * Console command to install the page with all the mandatory information and setting.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Console\Commands
 */
class Install extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure the page.';

    /**
     * The logger to print information on the console.
     *
     * @var ConsoleLogger
     */
    private $logger;

    /**
     * Executes the console command.
     */
    public function handle() {
        $this->logger = new ConsoleLogger($this, $this->output);

        $this->logger->comment('Welcome to the page installation! You\'ll be up and running in no time...');

        if ($this->confirm('Do you wish to setup the page? If it was already setup all of your database tables will be reset.')) {
            $this->setupDatabase();
            $this->setupPageInformation();
            $this->setupApplicationKey();
            $this->setupAdditionalSettings();
            $this->seedDatabase();
            $this->finishSetup();
        }
    }

    /**
     * Migrates the database tables.
     */
    private function setupDatabase() {
        $this->logger->comment('Creating the database tables...');

        Artisan::call('migrate:refresh');

        $this->logger->progress(16);
        $this->logger->success('Your database tables are set up and configured.');
    }

    /**
     * Setups the page with all the mandatory information.
     */
    private function setupPageInformation() {
        $this->comment(PHP_EOL . 'Please provide the following information. Don\'t worry, you can always change these settings later from the dashboard.');

        // Super Admin User
        $this->comment(PHP_EOL . 'Step 1/4: Creating the first admin user');
        $this->setupAdmin();

        // Page Title
        $pageTitle = $this->ask('Step 2/4: Title of your page');
        $this->savePageInfo('title', $pageTitle);

        // Page Subtitle
        $pageSubtitle = $this->ask('Step 3/4: Subtitle of your page', false);
        $this->savePageInfo('subtitle', $pageSubtitle);

        // Page Contact email address
        $pageEmail = $this->ask('Step 4/4: The contact email address to use for the contact form', false);
        $this->savePageInfo('email', $pageEmail);
        $this->savePageInfo('email_technical', $pageEmail);

    }

    /**
     * Saves the specified setting value for the page under the specified setting name.
     *
     * @param $settingName
     * @param $settingValue
     */
    private function savePageInfo($settingName, $settingValue) {
        $this->saveSetting($settingName, $settingValue, "$settingName of the page");
    }

    /**
     * Saves the specified setting value under the specified setting name.
     *
     * @param        $settingName
     * @param        $settingValue
     * @param string $consoleName
     */
    private function saveSetting($settingName, $settingValue, $consoleName = 'setting') {
        $this->comment("Saving $settingName ...");
        $settings = new Settings();

        if (empty($settingValue)) {
            $settingValue = null;
        }

        $settings->key = $settingName;
        $settings->value = $settingValue;
        $settings->save();
        $this->logger->progress(1);
        $closingText = ".";
        if (!empty($settingValue)) {
            $closingText = " to '$settingValue'.";
        }
        $this->logger->success("The $consoleName has been saved$closingText");
    }

    private function setupAdmin() {
        $emailRules = ['email' => 'unique:users,email'];
        do {
            $email = $this->ask('Email address for the user');
            $validator = Validator::make(['email' => $email], $emailRules);
            if ($invalidEmail = $validator->fails()) {
                $this->error('That email already exists in the system.');
            }
        } while ($invalidEmail);

        $passwordRules = ['password' => 'confirmed'];
        do {
            $password = $this->secret('Password for the user');
            $passwordConfirmation = $this->secret('Confirm the password for the user');
            $validator = Validator::make(['password' => $password, 'password_confirmation' => $passwordConfirmation],
                $passwordRules);
            if ($invalidPassword = $validator->fails()) {
                $this->error('The passwords do not match.');
            }
        } while ($invalidPassword);

        $firstName = $this->ask('First name for the user');
        $lastName = $this->ask('Last name for the user');
        $user = $this->createUser($email, $password, \Config::get('starmee.user_type.admin'));
        $admin = $this->createAdmin($user, $firstName, $lastName);
        $this->logger->success("The admin $admin->display_name has been created.");

        $this->savePageInfo('author', $admin->display_name);
    }

    private function createUser($email, $password, $userType = 0) {
        $user = new User();
        $user->email = $email;
        $user->password = $password;
        $user->user_type = $userType;
        $user->confirmed = true;
        $user->verified = true;
        $user->save();

        $this->logger->comment('Saving user information...');
        $this->logger->progress(1);

        return $user;
    }

    private function createAdmin(User $user, $firstName, $lastName) {
        $admin = new Admin();
        $admin->first_name = $firstName;
        $admin->last_name = $lastName;
        $admin->display_name = $firstName . " " . $lastName;
        return $user->admin()->save($admin);
    }

    private function seedDatabase() {
        $this->logger->comment('Seeding the database...');
        Artisan::call('db:seed');
        $this->logger->progress(3);
        $this->logger->success('The database has been filled with fake data.');
    }

    private function setupApplicationKey() {
        $this->logger->comment('Creating a unique application key...');
        Artisan::call('key:generate');
        $this->logger->progress(5);
        $this->logger->success('A unique application key has been generated.');
    }

    private function setupAdditionalSettings() {
        $this->savePageInfo('description', null);
        $this->savePageInfo('description_short', null);
        $this->savePageInfo('seo_keywords', null);
        $this->savePageInfo('logo', asset('images/logo.png'));
        $this->savePageInfo('background', asset('images/background.jpg'));
        $this->savePageInfo('favicon', asset('images/favicon.png'));
        $this->savePageInfo('imprint', null);
        $this->savePageInfo('facebook', null);
        $this->savePageInfo('twitter', null);
        $this->savePageInfo('instagram', null);
    }

    private function finishSetup() {
        $this->logger->success('The page has been installed. Pretty easy huh?' . PHP_EOL);

        $headers = ['Login Email', 'Login Password'];
        $data = User::select('email', 'password')->get()->toArray();
        $data[0]['password'] = 'Your chosen password.';
        $this->logger->table($headers, $data);
    }

}
