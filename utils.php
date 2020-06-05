<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 20/05/2019
 * Time: 13:38
 */
function print_r2($val)
{
    echo '<pre>';
    print_r($val);
    echo '</pre>';
}

function print_r3($name, $val)
{
    echo '<pre>';
    echo("$name\n");
    print_r($val);
    echo '</pre>';
}