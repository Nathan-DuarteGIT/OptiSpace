function mostrarModalConfirmar() {
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