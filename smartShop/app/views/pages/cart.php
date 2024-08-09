<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="hero-wrap hero-bread" style="background-image: url(<?php echo URLROOT; ?>/images/post-item7.jpg)">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Cart</span></p>
                <h1 class="mb-0 bread">My Wishlist</h1>
            </div>
        </div>
    </div>
</div>

<?php print_r($data); ?>

<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <?php 
                    $total = 0; // التأكد من أن المتغير $total يساوي صفر في البداية
                    if (!empty($data['carts'])): // التأكد من وجود بيانات في المصفوفة
                        foreach ($data['carts'] as $cart) {
                            $total += $cart->price * $cart->quantity; // جمع أسعار جميع المنتجات بناءً على الكمية
                        }
                    endif;
                    ?>
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['carts'])): // التأكد من وجود بيانات في المصفوفة ?>
                                <?php foreach ($data['carts'] as $cart): ?>
                                <tr class="text-center">
                                    <td class="product-remove"><a href="#"><span class="ion-ios-close"></span></a></td>

                                    <td class="image-prod">
                                        <div class="img" style="background-image:url(<?php echo URLROOT; ?>/images/banner-image.png);"></div>
                                    </td>

                                    <td class="product-name">
                                        <h3><?php echo $cart->name; ?></h3>
                                        <p><?php echo $cart->description; ?></p>
                                    </td>

                                    <td class="price">$<?php echo number_format($cart->price, 2); ?></td>

                                    <td class="quantity">
                                        <div class="input-group mb-3">
                                            <select name="quantity" class="form-control">
                                                <?php
                                                $minQuantity = 1;
                                                $maxQuantity = $cart->quantity;

                                                for ($i = $minQuantity; $i <= $maxQuantity; $i++): ?>  
                                                    <option value="<?php echo $i; ?>" <?php echo ($i == $minQuantity) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </td>

                                    <td class="total" id="total2">$<?php echo number_format($cart->price, 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No items in cart</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row justify-content-start">
            <div class="col col-lg-5 col-md-6 mt-5 cart-wrap ftco-animate">
                <div class="cart-total mb-3">
                    <h3>Cart Totals</h3>
                    <p class="d-flex">
                        <span>Subtotal</span>
                        <span id="cart-subtotal">$<?php echo number_format($total, 2); ?></span>
                    </p>
                </div>
                <p class="text-center"><a href="<?php echo URLROOT; ?>/pages/checkout" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
            </div>
        </div> 
    </div>
</section>

<p id="demo">إجمالي السعر لكل المنتجات: $<?php echo number_format($total, 2); ?></p>



<script>
    // تحديد القيمة الابتدائية من PHP
    let initialTotal = parseFloat('<?php echo $total; ?>');

    function updateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.total').forEach(function(totalElement) {
            let total = parseFloat(totalElement.innerText.replace('$', ''));
            if (isNaN(total)) {
                total = 0;
            }
            grandTotal += total;
        });
        if (isNaN(grandTotal)) {
            grandTotal = initialTotal;
        }
        document.getElementById('cart-subtotal').innerText = `$${grandTotal.toFixed(2)}`;
    }

    function selectRandomQuantity() {
        let selects = document.querySelectorAll('select[name="quantity"]');
        selects.forEach(function(selectElement) {
            let options = selectElement.querySelectorAll('option');
            let randomIndex = Math.floor(Math.random() * options.length);
            selectElement.value = options[randomIndex].value;

            // إعادة القيمة إلى 1 بعد 0.25 ثانية (250 مللي ثانية)
            setTimeout(function() {
                selectElement.value = 1;
                // تحديث الإجمالي بعد إعادة القيمة
                updateGrandTotal();
            }, 250);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // اختيار قيمة عشوائية فور تحميل الصفحة وإعادة تعيينها بعد 0.25 ثانية
        selectRandomQuantity();
    });
</script>







<?php require APPROOT . '/views/inc/footer.php'; ?>
