<?php namespace Tdev\Generators\Commands;


class ControllerRestActionsCommand extends BaseCommand {

	protected $signature = 'tdev:controller:rest-actions
		{--force= : override the existing files}';

	protected $description = 'Generates REST actions trait to use into controllers';

    public function handle()
    {
        $content = $this->getTemplate('controller/rest-actions')->get();

        $this->save($content, "./app/Http/Controllers/RESTActions.php", "REST actions trait");
    }

}
