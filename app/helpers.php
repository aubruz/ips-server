<?php

if (! function_exists('optimus_decode')) {
    /**
     * Decode Optimus ID.
     *
     * @param $value
     *
     * @return mixed
     */
    function optimus_decode($value)
    {
        /* @noinspection PhpUndefinedMethodInspection */
        if(is_array($value)){
            foreach($value as $key => $val){
                $value[$key] = app('optimus')->decode($val);
            }
            return $value;
        }else {
            return app('optimus')->decode($value);
        }
    }
}

if (! function_exists('optimus_encode')) {
    /**
     * Encode Optimus ID.
     *
     * @param $value
     *
     * @return mixed
     */
    function optimus_encode($value)
    {
        /* @noinspection PhpUndefinedMethodInspection */
        if(is_array($value)){
            foreach($value as $key => $val){
                $value[$key] = app('optimus')->encode($val);
            }
            return $value;
        }else {
            return app('optimus')->encode($value);
        }
    }
}

if( !function_exists('ordinalSuffix')){
    /**
     * Get the ordinal suffix from a number
     *
     * @param $number
     * @return string
     */
    function ordinalSuffix($number) {
        if(\App::getLocale() == 'fr'){
            if($number == 1) {
                return 'er';
            }
            return 'ème';
        }

        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return 'th';
        else
            return $ends[$number % 10];
    }
}

if (! function_exists('domain')) {
    /**
     * Get the app domain.
     *
     * @return string
     */
    function domain()
    {
        return Config::get('app.domain');
    }
}

if (! function_exists('subdomain')) {
    /**
     * Get the app domain.
     *
     * @param $subdomain
     *
     * @return string
     */
    function subdomain($subdomain)
    {
        return $subdomain.'.'.domain();
    }
}

if (! function_exists('updateUrl')) {
    /**
     * Modify url query parameters
     *
     * @param $url
     * @param $query
     *
     * @return string
     */
    function updateUrl($url, $query)
    {
        $currentQuery = parse_url($url, PHP_URL_QUERY);
        $currentQueryArray = [];
        if($currentQuery){
            parse_str($currentQuery, $currentQueryArray);
        }

        $allQuery = array_merge($currentQueryArray, $query);

        $newQuery = http_build_query($allQuery);

        if($currentQuery) {
            return str_replace($currentQuery, $newQuery, $url);
        }

        return $url . '?' . $newQuery;
    }
}

if (! function_exists('getFileName')) {

    /**
     * @param $extension
     * @return string
     */
    function getFileName($extension)
    {
        $fileName =  str_random(30) . '.' . $extension;
        while(\Illuminate\Support\Facades\Storage::disk('public')->exists('avatars/' . $fileName)){
            $fileName =  str_random(30) . '.' . $extension;
        }

        return $fileName;
    }
}

if(! function_exists('isChutenogol')){

    /**
     * Determine if the site is protugues or not
     *
     * @return bool
     */
    function isChutenogol()
    {
        return config('app.url') == 'https://chutenogol.com.br';
    }
}