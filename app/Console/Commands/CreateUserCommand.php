<?php

namespace App\Console\Commands;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $user['name'] = $this->ask('Enter the user name');
        $user['email'] = $this->ask('Enter the user email');
        $user['password'] = $this->secret('Enter the user password');
        $roleName = $this->choice('Select the user role', ['admin', 'editor'], 1);

        $role = Roles::where('name', $roleName)->first();

        if (! $role) {
            $this->error('Invalid role selected.');

            return;
        }

        $validation = Validator::make(
            $user,
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required'],
            ]

        );

        if ($validation->fails()) {
            $this->error('Validation failed.');
            foreach ($validation->errors()->all() as $error) {
                $this->error($error);
            }

            return;
        }

        // Use a transaction to ensure data integrity && ensure all operations succeed or fail together

        DB::transaction(function () use ($user, $role) {
            $user['password'] = bcrypt($user['password']);
            $newUser = User::create($user);
            $newUser->roles()->attach($role->id);
        });

        $this->info('User created successfully.');
    }
}
