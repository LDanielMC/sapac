document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#employeeTable tbody tr');

    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
});
