import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Puja la teva publicació',
    acceptedFiles: '.png, .jpg, .jpeg, .gif',
    addRemoveLinks: true,
    dictRemoveFile: 'Eliminar Arxiu',
    maxFiles: 1,
    uploadMultiple: false,

    init: function () {
        if (document.querySelector('[name="img"]').value.trim()) {
            const imgPublicada = {};
            imgPublicada.size = 1234;
            imgPublicada.name = document.querySelector('[name="img"]').value.trim();

            this.options.addedfile.call(this, imgPublicada);
            this.options.thumbnail.call(this, imgPublicada, `/uploads/${imgPublicada.name}`);

            imgPublicada.previewElement.classList.add('dz-success', 'dz-complete');
        }
    }
})

dropzone.on('success', (file, response) => {
    console.log(response.imatge);
    document.querySelector('[name="img"]').value = response.imatge;
})

dropzone.on('removedfile', () => {
    document.querySelector('[name="img"]').value = ''
})