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
    private static $modules;

    /**
     * @return array|mixed
     * @throws \Exception
     */
    public static function generate()
    {
        $admins = self::getMenu('admin');
//        $departments = self::getMenu('department');

        $menus = [
            [
                'name'        => __('Admin'),
                'icon'        => 'flaticon-cogwheel',
                'menus'       => $admins,
                'activeClass' => self::setActiveClass($admins)
            ],
//            [
//                'name'        => __('Department'),
//                'icon'        => 'flaticon-calendar-3',
//                'menus'       => $departments,
//                'activeClass' => self::setActiveClass($departments)
//            ]
        ];

        return $menus;
    }

    /**
     * @param $module
     *
     * @return array
     * @throws \ReflectionException
     */
    private static function getMenu($module): array
    {
        if ( ! self::$modules) {
            self::$modules = getMenuConfig();
        }
        $menuModules = self::$modules[$module];

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
        $datas['activeClass'] = self::setActiveClass($datas);

        return $datas;
    }

    /**
     * @param $arrays
     *
     * @return string
     */
    public static function setActiveClass($arrays): string
    {
        return \in_array('m-menu__item--active', collect($arrays)->flatten()->toArray(), true) ? 'm-menu__item--active' : '';
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
        $currentRouteNames = explode('.', \Route::currentRouteName());
        $currentRouteName  = $currentRouteNames[0];
        $className         = studly_case($singularModuleName);
        $labelName         = self::getMenuLabel($menuModule, $className);

        $props = [
            'name'        => $labelName,
            'route'       => \Route::has("{$menuModule}.index") ? route("{$menuModule}.index") : 'javascript:void(0)',
            'activeClass' => $currentRouteName === $menuModule ? 'm-menu__item--active' : '',
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