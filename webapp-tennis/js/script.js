// Esempio semplice di validazione del form lato client
document.querySelector('form').addEventListener('submit', function(e) {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    if(username === "" || password === "") {
        e.preventDefault(); // Ferma l'invio del form
        alert("I campi username e password sono obbligatori");
    }
});
