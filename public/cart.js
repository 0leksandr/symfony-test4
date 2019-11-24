'use strict';

let cart = {};

function toggleCart() {
    document.querySelector('#cart-modal').classList.toggle('visible');
}

let addToCart = function (productName, price) {
    if (productName in cart) {
        cart[productName].quantity++;
    } else {
        cart[productName] = {
            name: productName,
            price: price,
            quantity: 1
        };
    }
    drawCart();
};
function drawCart() {
    let cartContent = '';
    foreach(cart, function (product) {
        cartContent += `
            <div class="product">
                <div class="product-name">${product.name}</div>
                <div class="price">
                    <span class="amount">${product.price}</span>
                    <span class="currency">$</span>
                </div>
                <div class="quantity">
                    <input type="number"
                           value="${product.quantity}"
                           min="1"
                           onchange="changeQuantity('${product.name}', this.value)"
                    >
                </div>
                <div class="remove" onclick="remove(this)">X</div>
            </div>
        `;
    });
    document.querySelector('#product-list').innerHTML = cartContent;
    updateTotal();
}
function updateTotal() {
    let total = 0;
    foreach(cart, function (product) {
        total += product.price * product.quantity;
    });
    total = total.toString();

    let elem = document.querySelector('#cart-total .amount');
    if (total !== elem.innerHTML) {
        let time = 400;
        animate(elem, 'transform', 0, 90, 'rotateX($grad)', time);
        setTimeout(
            () => {
                elem.innerHTML = total;
                animate(elem, 'transform', 90, 0, 'rotateX($grad)', time);
            },
            time
        );
    }
}
function changeQuantity(productName, quantity) {
    cart[productName].quantity = quantity;
    updateTotal();
}

function updateButtons() {
    document.querySelectorAll('.button-buy').forEach(function (button) {
        button.onclick = function () {
            let product = button.parentNode;
            let name = product.querySelector('.product-name').innerHTML;
            let price = +product.querySelector('.product-price .amount').innerHTML;
            addToCart(name, price);
        };
    });
}
updateButtons();

function remove(button) {
    let product = button.parentNode;
    let time = 500;
    product.style.opacity = '0';
    animate(product, 'left', 0, -100, '$%', time);

    setTimeout(
        () => {
            delete cart[product.querySelector('.product-name').innerHTML];
            drawCart();
        },
        time
    );
}
