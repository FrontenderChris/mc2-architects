<?php

namespace App\Console\Commands;

use App\Models\Settings;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class ModulatteInstall extends Command
{
    protected $modulatteDirs = [];
    protected $signature = 'modulatte:install {--provider=} {--tag=}';
    protected $description = 'Run Modulatte migrations and publish mandatory files.';

    /**
     * @return mixed
     */
    public function handle()
    {
        $this->generateKey();
        $this->setModulatteDirs();
        $this->migrate();
        $this->publish();
        $this->settings();
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['provider', null, InputOption::VALUE_REQUIRED, 'Optional provider for vendor:publish command.'],
            ['tag', null, InputOption::VALUE_REQUIRED, 'Optional tag for vendor:publish command.'],
        ];
    }

    /**
     *
     */
    private function generateKey()
    {
        if ($this->hasEnvFile()) {
            if (env('APP_KEY') == 'SomeRandomString' || empty(env('APP_KEY'))) {
                $this->call('key:generate');
            }
        }
    }

    /**
     *
     */
    private function migrate()
    {
        if ($this->hasEnvFile()) {
            $composer = $this->getComposer();
            foreach ($this->modulatteDirs as $folder) {
                // todo: This block can be removed when all packages migrations have been moved into the /database/migrations folder
                $migrationsDir = $folder . '/src/migrations';
                if (\File::isDirectory($migrationsDir)) {
                    $relativeDir = $this->relativeDir($migrationsDir);
                    $this->runMigration($relativeDir);
                    $this->updateComposer($relativeDir, $composer->autoload->classmap);
                }

                $migrationsDir = $folder . '/src/database/migrations';
                if (\File::isDirectory($migrationsDir)) {
                    $relativeDir = $this->relativeDir($migrationsDir);
                    $this->runMigration($relativeDir);
                    $this->updateComposer($relativeDir, $composer->autoload->classmap);
                }
            }

            $this->call('migrate', ['--force' => true]);
        }
    }

    /**
     * @param string $tag
     */
    private function publish($tag = 'mandatory')
    {
        if ($this->option('tag'))
            $tag = $this->option('tag');

        if ($provider = $this->option('provider')) {
            $this->info('Publishing vendor files for "' . $provider . '"...');
            $this->call('vendor:publish', ['--tag' => [$tag], '--provider' => $provider]);
        } else {
            $this->info('Publishing vendor files...');
            $this->call('vendor:publish', ['--tag' => [$tag]]);
        }
    }

    private function settings()
    {
        if ($this->hasEnvFile()) {
            Settings::checkSettingsExist();
        }
    }

    /**
     * @param $migrationDir
     * @param $classmap
     */
    private function updateComposer($migrationDir, $classmap)
    {
        if (!in_array($migrationDir, $classmap)) {
            $composer = $this->getComposer();
            $composer->autoload->classmap[] = $migrationDir;
            $this->setComposer($composer);
        }
    }

    /**
     * @return mixed
     */
    private function getComposer()
    {
        return json_decode(file_get_contents(base_path('composer.json')));
    }

    /**
     * @param $data
     * @return int
     */
    private function setComposer($data)
    {
        return file_put_contents(base_path('composer.json'), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * @param $dir
     * @return mixed
     */
    private function relativeDir($dir)
    {
        if (strpos($dir, 'vendor') !== false)
            return str_replace('\\', '/', substr($dir, strpos($dir, 'vendor')));

        return str_replace('\\', '/', substr($dir, strpos($dir, 'packages')));
    }

    /**
     * @param $relativeDir
     */
    private function runMigration($relativeDir)
    {
        $this->info('Checking migrations in ' . $relativeDir . '...');
        $this->call('migrate', ['--path' => $relativeDir, '--force' => true]);
    }

    /**
     *
     */
    private function setModulatteDirs()
    {
        $modulattePath = base_path('vendor/modulatte');
        if (\File::isDirectory($modulattePath)) {
            foreach (\File::directories($modulattePath) as $folder) {
                $this->modulatteDirs[] = $folder;
            }
        }

        $packagesPath = base_path('packages/modulatte');
        if (\File::isDirectory($packagesPath)) {
            foreach (\File::directories($packagesPath) as $folder) {
                $this->modulatteDirs[] = $folder;
            }
        }
    }

    /**
     * @return string
     */
    private function hasEnvFile()
    {
        return file_exists(base_path() . '/.env');
    }
}
