<?php

namespace App\Facades;

class Config extends \Illuminate\Support\Facades\Config
{
    /**
     * Returns all exportable config values as an associative array
     *
     * @return array
     */
    public static function export()
    {
        $exportable = self::get('exportable');
        $export = [];

        foreach ($exportable as $key => $value) {
            $configKey = is_array($value) ? $key : $value;
            $subKeys = is_array($value) ? $value : ['*'];
            
            $data = Config::get($configKey);
            $export[$configKey] =
                in_array('*', $subKeys) ?
                $data :
                array_filter($data, function ($subKey) use ($subKeys) {
                    return in_array($subKey, $subKeys);
                }, ARRAY_FILTER_USE_KEY);
        }

        return $export;
    }
}
