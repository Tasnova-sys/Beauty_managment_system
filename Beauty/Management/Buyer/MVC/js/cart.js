
document.addEventListener("DOMContentLoaded", function () {
  updateCartCount();
});

function updateCartQuantity(cartId, quantity) {
  quantity = parseInt(quantity);

  if (quantity < 1) {
    removeFromCart(cartId);
    return;
  }

  const formData = new FormData();
  formData.append("action", "update_cart");
  formData.append("cart_id", cartId);
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
        window.location.href = "cart.php?success=1";
      } else {
        alert(data.message);
      }
    })
    .catch(function (error) {
      console.log("Error:", error);
    });
}

function removeFromCart(cartId) {
  if (!confirm("Remove this item from cart?")) {
    return;
  }

  const formData = new FormData();
  formData.append("action", "remove_from_cart");
  formData.append("cart_id", cartId);

  fetch("../php/CartHandler.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      if (data.status) {
        window.location.href = "cart.php?success=1";
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
