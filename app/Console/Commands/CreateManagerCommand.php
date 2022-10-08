<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Validator;

class CreateManagerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manager:make {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make user a manager';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $validated = Validator::validate(array_merge($this->arguments(), $this->options()), [
                'email' => 'required|email|exists:users,email',
            ]);

            $user = User::where('email', '=', $validated['email'])
                ->firstOrFail();

            $user->role = User::ROLE_MANAGER;
            $user->update();

        } catch (ModelNotFoundException $exception) {

            $this->error($exception->getMessage());
            return false;

        } catch (ValidationException $exception) {

            $this->error($exception->getMessage());
            return false;

        }

        $this->info('Success Create Manager');
        return true;
    }
}
