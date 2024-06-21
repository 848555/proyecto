document.addEventListener('DOMContentLoaded', function() {
    const menuIcon = document.getElementById('menuIcon');
    const closeIcon = document.getElementById('closeIcon');
    const barraLateral = document.getElementById('barraLateral');

    menuIcon.addEventListener('click', function() {
        barraLateral.style.display = 'block';
        menuIcon.style.display = 'none';
        closeIcon.style.display = 'block';
    });

    closeIcon.addEventListener('click', function() {
        barraLateral.style.display = 'none';
        menuIcon.style.display = 'block';
        closeIcon.style.display = 'none';
    });

    
});
