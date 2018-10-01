<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 4/27/2018
 * Time: 11:07 AM
 */

namespace App\Entities\Core;

/**
 * Class Menu
 *
 * @property $modules
 * @package App\Entities\Core
 */
class Menu
{
    /**
     * @return array|mixed
     * @throws \Exception
     */
    public static function generate()
    {
        $menuModules = getMenuConfig();
        $menus       = [];
        foreach ($menuModules as $moduleKey => $menuModule) {
            if (isset($menuModule['modules'])) {
                $modules = self::getMenu($menuModule['modules']);

                $menus[] = [
                    'name'        => __(ucfirst($moduleKey)),
                    'icon'        => $menuModule['icon'],
                    'menus'       => $modules,
                    'activeClass' => self::getMenuActiveClass($modules)
                ];
            } else {
                $menus[] = [
                    'name'        => __(ucfirst($moduleKey)),
                    'icon'        => $menuModule['icon'],
                    'activeClass' => self::getMenuItemActiveClass($moduleKey),
                    'route'       => route($menuModule['route'])
                ];
            }
        }

        return $menus;
    }

    /**
     * @param $menuModules
     *
     * @return array
     * @throws \ReflectionException
     */
    private static function getMenu($menuModules): array
    {
        return self::buildMenu($menuModules);
    }

    /**
     * @param $menuModules
     *
     * @return array
     * @throws \ReflectionException
     */
    private static function buildMenu($menuModules): array
    {
        $datas = [];
        foreach ($menuModules as $menuModule => $maps) {
            $singularModuleName = lcfirst(studly_case(str_singular($menuModule)));
            $module             = $singularModuleName;

            if (strpos($menuModule, 'logs') !== false) {
                $module = 'log';
            }

            if (can("view-{$module}") || can("create-{$module}")) {
                $datas = self::buildSubMenu($maps ?? [], $menuModule, $singularModuleName, $datas);
            }
        }
        $datas['activeClass'] = self::getMenuActiveClass($datas);

        return $datas;
    }

    /**
     * @param $arrays
     *
     * @return string
     */
    public static function getMenuActiveClass($arrays): string
    {
        return \in_array('m-menu__item--active', collect($arrays)->flatten()->toArray(), true) ? 'm-menu__item--active' : '';
    }

    /**
     * @param $menuModule
     *
     * @return string
     */
    private static function getMenuItemActiveClass($menuModule): string
    {
        $currentRouteNames = explode('.', \Route::currentRouteName());
        $currentRouteName  = $currentRouteNames[0];

        return $currentRouteName === $menuModule ? 'm-menu__item--active' : '';
    }

    /**
     * @param $menuModule
     * @param $className
     *
     * @return string
     * @throws \ReflectionException
     */
    private static function getMenuLabel($menuModule, $className)
    {
        $labelName = __(ucfirst(camel2words(str_singular($menuModule))));
        if (class_exists("App\\Models\\$className")) {
            $reflect = new \ReflectionClass("App\\Models\\$className");
            if ($reflect->hasMethod('classLabel')) {
                $labelName = $reflect->getMethod('classLabel')->invoke($reflect->newInstance());
            }
        }

        return $labelName;
    }

    /**
     * @param $menuMap
     * @param $menuModule
     * @param $singularModuleName
     * @param $datas
     *
     * @return array
     * @throws \ReflectionException
     */
    private static function buildSubMenu($menuMap, $menuModule, $singularModuleName, $datas): array
    {
        $className = studly_case($singularModuleName);
        $labelName = self::getMenuLabel($menuModule, $className);

        $props = [
            'name'        => $labelName,
            'route'       => \Route::has("{$menuModule}.index") ? route("{$menuModule}.index") : 'javascript:void(0)',
            'activeClass' => self::getMenuItemActiveClass($menuModule),
            'icon'        => ''
        ];

        if ( ! $menuMap) {
            $datas[] = $props;

            return $datas;
        }

        if ( ! isset($menuMap['hide']) || (isset($menuMap['hide']) && ! $menuMap['hide'])) {
            $props['icon'] = $menuMap['icon'];
            if ($menuMap['parent'] !== '') {
                $datas[$menuMap['parent']][] = $props;

                return $datas;
            }

            $datas[] = $props;
        }

        return $datas;
    }
}