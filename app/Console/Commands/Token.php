<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\AuthController;
use Illuminate\Console\Command;

class Token extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jwt:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retorna o token, facilitando o auth';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = app()->make(AuthController::class);

        request()
            ->merge([
                'email' => 'admin@admin.com',
                'password' => 123456
            ]);

        $logger = $controller->login();
        echo $logger->original['access_token'];
    }
}
