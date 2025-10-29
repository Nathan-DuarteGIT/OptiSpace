<?php
require_once __DIR__ . '/config/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/output.css">
    <link rel="shortcut icon" href="assets/images/logo_optispace.ico" type="image/x-icon">
    <title>OptiSpace-Homepage</title>
</head>

<body class="bg-primary font-sans mx-4 lg:mx-40">
    <header class="mx-4 lg:mx-40">
        <nav class="flex justify-between items-center ml-8 mr-8 mt-2">
            <img class="w-32 h-auto " src="assets/images/logo_optispace.png" alt="logo_OptiSpace">
            <ul class="flex justify-between items-center">
                <li class="ml-4 mr-4"><a href="">Inicio</a></li>
                <li class="ml-4 mr-4"><a href="">Serviços</a></li>
                <li class="ml-4 mr-4"><a href="">Junte-se a nós</a></li>
                <li class="ml-4 mr-4"><a class="btn-primary" href="">Registo</a></li>
                <li class="ml-4 mr-4"><a class="btn-primary" href="">Entrar</a></li>
            </ul>
        </nav>
    </header>
    <!-- SVG decorativo -->

    <section id="inicio" class="flex items-center my-20 mx-4 lg:mx-40">
        <div class="flex-1">
            <h1 class="text-4xl font-bold">Reserve com inteligência, otimize com Optispace.</h1>
            <h2 class="text-2xl font-light text-description my-10">A Optispace automatiza a gestão de recursos partilhados com reservas inteligentes, eliminando conflitos e aumentando a produtividade empresarial.</h2>
            <div class="mt-5 flex flex-col sm:flex-row gap-4 text-center">
                <a class="btn-outline" href="#juntese">Comece agora</a>
                <a class="bg-[#17876E] px-10 py-3 rounded-full text-white font-bold hover:bg-[#2EA98C] transition duration-200" href="#servicos">Saiba mais</a>
            </div>
        </div>
        <div class="flex-1">
            <img src="assets/images/pc1.png" alt="um computador">
        </div>
    </section>
    <section id="servicos" class=" flex flex-col justify-center text-center my-20 overflow-hidden mx-4 lg:mx-40">


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
    <section id="juntese" class="flex gap-8 my-20 mx-4 lg:mx-40">
        <div class="flex-1">
            <img src="assets/images/analiseEmpresa.png" alt="pessoa com uma prancheta e um grafico a subir">
        </div>
        <div class="flex-1">
            <h1 class="text-4xl font-bold">Registe a sua empresa!</h1>
            <div class="w-16 h-[2px] bg-black my-5"></div>
            <h2 class="text-2xl font-light text-description my-10">Junte-se ao Optispace e simplifique a gestão de recursos da sua empresa! Registe-se agora para reservas automáticas e maior produtividade.</h2>
            <a class="btn-outline" href="auth/registo-empresa.php">Registe-se agora</a>
        </div>
    </section>
    <footer>
        <img src="" alt="">
        <div>

        </div>
        <p></p>
        <div>

        </div>
        <p></p>
    </footer>
</body>

</html>