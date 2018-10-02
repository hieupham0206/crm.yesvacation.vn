<?php /** @noinspection PhpInconsistentReturnPointsInspection */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Class CrudAllCommand
 *
 * php artisan crud:make --crud=brands --namespace=Business --fields=name#string;type#select#options=1_New**2_NotNew --validations=name#required --permissions=view,create,update,delete
 *
 * @package App\Console\Commands
 */
class CrudMakeCommand extends Command
{
    protected $signature = 'crud:make
                            {--crud= : Tên của table trong database.}
                            {--fields= : Tên các column để hiện trong view (Default: --fields=name#string.}
                            {--validations= : Khai báo field validation trong controller. (Default: --validations=name#required).}
                            {--namespace= : Tên namespace của controller (Default: --namespace=Common).}
                            {--permissions= : Quyền của model (Default: --permissions=view,create,update,delete).}
    ';

    protected $description = 'Trigger all CRUD command';

    protected $type = 'CRUD Make';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $cruds = explode(',', $this->option('crud'));

        $namespace  = $this->option('namespace');
        $namespaces = $namespace !== '' ? explode(',', $namespace) : ['Common'];
        $namespaces = array_map('ucfirst', $namespaces);

        foreach ($cruds as $key => $crud) {
            $namespace = $namespaces[$key] ?? $namespace;

            $this->generateCrud($crud, $namespace);
        }

        //Clear cache menu
        \Cache::forget('menu');
    }

    /**
     * @param $crud
     * @param $namespace
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function generateCrud($crud, $namespace)
    {
        $model          = studly_case(str_singular($crud));
        $table          = $crud;
        $controllerName = str_plural($model) . 'Controller';
        $route          = str_plural(snake_case($model));

        //optional
        $fields = $this->option('fields');
        if ($fields == '') {
            $fields = 'name#string';
        }
        $validations = $this->option('validations');
        if ($validations == '') {
            $validations = 'name#required';
        }

        $permissions = $this->hasOption('permissions') ? $this->option('permissions') : '';
        if ($permissions) {
            $permissions = explode(',', $permissions);
        }

        $this->makeRoute($namespace, $table);

        $this->makeMenu($namespace, $table);

        $this->makePermission($namespace, $table, $permissions);

        $this->makeModel($table);

        $this->makeController($crud, $namespace, $controllerName, $model, $validations);

        $this->makeIndexTable($crud, $namespace, $model, $fields);

        $this->makeModelTest($crud, $model);

        $this->makeView($namespace, $route, $fields, $validations);

        $this->makeJs($crud, $namespace, $route, $model);

        $this->makeSeederAndFactory($model);

        $this->makeIdeHelper($model);

        $this->runPermissionSeeder();
    }

    /**
     * Replace the modelName for the given stub.
     *
     * @param  string $stub
     * @param  string $route
     *
     * @return $this
     */
    protected function replaceRoute(&$stub, $route): self
    {
        $stub = str_replace('{{ route }}', $route, $stub);

        return $this;
    }

    /**
     * Replace the modelName for the given stub.
     *
     * @param  string $stub
     * @param  string $modelName
     *
     * @return $this
     */
    protected function replaceModelName(&$stub, $modelName): self
    {
        $stub = str_replace('{{ modelName }}', $modelName, $stub);

        return $this;
    }

    /**
     * Replace the modelName for the given stub.
     *
     * @param  string $stub
     * @param  string $modelName
     *
     * @return $this
     */
    protected function replaceModelNameCap(&$stub, $modelName): self
    {
        $stub = str_replace('{{ modelNameCap }}', ucfirst($modelName), $stub);

        return $this;
    }

    private function makePermission($namespace, $table, $permissions): bool
    {
        $table             = str_singular($table);
        $permissions       = $permissions ?? ['view', 'create', 'update', 'delete'];
        $jsonFile          = base_path() . '/database/files/permissions.json';
        $permissionConfigs = getPermissionConfig();

        $namespace = lcfirst($namespace);
        if ( ! isset($permissionConfigs[$namespace])) {
            $permissionConfigs[$namespace] = [
                'modules' => [
                    $table => [
                        'actions' => $permissions
                    ]
                ]
            ];
            $this->writeJsonConfig($permissionConfigs, $jsonFile);

            return true;
        }

        if ( ! \in_array($table, $permissionConfigs[$namespace], true)) {
            $permissionConfigs[$namespace]['modules'][$table]['actions'] = $permissions;
        }

        $this->info('Make permission successfully');

        return $this->writeJsonConfig($permissionConfigs, $jsonFile);
    }

    private function makeRoute($namespace, $table): bool
    {
        $jsonFile = base_path() . '/routes/routes.json';
        $routes   = getRouteConfig();

        $jsonKey = lcfirst($namespace);
        if ( ! isset($routes[$jsonKey])) {
            $routes[$jsonKey] = [$table];
            $this->writeJsonConfig($routes, $jsonFile);

            return true;
        }

        if ( ! \in_array($table, $routes[$jsonKey], true)) {
            $routes[$jsonKey][] = $table;
        }

        $this->info('Make route successfully');

        return $this->writeJsonConfig($routes, $jsonFile);
    }

    private function makeMenu($namespace, $table): bool
    {
        $jsonFile = base_path() . '/routes/menus.json';
        $menus    = getMenuConfig();

        $jsonKey = lcfirst($namespace);
        if ( ! isset($menus[$jsonKey])) {
            $menus[$jsonKey]['modules'] = [
                $table => [
                    'icon'   => '',
                    'parent' => ''
                ]
            ];
            $this->writeJsonConfig($menus, $jsonFile);

            return true;
        }

        if ( ! \in_array($table, $menus[$jsonKey], true)) {
            $menus[$jsonKey] = [
                'modules' => [
                    $table => [
                        'icon'   => '',
                        'parent' => ''
                    ],
                ],
                'icon'    => ''
            ];
        }

        $this->info('Make menu successfully');

        return $this->writeJsonConfig($menus, $jsonFile);
    }

    /**
     * @param $crud
     * @param $namespace
     * @param $route
     * @param $model
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function makeJs($crud, $namespace, $route, $model): void
    {
        $jsPath = resource_path('js/') . $route;
        if ($namespace !== '') {
            $jsPath = resource_path('js/') . lcfirst($namespace) . '/' . $route;
        }
        $jsPath = str_replace('\\', '/', $jsPath);
        $file   = new Filesystem();
        if ( ! is_dir($jsPath)) {
            $file->makeDirectory($jsPath, 0777, true);
        }
        $jsFiles = ['index.js.stub', 'form.js.stub'];
        foreach ($jsFiles as $jsFile) {
            $fileJsName = str_replace('.stub', '', $jsFile);
            $file       = new Filesystem();
            $stubPath   = str_replace('\\', '/', app_path() . "/Console/stubs/views/js/{$jsFile}");
            $stub       = $file->get($stubPath);

            $this->replaceRoute($stub, $crud)
                 ->replaceModelName($stub, $crud)
                 ->replaceModelNameCap($stub, $model);

            $file->put($jsPath . "/{$fileJsName}", $stub);
        }

        $this->info('Make js folder successfully');
    }

    private function writeJsonConfig($routes, $jsonFile): bool
    {
        $jsondata = json_encode($routes, JSON_PRETTY_PRINT);

        return file_put_contents($jsonFile, $jsondata);
    }

    private function makeSeederAndFactory($model): void
    {
        $this->call('make:seeder', [
            'name' => "{$model}Seeder",
        ]);

        $this->call('make:factory', [
            'name'    => "{$model}Factory",
            '--model' => "App\\Models\\$model"
        ]);
    }

    private function makeController($crud, $namespace, $controllerName, $model, $validations): void
    {
        $this->call('crud:controller', [
            'name'          => $controllerName,
            '--crud'        => $crud,
            '--model'       => $model,
            '--validations' => $validations,
            '--namespace'   => $namespace,
        ]);
    }

    private function makeIndexTable($crud, $namespace, $model, $fields): void
    {
        $this->call('crud:table', [
            'name'        => "{$model}Table",
            '--crud'      => $crud,
            '--model'     => $model,
            '--namespace' => $namespace,
            '--fields'    => $fields,
        ]);
    }

    private function makeModelTest($crud, $model): void
    {
        $this->call('crud:test', [
            'name'    => "{$model}Test",
            '--crud'  => $crud,
            '--model' => $model,
        ]);
    }

    private function makeView($namespace, $route, $fields, $validations): void
    {
        $this->call('crud:view', [
            'name'          => $route,
            '--fields'      => $fields,
            '--validations' => $validations,
            '--view-path'   => $namespace,
        ]);
    }

    private function makeModel($table): void
    {
        $this->call('code:models', [
            '--table' => $table
        ]);
    }

    private function makeIdeHelper($model): void
    {
        exec('composer dump-autoload');

        $this->call('ide-helper:models', [
            'model' => ["App\\Models\\{$model}"],
            '-W'    => true,
            '-R'    => true
        ]);
    }

    private function runPermissionSeeder(): void
    {
        $this->call('db:seed', [
            '--class' => \PermissionSeeder::class
        ]);
    }
}
