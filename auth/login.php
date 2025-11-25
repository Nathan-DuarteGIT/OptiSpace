<?php
require_once "../config/config.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: ../dashboard/index.php');
    exit();
}
function showVar($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}
?>
<!DOCTYPE html>

<html lang="pt" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="shortcut icon" href="../assets/images/logo_optispace.ico" type="image/x-icon">
    <title>Login</title>
</head>

<body class="bg-primary m-0 p-0 h-screen w-screen">
    <?php showVar($_SESSION); ?>
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
                    <input type="password" name="password" required placeholder="Palavra-passe"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-dark focus:border-transparent transition">

                    <div class="text-right mt-2">
                        <a href="recuperar-passe.php" class="font-semibold text-sm text-primary-dark hover:underline">Recuperar palavra-passe</a>
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary-dark_green text-white py-3 rounded-lg font-semibold text-lg hover:bg-primary-dark/90 transition">Entrar</button>
            </form>
        </div>
    </div>
</body>

</html>