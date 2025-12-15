<?php
include_once '../includes/functions.php';
require_once "../config/config.php";
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
            <div class="w-full max-w-md">
                <h3 class="text-2xl font-semibold mb-6 text-black">Nova reserva</h3>
                <!-- Card do formulário -->
                <div class="rounded-2xl px-8 py-10">

                    <form action="" method="post" class="space-y-8">

                        <!-- Data inicio -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Data de Inicio</label>
                            <div class="relative">
                                <input type="date" name="data_inicio" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Data fim -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Data de Fim</label>
                            <div class="relative">
                                <input type="date" name="data_fim" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <datalist id="ten-min-intervals">
                            <?php
                            for ($h = 0; $h < 24; $h++) {
                                for ($m = 0; $m < 60; $m += 10) {
                                    printf('<option value="%02d:%02d">', $h, $m);
                                }
                            }
                            ?>
                        </datalist>

                        <!-- Horários  -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Hora de início</label>
                                <input type="time"
                                    name="hora_inicio"
                                    list="ten-min-intervals"
                                    step="600"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Hora de fim</label>
                                <input type="time"
                                    name="hora_fim"
                                    list="ten-min-intervals"
                                    step="600"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            </div>
                        </div>

                        <!-- Tipo de Recurso -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de recurso</label>
                            <div class="relative">
                                <select name="tipo_recurso" id="tipo_recurso" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg appearance-none bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                    <option value="" disabled selected>Selecione o tipo de recurso</option>
                                    <option value="sala">Sala</option>
                                    <option value="viatura">Viatura</option>
                                    <option value="equipamento">Equipamento</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Campos condicionais para SALA -->
                        <div id="campos-sala" class="hidden space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nº de participantes</label>
                                <select name="participantes"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                    <option value="">Selecione o nº de participantes</option>
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?= $i ?>"><?= $i ?> participante<?= $i > 1 ? 's' : '' ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Equipamentos adicionais (opcional)</label>
                                <div class="space-y-2">
                                    <label class="flex items-center"><input type="checkbox" name="equipamentos_sala[]" value="projetor" class="mr-3"> Projetor</label>
                                    <label class="flex items-center"><input type="checkbox" name="equipamentos_sala[]" value="tv" class="mr-3"> TV</label>
                                    <label class="flex items-center"><input type="checkbox" name="equipamentos_sala[]" value="teleconferencia" class="mr-3"> Videoconferência</label>
                                </div>
                            </div>
                        </div>

                        <!-- Campos condicionais para VIATURA -->
                        <div id="campos-viatura" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Viatura</label>
                            <div class="space-y-3">
                                <label class="flex items-center"><input type="radio" name="viatura" value="bmw" class="mr-3"> BMW Série 5</label>
                                <label class="flex items-center"><input type="radio" name="viatura" value="peugeot" class="mr-3"> Peugeot e-208</label>
                                <label class="flex items-center"><input type="radio" name="viatura" value="renault" class="mr-3"> Renault Kangoo Van</label>
                            </div>
                        </div>

                        <!-- Campos condicionais para EQUIPAMENTO -->
                        <div id="campos-equipamento" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Equipamento</label>
                            <div class="space-y-3">
                                <label class="flex items-center"><input type="radio" name="equipamento" value="macbook" class="mr-3"> MacBook Air</label>
                                <label class="flex items-center"><input type="radio" name="equipamento" value="ipad" class="mr-3"> iPad</label>
                                <label class="flex items-center"><input type="radio" name="equipamento" value="canon" class="mr-3"> Canon EOS R5</label>
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit"
                                class="w-full bg-primary-dark_green hover:bg-primary-600 text-white font-medium py-4 rounded-xl transition duration-200 shadow-lg hover:shadow-xl">
                                Criar Reserva
                            </button>
                        </div>

                    </form>
                </div>
        </main>
    </div>
</body>

</html>

<script src="../assets/js/reservas.js"></script>