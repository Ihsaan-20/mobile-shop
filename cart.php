<?php 
    include_once 'include/header.php';
?>
<div class="container" style="min-height: 75vh;">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-10 mx-auto">
            <div class="table-responsive">
                <!-- Alert messges -->
                <div class="alert alert-<?php if(isset($_SESSION['color'])){echo $_SESSION['color'];}else{echo 'none';} unset($_SESSION['color']);?> alert-dismissible fade show mt-3" role="alert"
                    style="display:<?php if(isset($_SESSION['alert'])){echo $_SESSION['alert'];}else{echo 'none';} unset($_SESSION['alert']);?>;">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><?php if(isset($_SESSION['message'])){echo $_SESSION['message'];} unset($_SESSION['alert']);?></strong>
                </div>
                <!-- Alert messges -->

                <?php 
                $stmt = $conn->prepare('SELECT id, product_name, product_price, product_image, qty, total_price FROM cart');
                $stmt->execute();
                $result = $stmt->get_result();
                $grand_total = 0;
                $count = 0;
                // Check if there are rows in the result
                if ($result->num_rows == 0):
                ?>
                <div class="text-center text-danger mt-5">
                    <h1>No Data Found</h1>
                </div>
                <?php else: ?>
                <table class="table table-bordered table-striped shadow  text-center mt-3">
                    <thead>
                        <tr>
                            <td colspan="7">
                                <h3 class="text-primary">Products in your cart!</h3>
                            </td>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Product Quantity</th>
                            <th>Total Price</th>
                            <th><a href="action.php?clear=all"
                                    onclick="return confirm('Do you want to clear the cart items?')"
                                    class="bg-danger p-1 text-decoration-none text-light rounded <?php ?>"><i
                                        class="bi bi-trash3-fill"></i> Clear Cart</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ++$count; ?>
                        <tr>
                            <td>
                                <input type="hidden" class="pid" value="<?= $row['id']; ?>">
                                <?= $count ?>
                            </td>
                            <td>
                                <img src="<?= $row['product_image']; ?>" width="50" alt="product-image">
                            </td>
                            <td>
                                <?= $row['product_name']; ?>
                            </td>
                            <td>
                                <input type="hidden" class="pprice" value="<?= $row['product_price']; ?>">
                                <?= number_format($row['product_price'],2); ?>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <input type="number"  value="<?= $row['qty'] ?>"
                                        class="form-control w-50 itemQty">
                                </div>
                            </td>
                            <td>
                                <?= number_format($row['total_price'],2); ?>
                            </td>
                            <td>
                                <a href="action.php?remove=<?= $row['id']?>"
                                    onclick="return confirm('Do you want to delete this product from the cart?')"><i
                                        class="bi bi-trash3-fill text-danger lead"></i></a>
                            </td>
                        </tr>
                        <?php $grand_total += $row['total_price']; endwhile; ?>
                        <tr>
                            <td colspan="3">
                                <a href="index.php"
                                    class="text-decoration-none text-light bg-success rounded p-1 mb-2"><i
                                        class="bi bi-cart-plus-fill"></i> Continue Shopping</a>
                            </td>
                            <td colspan="2" class="text-end">
                                <b>Total Bill:</b>
                            </td>
                            <td class="text-start">
                                <b><?= number_format($grand_total,2); ?></b>
                            </td>
                            <td>
                                <?php //($grand_total > 0 )?'':'disabled'; ?>
                                <a href="checkout.php"
                                    class="text-decoration-none bg-info rounded text-dark p-1 mb-2"><i
                                        class="bi bi-credit-card"></i> Checkout</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // cart code here
    $(".itemQty").on('change', function() {
        var $el = $(this).closest('tr');

        var pid = $el.find('.pid').val();
        var pprice = $el.find('.pprice').val();
        var qty = $el.find('.itemQty').val();
        location.reload(true);

        // ajax code here
        $.ajax({
            url: 'action.php',
            method: 'post',
            cache: false,
            data: {
                pid: pid,
                pprice: pprice,
                qty: qty
            },
            success: function(response) {
                console.log(response);
            }
        });

    });

    // function cart number;
    show_cart_number();

    function show_cart_number() {
        $.ajax({
            url: 'action.php',
            method: 'get',
            data: {
                cartItem: "cart_item"
            },
            success: function(response) {
                $('#cart-item').html(response);
            }
        });
    }

});
</script>

<?php 
    include_once 'include/footer.php';
?>