document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchCA');
    const tableRows = document.querySelectorAll('#CASearch tbody tr');

    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
});
