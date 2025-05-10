function loadNavigation() {
    fetch('../components/nav.html')
        .then(response => response.text())
        .then(data => {
            document.querySelector('body').insertAdjacentHTML('afterbegin', data);
        })
        .catch(error => console.error('Error al cargar la navegación:', error));
}

// Cargar la navegación cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', loadNavigation); 