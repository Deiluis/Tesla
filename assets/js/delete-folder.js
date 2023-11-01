const deleteButtons = document.querySelectorAll('.delete-folder');

const deleteModal = document.querySelector('.delete-modal');
const deleteModalBackground = document.querySelector(".delete-modal .modal__background");
const deleteModalCloseBtn = document.querySelector(".delete-modal .modal__close-button");

const confirmDeleteBtn = document.querySelector('.delete-modal .modal__button--confirm');
const cancelDeleteBtn = document.querySelector('.delete-modal .modal__button--cancel');

let folderToDelete = ''; // Variable para almacenar el nombre de la carpeta a eliminar
let subjectId;

const closeModal = () => {
    deleteModal.classList.remove("modal--show");
};

deleteButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        folderToDelete = btn.getAttribute('data-folder');
        subjectId = btn.getAttribute('data-subject');
        deleteModal.classList.add("modal--show");
        console.log(folderToDelete);
    });
});

deleteModalBackground.addEventListener("click", closeModal);
deleteModalCloseBtn.addEventListener("click", closeModal);
cancelDeleteBtn.addEventListener("click", closeModal);

confirmDeleteBtn.addEventListener('click', (e) => {
    e.preventDefault();

    $.ajax({
        url: './actions/delete-folder.php', // Cambia esto al nombre de tu script PHP
        method: 'POST',
        data: { 
            dir_name: folderToDelete,
            subject_id: subjectId,
        }, // Enviar el nombre de la carpeta
        dataType: 'json', // Especifica el tipo de datos esperados desde el servidor
        success: function (response) {
            // La solicitud se completó con éxito, puedes realizar acciones adicionales aquí
            deleteModal.classList.remove("modal--show"); // Cierra la modal
            window.location.reload();
            console.log(response);
        },
        error: function (error) {
            // La solicitud falló, manejar el error aquí
            console.error('Error al eliminar la carpeta', error);
        }
    });
});