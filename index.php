<?php
require_once __DIR__ . '/config/config.php';
$file_css = 'assets/css/output.css';
$versioncss = filemtime($file_css);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css?v=<?= $versioncss ?>">
    <link rel="shortcut icon" href="assets/images/icon_optispace_1.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>OptiSpace-Homepage</title>
</head>

<body class="bg-primary font-sans overflow-x-hidden">
    <header class="max-w-7xl mx-auto px-4">
        <nav class="flex flex-col md:flex-row justify-between items-center px-4 py-2 gap-4">
            <img class="w-32 h-auto" src="assets/images/logo_optispace.png" alt="logo_OptiSpace">
            <ul class="flex flex-wrap justify-center items-center gap-4 md:gap-8">
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#servicos">Serviços</a></li>
                <li><a href="#juntese">Junte-se a nós</a></li>
                <li><a class="btn-primary" href="auth/registo-empresa.php">Registo</a></li>
                <li><a class="btn-primary" href="auth/login.php">Entrar</a></li>
            </ul>
        </nav>
    </header>

    <section id="inicio" class="flex flex-col lg:flex-row items-center my-10 lg:my-20 gap-10 max-w-7xl mx-auto px-4">
        <div class="flex-1">
            <h1 class="text-4xl font-bold">Reserve com inteligência, otimize com Optispace.</h1>
            <h2 class="text-2xl font-light text-description my-10">A Optispace automatiza a gestão de recursos partilhados com reservas inteligentes, eliminando conflitos e aumentando a produtividade empresarial.</h2>
            <div class="mt-5 flex flex-col sm:flex-row gap-4 text-center">
                <a class="btn-outline" href="#juntese">Comece agora</a>
                <a class="bg-[#17876E] px-10 py-3 rounded-full text-white font-bold hover:bg-[#2EA98C] transition duration-200" href="#servicos">Saiba mais</a>
            </div>
        </div>
        <div class="flex-1">
            <img class="max-w-full h-auto" src="assets/images/pc1.png" alt="um computador">
        </div>
    </section>
    <section id="servicos" class="flex flex-col justify-center text-center my-20 max-w-7xl mx-auto px-4">


        <h1 class="text-4xl font-bold">Os Nossos Serviços</h1>
        <div class="w-16 h-[2px] bg-black mx-auto my-5"></div>
        <p class="font-light text-description mx-auto w-3/4">
            Simplificamos a gestão de recursos partilhados, oferecendo reservas automáticas de salas e equipamentos, otimização em tempo real e rastreio eficiente, eliminando conflitos e aumentando a produtividade da sua equipa
        </p>

        <div class="grid gap-6 my-10 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 justify-items-center">
            <div class="card">
                <img src="assets/images/reservas1.png" alt="imagem de reservas">
                <p class="text-2xl font-bold">Reservas inteligentes</p>
                <p class="font-light text-description">
                    Indique participantes e equipamentos que sugerimos a melhor opção em tempo real, integrado com os seus calendários.
                </p>
            </div>

            <div class="card">
                <img src="assets/images/equipamentos1.png" alt="imagem de equipamentos">
                <p class="text-2xl font-bold">Gestão de recursos</p>
                <p class="font-light text-description">
                    Reserve equipamentos, viaturas ou outros materiais de forma simples, rápida e segura.
                </p>
            </div>

            <div class="card">
                <img src="assets/images/relogio.png" alt="imagem de relógio">
                <p class="text-2xl font-bold">Check-in automático</p>
                <p class="font-light text-description">
                    Check-in e check-out rápidos para uma gestão eficiente.
                </p>
            </div>
        </div>
    </section>
    <section id="juntese" class="flex flex-col lg:flex-row items-center gap-8 my-20 max-w-7xl mx-auto px-4">
        <div class="flex-1">
            <img class="max-w-full h-auto" src="assets/images/analiseEmpresa.png" alt="pessoa com uma prancheta e um grafico a subir">
        </div>
        <div class="flex-1">
            <h1 class="text-3xl font-bold">Registe a sua empresa!</h1>
            <div class="w-16 h-[2px] bg-black my-5"></div>
            <h2 class="text-xl font-light text-description my-10">Junte-se ao Optispace e simplifique a gestão de recursos da sua empresa! Registe-se agora para reservas automáticas e maior produtividade.</h2>
            <a class="btn-outline whitespace-nowrap" href="auth/registo-empresa.php">Registe-se agora</a>
        </div>
    </section>
    <footer class="flex flex-col justify-center items-center bg-[#085543] py-8 text-white gap-4 w-full">
        <img class="w-32 h-auto" src="assets/images/logo_optispace_branca.png" alt="logo OptiSpace">
        <div class="flex flex-col md:flex-row gap-4">
            <p><i class="fa-regular fa-envelope"></i> info@optispace.pt</p>
            <p><i class="fa-solid fa-phone"></i> + 351 987 654 321</p>
        </div>
        <p>Complexo Andaluz, Apartado 279 2001-904 Santarém</p>
        <div class="flex">
            <a class="px-2" href=""><i class="fa-brands fa-instagram text-2xl"></i></a>
            <a class="px-2" href=""><i class="fa-brands fa-whatsapp text-2xl"></i></a>
            <a class="px-2" href=""><i class="fa-brands fa-facebook text-2xl"></i></a>
        </div>
        <p>&copy;OptiSpace LTD 2025. Todos os direitos reservados</p>
    </footer>

</body>

</html>