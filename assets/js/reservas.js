const inputDataInicio = document.querySelector('input[name="data_inicio"]');
    const inputDataFim = document.querySelector('input[name="data_fim"]');
    const inputHoraInicio = document.querySelector('input[name="hora_inicio"]');
    const inputHoraFim = document.querySelector('input[name="hora_fim"]');
    const tipoRecurso = document.getElementById('tipo_recurso');
    const camposSala = document.getElementById('campos-sala');
    const camposViatura = document.getElementById('campos-viatura');
    const camposEquipamento = document.getElementById('campos-equipamento');

    function atualizarCampos() {
        camposSala.classList.add('hidden');
        camposViatura.classList.add('hidden');
        camposEquipamento.classList.add('hidden');

        if (tipoRecurso.value === 'sala') {
            camposSala.classList.remove('hidden');
        } else if (tipoRecurso.value === 'viatura') {
            camposViatura.classList.remove('hidden');
        } else if (tipoRecurso.value === 'equipamento') {
            camposEquipamento.classList.remove('hidden');
        }
    }

    function resetarTipoRecurso() {
        // Redefine o valor do select "Tipo de recurso" para a opção inicial (disabled selected)
        tipoRecurso.value = ''; 
        // Chama a função para ocultar os campos condicionais e limpar os seus valores
        atualizarCampos(); 
    }
    
    inputDataInicio.addEventListener('change', resetarTipoRecurso);
    inputDataFim.addEventListener('change', resetarTipoRecurso);
    inputHoraInicio.addEventListener('change', resetarTipoRecurso);
    inputHoraFim.addEventListener('change', resetarTipoRecurso);

    tipoRecurso.addEventListener('change', atualizarCampos);
    document.addEventListener('DOMContentLoaded', atualizarCampos);