
document.addEventListener('DOMContentLoaded', function () {
    const searchInputs = document.querySelectorAll('input[name="search"]');
    
    searchInputs.forEach(input => {
        input.addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            const tableBody = this.closest('form').nextElementSibling.querySelector('tbody');
            const rows = tableBody.querySelectorAll('tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    });
});
