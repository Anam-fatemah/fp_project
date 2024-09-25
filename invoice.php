<?php
session_start();
include 'db_connect.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $phone_number = $_POST['phone_number'];

    // customer details
    $sql = "INSERT INTO customer (customer_name,phone_number) VALUES ('$customer_name','$phone_number')";
    if(mysqli_query($conn,$sql)) {
        $customer_id = mysqli_insert_id($conn);
        $tenant_id = $_SESSION['tenant_id'];

        // invoice
        $invoice_query = "INSERT INTO invoice (c_id,tnt_id) VALUES ('$customer_id','$tenant_id')";
        if(mysqli_query($conn,$invoice_query)) {
            $invoice_id = mysqli_insert_id($conn);

            // multiple products
            $product_ids = $_POST['product_id'];
            $quantities = $_POST['quantity'];
            $prices = $_POST['price'];
            $grand_total = 0;

            for($i = 0; $i < count($product_ids); $i++){
                $product_id = $product_ids[$i];
                $quantity = (int)$quantities[$i];
                $price = (int)$prices[$i];
                $total_price = $price * $quantity;

                // grand total
                $grand_total += $total_price;
                
                // $product_name = $_SESSION['product_name'];
                $invoice_items_query = "INSERT INTO invoiceitems (ii_id,inv_product_id,quantity,
                total_price) VALUES($invoice_id,$product_id,$quantity,$total_price)";
                mysqli_query($conn,$invoice_items_query);
            }
            echo "<h2>Invoice Created Successfully</h2>";
            echo "<p>Total Invoice Amount: " . $grand_total . "</p>";

        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice</title>
    <link rel="stylesheet" href="invoice.css">

</head>
<body>
    <h1 style="text-align: center;">Invoice</h1>

    <form method="POST" onsubmit="this.submit.disabled=true;">
    <label for="date">Date: </label>
    <input type="date" name="date"><br><br>
    <table>
        <tr>
            <th colspan="5">Customer</th>
        </tr>
        <tr>
            <td>Customer Name:</td>
            <td colspan="2"><input type="text" name="customer_name" id="customer_name" required></td>
            <td>Phone Number:</td>
            <td colspan="2"><input type="number" name="phone_number" id="phone_number" required></td>
        </tr>
    </table><br><br><br><br>

    <table>
        <tr>
            <th colspan="5">Product</th>
        </tr>
        <tr>
            <th>Product</th>
            <th>Quantity: </th>
            <th>Price:</th>
            <th>Total</th>
        </tr>

        <?php for($i = 1; $i <= 7; $i++) {?>
            <tr>
                <td>
                    <select name="product_id[]">
                        <?php
                        // print_r($_SESSION);
                        $tenant_id = $_SESSION['tenant_id'];

                        $query = "SELECT product_id, product_name FROM products WHERE prod_t_id = $tenant_id";
                        $result = mysqli_query($conn,$query);

                        if(mysqli_num_rows($result)>0){
                        while($row = mysqli_fetch_assoc($result)) {
                        $_SESSION['product_name'] = $row['product_name'];
                        echo "<option value='" . ($row['product_id']). "'>" . ($row['product_name']) ."</option>";
                        }       
                        } else{
                            echo "not available";
                        }
                        ?>
                    </select> 
                </td>
                <td><input type="number" name="quantity[]"></td>
                <td><input type="number" name="price[]" step="0.01"></td>
                <td><input type="number" name="total[]" readonly></td>
            </tr>
            <?php }?>

            <tr>
                <td colspan="3" style="text-align: right;"><strong>Grand Total</strong></td>
                <td><input type="number" name="grand_total" id="grand_total" disabled></td>
            </tr>
    </table>
    <br>
    <button type="submit" style="display: block; margin: 0 auto;">Generate Invoice</button>
    </form>

    <?php
    if (isset($grand_total)) {
    echo "<h3 style='text-align:center;'>Grand Total: " . $grand_total . "</h3>";
    }
    ?>

</body>
</html>