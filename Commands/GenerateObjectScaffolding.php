<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class GenerateObjectScaffolding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:scaffolding {name}';

    protected $template_controller = '';
    protected $template_model = '';
    protected $template_view_view = '';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate object scaffolding';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // load template files for use
        $this->template_controller = File::get(app_path('Console/Commands/templates/controller.tpl'));
        $this->template_model = File::get(app_path('Console/Commands/templates/model.tpl'));
        $this->template_view_view = File::get(app_path('Console/Commands/templates/view-view.tpl'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // define name
        $name = $this->argument('name');
        $name_variations = [
            'lower' => $name,
            'plural' => $name .'s',
            'upper' => ucfirst($name)
        ];

        // start work
        $this->info('Generating object scaffolding for: '. $name);

        // generate controller file
        $this->info('Generating controller file: '. $name_variations['upper'] .'Controller.php');
        $converted_controller = preg_replace('/\{\{(nameLower)\}\}/', $name_variations['lower'], $this->template_controller);
        $converted_controller = preg_replace('/\{\{(namePlural)\}\}/', $name_variations['plural'], $converted_controller);
        $converted_controller = preg_replace('/\{\{(nameUpper)\}\}/', $name_variations['upper'], $converted_controller);
        $file_controller = File::put(app_path('Http/Controllers/') . $name_variations['upper'] .'Controller.php', $converted_controller);

        // generate model file
        $this->info('Generating model file: '. $name_variations['upper'] .'.php');
        $converted_model = preg_replace('/\{\{(nameUpper)\}\}/', $name_variations['upper'], $this->template_model);
        $file_model = File::put(app_path('Models/') . $name_variations['upper'] .'.php', $converted_model);

        // create view directory
        $this->info('Generating view directory:');
        $view_directory_created = File::makeDirectory(resource_path('views/'. $name_variations['plural']));

        // generate view files
        $this->info('Generating view files:');
        $converted_view_view = preg_replace('/\{\{(nameLower)\}\}/', $name_variations['lower'], $this->template_view_view);
        $converted_view_view = preg_replace('/\{\{(namePlural)\}\}/', $name_variations['plural'], $converted_view_view);
        $file_view_single = File::put(resource_path('views/'. $name_variations['plural'] .'/') .'view.blade.php', $converted_view_view);
    }
}
