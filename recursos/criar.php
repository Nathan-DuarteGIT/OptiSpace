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
                <h3 class="text-2xl font-semibold mb-6 text-black">Novo Recurso</h3>
                <form action="../actions/action-criarRecurso.php" method="post" class="space-y-6">
                    <!-- Card do formulário -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nome do recurso</label>
                        <input type="text" name="name" placeholder="Nome do recurso" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                    </div>

                    <!-- Tipo de Recurso -->
                    <div>
                        <div class="relative">
                            <select name="tipo_recurso" id="tipo_recurso" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg appearance-none bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                <option value="" disabled selected>Recurso</option>
                                <option value="sala">Sala</option>
                                <option value="viatura">Viatura</option>
                                <option value="equipamento">Equipamento</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Campos condicionais para SALA -->
                    <div id="campos-sala" class="hidden space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Capacidade máxima</label>
                            <input type="number" name="capacidade" min="1" placeholder="Digite o número de participantes" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Equipamentos (opcional)</label>
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="equipamentos_sala[]" value="computador" class="mr-3 w-4 h-4 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
                                    <span>Computador</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="equipamentos_sala[]" value="projetor" class="mr-3 w-4 h-4 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
                                    <span>Projetor</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="equipamentos_sala[]" value="videoconferencia" class="mr-3 w-4 h-4 text-indigo-600 rounded focus:ring-2 focus:ring-indigo-500">
                                    <span>Videoconferência</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Outro equipamento (opcional)</label>
                            <input type="text" name="outro_equipamento" placeholder="Especifique outro equipamento"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        </div>
                    </div>

                    <!-- Campos condicionais para VIATURA -->
                    <div id="campos-viatura" class="hidden space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Marca *</label>
                            <input type="text" name="marca" placeholder="Ex: BMW, Peugeot, Renault..." required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Modelo *</label>
                            <input type="text" name="modelo" placeholder="Ex: 320i, 208, Clio..." required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Matrícula *</label>
                            <input type="text" name="matricula" placeholder="Ex: AA-00-BB" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        </div>
                    </div>

                    <!-- Campos condicionais para EQUIPAMENTO -->
                    <div id="campos-equipamento" class="hidden space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nome do equipamento *</label>
                            <input type="text" name="nome_equipamento" placeholder="Ex: MacBook Air, iPad, Canon EOS R5..." required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de equipamento *</label>
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="tipo_equipamento" value="fixo" required class="mr-3 w-4 h-4 text-indigo-600 focus:ring-2 focus:ring-indigo-500">
                                    <span>Equipamento fixo</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="tipo_equipamento" value="remoto" required class="mr-3 w-4 h-4 text-indigo-600 focus:ring-2 focus:ring-indigo-500">
                                    <span>Equipamento móvel</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Imagem do equipamento (opcional)</label>
                            <input type="file" name="imagem_equipamento" id="imagem_equipamento" accept="image/*"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">

                            <!-- Preview da imagem -->
                            <div id="preview-container" class="hidden mt-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                                <div class="relative inline-block">
                                    <img id="preview-imagem" src="" alt="Preview" class="max-w-xs max-h-64 rounded-lg border-2 border-gray-300 shadow-md">
                                    <button type="button" id="remover-imagem" class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg transition z-10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Criar recurso -->
                    <div class="pt-6">
                        <button type="submit" class="w-full bg-primary-dark_green hover:bg-primary-600 text-white font-medium py-4 rounded-xl transition duration-200 shadow-lg hover:shadow-xl">
                            Criar Recurso
                        </button>
                    </div>
                </form>
            </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipoRecurso = document.getElementById('tipo_recurso');
            const camposSala = document.getElementById('campos-sala');
            const camposViatura = document.getElementById('campos-viatura');
            const camposEquipamento = document.getElementById('campos-equipamento');

            tipoRecurso.addEventListener('change', function() {
                // Esconder todos os campos
                camposSala.classList.add('hidden');
                camposViatura.classList.add('hidden');
                camposEquipamento.classList.add('hidden');

                // Remover required dos campos escondidos
                document.querySelectorAll('#campos-sala input, #campos-viatura input, #campos-equipamento input').forEach(input => {
                    input.removeAttribute('required');
                });

                // Mostrar campos correspondentes 
                if (this.value === 'sala') {
                    camposSala.classList.remove('hidden');
                    document.querySelector('input[name="capacidade"]').setAttribute('required', 'required');
                } else if (this.value === 'viatura') {
                    camposViatura.classList.remove('hidden');
                    document.querySelector('input[name="marca"]').setAttribute('required', 'required');
                    document.querySelector('input[name="modelo"]').setAttribute('required', 'required');
                    document.querySelector('input[name="matricula"]').setAttribute('required', 'required');
                } else if (this.value === 'equipamento') {
                    camposEquipamento.classList.remove('hidden');
                    document.querySelector('input[name="nome_equipamento"]').setAttribute('required', 'required');

                    document.querySelectorAll('input[name="tipo_equipamento"]').forEach(radio => {
                        radio.setAttribute('required', 'required');
                    });
                }
            });

            // Preview da imagem
            const inputImagem = document.getElementById('imagem_equipamento');
            const previewContainer = document.getElementById('preview-container');
            const previewImagem = document.getElementById('preview-imagem');
            const btnRemover = document.getElementById('remover-imagem');

            if (inputImagem) {
                inputImagem.addEventListener('change', function(e) {
                    const file = e.target.files[0];

                    if (file) {
                        // Validar se é uma imagem
                        if (!file.type.startsWith('image/')) {
                            alert('Por favor, selecione apenas arquivos de imagem.');
                            this.value = '';
                            return;
                        }

                        // Validar tamanho (máximo 5MB)
                        if (file.size > 5 * 1024 * 1024) {
                            alert('A imagem deve ter no máximo 5MB.');
                            this.value = '';
                            return;
                        }

                        // Criar URL da imagem e mostrar preview
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImagem.src = e.target.result;
                            previewContainer.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Remover imagem
                btnRemover.addEventListener('click', function() {
                    inputImagem.value = '';
                    previewImagem.src = '';
                    previewContainer.classList.add('hidden');
                });
            }
        });
    </script>