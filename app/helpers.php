<?php

if (!function_exists('words')) {
    /**
     * Limit the number of words in a string.
     *
     * @param string $value
     * @param int $words
     * @param string $end
     * @return string
     */
    function words($value, $words = 100, $end = ''): string
    {
        return \Illuminate\Support\Str::words($value, $words, $end);
    }
}

if (!function_exists('setting')) {

    /**
     * @param $key
     * @param null $default
     * @return \App\Setting|mixed
     */
    function setting($key, $default = null)
    {
        if (is_null($key)) {
            return new \App\Setting();
        }

        if (is_array($key)) {
            return \App\Setting::set($key[0], $key[1]);
        }

        $value = \App\Setting::get($key);

        return is_null($value) ? value($default) : $value;
    }
}