document.addEventListener('DOMContentLoaded', function () {

    if (typeof productBadgesData === 'undefined') {
        return;
    }

    document.querySelectorAll('.cart-item').forEach(function(cartItem) {

        const link = cartItem.querySelector('.product-line-info a');

        if (!link) {
            return;
        }

        const href = link.getAttribute('href');

        const match = href.match(/\/(\d+)-/);

        if (!match) {
            return;
        }

        const productId = parseInt(match[1]);

        if (!productBadgesData[productId]) {
            return;
        }

        const badgesContainer = document.createElement('div');
        badgesContainer.className = 'product-badges-list cart-product-badges';

        productBadgesData[productId].forEach(function(badge) {

            const badgeElement = document.createElement('span');

            badgeElement.className = 'product-badge';
            badgeElement.innerText = badge.label;
            badgeElement.style.backgroundColor = badge.color;

            badgesContainer.appendChild(badgeElement);
        });

        const productInfo = cartItem.querySelector('.product-line-info');

        if (productInfo) {
            productInfo.appendChild(badgesContainer);
        }
    });
});