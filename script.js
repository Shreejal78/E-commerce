let categoryBtn = document.getElementById("categoryBtn");
let categoryBox = document.querySelector(".categoryBox");
let categoryOption = document.querySelectorAll(".categoryOption");
let productContainer = document.getElementById("products");
categoryBtn.addEventListener("click", () => {
  if (categoryBox.style.display == "none") {
    categoryBox.style.display = "flex";
  } else {
    categoryBox.style.display = "none";
  }
});

categoryOption.forEach((btn) => {
  btn.addEventListener("click", async () => {
    {
      let res = await fetch("loadProducts.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `category=${btn.dataset.category}`,
      });
      let products = await res.json();
      productContainer.innerHTML = "";
      products.forEach((product) => {
        productContainer.innerHTML += `
        <div class="card" onclick="location.href='product.php?product_id=${product.id}'">
                    <img src="${product.image}" alt="" loading='lazy'>
                    <div class="card-content">
                        <h2>${product.name}</h2>
                        <div class="price">$${product.price}</div>
                        <button onclick="location.href='product.php?product_id=${product.id}'">
                            View Product
                        </button>
                    </div>
                </div>
        `;
      });
    }
  });
});

let search = document.getElementById("search");
let timeout;
let searchBtn = document.getElementById("searchBtn");

search.addEventListener("input", () => {
  clearTimeout(timeout);
  timeout = setTimeout(async () => {
    let res = await fetch("loadSearch.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `search=${search.value}`,
    });
    let products = await res.json();
    console.log(products);
    productContainer.innerHTML = "";
    products.forEach((product) => {
      productContainer.innerHTML += `
        <div class="card" onclick="location.href='product.php?product_id=${product.id}'">
                    <img src="${product.image}" alt="" loading='lazy'>
                    <div class="card-content">
                        <h2>${product.name}</h2>
                        <div class="price">$${product.price}</div>
                        <button onclick="location.href='product.php?product_id=${product.id}'">
                            View Product
                        </button>
                    </div>
                </div>
        `;
    });
  }, 500);
});


searchBtn.addEventListener("click", async () => {
  let res = await fetch("loadSearch.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `search=${search.value}`,
  });
  let products = await res.json();
  console.log(products);
  productContainer.innerHTML = "";
  products.forEach((product) => {
    productContainer.innerHTML += `
        <div class="card" onclick="location.href='product.php?product_id=${product.id}'">
                    <img src="${product.image}" alt="" loading='lazy'>
                    <div class="card-content">
                        <h2>${product.name}</h2>
                        <div class="price">$${product.price}</div>
                        <button onclick="location.href='product.php?product_id=${product.id}'">
                            View Product
                        </button>
                    </div>
                </div>
        `;
  });
});
