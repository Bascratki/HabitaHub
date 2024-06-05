function validateForm() {
    var usuario = document.getElementById("usuario").value;
    var senha = document.getElementById("senha").value;
    var endereco = document.getElementById("endereco").value;
    var bloco = document.getElementById("bloco").value;

    if (usuario === "" || senha === "" || endereco === "" || bloco === "") {
        alert("Por favor, preencha todos os campos.");
        return false;
    }

    // Redirect to the login page
    window.location.href = "../pages/login_morador.html";
}
