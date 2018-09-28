<?php
if ( ! function_exists('dateranges')) {
    /**
     * @param $start
     * @param $end
     * @param string $format
     *
     * @return array
     * @throws Exception
     */
    function dateranges($start, $end, $format = 'd-m-Y')
    {
        $array    = array();
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

        foreach ($period as $date) {
            $array[] = $date->format($format);
        }

        return $array;
    }
}

if ( ! function_exists('camel2words')) {
    /**
     * For example, 'PostTag' will be converted to 'Post Tag'.
     *
     * @param $name
     *
     * @return string
     */
    function camel2words($name)
    {
        $label = strtolower(trim(str_replace([
            '-',
            '_',
            '.',
        ], ' ', preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $name))));

        return $label;
    }
}

if ( ! function_exists('getRouteConfig')) {
    /**
     * Lấy nội dung file routes.json
     *
     * @return stdClass
     */
    function getRouteConfig()
    {
        $json = file_get_contents(base_path() . '/routes/routes.json');

        /** @noinspection PhpComposerExtensionStubsInspection */
        return json_decode($json, JSON_FORCE_OBJECT);
    }
}

if ( ! function_exists('getMenuConfig')) {
    /**
     * Lấy nội dung file routes.json
     *
     * @return stdClass
     */
    function getMenuConfig()
    {
        $json = file_get_contents(base_path() . '/routes/menus.json');

        /** @noinspection PhpComposerExtensionStubsInspection */
        return json_decode($json, JSON_FORCE_OBJECT);
    }
}

if ( ! function_exists('getPermissionConfig')) {
    /**
     * Lấy nội dung file routes.json
     *
     * @return stdClass
     */
    function getPermissionConfig()
    {
        $json = file_get_contents(base_path() . '/database/files/permissions.json');

        /** @noinspection PhpComposerExtensionStubsInspection */
        return json_decode($json, JSON_FORCE_OBJECT);
    }
}

if ( ! function_exists('can')) {
    /**
     * Check quyền và vai trò
     *
     * @param string|array $permissions
     * @param string $role
     *
     * @return bool
     */
    function can($permissions, $role = 'Admin')
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ( ! $user) {
            return false;
        }

        if (is_array($permissions)) {
            return $user->hasRole($role) || $user->hasAnyPermission($permissions);
        }

        return $user->hasRole($role) || $user->can($permissions);
    }
}

if ( ! function_exists('isValueEmpty')) {
    /**
     * Returns a value indicating whether the give value is "empty".
     *
     * The value is considered "empty", if one of the following conditions is satisfied:
     *
     * - it is `null`,
     * - an empty string (`''`),
     * - a string containing only whitespace characters,
     * - or an empty array.
     *
     * @param mixed $value
     *
     * @return boolean if the value is empty
     */
    function isValueEmpty($value)
    {
        return $value === '' || $value === [] || $value === null || (\is_string($value) && trim($value) === '');
    }
}

if ( ! function_exists('setEnvValue')) {
    /**
     * Thay đổi giá trị config trong file .env
     * @param $envKey
     * @param $envValue
     */
    function setEnvValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);

        $oldValue = env($envKey);

        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);

        $fopen = fopen($envFile, 'wb');
        fwrite($fopen, $str);
        fclose($fopen);
    }
}
