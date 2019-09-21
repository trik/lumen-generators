<?php namespace Tdev\Generators\Template;

use Illuminate\Filesystem\Filesystem;
use Tdev\Generators\Exceptions\TemplateException;
use Tdev\Generators\Template\Template;


class TemplateLoader {
	
	protected $fs;

	protected $loaded;

	public function __construct(Filesystem $fs)
	{
		$this->fs = $fs;
		$this->loaded = [];
	}

	public function load($name)
	{
		if(! isset($this->loaded[$name])){
			$path = __DIR__ . "/../../templates/{$name}.wnt";
			try {
				$this->loaded[$name] = $this->fs->get($path);
			} catch(\Exception $e) {
				throw new TemplateException("Unable to read the file '{$path}'");
			}
		}
		return new Template($this, $this->loaded[$name]);
	}

}
