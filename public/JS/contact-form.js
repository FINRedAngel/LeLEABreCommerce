window.addEventListener('load', () => {
    initOnFormSubmit();
})

function initOnFormSubmit(){
    const form = document.querySelector('#ContactModal form');

    form.addEventListener('submit', (event)=> {
        event.preventDefault();
        sendData(form);
    })
}

function sendData(form) {
    const xhr = new XMLHttpRequest();
    const formData = new FormData(form);

    xhr.addEventListener('load', () => {
        const newHtml = xhr.response;
        const divElement = document.createElement('div');
        divElement.innerHTML = newHtml;
        const newModalBody = divElement.querySelector('.ContactModal .modal-body');
        const oldModalBody = document.querySelector('.ContactModal .modal-body');

        if(newModalBody){
            oldModalBody.innerHTML = newModalBody.innerHTML;
        } else {
            document.querySelector('.ContactModal .modal-body').innerHTML = 'Error occurred. Please try again later';
        }
        
        initOnFormSubmit();
    })

    xhr.addEventListener('error', () => {
        document.querySelector('.ContactModal .modal-body').innerHTML = 'Error occurred. Please try again later';
    })

    xhr.open('POST', form.getAttribute('action'));
    xhr.send(formData);
}