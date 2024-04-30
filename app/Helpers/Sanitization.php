<?php

if (!function_exists("escape_string")) {
    function escape_string($value)
    {
        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");
        return str_replace($search, $replace, $value);
    }
}

if (!function_exists("clean_input")) {
    function clean_input($input)
    {
        $search = [
            '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
        ];
        $output = preg_replace($search, '', $input);
        return $output;
    }
}

if (!function_exists('sanitize_input')) {
    function sanitize_input($input)
    {
        if (is_array($input)) {
            $output = [];
            foreach ($input as $var => $val) {
                $output[$var] = sanitize_input($val);
            }
            return $output;
        } else {
            return escape_string(clean_input(stripslashes($input)));
        }
    }
}


if (!function_exists('shallow_sanitize')) {
    function shallow_sanitize($input)
    {
        if (is_array($input)) {
            $output = [];
            foreach ($input as $var => $val) {
                $output[$var] = shallow_sanitize($val);
            }
            return $output;
        } else {
            return escape_string(stripslashes($input));
        }
    }
}
