export const deleteActions = ({ modal, closeModal }) => {

    let folderToDelete = ''; // Variable para almacenar el nombre de la carpeta a eliminar
    let subjectId;

    const deleteButtons = document.querySelectorAll('.delete-folder');
    const modalConfirmBtn = document.querySelector(`#${modal.id} .modal__button--confirm`);
    const modalCancelBtn = document.querySelector(`#${modal.id} .modal__button--cancel`);

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            folderToDelete = btn.getAttribute('data-folder');
            subjectId = btn.getAttribute('data-subject');
            modal.classList.add("modal--show");
        });
    });

    modalConfirmBtn.addEventListener("click", (e) => {
        e.preventDefault();

        $.ajax({
            url: './actions/delete-folder.php',
            method: 'POST',
            data: { dir_name: folderToDelete, subject_id: subjectId },
            dataType: 'json', 
            success: function (response) {
                modal.classList.remove("modal--show");
                window.location.reload();
                console.log(response);
            },
            error: function (error) {
                console.error('Error al eliminar la carpeta', error);
            }
        });
    });

    modalCancelBtn?.addEventListener("click", closeModal);
};

export const renameActions = ({ modal }) => {
    let oldName = '';
    let newName = '';
    let subjectId;

    const renameButtons = document.querySelectorAll('.rename-folder');
    const modalInput = document.querySelector(`#${modal.id} input`);
    const modalForm = document.querySelector(`#${modal.id} .modal__form`);

    renameButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            oldName = btn.getAttribute('data-old-name');
            subjectId = btn.getAttribute('data-subject');
    
            modalInput.value = oldName;
            modal.classList.add("modal--show");
        });
    });

    modalForm.addEventListener('submit', (e) => {
        e.preventDefault();
    
        newName = modalInput.value;
    
        console.log(newName);

        $.ajax({
            url: './actions/rename-folder.php',
            method: 'POST',
            data: { 
                old_name: oldName,
                new_name: newName,
                subject_id: subjectId,
            },
            dataType: 'json',
            success: function (response) {
                modal.classList.remove("modal--show");
                window.location.reload();
                console.log(response);
            },
            error: function (error) {
                console.error('Error al renombrar la carpeta', error);
            }
        });
    });
};

export const filesActions = ({ modal }) => {
    const addFilesBtn = document.querySelector(".add-files");

    addFilesBtn?.addEventListener('click', () => {
        console.log("hola");
        modal.classList.add("modal--show");
    });
};

export const viewActions = ({ modal }) => {

    const viewButtons = document.querySelectorAll('table .library-items');
    const modalContainer = document.querySelector(`#${modal.id} .modal__container`);

    viewButtons.forEach(button => {
        button.addEventListener("click", (e) => {
            e.preventDefault();
            modal.classList.add("modal--show");

            // Obtiene el archivo y devuelve una string que muestra en el modal la posición y el tipo de archivo a mostrar.
            $.ajax({
                type: "POST",
                data: "id-file=" + button.id,
                url: "./actions/obtain-file.php",
                success: function (res) {
                    modalContainer.innerHTML = res;
                },
                error: function (res) {
                    modalContainer.innerHTML = "No se puede mostrar el archivo.";
                }
            });
        });
    });
};

export const registerActions = ({ modal }) => {
    const registerButton = document.querySelector("#register");

    registerButton?.addEventListener("click", () => {
        document.querySelector(".login-form").classList.remove("login-form--show");
        modal.classList.add("modal--show");
    });
};

export const notificationActions = ({ modal }) => {
    const createNotificationButton = document.querySelector("#create-notification");

    createNotificationButton.addEventListener("click", () => {
        modal.classList.add("modal--show");
    });
};
export const objectActions = ({ modal }) => {
    const viewObjectButton = document.querySelector("#view-object");

    viewObjectButton.addEventListener("click", () => {
        modal.classList.add("modal--show");
    });
};

export const pcActions = ({ modal, closeModal }) => {

    const modalBackground = document.querySelector(`#${modal.id} .modal__background`);
    const modalCloseBtn = document.querySelector(`#${modal.id} .modal__close-button`);

    console.log(modalCloseBtn);

    // modalBackground.addEventListener("click", () => {
    //     document.querySelector(`${modal.id} .modal__container`).innerHTML = "";
    //     closeModal();
    // });

    //modalBackground.removeEventListener("click", closeModal);
    // modalCloseBtn.removeEventListener("click", closeModal);

    // console.log("aaaaaaaaaaaaaaaaaaa");

    modalBackground.addEventListener("click", () => {
        console.log("aaa");

        document.querySelector(`#${modal.id} .modal__container`).innerHTML = 
        `
            <div class="modal__close-button">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                </svg>
            </div>
        `;
        closeModal();
    });
};