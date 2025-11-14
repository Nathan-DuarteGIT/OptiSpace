<?php
include_once '../includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="shortcut icon" href="../assets/images/logo_optispace.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Reservas</title>
</head>

<body class="bg-primary font-sans text-gray-900 min-h-screen flex">
    <!-- Sidebar fixa à esquerda -->
    <?php include '../includes/sidebar.php'; ?>

    <!-- Conteúdo principal ocupa o resto -->
    <div class="flex-1 flex flex-col">
        <!-- Header no topo -->
        <?php include '../includes/header.php'; ?>

        <!-- Conteúdo principal -->
        <main class="flex-1 p-8">
            <section class="mt-8">
                <h3 class="text-2xl font-semibold mb-6 text-black">Reservas</h3>

                <!-- Container dos cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-0 gap-y-6">
                    <!-- card criar reserva -->
                    <a href="criar.php"
                        class="card-dashboard flex flex-col items-center justify-center hover:bg-gray-50 hover:shadow-xl transition-all duration-200 cursor-pointer group">
                        <h4 class="text-lg font-bold text-black group-hover:text-indigo-600 transition-colors">Criar Reserva</h4>
                    </a>

                    <div class="card-dashboard">
                        <div class="leading-tight">
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Data:</span> 11/10/2025</p>
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Hora de início:</span> 10:00</p>
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Hora de fim:</span> 14:00</p>
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Recurso:</span> Sala 2</p>

                            <div class="flex items-center gap-3">
                                <span class="font-medium text-sm text-black">Status:</span>
                                <span class="inline-block bg-green-200 text-green-800 text-xs font-medium px-3 py-1 rounded-full">confirmada</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-dashboard ">
                        <div class="leading-tight">
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Data:</span> 10/10/2025</p>
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Hora de início:</span> 09:30</p>
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Hora de fim:</span> 17:30</p>
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Recurso:</span> Sala 4</p>

                            <div class="flex items-center gap-3">
                                <span class="font-medium text-sm text-black">Status:</span>
                                <span class="inline-block bg-green-200 text-green-800 text-xs font-medium px-3 py-1 rounded-full">confirmada</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-dashboard">
                        <div class="leading-tight">
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Data:</span> 05/10/2025</p>
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Hora de início:</span> 8:20</p>
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Hora de fim:</span> 10:20</p>
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Recurso:</span> sala 3</p>
                            <div class="flex items-center gap-3">
                                <span class="font-medium text-sm text-black">Status:</span>
                                <span class="inline-block bg-red-200 text-red-800 text-xs font-medium px-3 py-1 rounded-full">Concluída</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>