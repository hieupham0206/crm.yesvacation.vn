<?php
try {
    Breadcrumbs::for('home', function ($trail) {
        $trail->push(__('Dashboard'), route('home'));
    });

    $routeArr = getRouteConfig();

    $views = collect($routeArr)->flatten();

    $actions = ['index', 'create', 'edit', 'show'];
    foreach ($views as $view) {
        foreach ($actions as $action) {
            if ($action == 'index') {
                Breadcrumbs::for("{$view}.{$action}", function ($trail, $label = null) use ($view) {
                    $trail->parent('home');
                    if ($label) {
                        $labelName = $label;
                    } else {
                        $viewUc    = str_singular(camel2words(ucfirst($view)));
                        if (class_exists("App\\Models\\{$viewUc}")) {
                            $reflect   = new \ReflectionClass("App\\Models\\$viewUc");
                            $labelName = $reflect->getMethod('classLabel')->invoke($reflect->newInstance());
                        } else {
                            $labelName = __($viewUc);
                        }
                    }
                    $trail->push($labelName, route("{$view}.index"));
                });
            } else {
                Breadcrumbs::for("{$view}.{$action}", function ($trail, $params) use ($view, $action) {
                    $model = $params['model'];
                    $label = $params['label'] ?? null;

                    $uppercaseAction = ucfirst($action);
                    $title           = $label ?? __("action.{$uppercaseAction} Model", ['model' => $model->classLabel(true)]);

                    $trail->parent("{$view}.index");
                    $trail->push($title, route("{$view}.{$action}", $model));
                });
            }
        }
    }
} catch (\DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException $e) {
}