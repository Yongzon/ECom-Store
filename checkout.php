<?php
session_start();
include 'helpers/functions.php';
require 'vendor/autoload.php';

use Aries\MiniFrameworkStore\Models\Checkout;
use Carbon\Carbon;

$checkout = new Checkout();

$superTotal = 0;
$orderId = null;
$message = ''; 
$message_type = ''; 

if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach($_SESSION['cart'] as $item) {
        $itemTotal = isset($item['total']) ? (float)$item['total'] : 0;
        $itemQuantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;
        $superTotal += $itemTotal * $itemQuantity;
    }
} else {
    $message = 'Your cart is empty. Please add items before checking out.';
    $message_type = 'info';
}

$amounLocale = 'en_PH';
$pesoFormatter = new NumberFormatter($amounLocale, NumberFormatter::CURRENCY);

if(isset($_POST['submit']) && $superTotal > 0 && empty($message)) {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $payment_method = 'COD'; 

    if (empty($name) || empty($address) || empty($phone)) {
        $message = 'Please fill in all shipping information fields.';
        $message_type = 'danger';
    } elseif (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $message = 'Please enter a valid phone number (10-15 digits, digits only).';
        $message_type = 'danger';
    } else {
        
        try {
            if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
                $orderId = $checkout->userCheckout([
                    'user_id' => $_SESSION['user']['id'],
                    'total' => $superTotal,
                    'payment_method' => $payment_method
                ]);
            } else {
                $orderId = $checkout->guestCheckout([
                    'name' => $name,
                    'address' => $address,
                    'phone' => $phone,
                    'total' => $superTotal,
                    'payment_method' => $payment_method
                ]);
            }

            if ($orderId) {
                foreach($_SESSION['cart'] as $item) {
                    $checkout->saveOrderDetails([
                        'order_id' => $orderId,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => (float)($item['price'] * $item['quantity'])
                    ]);
                }

                unset($_SESSION['cart']);

                $message = 'Order placed successfully! Your Order ID is: <strong>' . htmlspecialchars($orderId) . '</strong>. Redirecting to dashboard...';
                $message_type = 'success';
                
                echo '<meta http-equiv="refresh" content="3;url=dashboard.php">';
            } else {
                $message = 'Failed to place order. Please try again.';
                $message_type = 'danger';
            }
        } catch (Exception $e) {
            $message = 'An error occurred: ' . htmlspecialchars($e->getMessage());
            $message_type = 'danger';
        }
    }
}

template('header.php');
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h1 class="mb-4 text-center text-primary">Checkout</h1>

            <?php if (!empty($message)) : ?>
                <div class="alert alert-<?php echo htmlspecialchars($message_type); ?> mb-4 text-center" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="card shadow p-4 mb-4">
                <h2 class="card-title h4 mb-3">Order Summary</h2>
                <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-end">Unit Price</th>
                                    <th scope="col" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($_SESSION['cart'] as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['name'] ?? 'N/A'); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($item['quantity'] ?? 0); ?></td>
                                        <td class="text-end"><?php echo $pesoFormatter->formatCurrency($item['price'] ?? 0, 'PHP'); ?></td>
                                        <td class="text-end"><?php echo $pesoFormatter->formatCurrency($item['total'] ?? 0, 'PHP'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="3" class="text-end h5 mb-0 py-3"><strong>Grand Total</strong></td>
                                    <td class="text-end h5 mb-0 py-3"><strong><?php echo $pesoFormatter->formatCurrency($superTotal, 'PHP'); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <a href="cart.php" class="btn btn-outline-secondary">Edit Cart</a>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted py-3">Your cart is empty. Please add items to proceed with checkout.</p>
                    <div class="text-center mb-3">
                        <a href="index.php" class="btn btn-primary">Continue Shopping</a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart']) && $superTotal > 0):  ?>
                <div class="card shadow p-4">
                    <h2 class="card-title h4 mb-3">Shipping Information</h2>
                    <form action="checkout.php" method="POST">
                        <?php if (isset($_SESSION['user'])) :  ?>
                            <div class="alert alert-info" role="alert">
                                You are logged in. We'll use your account details for delivery. Please update if needed.
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['user']['name'] ?? ''); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Delivery Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required autocomplete="street-address"><?php echo htmlspecialchars($_SESSION['user']['address'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($_SESSION['user']['phone'] ?? ''); ?>" required pattern="[0-9]{10,15}">
                                <small class="form-text text-muted">e.g., 09123456789 (10-15 digits, numbers only).</small>
                            </div>
                        <?php else: // Fields for guests ?>
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required autocomplete="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Delivery Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required autocomplete="street-address"><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required autocomplete="tel" pattern="[0-9]{10,15}" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                                <small class="form-text text-muted">e.g., 09123456789 (10-15 digits, numbers only).</small>
                            </div>
                        <?php endif; ?>

                        <div class="mb-4">
                            <p class="mb-1"><strong>Payment Method:</strong></p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method_display" id="paymentCod" value="COD" checked disabled>
                                <label class="form-check-label" for="paymentCod">
                                    Cash on Delivery (COD)
                                </label>
                            </div>
                            <input type="hidden" name="payment_method" value="COD"> </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg" name="submit">Place Order</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php template('footer.php'); ?>