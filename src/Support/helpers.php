<?php

function array_multi_key_exists(array $arr, $key)
{
    if (array_key_exists($key, $arr)) {
        return true;
    }

    foreach ($arr as $element) {
        if (is_array($element)) {
            if (array_multi_key_exists($element, $key)) {
                return true;
            }
        }

    }

    return false;
}