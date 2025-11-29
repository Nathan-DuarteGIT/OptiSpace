<?php
require_once "../config/config.php";

if (isset($_GET['erro_mudar'])) {
    $erro_mudar = htmlspecialchars($_GET['erro_mudar']);
    echo "<script>alert('$erro_mudar');</script>";
}
?>

<!DOCTYPE html>

<html lang="pt" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="shortcut icon" href="../assets/images/logo_optispace.ico" type="image/x-icon">
    <title>Mudar passe</title>
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
        <form method="POST" action="../actions/action-mudarPasse.php" class="space-y-6">
            <div class="flex justify-between text-left mb-6">
                <h1 class="text-lg md:text-xl text-dark">Bem-vindo à OptiSpace</h1>
                <div class="absolute top-3 md:top-6 right-3 md:right-6 text-xs md:text-sm text-gray-600 bg-white/80 backdrop-blur-sm px-2 md:px-3 py-1 rounded-md">
                    <span>Já tem conta? </span><br>
                    <a href="login.php" class="text-primary-dark font-semibold hover:underline">Entrar</a>
                </div>
            </div>
            <h2 class="text-2xl md:text-3xl text-dark-600 mt-1">Alterar palavra-passe</h2>
            <?php
            if (isset($_GET['email'])) {
                echo '<input type="hidden" name="email" value="' . htmlspecialchars($_GET['email']) . '">';
            }
            ?>
            <div class="space-y-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Insira a nova palavra-passe</label>
                    <input type="password" name="password" id="newPassword" required placeholder="Nova palavra-passe"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-dark focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirme a nova palavra-passe</label>
                    <input type="password" name="ConfirmPassword" id="confirmPassword" required placeholder="Confirme a nova palavra-passe"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-dark focus:border-transparent transition">
                </div>
            </div>
            <button type="submit" id="submitBtn"
                class="w-full bg-primary-dark_green text-white py-3 rounded-lg font-semibold text-lg hover:bg-primary-dark/90 transition" disabled>
                Confirmar
            </button>
        </form>
    </div>
    <script>
        const newPass = document.getElementById('newPassword');
        const confirmPass = document.getElementById('confirmPassword');
        const submitBtn = document.getElementById('submitBtn');

        function checkInputs() {
            if (newPass.value.trim() !== '' && confirmPass.value.trim() !== '' && newPass.value === confirmPass.value) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        }

        newPass.addEventListener('input', checkInputs);
        confirmPass.addEventListener('input', checkInputs);
    </script>
</body>

</html>