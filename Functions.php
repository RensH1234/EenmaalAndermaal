<?php

function _generateFooter($jaar){
    $footer = "<footer><div class='container-fluid'><div class='row'><div class='col border'>";
    $footer .= "<h4 class='text-center'>&copy;  $jaar</h4></div></div></div><footer>";
    return $footer;
}

function _activeHeader($page_cur)
{
    $url_array = explode('/', $_SERVER['REQUEST_URI']);
    $url = end($url_array);
    if ($page_cur == $url) {
        echo 'active';
    }
}

