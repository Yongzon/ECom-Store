<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>

<?php
use Aries\MiniFrameworkStore\Models\Product;

$products = new Product();
$category = $_GET['name'];

$amounLocale = 'en_PH';
$pesoFormatter = new NumberFormatter($amounLocale, NumberFormatter::CURRENCY);
?>

<div class="container my-5">
    <div class="row align-items-center mb-4">
        <div class="col-md-12">
            <h1 class="text-center display-4"><?php echo htmlspecialchars($category) ?></h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="border-bottom pb-2">Available Products</h2>
        </div>
        
        <?php foreach($products->getByCategory($category) as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="<?php echo htmlspecialchars($product['image_path']) ?>" class="card-img-top p-3" alt="<?php echo htmlspecialchars($product['name']) ?>" style="height: 250px; object-fit: contain;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo htmlspecialchars($product['name']) ?></h5>
                    <h6 class="card-subtitle mb-2 text-danger"><?php echo $pesoFormatter->formatCurrency($product['price'], 'PHP') ?></h6>
                    <p class="card-text text-muted flex-grow-1"><?php echo htmlspecialchars($product['description']) ?></p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="product.php?id=<?php echo $product['id'] ?>" class="btn btn-outline-primary me-md-2">View Details</a>
                        <a href="cart.php?product_id=<?php echo $product['id'] ?>" class="btn btn-success">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php template('footer.php'); ?>