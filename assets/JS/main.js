/* MODAL */

function iniciaModal(modalID) {
    const modal = document.getElementById(modalID)
    if (modal) {
        modal.classList.add('mostrar');
        modal.addEventListener('click', (e) => {
            if (e.target.id == modalID || e.target.className == 'fechar') {
                modal.classList.remove('mostrar');
            }
            if (e.target.tagName.toLowerCase() == 'a') {
                modal.classList.remove('mostrar');
            }
        });
    }
}

const botao = document.querySelectorAll('.abrir');

botao.forEach(e => {
    e.addEventListener('click', () => iniciaModal('modal-login'));
})