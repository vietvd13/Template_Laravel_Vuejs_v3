<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;


class MakeResourceCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:resources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Resource class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Resource';

    protected $className = '';
    protected $fileName = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->setRepositoryClass();
        $path = $this->getPath($this->fileName);
        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass($this->fileName));
        $this->info($this->type . ' created successfully.');

        $this->line("<info>Created  :</info> $this->fileName");
    }

    /**
     * Set repository class name
     *
     * @return  void
     */
    private function setRepositoryClass()
    {
        $name = $this->argument('name');
        $this->model = $name;
        $modelClass = $this->qualifyClass($name);
        $this->fileName = $modelClass . $this->type;
        $this->className = $name;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        if (!$this->argument('name')) {
            throw new InvalidArgumentException("Missing required argument model name");
        }

        $stub = parent::replaceClass($stub, $name);
        $stub = str_replace('DummyName', $this->className, $stub);
        $mytime = Carbon::now();
        $stub = str_replace('DummyDate', $mytime->toDateString(), $stub);
        return $stub;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return app_path() . '\Console\stubs\resource.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Resources';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the repository already exists.'],
        ];
    }
}
