
document.addEventListener("DOMContentLoaded", function () {
  loadFeaturedProducts();
  updateCartCount();
});

function loadFeaturedProducts() {
  fetch("../php/ProductHandler.php?action=get_category_products&category=")
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      if (data.status) {
        displayFeaturedProducts(data.products.slice(0, 3));
      }
    })
    .catch(function (error) {
      console.log("Error:", error);
    });
}

function displayFeaturedProducts(products) {
  const container = document.getElementById("featured-products");
  container.innerHTML = "";

  if (products.length === 0) {
    container.innerHTML = "<p>No products available</p>";
    return;
  }

  products.forEach(function (product) {
    var imageName = product.product_image || "no-image.png";
    var price = parseFloat(product.price).toFixed(2);
    var productHTML =
      '<div class="product-card">' +
      '<div class="product-image">' +
      '<img src="../images/' +
      imageName +
      '" alt="' +
      product.product_name +
      '">' +
      "</div>" +
      '<div class="product-info">' +
      "<h3>" +
      product.product_name.substring(0, 30) +
      "</h3>" +
      '<p class="category">' +
      product.category +
      "</p>" +
      '<div class="product-footer">' +
      '<span class="price">Tk. ' +
      price +
      "</span>" +
      '<div class="product-actions">' +
      '<button onclick="addToCart(' +
      product.product_id +
      ')" class="btn btn-small btn-primary">Add Cart</button>' +
      "</div>" +
      "</div>" +
      "</div>" +
      "</div>";
    container.innerHTML += productHTML;
  });
}

function addToCart(productId, quantity) {
  if (!quantity) {
    quantity = 1;
  }
  const formData = new FormData();
  formData.append("action", "add_to_cart");
  formData.append("product_id", productId);
  formData.append("quantity", quantity);

  fetch("../php/CartHandler.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      if (data.status) {
        alert(data.message);
        updateCartCount();
      } else {
        alert(data.message);
      }
    })
    .catch(function (error) {
      console.log("Error:", error);
    });
}

function updateCartCount() {
  const formData = new FormData();
  formData.append("action", "get_cart_count");

  fetch("../php/CartHandler.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      if (data.status) {
        const cartBadges = document.querySelectorAll("#cart-count");
        cartBadges.forEach(function (badge) {
          badge.textContent = data.count > 0 ? data.count : "";
        });
      }
    })
    .catch(function (error) {
      console.log("Error:", error);
    });
}
