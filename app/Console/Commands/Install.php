<?php

namespace App\Console\Commands;

use App\Console\ConsoleLogger;
use App\Models\Admin;
use App\Models\PaymentDetails;
use App\Models\Settings;
use App\Models\User;
use Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Schema;
use Symfony\Component\Console\Input\InputOption;

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
     * The name of the console command.
     *
     * @var string
     */
    protected $name = 'page:install';

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
     * The admin to insert during the install.
     *
     * @var User
     */
    private $admin;

    /**
     * The setting names to save during the install.
     *
     * @var array
     */
    private $settings = [
        'title'             => null,
        'subtitle'          => null,
        'email'             => null,
        'email_technical'   => null,
        'description'       => null,
        'description_short' => null,
        'seo_keywords'      => null,
        'logo'              => null,
        'background'        => null,
        'favicon'           => null,
        'imprint'           => null,
        'facebook'          => null,
        'twitter'           => null,
        'instagram'         => null,
    ];

    /**
     * States if old available date shall be kept in the database.
     *
     * @var boolean
     */
    private $keepOldData;

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions() {
        return [
            ['keep', 'k', InputOption::VALUE_NONE, 'Keep old available data.'],
        ];
    }

    /**
     * Executes the console command.
     */
    public function handle() {
        $this->logger = new ConsoleLogger($this, $this->output);

        $this->keepOldData = !!$this->option('keep');

        $this->logger->comment('Welcome to the page installation! You\'ll be up and running in no time...');

        $extraConfirmInfo = $this->keepOldData
            ? "You've set the option to keep the old data, so your old data from the database will be kept if it exists."
            : "If it was already setup all of your database tables will be reset.";
        if ($this->confirm("Do you wish to setup the page? $extraConfirmInfo")
        ) {
            $this->saveOldData();
            $this->resetStripeData();
            $this->setupDatabase();
            $this->setupPageInformation();
            $this->setupApplicationKey();
            $this->setupAdditionalSettings();
            $this->seedDatabase();
            $this->finishSetup();
        }
    }

    /**
     * Save the old data.
     */
    private function saveOldData() {
        if ($this->keepOldData) {

            // Save settings
            if (Schema::hasTable('settings')) {
                foreach ($this->settings as $settingName => $settingValue) {
                    if (empty($settingValue)) {
                        $this->settings[$settingName] = Settings::getByName($settingName);
                    }
                }
            }

            // Save the admin
            if (Schema::hasTable('admins')) {
                if (empty($this->admin)) {
                    $this->admin = User::with('admin')->first();
                }
            }
        }
    }

    private function resetStripeData() {
        if (Schema::hasTable('payment_details')) {
            foreach (PaymentDetails::all() as $paymentDetails) {
                $stripeObject = null;
                switch ($paymentDetails->object) {
                    case 'account':
                        $stripeObject = \Stripe\Account::retrieve($paymentDetails->stripe_id);
                        break;
                    case 'customer':
                        $stripeObject = \Stripe\Customer::retrieve($paymentDetails->stripe_id);
                        break;
                }

                if ($stripeObject && $stripeObject->email) {
                    $stripeObject->delete();
                }
            }
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
        $this->logger->comment('Please provide the following information. Don\'t worry, you can always change these settings later from the dashboard.');

        // Super Admin User
        $steps = $this->keepOldData ? 1 : 4;
        $this->logger->comment("Step 1/$steps: Creating the first admin user");
        $this->setupAdmin();

        // Page Title
        $pageTitle = $this->settings['title'] ?? $this->ask('Step 2/4: Title of your page');
        $this->savePageInfo('title', $pageTitle);

        // Page Subtitle
        $pageSubtitle = $this->settings['subtitle'] ?? $this->ask('Step 3/4: Subtitle of your page', false);
        $this->savePageInfo('subtitle', $pageSubtitle);

        // Page Contact email address
        $pageEmail = $this->settings['email'] ??
                     $this->ask('Step 4/4: The contact email address to use for the contact form', false);
        $technicalEmail = $this->settings['email_technical'] ?? $pageEmail;
        $this->savePageInfo('email', $pageEmail);
        $this->savePageInfo('email_technical', $technicalEmail);

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
        $this->logger->comment("Saving $settingName ...");
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

        // Check if old admin data exists, if not ask for information
        if (empty($this->admin)) {

            // Get the email address of the admin
            $emailRules = ['email' => 'unique:users,email'];
            do {
                $email = $this->ask('Email address for the user');
                $validator = Validator::make(['email' => $email], $emailRules);
                if ($invalidEmail = $validator->fails()) {
                    $this->logger->error('That email already exists in the system.');
                }
            } while ($invalidEmail);

            // Get the name of the admin
            $firstName = $this->ask('First name for the user');
            $lastName = $this->ask('Last name for the user');
        } else {

            // Fetch the admin data from the old data
            $email = $this->admin->email;
            $firstName = $this->admin->admin->first_name;
            $lastName = $this->admin->admin->last_name;

            $this->logger->info("Old admin data with email '$email' retrieved from database. You just have to enter your password again.");
        }

        // Ask for the password, no matter if old data existed
        $passwordRules = ['password' => 'confirmed'];
        do {
            $password = $this->secret('Password for the user');
            $passwordConfirmation = $this->secret('Confirm the password for the user');
            $validator = Validator::make(['password' => $password, 'password_confirmation' => $passwordConfirmation],
                $passwordRules);
            if ($invalidPassword = $validator->fails()) {
                $this->logger->error('The passwords do not match.');
            }
        } while ($invalidPassword);

        $user = $this->createUser($email, $password, config('spoferan.user_type.admin'));
        $admin = $this->createAdmin($user, $firstName, $lastName);
        $this->logger->success("The admin $admin->display_name has been created.");

        $this->savePageInfo('author', $admin->display_name);
    }

    private function createUser($email, $password, $userType) {
        $user = new User();
        $user->email = $email;
        $user->password = $password;
        $user->current_user_type = $userType;
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
        $this->savePageInfo('description', $this->settings['description']);
        $this->savePageInfo('description_short', $this->settings['description_short']);
        $this->savePageInfo('seo_keywords', $this->settings['seo_keywords']);
        $this->savePageInfo('logo', $this->settings['logo'] ?? '/images/logo.png');
        $this->savePageInfo('background', $this->settings['background'] ?? '/images/background.jpg');
        $this->savePageInfo('favicon', $this->settings['favicon'] ?? '/images/favicon.png');
        $this->savePageInfo('imprint', $this->settings['imprint']);
        $this->savePageInfo('facebook', $this->settings['facebook']);
        $this->savePageInfo('twitter', $this->settings['twitter']);
        $this->savePageInfo('instagram', $this->settings['instagram']);
    }

    private function finishSetup() {
        $this->logger->success('The page has been installed. Pretty easy huh?' . PHP_EOL);

        $headers = ['Login Email', 'Login Password'];
        $data = User::select('email', 'password')->get()->toArray();
        $data[0]['password'] = 'Your chosen password.';
        $this->logger->table($headers, $data);
    }

}
