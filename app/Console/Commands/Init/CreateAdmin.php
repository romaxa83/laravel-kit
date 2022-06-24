<?php

namespace App\Console\Commands\Init;

use App\DTO\User\UserDto;
use App\Models\User\User;
use App\Repositories\User\UserRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'app:create-admin';

    protected $description = 'Create super admin';

    public function handle(UserRepository $repo)
    {
        $dto = UserDto::byArgs([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);

        if($repo->existBy('email', $dto->email)){
            $this->warn("admin exist");
        } else {
            $user = new User();
            $user->name = $dto->name;
            $user->email = $dto->email;
            $user->password = Hash::make($dto->password);
            $user->save();

            $this->info("super admin created");
        }

        $this->info("[✔] - email: {$dto->email}");
        $this->info("[✔] - password: {$dto->password}");
        $this->info("-------------------");
    }
}

