<?php
function encodeSlashes($string, $search = '/')
{
    return trim(str_replace($search, '|', $string));
}

function decodeSlashes($string, $replace = '/')
{
    return trim(str_replace('|', $replace, $string));
}