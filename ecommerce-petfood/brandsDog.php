<?php
session_start();
include('db.php');

// Function to format price as Rupiah
function formatRupiah($price) {
    return 'Rp' . number_format($price, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food and Snacks For Dogs</title>
    <link rel="stylesheet" href="projectBrand.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.add-to-cart-form').on('submit', function(e){
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    type: form.attr('method'),
                    url: 'cart.php',
                    data: form.serialize(),
                    success: function(response){
                        alert('Product added to cart successfully!');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="navbar">
        <div class="logo"><a href="brandsDog.php">E-Commerce</a></div>
        <input type="search" name="" id="" class="search-bar" placeholder="Search...">
        <div class="icons">
            <a href="cart.php"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAqlJREFUSEvNlluITlEUx3/jnkt5YUJuQ2hoeFNSvCDlknhSbkkiTSQemJHrg0siKXmQXB6kJkSJF5J4FIXcbxGTS7llEPuvdbTndM759vZNfdbLzLf3f63/Weus9V+nigpZVYV4+e+JewDbgD3Ao5wq1QArgfXAx1KVDM14N7DKgg0AnqcC6+ypnQm7ui2IhwJ3gfbAUZfx/JygR4B5wE9gBPCgiDwk4wvAJOAboHK+zAnY1xE/BLoAF4HJ5RBPB85YgC3AhhIlFKbBMPI9m4cvyrgjcBtQqZuBQcCXEsRdgcdAbyt1rWu271k+RcRrge3mtBg4VKph7H4JcND+V4ydMcS9gCeAMlDWo4BfgcTtgJvASBurIVaxVu5+xgOBzYD+9gGGGVKlexZImsA0XoPtxz3gFfACWJfE8onrgb2RBLHwFcB+OfnEE4BLFul+wdjEkvWzBpXfROBymrgD8AnoDBwAlsUy5OAVa6npQHc3bj/SxPp9HphiQqAxagtTf/S32FOTgOlxksbussssTdaSGAPcsIUgaNZZEl8Pr9cmU2zp+B9LE4+2oLpTqVUm39QD6gW9J70vWdZZ4rM8aSagDriVR6zz9y6Lng7Y5ICzyyQ+BcwE3gDVfqws5ToOzAU+A9rDvnDEZKxm/eCUq5vr6mO2uf5yZxEv8uRxnGu2a96TxhCPB66Y7wK32bQ2C4kl8K8NsdH1waZ/JJYKNpqvyqxyFxLrUot/uNvDVwE9eWILbUtJxw/bYdaZrq4DY03rpdutLG877QMkbxp2NZred4zJ551NjWRY32JBxDOA04ac5WZX3Rljc9x2OmkO04BzocSStrdApxi2DGyLVexrKLFwO1yJ15RJvNVrsKBSC6SsVXJ94GkmY+0OcCLPKeQrM5YwCF8x4t/VCoUfQcCP2QAAAABJRU5ErkJggg==" class="icon"/></a>
        </div>
    </div>

    <ul class="menu">
        <li><a href="brandsCat.php">Cats</a></li>
        <li><a href="brandsDog.php">Dogs</a></li>
        <li><a href="#contacts">Contacts</a></li>
    </ul>

    <nav class="category-menu">
        <ul>
            <li><a href="brandsDog.php">Dogs</a></li>
        </ul>
    </nav>

    <div class="container">
        <img src="img/dog2.jpg" alt="gambar anjing">
    </div>

    <section class="products">
        <h2>Our Products</h2>
        <div class="product-list">
            <?php
            // Fetch products for dogs category
            $sql = "SELECT * FROM products WHERE category = 'Dog'";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='product'>
                    <img src='img/{$row['image']}' alt='{$row['name']}'>
                    <h3>{$row['name']}</h3>
                    <p>{$row['description']}</p>
                    <p class='price'>" . formatRupiah($row['price']) . "</p>
                    <form method='post' class='add-to-cart-form'>
                        <input type='hidden' name='action' value='add_to_cart'>
                        <input type='hidden' name='product_id' value='{$row['id']}'>
                        <button type='submit'>Add to Cart</button>
                    </form>
                </div>";
            }
            ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 E-Commerce Pet Food. All rights reserved.</p>
    </footer>
</body>
</html>
