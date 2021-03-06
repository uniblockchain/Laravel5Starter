<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

/**
 * Settings model
 *
 * @author Todor Todorov <todstoychev@gmail.com>
 * @package App\Models
 */
class Settings extends Model {

    /**
     * Database table name
     *
     * @var String
     */
    protected $table = 'settings';

    /**
     * Timestamps
     *
     * @var Boolean
     */
    public $timestamps = false;

    /**
     * Fillable params
     *
     * @var Array
     */
    protected $fillable = ['param', 'value'];

    /**
     * Get all settings as array
     * 
     * @return Array
     */
    public static function getAll() {
        if (Cache::has('settings')) {
            $array = Cache::get('settings');
        } else {
            $query = self::all();
            $array = [];

            foreach ($query as $item) {
                $array[$item->param] = $item->value;
            }

            Cache::forever('settings', $array);
        }

        return $array;
    }

    /**
     * Get specific setting value
     *
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        $array = self::getAll();

        return $array[$key];
    }
    
    /**
     * Get locales as array
     * 
     * @return Array
     */
    public static function getLocales() {
        $array = self::getAll();
        $value = $array['locales'];
        
            $locales = explode(', ', $value);
        
        return $locales;
    } 
    
    /**
     * Get the favicon
     *
     * @deprecated
     * 
     * @return string
     */
    public static function getFavicon() {
        $array = self::getAll();
        $value = $array['favicon'];
        
        return $value;
    }

    /**
     * Gets the sitename
     *
     * @deprecated
     * 
     * @return String
     */
    public static function getSitename() {
        $array = self::getAll();
        $value = $array['sitename_' . Session::get('locale')];
        
        return $value;
    }
    
    /**
     * Gets the fallback locale
     *
     * @deprecated
     * 
     * @return string
     */
    public static function getFallBackLocale() {
        $array = self::getAll();
        $value = $array['fallback_locale'];
        
        return $value;
    }
    
    
}
