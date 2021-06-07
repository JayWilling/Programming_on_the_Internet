<?php

session_start();

if (isset($_SESSION['cars'])) {
    print json_encode($_SESSION['cars']);
} else {
    $_SESSION['cars'] = array();
    print json_encode($_SESSION['cars']);
}

?>