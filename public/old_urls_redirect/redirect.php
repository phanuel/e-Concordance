<?php

    define("BASE_URL", "http://".$_SERVER['SERVER_NAME']."/e-concordance/");

    function redirect301($relative_url) {
        Header( "HTTP/1.1 301 Moved Permanently" );
        Header( "Location: ".BASE_URL.$relative_url );
        die();
    }

?>
