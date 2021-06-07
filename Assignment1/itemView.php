<!DOCTYPE html>
<html>
    <head>
        <style>
            body {
                background-color: rgb(200, 200, 200);
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
        <h1>Selected Item</h1>
        
        
        <!--<form method="get" action="shoppingCart.php" target="bottomRightPanel">-->
        <?php
        
        session_start();
        if (isset($_GET['itemNo'])) {
            // Initialise connection to the database
            $link = mysqli_connect("aarte6rc2kkj7c.c58qtgvhlq4z.us-east-1.rds.amazonaws.com:3306", "uts", "internet", "assignment1") or die("Could not connect to server");
            
            // Query
            $itemNo = $_GET['itemNo'];
            
            $queryString = "SELECT * FROM products WHERE product_id = $itemNo";
            $result = mysqli_query($link, $queryString);
            
            $numRows = mysqli_num_rows($result);
            
            
            // Print out data for the selected item
            if ($numRows > 0) {
                $row = $result -> fetch_assoc();
                
                // Set currently selected item for use by other shopping cart php
                // To avoid showing product ID to users, a composite key between 
                $_SESSION['current'] = $row;
                
                print "<img style='float: left' height=100 width=auto src='images/" . $row['product_name'] . ".png'>";
                print "<table id='itemTable'>";
                print "<tr>\n";
                print "<td><b>Product</b></td>\n";
                print "\t<td>" . $row['product_name'] . "</td>\n";
                print "</tr>\n";
                
                print "<tr>\n";
                print "<td><b>Item Price</b></td>\n";
                print "<td>" . $row['unit_price'] . "</td>\n";
                print "</tr>\n";
                
                print "<tr>\n";
                print "<td><b>Size of item</b></td>\n";
                print "<td>" . $row['unit_quantity'] . "</td>\n";
                print "</tr>\n";
                
                print "<tr>\n";
                print "<td><b>In stock</b></td>\n";
                if ($row['in_stock'] > 0) {
                    print "<td style='color:green'> Yes </td>";
                } else {
                    print "<td style='color:red'> No </td>";
                }
                
                
                
                //print "<td> $row['in_stock'] </td>\n";
                //print "</tr>\n";
                
                // while ($a_row = mysqli_fetch_row($result)) {
                //     print "<tr>\n";
                    
                //     foreach ($a_row as $field) {
                //         print "\t<td>$field</td>\n";
                //     }
                //     print "</tr>";
                // }
                print "</table>";
                
            }
            echo '<br><form method="get" action="shoppingCart.php" target="bottomRightPanel">
            Select the quantity:<br>
            
            <input id="quantity" name="quantity" type="number"><br>
            <button onclick="return addToCart();">Add to cart</button>
            </form>';
        } else {
            echo "<br> No item selected. <br>Use the panel on the left to navigate groceries";
        }
        
        ?>
        <?php
        mysqli_close($link);
        ?>
        </form>
        
        <script>
            function addToCart() {
                var quantity = document.getElementById("quantity").value;
                if(quantity <= 20) {
                    parent.document.getElementById("bottomRightPanel").src = "shoppingCart.php?quantity=" + quantity;
                    return true;
                } else {
                    alert("Can only buy up to 20 of one item");
                    return false;
                }
            }
            //document.getElementById("submitBtn").addEventListener("click", addToCart);
            //https://stackoverflow.com/questions/42530261/javascript-button-onclick-not-working
        </script>
        
    </body>
</html>

