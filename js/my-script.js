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


