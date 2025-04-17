

document.addEventListener('DOMContentLoaded', () => {
    const products = document.querySelectorAll('.product-card');
    const accessoryFilters = document.querySelectorAll('.accessory-filter input[type="checkbox"]');
    const stoneFilters = document.querySelectorAll('.stone-filter input[type="checkbox"]');
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');
    const clearBtn = document.querySelector('.clear-filters');

    // Handle checkbox groups
    function handleCheckboxGroup(group) {
        group.forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                if(e.target.value === 'All') {
                    group.forEach(cb => {
                        if(cb !== e.target) cb.checked = false;
                    });
                } else {
                    group[0].checked = false; // Uncheck "All"
                }
                filterProducts();
            });
        });
    }

    // Filter products function
    function filterProducts() {
        const selectedAccessories = Array.from(accessoryFilters)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        const selectedStones = Array.from(stoneFilters)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        const minPrice = parseFloat(minPriceInput.value) || 0;
        const maxPrice = parseFloat(maxPriceInput.value) || Infinity;

        products.forEach(product => {
            const category = product.dataset.category;
            const stone = product.dataset.stone;
            const price = parseFloat(product.dataset.price);

            const categoryMatch = selectedAccessories.includes('All') || 
                selectedAccessories.includes(category);
            
            const stoneMatch = selectedStones.includes('All') || 
                selectedStones.includes(stone);

            const priceMatch = price >= minPrice && price <= maxPrice;

            product.style.display = (categoryMatch && stoneMatch && priceMatch) 
                ? 'block' 
                : 'none';
        });
    }

    // Initialize checkbox groups
    handleCheckboxGroup(accessoryFilters);
    handleCheckboxGroup(stoneFilters);

    // Event Listeners
    minPriceInput.addEventListener('input', filterProducts);
    maxPriceInput.addEventListener('input', filterProducts);

    clearBtn.addEventListener('click', () => {
        // Reset accessory filters
        accessoryFilters[0].checked = true;
        accessoryFilters.forEach((cb, index) => {
            if(index !== 0) cb.checked = false;
        });

        // Reset stone filters
        stoneFilters[0].checked = true;
        stoneFilters.forEach((cb, index) => {
            if(index !== 0) cb.checked = false;
        });

        // Reset price inputs
        minPriceInput.value = '';
        maxPriceInput.value = '';
        
        filterProducts();
    });

    // Initial filter
    filterProducts();
});