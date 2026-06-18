document.addEventListener("DOMContentLoaded", function () {

    const rows = document.querySelectorAll(".ingredient-row");

    rows.forEach(row => {

        const minusBtn = row.querySelector(".minus");
        const plusBtn = row.querySelector(".plus");
        const qtyDisplay = row.querySelector(".ing-qty-number");
        const addBtn = row.querySelector(".add-cart-small");

        // Skip if anything is missing
        if (!minusBtn || !plusBtn || !qtyDisplay || !addBtn) {
            return;
        }

        let qty = parseInt(qtyDisplay.textContent) || 1;

        // Minus button
        minusBtn.addEventListener("click", () => {
            if (qty > 1) {
                qty--;
                qtyDisplay.textContent = qty;
            }
        });

        // Plus button
        plusBtn.addEventListener("click", () => {
            qty++;
            qtyDisplay.textContent = qty;
        });

        // ⭐ Add to Cart
        addBtn.addEventListener("click", () => {
            const ingredientId = row.dataset.id;

            fetch("add_to_cart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `id=${ingredientId}&qty=${qty}`
            })
                .then(res => res.text())
                .then(data => {
                    console.log(data);
                    addBtn.textContent = "Added";
                    setTimeout(() => addBtn.textContent = "Add", 1000);
                });
        });

    }); // end rows.forEach

}); // end DOMContentLoaded
