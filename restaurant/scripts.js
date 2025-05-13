document.addEventListener('DOMContentLoaded', () => {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const quantities = document.querySelectorAll('.quantity');
    const totalInput = document.getElementById('total');

    const updateTotal = () => {
        let total = 0;
        checkboxes.forEach((checkbox, index) => {
            if (checkbox.checked) {
                const price = parseFloat(checkbox.dataset.price);
                const quantity = parseInt(quantities[index].value);
                total += price * quantity;
            }
        });
        totalInput.value = total.toFixed(2);
    };

    checkboxes.forEach((checkbox, index) => {
        checkbox.addEventListener('change', () => {
            quantities[index].disabled = !checkbox.checked;
            if (!checkbox.checked) quantities[index].value = 0;
            updateTotal();
        });
    });

    quantities.forEach(quantity => {
        quantity.addEventListener('input', updateTotal);
    });
});