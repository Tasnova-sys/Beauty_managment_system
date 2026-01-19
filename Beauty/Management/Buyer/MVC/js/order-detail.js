
document.addEventListener("DOMContentLoaded", function () {
  updateCartCount();
});

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
