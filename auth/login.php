<!DOCTYPE html>

<html lang="pt" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="shortcut icon" href="../assets/images/logo_optispace.ico" type="image/x-icon">
    <title>Login</title>
</head>

<body class="bg-primary m-0 p-0 h-screen w-screen flex">
    <!--<div class="container flex flex-row items-center h-screen w-screen"> -->
    <div class="left-section bg-primary-dark flex flex-col justify-between items-center flex-1 h-screen">
        <img src="../assets/images/logo_optispace_branca.png"
        alt="logo_OptiSpace"
        class="absolute top-6 left-8 w-28 h-auto">
        <img src="../assets/images/Saly-2.png"
        alt="Decoração"
        class="absolute left-[90px] top-1/2 -translate-y-1/2 w-[350px] h-auto">
    </div>

    <div class="right-section flex-1 flex justify-center items-center h-screen relative bg-gray-50">
        <img src="../assets/images/computer_inicio.png"
        alt="Computer"
        class="absolute right-[100px] top-1/2 -translate-y-1/2 w-[375px] h-auto">
    </div>

    <div class="form-container w-full max-w-md bg-white p-8 rounded-2xl shadow-xl 
            absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10">
        <form method="POST" class="space-y-6">
            <div class="text-left mb-6">
                <h1 class="text-lg md:text-xl text-dark">Bem-vindo à OptiSpace</h1>
                <h2 class="text-2xl md:text-3xl text-dark-600 mt-1">Entrar</h2>
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
            </div>

            <button type="submit" class="w-full bg-primary-dark_green text-white py-3 rounded-lg font-semibold text-lg hover:bg-primary-dark/90 transition">Entrar</button>

            <div class="links absolute top-6 right-6 text-sm text-gray-600 bg-white/80 backdrop-blur-sm px-3 py-1 rounded-md">
                <span>Não tem conta? </span><br>
                <a href="registo.php" class="text-primary-dark font-semibold hover:underline">Registe-se</a>
            </div>
        </form>
    </div>
    <!-- fim container </div>  -->

</body>

</html>