<?php


//** Debug  */
function dd($expression = [])
{
    echo "<pre>";
    var_dump($expression);
    echo "</pre>";
    die;
}

//** Debug  */
function debug($expression = [])
{
    echo "<pre>";
    print_r($expression);
    echo "</pre>";
    exit;
}
