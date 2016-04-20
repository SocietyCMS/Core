<?php

namespace Modules\Core\Console\Installers\Scripts;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Console\Installers\SetupScript;

/**
 * Class AdminUserInstaller.
 */
class AdminUserInstaller implements SetupScript
{
    /**
     * @var Command
     */
    protected $command;

    /**
     * @var Application
     */
    protected $application;

    /**
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->application['env'] = 'local';
    }

    /**
     * Fire the install script.
     *
     * @param Command $command
     *
     * @return mixed
     */
    public function fire(Command $command)
    {
        $this->command = $command;

        if ($command->option('verbose')) {
            $command->blockMessage('User', 'Creating Admin User...', 'comment');
        }

        $this->seedAdminRole();
        $this->createFirstUser();
    }

    /**
     * @return mixed
     */
    public function seedAdminRole()
    {
        if ($this->command->option('verbose')) {
            return $this->command->call('db:seed', ['--class' => 'Modules\User\Database\Seeders\GroupSeedTableSeeder']);
        }

        return $this->command->callSilent('db:seed', ['--class' => 'Modules\User\Database\Seeders\GroupSeedTableSeeder']);
    }

    /**
     * @return mixed
     */
    public function getAdminRole()
    {
        return $this->application->make('Modules\User\Repositories\RoleRepository')->skipCache()->findByField('name', 'admin')->first();
    }

    /**
     * Create a first admin user.
     *
     * @param $adminRoleId
     */
    protected function createFirstUser()
    {
        $info = [
            'first_name' => $this->askForFirstName(),
            'last_name'  => $this->askForLastName(),
            'email'      => $this->askForEmail(),
            'password'   => $this->askForPassword(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        $this->application->make('Modules\User\Repositories\UserRepository')->createWithRoles(
            $info,
            $this->getAdminRole()
        );

        $this->command->info('Admin account created!');
    }

    /**
     * @return string
     */
    private function askForFirstName()
    {
        do {
            $firstname = $this->command->ask('Enter your first name');
            if ($firstname == '') {
                $this->command->error('First name is required');
            }
        } while (! $firstname);

        return $firstname;
    }

    /**
     * @return string
     */
    private function askForLastName()
    {
        do {
            $lastname = $this->command->ask('Enter your last name');
            if ($lastname == '') {
                $this->command->error('Last name is required');
            }
        } while (! $lastname);

        return $lastname;
    }

    /**
     * @return string
     */
    private function askForEmail()
    {
        do {
            $email = $this->command->ask('Enter your email address');
            if ($email == '') {
                $this->command->error('Email is required');
            }
        } while (! $email);

        return $email;
    }

    /**
     * @return string
     */
    private function askForPassword()
    {
        do {
            $password = $this->askForFirstPassword();
            $passwordConfirmation = $this->askForPasswordConfirmation();
            if ($password != $passwordConfirmation) {
                $this->command->error('Password confirmation doesn\'t match. Please try again.');
            }
        } while ($password != $passwordConfirmation);

        return $password;
    }

    /**
     * @return string
     */
    private function askForFirstPassword()
    {
        do {
            $password = $this->command->secret('Enter a password');
            if ($password == '') {
                $this->command->error('Password is required');
            }
        } while (! $password);

        return $password;
    }

    /**
     * @return string
     */
    private function askForPasswordConfirmation()
    {
        do {
            $passwordConfirmation = $this->command->secret('Please confirm your password');
            if ($passwordConfirmation == '') {
                $this->command->error('Password confirmation is required');
            }
        } while (! $passwordConfirmation);

        return $passwordConfirmation;
    }
}
