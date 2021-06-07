<html>
    <head>
        <style>
            body {
                background-color: rgb(220, 220, 220);
            }
            table, td, th {
                border: 1px solid black;
            }
            
            table {
                background-color: rgb(255, 255, 255);
                width: 50%;
                border-collapse: collapse;
            }
        </style>
        
    </head>
    <body>
        <h1>Shopping Cart</h1>
        
        <?php
        
        session_start();
        
        if(isset($_REQUEST['clear'])) {
            if ($_REQUEST['clear']) {
                unset($_SESSION['cart']);
                unset($_SESSION['current']);
            }
        }
        $escape = false;
        if(isset($_REQUEST['checkout'])) {
            if(isset($_SESSION['cart'])) {
                $escape = true;
            }
        }
        
        // Add the selected item and quantity to the shopping cart if selected
        if (isset($_SESSION['current']) && isset($_REQUEST['quantity'])) {
            
            // Use product name and product price as composite key in future
            
            // Check if the cart already contains an entry for the item
            $isFound = false;
            $currentId = $_SESSION['current']['product_id'];
            foreach($_SESSION['cart'] as $index => $item) {
                if ($item['id'] == $currentId) {
                    $_SESSION['cart'][$index]['quantity'] += $_REQUEST['quantity'];
                    $isFound = true;
                    break;
                }
            }
            
            // If the item is not in the cart, then add it
            if (!$isFound) {
                $newId = $_SESSION['current']['product_id'];
                $current = array("id" => $_SESSION['current']['product_id'], "product_name" => $_SESSION['current']['product_name'], "unit_price" => $_SESSION['current']['unit_price'], "quantity" => $_REQUEST['quantity']);
                array_push($_SESSION['cart'], $current);
            }
            
        } else {
            
        }
        
        // Print out the shopping cart
        if (isset($_SESSION['cart'])) {
            
            $totalCost = 0;
            
            echo "<table border=1>\n";
            echo "<tr>
                <td><b>Product Name</b></td>
                <td><b>Unit Price</b></td>
                <td><b>Quantity</b></td>
                <td><b>Total Price</b></td>
                </tr>";
            foreach($_SESSION['cart'] as $item) {
                
                echo "<tr>";
                
                echo "<td>" . $item['product_name'] . "</td>";
                echo "<td>" . $item['unit_price'] . "</td>";
                echo "<td>" . $item['quantity'] . "</td>";
                $price = $item['quantity'] * $item['unit_price'];
                echo "<td>" . $price . "</td>";
                $totalCost += $price;
                
                echo "</tr>";
                
            }
            echo "<tr><td></td><td></td><td></td><td>" . $totalCost . "</td></tr>";
            echo "</table>\n";
            echo '
            <br>
            <button onclick="return clearCart();">Empty cart</button>
            <button onclick="return checkout();">Checkout</button>';
            
        } else {
            $_SESSION['cart'] = array();
            echo "<br>No items in the shopping cart";
        }
        
        // if (isset($_SESSION['current']) && $_REQUEST['quantity'] > 0) {
            
        //     // Use product name and product price as composite key
            
        //     $current = $_SESSION['current'];
        //     $_SESSION['cart'][$current['product_name']][$current['unit_price']] += $_REQUEST['quantity'];
            
        //     // $_SESSION['cart'] stores arrays of items within the shopping cart
        //     //      product_name
        //     //      unit_price
        //     //      quantity - This is the value that changes
        //     //
        //     // $_SESSION['cart'][]
        
            
        
        // }
        ?>
        
        
        <script>
            
            function clearCart() {
                parent.document.getElementById("bottomRightPanel").src = "shoppingCart.php?clear=true";
            }
            
            function checkout() {
                parent.document.getElementById("topRightPanel").src = "checkout.php";
            }
            
        </script>
        
    </body>
</html>