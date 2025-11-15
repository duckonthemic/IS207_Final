/**
 * Product Filter - Dynamic AJAX filtering without page reload
 */

document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const productGrid = document.querySelector('[data-product-grid]');
    const sortLinks = document.querySelectorAll('[data-sort-link]');
    
    if (!filterForm) return;

    // Auto-submit form on filter change
    const filterInputs = filterForm.querySelectorAll('input[type="checkbox"], input[type="radio"]:not([name="category"])');
    
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Optionally add debounce here
            submitFilterForm();
        });
    });

    // Handle sort links
    sortLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const sortValue = this.dataset.sort;
            
            // Add sort parameter to form
            let sortInput = filterForm.querySelector('input[name="sort"]');
            if (!sortInput) {
                sortInput = document.createElement('input');
                sortInput.type = 'hidden';
                sortInput.name = 'sort';
                filterForm.appendChild(sortInput);
            }
            sortInput.value = sortValue;
            
            submitFilterForm();
        });
    });

    function submitFilterForm() {
        // Show loading state
        if (productGrid) {
            productGrid.style.opacity = '0.5';
            productGrid.style.pointerEvents = 'none';
        }

        // Get form data
        const formData = new FormData(filterForm);
        const params = new URLSearchParams(formData);

        // Update URL without reload
        const newUrl = `${window.location.pathname}?${params.toString()}`;
        window.history.pushState({}, '', newUrl);

        // Submit form via AJAX
        fetch(newUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Parse the HTML response
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Update product grid
            const newProductGrid = doc.querySelector('[data-product-grid]');
            if (newProductGrid && productGrid) {
                productGrid.innerHTML = newProductGrid.innerHTML;
                productGrid.style.opacity = '1';
                productGrid.style.pointerEvents = 'auto';
            }
            
            // Update product count
            const newCount = doc.querySelector('[data-product-count]');
            const oldCount = document.querySelector('[data-product-count]');
            if (newCount && oldCount) {
                oldCount.textContent = newCount.textContent;
            }

            // Update pagination
            const newPagination = doc.querySelector('[data-pagination]');
            const oldPagination = document.querySelector('[data-pagination]');
            if (newPagination && oldPagination) {
                oldPagination.innerHTML = newPagination.innerHTML;
            }

            // Scroll to top of results
            window.scrollTo({
                top: document.querySelector('.container').offsetTop - 100,
                behavior: 'smooth'
            });
        })
        .catch(error => {
            console.error('Filter error:', error);
            // Fallback to normal form submission
            filterForm.submit();
        });
    }

    // Handle pagination links
    document.addEventListener('click', function(e) {
        const paginationLink = e.target.closest('[data-pagination] a');
        if (paginationLink && paginationLink.href) {
            e.preventDefault();
            
            // Show loading
            if (productGrid) {
                productGrid.style.opacity = '0.5';
            }
            
            fetch(paginationLink.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Update product grid
                const newProductGrid = doc.querySelector('[data-product-grid]');
                if (newProductGrid && productGrid) {
                    productGrid.innerHTML = newProductGrid.innerHTML;
                    productGrid.style.opacity = '1';
                }
                
                // Update pagination
                const newPagination = doc.querySelector('[data-pagination]');
                const oldPagination = document.querySelector('[data-pagination]');
                if (newPagination && oldPagination) {
                    oldPagination.innerHTML = newPagination.innerHTML;
                }
                
                // Update URL
                window.history.pushState({}, '', paginationLink.href);
                
                // Scroll to top
                window.scrollTo({
                    top: document.querySelector('.container').offsetTop - 100,
                    behavior: 'smooth'
                });
            })
            .catch(error => {
                console.error('Pagination error:', error);
                window.location.href = paginationLink.href;
            });
        }
    });
});
