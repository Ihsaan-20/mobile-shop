<?php 
    include_once 'include/header.php';
    $grand_total = 0;
    $allItems = '';
    $items = array();

    $sql = " SELECT CONCAT(product_name, ' [', qty, ']') AS ItemQty, total_price FROM cart ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row=$result->fetch_assoc()):
         $grand_total += $row['total_price'];
         $items[] = $row['ItemQty'];
    endwhile;
    $allItems = implode(", ",$items);

?>
<div id="mainsecond" class="container" style="min-height: 100vh; display:none">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-6 col-lg-6 pt-3" id="order"></div>
    </div>
</div>

<div id="mainfirst" class="container" style="min-height: 100vh; display:block">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-6 col-lg-6 pt-3" id="order2">
            <h4 class="text-center text-primary">Confirm your order!</h4>
            <div class="p-1 mb-3 bg-light rounded-3">
                <div class="container-fluid py-2 text-center">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <h4 class="display-5">Products</h4>
                                </td>
                            </tr>
                            <?php 
                            foreach ($items as $item) {
                                ?>
                            <tr>
                                <td><?php echo $item; ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td>Delivery charges: <b>Free</b></td>
                            </tr>
                            <tr>
                                <td>Total Amount Payable: <b><?php echo number_format($grand_total,2);?></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Cash on delivery || Cardpayment buttons -->
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-6 col-lg-6 pt-3">
            <div class="text-center  d-flex justify-content-space gap-2">
                <a href="#" class="payment-option text-decoration-none bg-primary p-1 w-100 text-light rounded px-3 py-2" data-method="cod"><i class="bi bi-cash"></i> Cash on Delivery</a>
                <a href="#" class="payment-option text-decoration-none bg-primary p-1 w-100 text-light rounded px-3 py-2" data-method="card"><i class="bi bi-credit-card-2-back-fill"></i> Card Payment</a>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <!-- Add div containers for the two different payment forms -->
        <div class="col-sm-12 col-md-6 col-lg-6 py-4" id="cod-payment-form" style="display: none;">
            <!-- Add fields for Cash on Delivery -->
                    <div class="p-1 bg-light rounded-3">
                        <div class="container-fluid py-2 text-center">
                            <form action="" method="POST" id="placeorder">
                                <!-- Form to send data into order table -->
                                <input type="hidden" name="products" value="<?= $allItems; ?>">
                                <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
                                <div class="text-center">
                                    <p class="text-danger">
                                        <?php if(isset($_SESSION['error'])){echo $_SESSION['error'];} unset($_SESSION['error']);?>
                                    </p>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" name="name" class="form-control" placeholder="Enter your name.."
                                        required>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email.."
                                        required>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="text" name="phone" class="form-control" placeholder="Enter your phone.."
                                        required>
                                </div>
                                <div class="form-group mb-3">
                                    <textarea name="address" class="form-control"
                                        placeholder="Enter your address for delivery.." cols="10" rows="3" required></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="hidden" name="pmode" class="form-control" value="cod"/>
                                    <input type="submit" name="submit" value="Place order" class="btn btn-success btn-block w-100">
                                </div>
                            </form>
                        </div>
                    </div>
            <!-- Add any additional fields as needed -->
        </div>

        <div class="col-sm-12 col-md-6 col-lg-6 py-4 pb-4" id="card-payment-form" style="display: none;">
            <!-- Add fields for Card Payment -->
            <form id="cardpayment" action="payment/payment.php" method="POST">
                <!-- Add the necessary card details fields here (e.g., card number, expiration date, CVC, etc.) -->
                <!-- For simplicity, I'm just showing the card number field -->
                 <!-- Form to send data into order table -->
                 <input type="hidden" name="products" value="<?= $allItems; ?>">
                <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
                <div class="text-center">
                    <p class="text-danger">
                        <?php if(isset($_SESSION['error'])){echo $_SESSION['error'];} unset($_SESSION['error']);?>
                    </p>
                </div>
                <div class="form-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Enter your name.."
                        required>
                </div>
                <div class="form-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Enter your email.."
                        required>
                </div>
                <div class="form-group mb-3">
                    <input type="text" name="phone" class="form-control" placeholder="Enter your phone.."
                        required>
                </div>
                <div class="form-group mb-3">
                    <textarea name="address" class="form-control"
                        placeholder="Enter your address for delivery.." cols="10" rows="3" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <input type='text' name='card_number' placeholder='XXXX-XXXX-XXXX-XXXX' class="form-control card-number">
                </div>
                <div class="form-group mb-3">
                    
                </div>
                <div class="input-group mb-3">
                    <input type='text' name='cvc' placeholder='CVC' class="form-control cvc">
                    <input type='text' name='mm' placeholder='MM' class="form-control card-expiry-month">
                    <input type='text' name='yyyy' placeholder='YYYY' class="form-control card-expiry-year">
                </div>
                <!-- Add any additional fields as needed -->
                <div class="form-group mb-3">
                    <input type="submit" name="submit"  value="Place order" class="btn btn-success btn-block w-100">
                </div>
            </form>
        </div>
    </div>
            
    
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>
    // Set your Stripe Publishable Key
    Stripe.setPublishableKey('sk_test_51NYY9lHQtBlyl9upCueFrF01v5Pb6NZpjKY5kih0EDtxhGs65xXi9ku1F2YOM2yir6Dy6Fgu197BpcKFSgpC1qaG00e72Dweez');

    // call back to handle the response;
    function stripeResonseHandler(status,response){
        if(response.error){
            $('#payBtn').removeAttr("disabled");
            $('.payment-errors').html(response.error.message);
        }else{
            var form = $("#cardpayment");
            var token = response['id'];
            form.append('<input type="hidden" name="stripeToken" value="'+ token +'" />');
            form.get(0).submit();
        }
    }
    // cashpayment;
    $(document).ready(function(){
        $("#cardpayment").submit(function(event) {
        // disable the submit button;
        $('#payBtn').attr("disabled", "disabled");

        // create single-use token to charge the user;
        Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
        }, stripeResonseHandler);

        return false;

        });
    });
</script>

<script>
$(document).ready(function() {
    // Bind click event to payment options links
    $(".payment-option").click(function(e) {
        e.preventDefault();
        var paymentMethod = $(this).data("method");

        // Hide both payment forms first
        $("#cod-payment-form").hide();
        $("#card-payment-form").hide();

        // Show the selected payment form
        if (paymentMethod === 'cod') {
            $("#cod-payment-form").show();
        } else if (paymentMethod === 'card') {
            $("#card-payment-form").show();
        }
    });
    // Cash on delivery;
    $("#placeorder").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'action.php',
            method: 'post',
            data: $('form').serialize() + "&action=order",
            success: function(response) {
                // Hide the elements with IDs '#show-page' and '#anchor-btn'
                $('#mainfirst').css('display', 'none');
                $('#mainsecond').css('display', 'block');
                $('#order').html(response);
            }
        });
    });

    // funtion cart number;
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