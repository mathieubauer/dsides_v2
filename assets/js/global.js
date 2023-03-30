console.log('global.js')
/**/
const modalId = document.getElementById('imageAttch');
if(modalId) {
    modalId.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const recipient = button.getAttribute('src')
        const image = modalId.querySelector('.modal-body img');
        image.src = recipient;
    })
}

const content_shaw_project = document.getElementById('content_shaw_project');

content_shaw_project?.getElementsByTagName('div')[0].classList.add('f_text_serif','text_extra_small')
