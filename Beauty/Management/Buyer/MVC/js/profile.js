
function switchTab(tabName) {
  const tabs = document.querySelectorAll(".tab-content");
  tabs.forEach(function (tab) {
    tab.classList.remove("active");
  });

  const buttons = document.querySelectorAll(".tab-btn");
  buttons.forEach(function (btn) {
    btn.classList.remove("active");
  });

  const selectedTab = document.getElementById(tabName + "-tab");
  if (selectedTab) {
    selectedTab.classList.add("active");
  }

  event.target.classList.add("active");
}

function deleteAccount() {
  if (
    !confirm(
      "Are you sure you want to delete your account? This action cannot be undone.",
    )
  ) {
    return;
  }

  if (!confirm("This will permanently delete all your data. Continue?")) {
    return;
  }

  const password = prompt(
    "Please enter your password to confirm account deletion:",
  );
  if (!password) {
    alert("Password is required to delete account");
    return;
  }

  const form = document.createElement("form");
  form.method = "POST";
  form.action = "../php/ProfileHandler.php";

  const actionInput = document.createElement("input");
  actionInput.type = "hidden";
  actionInput.name = "action";
  actionInput.value = "delete_account";
  form.appendChild(actionInput);

  const passwordInput = document.createElement("input");
  passwordInput.type = "hidden";
  passwordInput.name = "password";
  passwordInput.value = password;
  form.appendChild(passwordInput);

  document.body.appendChild(form);
  form.submit();
}

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
