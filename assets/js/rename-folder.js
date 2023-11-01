const renameButtons = document.querySelectorAll('.rename-folder');

const renameModal = document.querySelector('.rename-modal');
const renameModalBackground = document.querySelector(".rename-modal .modal__background");
const renameModalCloseBtn = document.querySelector(".rename-modal .modal__close-button");
const renameModalInput = document.querySelector(".rename-modal input");
const renameModalForm = document.querySelector(".rename-modal .modal__form");

//const confirmRenameBtn = document.querySelector('.rename-modal .modal__button--confirm');

let oldName = '';
let newName = '';

const closeRenameModal = () => {
    renameModal.classList.remove("modal--show");
};

renameButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        oldName = btn.getAttribute('data-old-name');
        //newName = btn.getAttribute('data-new-name');
        subjectId = btn.getAttribute('data-subject');

        renameModalInput.value = oldName;
        renameModal.classList.add("modal--show");
    });
});

renameModalBackground.addEventListener("click", closeRenameModal);
renameModalCloseBtn.addEventListener("click", closeRenameModal);

renameModalForm.addEventListener('submit', (e) => {
    e.preventDefault();

    newName = renameModalInput.value;

    $.ajax({
        url: './actions/rename-folder.php', // Cambia esto al nombre de tu script PHP
        method: 'POST',
        data: { 
            old_name: oldName,
            new_name: newName,
            subject_id: subjectId,
        }, // Enviar el nombre de la carpeta
        dataType: 'json', // Especifica el tipo de datos esperados desde el servidor
        success: function (response) {
            // La solicitud se completó con éxito, puedes realizar acciones adicionales aquí
            renameModal.classList.remove("modal--show"); // Cierra la modal
            window.location.reload();
            console.log(response);
        },
        error: function (error) {
            // La solicitud falló, manejar el error aquí
            console.error('Error al renombrar la carpeta', error);
        }
    });
});