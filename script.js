function toggleForms() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    // Si el login está activo, lo escondemos y mostramos el registro
    if (loginForm.classList.contains('form-active')) {
        loginForm.classList.remove('form-active');
        loginForm.classList.add('form-hidden');
        
        registerForm.classList.remove('form-hidden');
        registerForm.classList.add('form-active');
    } 
    // Si el registro está activo, lo escondemos y mostramos el login
    else {
        registerForm.classList.remove('form-active');
        registerForm.classList.add('form-hidden');
        
        loginForm.classList.remove('form-hidden');
        loginForm.classList.add('form-active');
    }
}

// Opcional: Evitar que la página se recargue al presionar los botones por ahora
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert("¡Iniciando sesión en la repostería!");
});

document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert("¡Cuenta dulce creada con éxito!");
});