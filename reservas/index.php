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
    <title>Document</title>
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
                <div class="flex flex-col sm:flex-row justify-start gap-6">
                    <!-- card criar reserva -->
                    <div class="card-dashboard">
                        <div class="leading-tight">
                            <h4 class="text-lg font-bold text-black">Criar Reserva</h4>
                        </div>
                    </div>

                    <div class="card-dashboard">
                        <div class="leading-tight">
                            <p class="text-sm text-black mb-1"><span class="font-medium">Data:</span> 11/10/2025</p>
                            <p class="text-sm text-black mb-1"><span class="font-medium">Hora de início:</span> 10:00</p>
                            <p class="text-sm text-black mb-1"><span class="font-medium">Hora de fim:</span> 14:00</p>
                            <p class="text-sm text-black mb-2"><span class="font-medium">Recurso:</span> Sala 2</p>
                            <p class="text-sm text-black mb-1"><span class="font-medium">Status:</span></p>
                            <span class="inline-block bg-green-200 text-green-800 text-xs font-medium px-3 py-1 rounded">confirmada</span>
                        </div>
                    </div>

                    <div class="card-dashboard ">
                        <div class="leading-tight">
                            <p class="text-sm text-black mb-1"><span class="font-medium">Data:</span> 10/10/2025</p>
                            <p class="text-sm text-black mb-1"><span class="font-medium">Hora de início:</span> 09:30</p>
                            <p class="text-sm text-black mb-1"><span class="font-medium">Hora de fim:</span> 17:30</p>
                            <p class="text-sm text-black mb-2"><span class="font-medium">Recurso:</span> Sala 4</p>
                            <p class="text-sm text-black mb-1"><span class="font-medium">Status:</span></p>
                            <span class="inline-block bg-green-200 text-green-800 text-xs font-medium px-3 py-1 rounded">confirmada</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-start gap-8 mt-6">
                        <div class="bg-white w-64 h-auto px-4 py-3 rounded-2xl border border-gray-200">
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Data:</span> 05/10/2025</p>
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Hora de início:</span> 8:20</p>
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Hora de fim:</span> 10:20</p>
                            <p class="text-xs text-black leading-relaxed"><span class="font-semibold">Recurso:</span> sala 3</p>
                            <div class="mt-2">
                                <p class="text-xs text-black mb-1"><span class="font-semibold">Status:</span></p>
                                <span class="inline-block bg-red-200 text-red-800 text-xs font-medium px-3 py-1 rounded">cancelada</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>