function mostrarModalConfirmar(idReserva) {
    // 1. Pega o input escondido DENTRO DO MODAL
    const inputModal = document.getElementById('id_reserva_no_modal');
    
    // 2. Define o valor dele com o ID que veio do botão
    inputModal.value = idReserva;
    
    // 1. Seleciona o elemento pelo ID
    const modal = document.getElementById('confirm-modal');
    
    // 2. Remove a classe 'hidden' da lista de classes
    modal.classList.remove('hidden');
}

function mostrarModalCancelar() {
    // 1. Seleciona o elemento pelo ID
    const modal = document.getElementById('cancel-modal');
    
    // 2. Remove a classe 'hidden' da lista de classes
    modal.classList.remove('hidden');
}

function fecharModal(modalId) {
    // 1. Seleciona o elemento pelo ID
    const modal = document.getElementById(modalId); 

    // 2. Adiciona a classe 'hidden' à lista de classes
    modal.classList.add('hidden');
}