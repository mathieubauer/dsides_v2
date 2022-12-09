console.log('global.js')
/**/
const modalId = document.getElementById('imageAttch');
modalId.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const recipient = button.getAttribute('src')
    const image = modalId.querySelector('.modal-body img');
    image.src = recipient;
})