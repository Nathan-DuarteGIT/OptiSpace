<?php
include_once '../includes/functions.php';
?>

<!DOCTYPE html>

<html lang="pt" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="shortcut icon" href="../assets/images/logo_optispace.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dashboard</title>
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/sidebar.php'; ?>
    <main class="flex-1 p-8">
        <section class="mt-8">
            <h3 class="text-2xl font-semibold mb-6 text-[#17876E]">Dashboard</h3>

            <!-- Container dos cards -->
            <div class="flex flex-col sm:flex-row gap-6">

                <!-- Card: Salas -->
                <div class="bg-white w-full sm:w-1/3 px-3 py-2 rounded-xl shadow-md hover:shadow-lg transition flex justify-between items-center">
                    <div class="leading-none">
                        <h4 class="text-base font-medium text-gray-700">Salas</h4>
                        <p id="salas" class="text-xl font-bold text-gray-900 mt-0.5">0</p>
                    </div>
                    <img src="../assets/images/salas.png" alt="Salas" class="w-8 h-auto ml-1">
                </div>

                <!-- Card: Equipamentos -->
                <div class="bg-white w-full sm:w-1/3 px-3 py-2 rounded-xl shadow-md hover:shadow-lg transition flex justify-between items-center">
                    <div class="leading-none">
                        <h4 class="text-base font-medium text-gray-700">Equipamentos</h4>
                        <p id="equipamentos" class="text-xl font-bold text-gray-900 mt-0.5">0</p>
                    </div>
                    <img src="../assets/images/equipamentos.png" alt="Equipamentos" class="w-8 h-auto ml-1">
                </div>

                <!-- Card: Viaturas -->
                <div class="bg-white w-full sm:w-1/3 px-3 py-2 rounded-xl shadow-md hover:shadow-lg transition flex justify-between items-center">
                    <div class="leading-none">
                        <h4 class="text-base font-medium text-gray-700">Viaturas</h4>
                        <p id="viaturas" class="text-xl font-bold text-gray-900 mt-0.5">0</p>
                    </div>
                    <img src="../assets/images/viaturas.png" alt="Viaturas" class="w-8 h-auto ml-1">
                </div>

            </div>
        </section>
    </main>
</body>