<?php
session_start();
// print_r($_SESSION);

/*if(!isset($_SESSION['login_id'])) {
    header(("Location: login.php"));
    exit;
}*/

include 'db_connect.php';

$tenant_id = $_SESSION['tenant_id'];
$login_id = $_SESSION['login_id'];
$tenant_name = $_SESSION['tenant_name'];
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body style="background-color: #d9d9d9;">
    <marquee behavior="slide" direction="right"><h1 align="center">Welcome to the Dashboard, <?php 
    echo $tenant_name; ?>!</h1></marquee>
    <br><br><br><br>

    <table>
        <tr>
        <th colspan="3"><h2>Select an option to manage your store: </h2></th>
        </tr>

        <tr>
            <td><h3><a href="viewstock.php">View Stock</a></h3></td>
            <td><h3><a href="addprod.php">Add Products</a></h3></td>
            <td><h3><a href="invoice.php">Create Invoice</a></h3></td>
        </tr>

    </table>

</body>
</html>