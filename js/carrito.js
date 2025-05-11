// Funciones comunes para el manejo del carrito
function agregarAlCarrito(productoId, talla = null) {
    const cantidad = document.getElementById('cantidad') ? document.getElementById('cantidad').value : 1;
    const loader = document.getElementById('loader');
    
    // Validar cantidad
    if (cantidad < 1 || cantidad > 99) {
        alert('Por favor, selecciona una cantidad válida (1-99)');
        return;
    }

    // Si el producto tiene tallas, validar que se haya seleccionado una
    if (talla === '') {
        alert('Por favor, selecciona una talla');
        return;
    }

    // Mostrar loader si existe
    if (loader) {
        loader.style.display = 'block';
    }

    // Preparar datos para la petición
    const datos = {
        producto_id: productoId,
        cantidad: parseInt(cantidad)
    };

    // Añadir talla solo si existe
    if (talla) {
        datos.talla = talla;
    }

    // Realizar petición AJAX
    fetch('api/carrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar contador del carrito
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
            }
            
            // Mostrar mensaje de éxito usando toast
            if (typeof mostrarToast === 'function') {
                mostrarToast('Producto añadido al carrito');
            } else {
                alert('Producto añadido al carrito');
            }
        } else {
            // Mostrar mensaje de error
            alert(data.message || 'Error al añadir el producto al carrito');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al añadir el producto al carrito');
    })
    .finally(() => {
        // Ocultar loader si existe
        if (loader) {
            loader.style.display = 'none';
        }
    });
}

// Función para manejar la galería de imágenes
function initImageGallery() {
    const mainImage = document.getElementById('main-image');
    const thumbnails = document.querySelectorAll('.thumbnail');
    
    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                // Remover clase active de todas las miniaturas
                thumbnails.forEach(t => t.classList.remove('active'));
                // Agregar clase active a la miniatura clickeada
                this.classList.add('active');
                // Actualizar imagen principal
                mainImage.src = this.src;
            });
        });
    }
}

// Función para manejar el selector de tallas
function initTallaSelector() {
    const tallaSelector = document.querySelector('.talla-selector');
    if (tallaSelector) {
        const tallas = tallaSelector.querySelectorAll('.talla');
        tallas.forEach(talla => {
            talla.addEventListener('click', function() {
                // Remover clase active de todas las tallas
                tallas.forEach(t => t.classList.remove('active'));
                // Agregar clase active a la talla seleccionada
                this.classList.add('active');
            });
        });
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initImageGallery();
    initTallaSelector();
}); 