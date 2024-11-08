function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm_password").value;

    if (password !== confirmPassword) {
        alert("Le password non corrispondono. Per favore, riprova.");
        return false; // Previene l'invio del form
    }
    return true;
}
