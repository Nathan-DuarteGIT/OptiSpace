<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>

<html lang="pt" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="shortcut icon" href="../assets/images/logo_optispace.ico" type="image/x-icon">
    <title>Ativação</title>
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
    </div>

    <div class="form-container w-[90%] md:w-full max-w-md bg-white p-8 rounded-2xl shadow-xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
        <form method="POST" class="space-y-6 text-center">
            <div class="text-left mb-6">
                <h1 class="text-lg md:text-xl text-dark">Bem-vindo à OptiSpace</h1>
                <h2 class="text-2xl md:text-3xl text-dark-600 mt-1">Ative a sua conta</h2>
            </div>

            <div class="flex justify-center gap-6 mb-6">
                <input type="text" name="digit1" maxlength="1"
                    class="input-activation w-10 h-10 md:w-10 md:h-10" required>
                <input type="text" name="digit2" maxlength="1"
                    class="input-activation w-10 h-10 md:w-10 md:h-10" required>
                <input type="text" name="digit3" maxlength="1"
                    class="input-activation w-10 h-10 md:w-10 md:h-10" required>
                <input type="text" name="digit4" maxlength="1"
                    class="input-activation w-10 h-10 md:w-10 md:h-10" required>
                <input type="text" name="digit5" maxlength="1"
                    class="input-activation w-10 h-10 md:w-10 md:h-10" required>
                <input type="text" name="digit6" maxlength="1"
                    class="input-activation w-10 h-10 md:w-10 md:h-10" required>
            </div>

            <button type="submit"
                class="w-full bg-primary-dark_green text-white py-3 rounded-lg font-semibold text-lg hover:bg-primary-dark/90 transition">
                Ativar
            </button>

            <div class="absolute top-3 md:top-6 right-3 md:right-6 text-xs md:text-sm text-gray-600 bg-white/80 backdrop-blur-sm px-2 md:px-3 py-1 rounded-md">
                <span>Já tem conta? </span><br>
                <a href="login.php" class="text-primary-dark font-semibold hover:underline">Entrar</a>
            </div>
        </form>
    </div>
</body>

</html>