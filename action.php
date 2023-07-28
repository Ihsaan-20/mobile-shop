<?php 
session_start();
require_once ('require/config.php');

if(isset($_POST['product_id'])){

   extract($_POST);
    $stmt = $conn->prepare("SELECT product_code FROM cart WHERE product_code = ?");
    $stmt->bind_param("s", $product_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_assoc(); // Fetch the result as an associative array

    if ($res) {
        // Product code already exists in the cart, show a message
        echo '
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Already Added</strong>
            </div>
        ';
    } else {
        // Product code doesn't exist in the cart, insert the item into the cart table
        $query = $conn->prepare("INSERT INTO cart (product_name, product_price, product_image, qty, total_price, product_code) VALUES (?, ?, ?, ?, ?, ?)");
        $query->bind_param("sssiss", $product_name, $product_price, $product_image, $product_qty, $product_price, $product_code);
        $query->execute();

        echo '
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Item Added</strong>
            </div>
        ';
    }

}

// add to cart numbers
if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
    $stmt = $conn->prepare("SELECT * FROM cart");
    $stmt->execute();
    $stmt->store_result();
    $row = $stmt->num_rows;
    echo $row;
}

// Remove a single item from cart;
if(isset($_GET['remove'])){

    $id = $_GET['remove'];

    $stmt = $conn->prepare(' DELETE FROM `cart` WHERE id = ? ');
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $_SESSION['alert'] = 'block';
    $_SESSION['color'] = 'success';
    $_SESSION['message'] = 'item removed from the cart!';
    header('location: cart.php');

}

// Clear cart items;
if(isset($_GET['clear']) && isset($_GET['clear']) == 'all'){
    $stmt = $conn->prepare(' DELETE FROM `cart` ');
    $stmt->execute();
    $_SESSION['alert'] = 'block';
    $_SESSION['color'] = 'success';
    $_SESSION['message'] = 'All items removed from the cart!';
    header('location: cart.php');
}

// Update total and grand_price;
if (isset($_POST['qty'])) {
    extract($_POST);
    
    $qty = (int)$qty;

    if ($qty > 10 || $qty < 1) {
        $_SESSION['alert'] = 'block';
        $_SESSION['color'] = 'danger';
        $_SESSION['message'] = 'Quantity must be between 1 and 10';
    } else {
        // Quantity is valid, proceed with the update
        $total_price = $qty * $pprice;
        $stmt = $conn->prepare('UPDATE cart SET qty = ?, total_price = ? WHERE id = ? ');
        $stmt->bind_param("isi", $qty, $total_price, $pid);
        $stmt->execute();
    }
}

// place your order into order table;
if(isset($_POST['action']) && $_POST['action'] == 'order'){
    extract($_POST);
        $order_query = "INSERT INTO `orders` (`name`, `email`, `phone`, `address`, `pmode`, `products`, `amount_paid`)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($order_query);
        $stmt->bind_param("sssssss", $name, $email, $phone, $address, $pmode, $products, $grand_total);
        $result = $stmt->execute();
        if($result){
        $stmt = $conn->prepare(' DELETE FROM `cart` ');
        $stmt->execute();
        echo '
        <div class="text-center" style="min-height:75vh;">
        <h1 class="text-center text-success"> Thankyou, Your order placed successfully</h1>
        <img src="image/thankyou/check-out.png" class="img-fluid w-50" >
        </div>
        ';


        }

    }

// process_payment_with_stripe
// if(isset($_POST['process_payment_with_stripe'])){
//     echo "workig";
// }



?>