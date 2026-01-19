
document.addEventListener("DOMContentLoaded", function () {
  updateCartCount();
});

function searchProducts() {
  const searchTerm = document.getElementById("search-input").value.trim();

  if (searchTerm === "") {
    alert("Please enter a search term");
    return;
  }

  var url =
    "../php/ProductHandler.php?action=search_products&search=" +
    encodeURIComponent(searchTerm);

  fetch(url)
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      if (data.status) {
        displayProducts(data.products);
      }
    })
    .catch(function (error) {
      console.log("Error:", error);
    });
}

function filterByCategory(category) {
  event.preventDefault();

  var url =
    "../php/ProductHandler.php?action=get_category_products&category=" +
    encodeURIComponent(category);

  fetch(url)
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      if (data.status) {
        displayProducts(data.products);
      }
    })
    .catch(function (error) {
      console.log("Error:", error);
    });
}

function displayProducts(products) {
  const container = document.getElementById("products-grid");
  container.innerHTML = "";

  if (products.length === 0) {
    container.innerHTML = "<p>No products found</p>";
    return;
  }

  products.forEach(function (product) {
    var imageName = product.product_image || "no-image.png";
    var desc = product.description
      ? product.description.substring(0, 50)
      : "No description";
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
      '<p class="description">' +
      desc +
      "...</p>" +
      '<div class="product-footer">' +
      '<span class="price">Tk. ' +
      price +
      "</span>" +
      '<div class="product-actions">' +
      '<button onclick="viewProduct(' +
      product.product_id +
      ')" class="btn btn-small">View</button>' +
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

function viewProduct(productId) {
  var url =
    "../php/ProductHandler.php?action=get_product&product_id=" + productId;
  fetch(url)
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      if (data.status) {
        displayProductModal(data.product);
      } else {
        alert("Product not found");
      }
    })
    .catch(function (error) {
      console.log("Error:", error);
    });
}

function displayProductModal(product) {
  const modalBody = document.getElementById("modal-body");
  var imageName = product.product_image || "no-image.png";
  var price = parseFloat(product.price).toFixed(2);
  var modalHtml =
    '<div class="product-detail">' +
    '<img src="../images/' +
    imageName +
    '" alt="' +
    product.product_name +
    '" style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 5px; margin-bottom: 20px;">' +
    "<h2>" +
    product.product_name +
    "</h2>" +
    "<p><strong>Category:</strong> " +
    product.category +
    "</p>" +
    "<p><strong>Description:</strong> " +
    product.description +
    "</p>" +
    "<p><strong>Price:</strong> Tk. " +
    price +
    "</p>" +
    "<p><strong>Stock:</strong> " +
    product.stock_quantity +
    " units available</p>" +
    '<button onclick="addToCart(' +
    product.product_id +
    ')" class="btn btn-primary" style="width: 100%; margin-top: 20px;">Add to Cart</button>' +
    "</div>";

  modalBody.innerHTML = modalHtml;

  openModal();
}

function openModal() {
  document.getElementById("product-modal").classList.add("show");
}

function closeModal() {
  document.getElementById("product-modal").classList.remove("show");
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
        closeModal();
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

document
  .getElementById("product-modal")
  .addEventListener("click", function (event) {
    if (event.target === this) {
      closeModal();
    }
  });
