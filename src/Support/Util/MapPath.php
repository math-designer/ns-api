<?php


namespace NS\Support\Util;


function &array_get_path(&$array, $path, $delim = NULL, $value = NULL, $unset = false)
{
    $num_args = func_num_args();
    $element = &$array;
    if (!is_array($path) && strlen($delim = (string)$delim)) {
        $path = explode($delim, $path);
    }
    // if
    if (!is_array($path)) {
        // Exception?
    }
    // if
    while ($path && ($key = array_shift($path))) {
        if (!$path && $num_args >= 5 && $unset) {
            unset($element[$key]);
            unset($element);
            $element = NULL;
        } // if
        else {
            $element =& $element[$key];
        }
        // else
    }
    // while
    if ($num_args >= 4 && !$unset) {
        $element = $value;
    }
    // if
    return $element;
}

// array_get_path
function array_set_path($value, &$array, $path, $delimiter = NULL)
{
    array_get_path($array, $path, $delimiter, $value);
    return;
}

// array_set_path
function array_unset_path(&$array, $path, $delimiter = NULL)
{
    array_get_path($array, $path, $delimiter, NULL, true);
    return;
}

// array_unset_path
function array_has_path($array, $path, $delimiter = NULL)
{
    $has = false;
    if (!is_array($path)) {
        $path = explode($delimiter, $path);
    }
    // if
    foreach ($path as $key) {
        if ($has = array_key_exists($key, $array)) {
            $array = $array[$key];
        }
        // if
    }
    // foreach
    return $has;
}


class MapPath
{
    protected $map;
    protected $path;
    protected $delimiter;

    public function __construct(&$array, $path = NULL, $delimiter = NULL)
    {
        $this->map($array);
        $this->path($path, $delimiter);
        return;
    }

    // __construct
    public static function make(&$array, $path = NULL, $delimiter = NULL)
    {
        return new self($array, $path, $delimiter);
    }

    // make
    public function &map(&$array = NULL)
    {
        if (!is_null($array)) {
            $return = $this;
            $this->map =& $array;
        }
        // if
        if (!isset($return)) {
            $return =& $this->map;
        }
        //
        return $return;
    }

    // map
    public function path($path = false, $delimiter = false)
    {
        foreach (array('path', 'delimiter') as $arg) {
            if ($$arg !== false) {
                $return = $this;
                $this->$arg = $$arg;
            }
            // if
        }
        // foreach
        $return = isset($return) ? $return : $this->path;
        return $return;
    }

    // path
    public function delim($delimiter = NULL)
    {
        if (!is_null($delimiter)) {
            $return = $this;
            $this->delimiter = $delimiter;
        }
        // if
        $return = $return ? $return : $this->delimiter;
        return $return;
    }

    // delim
    public function &get($path = NULL, $delimiter = NULL)
    {
        $return =& array_get_path(
            $this->map(),
            !is_null($path) ? $path : $this->path(),
            !is_null($delimiter) ? $delimiter : $this->delimiter
        );
        return $return;
    }

    // get
    public function set($value, $path = NULL, $delimiter = NULL)
    {
        array_get_path(
            $this->map(),
            !is_null($path) ? $path : $this->path(),
            !is_null($delimiter) ? $delimiter : $this->delimiter,
            $value
        );
        return;
    }

    // set
    public function drop($path = NULL, $delimiter = NULL)
    {
        array_get_path(
            $this->map(),
            !is_null($path) ? $path : $this->path(),
            !is_null($delimiter) ? $delimiter : $this->delimiter,
            NULL,
            true
        );
        return;
    }

    // drop
    public function has($path = NULL, $delimiter = NULL)
    {
        $has = array_has_path(
            $this->map(),
            !is_null($path) ? $path : $this->path(),
            !is_null($delimiter) ? $delimiter : $this->delimiter
        );
        return $has;
    }
}