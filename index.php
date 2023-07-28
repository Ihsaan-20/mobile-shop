<?php 
    include_once 'include/header.php';
?>
        
        <div class="container">

            <!-- Alert Messages -->
            <div id="msg"></div>

            <div class="row py-3">
                <?php 
            $stmt = $conn->prepare("SELECT * FROM product ");
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()):
            ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card mb-3 p-1">
                        <img src="<?=$row['product_image']?>" class="card-img-top" alt="product-image" height="250">
                        <div class="card-body text-center">
                            <h4><?= $row['product_name']?></h4>
                            <h5 class="text-danger"><i class="bi bi-currency-dollar"></i><?= number_format($row['product_price'],2)?></h5>
                        </div>
                        <div class="card-footer text-center">
                            <form action="" class="form-submit">
                                <input type="hidden" class="pid" value="<?= $row['id']; ?>">
                                <input type="hidden" class="pname" value="<?= $row['product_name']; ?>">
                                <input type="hidden" class="pprice" value="<?= $row['product_price']; ?>">
                                <input type="hidden" class="pqty" value="<?= $row['product_qty']; ?>">
                                <input type="hidden" class="pimage" value="<?= $row['product_image']; ?>">
                                <input type="hidden" class="pcode" value="<?= $row['product_code']; ?>">
                                <button class="btn btn-primary b-block addItemBtn" name="cart"><i class="bi bi-cart3"></i> Add to Card</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
<script>
    $(document).ready(function(){
    $(".addItemBtn").click(function(e){
        e.preventDefault();
        // get forms data
        var $form = $(this).closest('.form-submit');
        var product_id = $form.find('.pid').val();
        var product_name = $form.find('.pname').val();
        var product_price = $form.find('.pprice').val();
        var product_qty = $form.find('.pqty').val();
        var product_image = $form.find('.pimage').val();
        var product_code = $form.find('.pcode').val();
        // ajax code here
        $.ajax({
            url: 'action.php',
            method: 'post',
            data: {
                product_id: product_id,
                product_name: product_name,
                product_price: product_price,
                product_qty: product_qty,
                product_image: product_image,
                product_code: product_code
            },
            success: function(response){
                $('#msg').html(response);
                window.scrollTo(0, 0);
                // functions
                show_cart_number();
            }
        });
    });
    // funtion cart number;
    show_cart_number();
    function show_cart_number(){
        $.ajax({
            url: 'action.php',
            method: 'get',
            data: {cartItem: "cart_item"},
            success: function(response){
                $('#cart-item').html(response);
            }
        });
    }    
});

</script>
<?php 
    include_once 'include/footer.php';
?>