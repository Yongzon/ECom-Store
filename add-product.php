<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>
<?php

use Aries\MiniFrameworkStore\Models\Category;
use Aries\MiniFrameworkStore\Models\Product;
use Carbon\Carbon;

$categories = new Category();
$product = new Product();

$message = '';
$message_type = 'success'; // can be 'success', 'danger', etc.

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $category = $_POST['category'];
    $image = $_FILES['image'];

    // Validate inputs
    if (empty($name) || empty($description) || empty($price) || empty($category)) {
        $message = 'Please fill in all required fields.';
        $message_type = 'danger';
    } elseif (!is_numeric($price) || $price <= 0) {
        $message = 'Please enter a valid price (must be a positive number).';
        $message_type = 'danger';
    } elseif ($image['error'] !== UPLOAD_ERR_OK) {
        $message = 'Please upload a valid product image.';
        $message_type = 'danger';
    } else {
        // Process the image file
        $targetDir = "uploads/";
        $imageFileType = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
        $newFilename = uniqid() . '.' . $imageFileType;
        $targetFile = $targetDir . $newFilename;

        // Check if image file is an actual image
        $check = getimagesize($image["tmp_name"]);
        if ($check === false) {
            $message = 'File is not an image.';
            $message_type = 'danger';
        } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            $message = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
            $message_type = 'danger';
        } elseif (move_uploaded_file($image["tmp_name"], $targetFile)) {
            // Insert the product into the database
            $product->insert([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'image_path' => $targetFile,
                'category_id' => $category,
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now()
            ]);

            $message = "Product added successfully!";
            $message_type = 'success';
        } else {
            $message = 'Sorry, there was an error uploading your file.';
            $message_type = 'danger';
        }
    }
}

?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Add New Product</h2>
                </div>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                            <?php echo $message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form action="add-product.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product-name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="product-name" name="name" required>
                                    <div class="invalid-feedback">
                                        Please provide a product name.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product-price" class="form-label">Price (₱) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="number" class="form-control" id="product-price" name="price" step="0.01" min="0" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid price.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="product-description" class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="product-description" name="description" rows="5" required></textarea>
                                    <div class="invalid-feedback">
                                        Please provide a product description.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product-category" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" id="product-category" name="category" required>
                                        <option value="" selected disabled>Select category</option>
                                        <?php foreach($categories->getAll() as $category): ?>
                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a category.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product-image" class="form-label">Product Image <span class="text-danger">*</span></label>
                                    <input class="form-control" type="file" id="product-image" name="image" accept="image/*" required>
                                    <div class="invalid-feedback">
                                        Please upload a product image.
                                    </div>
                                    <small class="text-muted">Accepted formats: JPG, PNG, JPEG, GIF</small>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary btn-lg" type="submit" name="submit">
                                        <i class="bi bi-plus-circle me-2"></i> Add Product
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Bootstrap form validation
(function () {
    'use strict'
    
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
    
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>

<?php template('footer.php'); ?>