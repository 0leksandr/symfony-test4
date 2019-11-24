'use strict';

function loadPage(offset, length) {
    ajax("products-async.php?offset=" + offset + "&length=" + length, (response) => {
        let productsHtml = '';
        let products = JSON.parse(response);
        foreach(products, (product, article) => {
            productsHtml += `
                <div class='product'>
                    <a href='product.php?article=${article}'>
                        <img src='${product['image']}' alt='${product['name']}'>
                        <div class='product-name'>${product['name']}</div>
                        <div class='product-price'>
                            <span class='amount'>${product['price']}</span>
                            <span class='currency'>$</span>
                        </div>
                    </a>
                    <button class='button-buy'>Buy</button>
                </div>
            `;
        });
        document.getElementById('products').innerHTML = productsHtml;
        updateButtons();
    });
}
