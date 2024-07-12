<!DOCTYPE html>
<html>
<head>
    <title>Recuperação de Senha</title>
</head>
<body>
    <p>Olá {{ $name }},</p>

    <p>Você está recebendo este email porque solicitou a recuperação de senha.</p>
    
    <p>Se você não fez essa solicitação, pode ignorar este email.</p>

    <p>Seu token de recuperação de senha é: {{ $token }}</p>

    <p>Clique no link abaixo para redefinir sua senha:</p>

    <a
        style="background-color: #3490dc; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"
        href="{{ $url }}"
    >
        <span style="text-decoration: none; color: white;">Redefinir Senha</a>
    </a>

    <p>Se você está tendo problemas para clicar no botão "Redefinir Senha", copie e cole o URL abaixo em seu navegador:</p>

    <a href="{{ $url }}">{{ $url }}</a>

    <p>Este link de recuperação de senha expirará em {{ config('auth.passwords.users.expire') }} minutos.</p>

    <p>Atenciosamente,<br>Recuperação de Senha</p>
</body>
</html>
