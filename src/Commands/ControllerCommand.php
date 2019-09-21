<?php namespace Tdev\Generators\Commands;


use InvalidArgumentException;
use Illuminate\Support\Str;

class ControllerCommand extends BaseCommand {

	protected $signature = 'tdev:controller
        {model : Name of the model (with namespace if not App)}
		{--no-routes= : without routes}
        {--force= : override the existing files}
        {--laravel : Use Laravel style route definitions}
    ';

	protected $description = 'Generates RESTful controller using the RESTActions trait';

    public function handle()
    {
    	$model = $this->argument('model');
    	$name = '';
    	if(strrpos($model, "\\") === false){
    		$name = $model;
    		$model = "App\\" . $model;
    	} else {
    		$name = explode("\\", $model);
    		$name = $name[count($name) - 1];
    	}
        $controller = ucwords(Str::plural($name)) . 'Controller';
        $content = $this->getTemplate('controller')
        	->with([
        		'name' => $controller,
        		'model' => $model
        	])
        	->get();

        $this->save($content, "./app/Http/Controllers/{$controller}.php", "{$controller}");
        if(! $this->option('no-routes')){
            $options = [
                'resource' => Str::snake($name, '-'),
                '--controller' => $controller,
            ];

            if ($this->option('laravel')) {
                $options['--laravel'] = true;
            }

            $this->call('tdev:route', $options);
        }
    }

}
