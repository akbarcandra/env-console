<?php

namespace Akbarcandra\EnvConsole\Console\Commands;

use Illuminate\Console\Command;

class SetEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:set {name} {value}
        {name : The environmet variable\'s name.}
        {value : The environment variable\'s value.}
        {--f|force : Skip confirmation when overwriting an existing name.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set environment-specific variables.';

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
        $path = $this->envPath();
        if (file_exists($path) === false) {
            $this->error('Env file doesn\'t exists. Please create one by copy from `.env.exampe`.');
            return;
        }

        $env_name = $this->argument('name');
        $env_value = $this->argument('value');
        $env_var = $env_name.'='.$env_value;

        if (Str::contains(file_get_contents($path), $env_name) === false) {
            // if env name not exists, create new env variable
            file_put_contents($path, PHP_EOL.$env_var.PHP_EOL, FILE_APPEND);
        } else {
            $this->comment('Env variable exists: '.$env_var);
            if ($this->isConfirmed($env_name) === false) {
                $this->comment('Phew... No changes were made to your .env file.');
                return;
            }
            // update existing env variable
            file_put_contents($path, str_replace(
                $env_name.'='.env($env_name),
                $env_var, file_get_contents($path)
            ));
        }
    }

    /**
     * Get the .env file path.
     *
     * @return string
     */
    protected function envPath()
    {
        if (method_exists($this->laravel, 'environmentFilePath')) {
            return $this->laravel->environmentFilePath();
        }
        // check if laravel version Less than 5.4.17
        if (version_compare($this->laravel->version(), '5.4.17', '<')) {
            return $this->laravel->basePath().DIRECTORY_SEPARATOR.'.env';
        }
        return $this->laravel->basePath('.env');
    }

    /**
     * Check if the modification is confirmed.
     *
     * @return bool
     */
    protected function isConfirmed(string $envName)
    {
        return $this->option('force') ? true : $this->confirm(
            'This will overwrite existing env variable. Are you sure you want to override '.$envName.' ?'
        );
    }
}
