    const inputDataInicio = document.querySelector('input[name="data_inicio"]');
    const inputDataFim = document.querySelector('input[name="data_fim"]');
    const inputHoraInicio = document.querySelector('input[name="hora_inicio"]');
    const inputHoraFim = document.querySelector('input[name="hora_fim"]');
    const tipoRecurso = document.getElementById('tipo_recurso');
    const camposSala = document.getElementById('campos-sala');
    const campoRecursoEspecificoDiv = document.getElementById('campo-recurso-especifico');
    const selectRecursoEspecifico = document.getElementById('id_recurso_selecionado');

    // NOVOS ELEMENTOS PARA FILTRAGEM DE SALA
    const inputParticipantes = document.querySelector('select[name="participantes"]');
    const checkboxEquipamentos = document.querySelectorAll('input[name="equipamentos_sala[]"]');

    /**
 * Envia um pedido AJAX para o PHP para buscar recursos disponíveis.
 */
    async function buscarRecursosDisponiveis() {
    const data_inicio = inputDataInicio.value;
    const data_fim = inputDataFim.value;
    const hora_inicio = inputHoraInicio.value;
    const hora_fim = inputHoraFim.value;
    const tipo_recurso = tipoRecurso.value;

    // Se faltarem dados básicos, não fazemos a busca
    if (!data_inicio || !data_fim || !hora_inicio || !hora_fim || !tipo_recurso) {
        selectRecursoEspecifico.innerHTML = '<option value="" disabled selected>Preencha Data e Horários.</option>';
        campoRecursoEspecificoDiv.classList.add('hidden');
        return;
    }

    // Feedback de carregamento
    selectRecursoEspecifico.innerHTML = '<option value="" disabled selected>A carregar recursos...</option>';
    campoRecursoEspecificoDiv.classList.remove('hidden');

    try {
        // --- PREPARAÇÃO DOS PARÂMETROS ---
        const params = new URLSearchParams();
        params.append('data_inicio', data_inicio);
        params.append('data_fim', data_fim);
        params.append('hora_inicio', hora_inicio);
        params.append('hora_fim', hora_fim);
        params.append('tipo_recurso', tipo_recurso);

        // Se for uma sala, adicionamos os filtros específicos
        if (tipo_recurso === 'sala') {
            // 1. Participantes
            if (inputParticipantes && inputParticipantes.value) {
                params.append('participantes', inputParticipantes.value);
            }

            // 2. Equipamentos (Checkboxes)
            // Pegamos apenas os que estão marcados
            checkboxEquipamentos.forEach(checkbox => {
                if (checkbox.checked) {
                    // Importante usar o nome com [] para o PHP receber como array
                    params.append('equipamentos_sala[]', checkbox.value);
                }
            });
        }

        const response = await fetch('../actions/action-buscarRecursos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: params // Enviamos o objeto params completo
        });

        const dataJson = await response.json();

        selectRecursoEspecifico.innerHTML = '';

        if (dataJson.success && dataJson.recursos && dataJson.recursos.length > 0) {
            let options = '<option value="" disabled selected>Selecione um recurso disponível</option>';
            dataJson.recursos.forEach(recurso => {
                options += `<option value="${recurso.id}">${recurso.nome}</option>`;
            });
            selectRecursoEspecifico.innerHTML = options;
        } else {
            selectRecursoEspecifico.innerHTML = '<option value="" disabled selected>Nenhum recurso disponível com esses filtros.</option>';
        }

    } catch (error) {
        console.error('Erro na busca de recursos:', error);
        selectRecursoEspecifico.innerHTML = '<option value="" disabled selected>Erro ao comunicar com o servidor.</option>';
    }
}

    // A função principal de gestão do estado
    function atualizarCampos() {
       // Limpeza e ocultação de todos os campos condicionais e do select de recursos
    // Use IF para verificar a existência do elemento:
    if (camposSala) {
        camposSala.classList.add('hidden');
    }
    
    // ... (Limpeza dos campos internos) ...

    const tipoSelecionado = tipoRecurso.value;

        if (tipoSelecionado) {
            if (camposSala && tipoSelecionado === 'sala') {
                camposSala.classList.remove('hidden');
            }
            buscarRecursosDisponiveis();

        } else {
            // 3. SE NENHUM TIPO ESTÁ SELECIONADO: Apenas limpa o campo de recurso específico
            selectRecursoEspecifico.innerHTML = '<option value="" disabled selected>Selecione o tipo de recurso.</option>';
            campoRecursoEspecificoDiv.classList.add('hidden');
        }
    }
    

    tipoRecurso.addEventListener('change', atualizarCampos);
    inputDataInicio.addEventListener('change', atualizarCampos); 
    inputDataFim.addEventListener('change', atualizarCampos);
    inputHoraInicio.addEventListener('change', atualizarCampos);
    inputHoraFim.addEventListener('change', atualizarCampos);

    // NOVOS LISTENERS PARA OS CAMPOS DE SALA
    if (inputParticipantes) {
        inputParticipantes.addEventListener('change', atualizarCampos);
    }
    checkboxEquipamentos.forEach(checkbox => {
        checkbox.addEventListener('change', atualizarCampos);
    });

    document.addEventListener('DOMContentLoaded', atualizarCampos);