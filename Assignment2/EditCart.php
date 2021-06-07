<!--

This script handles any changes to the session data

-->

<?php

session_start();

// Add entire car object to the cart

if (isset($_GET['newCar'])) {
    if (!isset($_SESSION['cars'])) {
        $_SESSION['cars'] = array();
        array_push($_SESSION['cars'], json_decode($_GET['newCar'], true));
    } else {
        // Check if the car is already in the cart
        // Must check ID rather than whole object, as rentalDays value may be set already
        $carExists = false;
        $car = json_decode($_GET['newCar'], true);
        foreach ($_SESSION['cars'] as $key => $value) {
            if ($value['ID'] == $car['ID']) {
                $carExists = true;
                break;
            }
        }
        if ($carExists == false) {
            array_push($_SESSION['cars'], json_decode($_GET['newCar'], true));
        }
    }

// Remove a car from the cart

} elseif (isset($_GET['removeCar'])) {
    foreach($_SESSION['cars'] as $key => $car) {
        $currentCar = (array) $car;
        if ($currentCar["ID"] == $_GET['removeCar']) {
            unset($_SESSION['cars'][$key]);
            $_SESSION['cars'] = array_values($_SESSION['cars']);
            break;
        }
    }
} elseif (isset($_GET['clear'])) {
    unset($_SESSION['cars']);
}

?>