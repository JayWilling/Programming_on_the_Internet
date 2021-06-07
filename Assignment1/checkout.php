<!DOCTYPE html>
<html>
    <style>
        .error {
            color: #FF0000;
        }
        table, td, th {
            border: 1px solid black;
        }
        
        table {
            background-color: rgb(255, 255, 255);
            width: 50%;
            border-collapse: collapse;
        }
        .form {
            background-color: transparent;
            width: 0;
        }
        .bord {
            border: 0px;
        }
    </style>
    <body>
        <h1>Order</h1>
        <table>
            <tr>
                <td><b>Product Name</b></td>
                <td><b>Unit Price</b></td>
                <td><b>Quantity</b></td>
                <td><b>Total Price</b></td>
            </tr>
            <?php
            session_start();
            
            $id = $_GET['id'];
            $quantity = $_GET['quantity'];
            $totalCost = 0;
            
            
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
            
            ?>
        </table>
        
        <?php
        
        $nameErr = $emailErr = "";
        $name = $email = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            
            if (empty($_POST["name"])) {
                $nameErr = "Name is required";
            } else {
                $name = test_input($_POST["name"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                    $nameErr = "Only letters and white space allowed";
                }
            }
            
            if (empty($_POST["email"])) {
                $emailErr = "Email is required";
            } else {
                $email = test_input($_POST["email"]);
                // check if e-mail address is well-formed
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                }
            }
            
            if (empty($_POST["address"])) {
                $addressErr = "Address is required";
            } else {
                $address = test_input($_POST["address"]);
            }
            
            if (empty($_POST["suburb"])) {
                $suburbErr = "Suburb is required";
            } else {
                $name = test_input($_POST["suburb"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z-' ]*$/",$suburb)) {
                    $suburbErr = "Only letters and white space allowed";
                }
            }
            
            if (empty($_POST["state"])) {
                $stateErr = "Name is required";
            } else {
                $state = test_input($_POST["state"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z-' ]*$/",$state)) {
                    $stateErr = "Only letters and white space allowed";
                }
            }
            
            if (empty($_POST["country"])) {
                $countryErr = "Name is required";
            } else {
                $country = test_input($_POST["country"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z-' ]*$/",$country)) {
                    $countryErr = "Only letters and white space allowed";
                }
            }
            
            if ($nameErr == "" && $addressErr == "" && $suburbErr == "" && $stateErr == "" && $countryErr == "" && $emailErr == "") {
                unset($_SESSION['cart']);
                unset($_SESSION['current']);
                echo "
                <script type='text/javascript'>
                alert('Order processed successfully');
                parent.document.getElementById('topRightPanel').src = 'itemView.php';
                parent.document.getElementById('bottomRightPanel').src = 'shoppingCart.php';
                top.frames.location.reload(false);
                </script>";
                //header('Location: index.html');
                exit();
            }
            
        }
            
            function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
            }
        
        ?>
        
        <h1>Checkout Form</h1>
        <p><span class="error">* required fields</span></p>
        <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
            <table class="form bord">
    			<tr class="bord">
    				<td class="bord">Name: </td>
    				<td class="bord"><input type="text" name="name" value="<?php echo $name;?>"></td>
    				<td class="bord"><span class="error">* <?php echo $nameErr;?></span></td>
    			</tr>
    			<tr class="bord">
    				<td class="bord">Address: </td>
    				<td class="bord"><input type="text" name="address" value="<?php echo $address;?>"></td>
    				<td class="bord"><span class="error">* <?php echo $addressErr;?></span></td>
    			</tr>
    			<tr class="bord">
    				<td class="bord">Suburb: </td>
    				<td class="bord"><input type="text" name="suburb" value="<?php echo $suburb;?>"></td>
    				<td class="bord"><span class="error">* <?php echo $suburbErr;?></span></td>
    			</tr>
    			<tr class="bord">
    				<td class="bord">State: </td>
    				<td class="bord"><input type="text" name="state" value="<?php echo $state;?>"></td>
    				<td class="bord"><span class="error">* <?php echo $stateErr;?></span></td>
    			</tr>
    			<tr class="bord">
    				<td class="bord">Country: </td>
    				<td class="bord"><input type="text" name="country" value="<?php echo $country;?>"></td>
    				<td class="bord"><span class="error">* <?php echo $countryErr;?></span></td>
    			</tr>
    			<tr class="bord">
    				<td class="bord">Email: </td>
    				<td class="bord"><input type="text" name="email" value="<?php echo $email;?>"></td>
    				<td class="bord"><span class="error">* <?php echo $emailErr;?></span></td>
    			</tr>
    		</table>
            <input type="submit" value="Purchase">
        </form>
        
        
    </body>

</html>