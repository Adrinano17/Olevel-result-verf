<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {email=admin@example.com} {password=password123}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update an admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::firstOrNew(['email' => $email]);
        $user->name = 'Admin User';
        $user->password = $password; // Model will auto-hash due to 'hashed' cast
        $user->role = 'admin';
        $user->save();

        $this->info("Admin user created/updated successfully!");
        $this->info("Email: {$email}");
        $this->info("Password: {$password}");
        $this->info("\nYou can now login with these credentials.");

        return 0;
    }
}






