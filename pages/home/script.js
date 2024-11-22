const buttons = document.querySelectorAll('.btn-buy');

for (let i = 0; i < buttons.length; i++) {
    const button = buttons[i];
    button.addEventListener('click', () => {
        const product = {
            id: button.getAttribute('data-id'),
            name: button.getAttribute('data-name'),
            price: button.getAttribute('data-price'),
            description: button.getAttribute('data-description'),
            image: button.getAttribute('data-image'),
            quantity: 1 
        };

        const cart = JSON.parse(localStorage.getItem('cart')) || []; 

        const existingProductIndex = cart.findIndex(item => item.id === product.id);

        if (existingProductIndex !== -1) {
            cart[existingProductIndex].quantity += 1;
        } else {
            cart.push(product);
        }

        localStorage.setItem('cart', JSON.stringify(cart));
    });
}
