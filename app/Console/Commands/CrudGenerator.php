<?php

namespace App\Console\Commands;


use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class CrudGenerator extends Command
{

    protected $signature = 'crud:generator 
    {name : Class (singular) for example User}
    {--c= : create Controller folder}
    {--m= :  create model folder}
    {--v= :  create views folder} ';

    protected $description = 'Create CRUD operations ';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $controller = $this->option('c');
        $model = $this->option('m');
        $view = $this->option('v'); 

        $name = ($this->argument('name'));

        
        $this->controller($name, $controller, $model, $view);
        $this->model($name, $model);
        $this->request($name);
        
        $controllerUri = strtolower(($controller) ? $controller . '/' : $controller);
        $controller = (($controller) ? $controller . '\\' : $controller);
        
        $controllername = strtolower(str_replace('\\', '.', $controller));


        $this->getViews($name, $view, $controllername );
 
        File::append(base_path('routes/web.php'), "\r\n" . "Route::resource('{$controllerUri}". Str::plural(strtolower($name)) . "', '{$controller}{$name}Controller', ['names' => '{$controllername}".strtolower($name)."']);");

        $files = scandir(database_path("/migrations"));
        $fileName = '';
        foreach ($files as $file) {
            if (strpos($file, 'create_' . strtolower(Str::plural($name)) . '_') !== false) {
                $fileName = $file;
            }
        }
        File::delete(database_path("/migrations/{$fileName}"));
        

        if ($this->confirm(' Proceed with the migration creation?')) {
            Artisan::call('make:migration create_' . strtolower(Str::plural($name)) . '_table --create=' . strtolower(Str::plural($name)));
            $this->info("successfully created Migration");
            
        }
         

        $this->info("completed successfully.");
    }


    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }
    protected function getViews($name, $view = null, $controllername = null)
    {
        $TemplateIndex = str_replace(
            [
                '{{Name}}',
                '{{NamePluralUpperCase}}',
                '{{NamePluralLowerCase}}',
                '{{NameSingularLowerCase}}',
                '{{view}}',
                '{{controllername}}'
            ],
            [
                $name,
                ucfirst(Str::plural($name)),
                strtolower(Str::plural($name)),
                strtolower($name),
                $view,
                $controllername,
            ],
            $this->getStub('views\index')
        );
        $TemplateEdit = str_replace(
            [
                '{{Name}}',
                '{{NamePluralUpperCase}}',
                '{{NamePluralLowerCase}}',
                '{{NameSingularLowerCase}}',
                '{{view}}',
                '{{controllername}}'
            ],
            [
                $name,
                ucfirst(Str::plural($name)), 
                strtolower(Str::plural($name)), 
                strtolower($name),
                $view,
                $controllername,
            ],
            $this->getStub('views\edit')
        );
        $TemplateCreate = str_replace(
            [
                '{{Name}}',
                '{{NamePluralUpperCase}}',
                '{{NamePluralLowerCase}}',
                '{{NameSingularLowerCase}}',
                '{{view}}',
                '{{controllername}}'
            ],
            [
                $name,
                ucfirst(Str::plural($name)),
                strtolower(Str::plural($name)),
                strtolower($name),
                $view,
                $controllername,
            ],
            $this->getStub('views\create')
        );
        $TemplateShow = str_replace(
            [
                '{{Name}}',
                '{{NamePluralUpperCase}}',
                '{{NamePluralLowerCase}}',
                '{{NameSingularLowerCase}}',
                '{{view}}',
                '{{controllername}}'
            ],
            [
                $name,
                ucfirst(Str::plural($name)),
                strtolower(Str::plural($name)),
                strtolower($name),
                $view,
                $controllername,
            ],
            $this->getStub('views\show')
        );



        // print_r($modelTemplate);
        $viewsFolder = "/";
        if ($view != null) {
            $viewsFolder .= $view . '/';
        }
        $viewsFolder .= $name . '/';
        if (!file_exists($path = resource_path("views/" . $viewsFolder)))
            mkdir($path, 0777, true);

        File::delete(resource_path("views/{$viewsFolder}create.blade.php"));
        File::delete(resource_path("views/{$viewsFolder}index.blade.php"));
        File::delete(resource_path("views/{$viewsFolder}show.blade.php"));
        File::delete(resource_path("views/{$viewsFolder}update.blade.php"));



        file_put_contents(resource_path("views/{$viewsFolder}create.blade.php"), $TemplateCreate);
        file_put_contents(resource_path("views/{$viewsFolder}index.blade.php"), $TemplateIndex);
        file_put_contents(resource_path("views/{$viewsFolder}show.blade.php"), $TemplateShow);
        file_put_contents(resource_path("views/{$viewsFolder}edit.blade.php"), $TemplateEdit);
    }
    protected function model($name, $model = null)
    {


        $modelFolder = "/";
        if ($model != null) {
            $modelFolder .= $model . '/';
            if (!file_exists($path = app_path($modelFolder)))
                mkdir($path, 0777, true);
            File::delete(app_path("{$modelFolder}/{$name}.php"));
        }

        $modelTemplate = str_replace(
            ['{{modelName}}', '{{model}}'],
            [
                $name,
                ($model) ? '\\' . $model : '',
            ],
            $this->getStub('Model')
        );

        file_put_contents(app_path("{$modelFolder}{$name}.php"), $modelTemplate);
        $this->info("successfully created Model");
    }

    protected function request($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );

        if (!file_exists($path = app_path('/Http/Requests')))
            mkdir($path, 0777, true);

        File::delete(app_path("/Http/Requests/{$name}Request.php"));

        file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $requestTemplate);
        $this->info("successfully created Request");
    }


    protected function controller($name, $controller = null, $model = null, $view = null)
    {

        $controllerFolder = '/';
        if ($controller != null) {
            $controllerFolder .= $controller . '/';
        }

        if (!file_exists($path = app_path('/Http/Controllers/' . $controllerFolder)))
            mkdir($path, 0777, true);
        File::delete(app_path("{$controllerFolder}{$name}.php"));


        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{controller}}',
                '{{model}}',
                '{{view}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
                '{{ifController}}'
            ],
            [
                $name,
                $controller ? '\\' . $controller : '',
                ($model) ? $model . '\\' : '',
                strtolower(($view) ? str_replace('\\', '.', $view) . '.' : ''),
                strtolower(Str::plural($name)),
                strtolower($name),
                $controller ? "use App\Http\Controllers\Controller;" : '',
            ],
            $this->getStub('Controller')
        );



        file_put_contents(app_path("/Http/Controllers/{$controllerFolder}{$name}Controller.php"), $controllerTemplate);

        $this->info("successfully created Controller");
    }
}
