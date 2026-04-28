document.getElementById('registerForm').addEventListener('submit', function(e) {
    const pass = document.getElementById('reg-password').value;
    const confirmPass = document.getElementById('reg-confirm').value;

    if (pass !== confirmPass) {
        e.preventDefault(); // Detiene el envío si no coinciden
        alert("¡Ups! Las contraseñas no coinciden. Inténtalo de nuevo 🍰");
    } else {
        // Aquí es donde el formulario se enviaría a tu base de datos
        console.log("Enviando datos al horno...");
    }
});