<?php namespace Tdev\Generators;

use Illuminate\Support\ServiceProvider;

class CommandsServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->registerModelCommand();
        $this->registerControllerRestActionsCommand();
        $this->registerControllerCommand();
        $this->registerRouteCommand();
        $this->registerMigrationCommand();
        $this->registerResourceCommand();
        $this->registerResourcesCommand();
        $this->registerPivotTableCommand();
        $this->registerFactoryCommand();
        // registerSeederCommand
        // registerPivotSeederCommand
        // registerTestCommand
    }

    protected function registerModelCommand(){
        $this->app->singleton('command.tdev.model', function($app){
            return $app['Tdev\Generators\Commands\ModelCommand'];
        });
        $this->commands('command.tdev.model');
    }

    protected function registerControllerRestActionsCommand(){
        $this->app->singleton('command.tdev.controller.rest-actions', function($app){
            return $app['Tdev\Generators\Commands\ControllerRestActionsCommand'];
        });
        $this->commands('command.tdev.controller.rest-actions');
    }

    protected function registerControllerCommand(){
        $this->app->singleton('command.tdev.controller', function($app){
            return $app['Tdev\Generators\Commands\ControllerCommand'];
        });
        $this->commands('command.tdev.controller');
    }

    protected function registerMigrationCommand(){
        $this->app->singleton('command.tdev.migration', function($app){
            return $app['Tdev\Generators\Commands\MigrationCommand'];
        });
        $this->commands('command.tdev.migration');
    }

    protected function registerRouteCommand(){
        $this->app->singleton('command.tdev.route', function($app){
            return $app['Tdev\Generators\Commands\RouteCommand'];
        });
        $this->commands('command.tdev.route');
    }

    protected function registerTestCommand(){
        $this->app->singleton('command.tdev.test', function($app){
            return $app['Tdev\Generators\Commands\TestCommand'];
        });
        $this->commands('command.tdev.test');
    }

    protected function registerResourceCommand(){
        $this->app->singleton('command.tdev.resource', function($app){
            return $app['Tdev\Generators\Commands\ResourceCommand'];
        });
        $this->commands('command.tdev.resource');
    }

    protected function registerResourcesCommand(){
        $this->app->singleton('command.tdev.resources', function($app){
            return $app['Tdev\Generators\Commands\ResourcesCommand'];
        });
        $this->commands('command.tdev.resources');
    }

    protected function registerPivotTableCommand(){
        $this->app->singleton('command.tdev.pivot-table', function($app){
            return $app['Tdev\Generators\Commands\PivotTableCommand'];
        });
        $this->commands('command.tdev.pivot-table');
    }

    protected function registerFactoryCommand(){
        $this->app->singleton('command.tdev.factory', function($app){
            return $app['Tdev\Generators\Commands\FactoryCommand'];
        });
        $this->commands('command.tdev.factory');
    }

    protected function registerSeederCommand(){
        $this->app->singleton('command.tdev.seeder', function($app){
            return $app['Tdev\Generators\Commands\SeederCommand'];
        });
        $this->commands('command.tdev.seeder');
    }

    protected function registerPivotSeederCommand(){
        $this->app->singleton('command.tdev.pivot.seeder', function($app){
            return $app['Tdev\Generators\Commands\PivotSeederCommand'];
        });
        $this->commands('command.tdev.pivot.seeder');
    }

}
