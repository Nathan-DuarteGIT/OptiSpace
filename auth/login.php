<?php
require_once "../config/config.php";
$file_css = '../assets/css/output.css';
$versioncss = filemtime($file_css);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: ../dashboard/index.php');
    exit();
}

if (isset($_GET['erro_credenciais'])) {
    $erro_credenciais = htmlspecialchars($_GET['erro_credenciais']);
    echo "<script>alert('$erro_credenciais');</script>";
} else if (isset($_GET['conta_inativa'])) {
    $conta_inativa = htmlspecialchars($_GET['conta_inativa']);
    echo "<script>alert('$conta_inativa');</script>";
}
?>

<!DOCTYPE html>

<html lang="pt" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css?v=<?= $versioncss ?>">
    <link rel="shortcut icon" href="../assets/images/logo_optispace.ico" type="image/x-icon">
    <title>Login</title>
</head>

<body class="bg-primary m-0 p-0 h-screen w-screen">
    <div class="flex flex-col md:flex-row h-full relative">
        <div class="left-section bg-primary-dark flex flex-col justify-between items-center flex-1 h-[40vh] md:h-screen relative order-2 md:order-1 relative z-0">
            <img src="../assets/images/logo_optispace_branca.png"
                alt="logo_OptiSpace"
                class="absolute top-4 md:top-6 left-4 md:left-8 w-20 md:w-28 h-auto">
            <img src="../assets/images/Saly-2.png"
                alt="Decoração"
                class="absolute left-1/2 md:left-[90px] top-1/2 -translate-x-1/2 md:translate-x-0 -translate-y-1/2 w-[200px] md:w-[350px] h-auto md:block">
        </div>

        <div class="right-section flex-1 flex justify-center items-center h-[40vh] md:h-screen relative bg-gray-50 order-3 relative z-0">
            <img src="../assets/images/computer_inicio.png"
                alt="Computer"
                class="absolute right-1/2 md:right-[100px] top-1/2 translate-x-1/2 md:translate-x-0 -translate-y-1/2 w-[180px] md:w-[375px] h-auto md:block">
        </div>

        <div class="form-container w-[90%] md:w-full max-w-md bg-white p-8 rounded-2xl shadow-xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
            <form method="POST" action="../actions/action-login.php" class="space-y-6">
                <div class="text-left mb-6">
                    <h1 class="text-lg md:text-xl text-dark">Bem-vindo à OptiSpace</h1>
                    <h2 class="text-2xl md:text-3xl text-dark-600 mt-1">Entrar</h2>
                </div>

                <div class="links absolute top-3 md:top-6 right-3 md:right-6 text-xs md:text-sm text-gray-600 bg-white/80 backdrop-blur-sm px-2 md:px-3 py-1 rounded-md">
                    <span>Não tem conta? </span><br>
                    <a href="registo-empresa.php" class="text-primary-dark font-semibold hover:underline">Registe-se</a>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Insira o seu Email</label>
                    <input type="email" name="email" required placeholder="E-mail"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-dark focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Insira a sua Palavra-passe</label>
                    <div class="relative">
                        <input type="password" name="password" id="login_password" required placeholder="Palavra-passe"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-dark focus:border-transparent transition pr-10">
                        <button
                            type="button"
                            onclick="togglePassword('login_password')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 p-1">

                            <!-- Ícone de Olho Aberto -->
                            <svg id="icon_login_password_open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>

                            <!-- Ícone de Olho Fechado -->
                            <svg id="icon_login_password_closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12c0 2.21.574 4.257 1.543 6.114M10.125 10.5h.008v.008h-.008v-.008Zm2.25 0h.008v.008h-.008v-.008Zm2.25 0h.008v.008h-.008v-.008Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 18.375L12 12M12 12L5.625 5.625" />
                            </svg>
                        </button>
                    </div>
                    <div class="text-right mt-2">
                        <a href="recuperar-passe.php" class="font-semibold text-sm text-primary-dark hover:underline">Recuperar palavra-passe</a>
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary-dark_green text-white py-3 rounded-lg font-semibold text-lg hover:bg-primary-dark/90 transition">Entrar</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const iconOpen = document.getElementById('icon_' + fieldId + '_open');
            const iconClosed = document.getElementById('icon_' + fieldId + '_closed');

            if (passwordField.type === 'password') {
                // Mudar para texto (mostrar senha)
                passwordField.type = 'text';
                iconOpen.classList.add('hidden');
                iconClosed.classList.remove('hidden');
            } else {
                // Mudar para password (ocultar senha)
                passwordField.type = 'password';
                iconOpen.classList.remove('hidden');
                iconClosed.classList.add('hidden');
            }
        }
    </script>

</body>

</html>