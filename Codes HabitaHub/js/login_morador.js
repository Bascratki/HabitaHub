function validateForm() {
    var usuario = document.getElementById("usuario").value;
    var senha = document.getElementById("senha").value;
    
    if (usuario === "" || senha === "") {
        alert("Por favor, preencha todos os campos.");
    } else {
        location.href = 'comunic_int.html';
    }
}