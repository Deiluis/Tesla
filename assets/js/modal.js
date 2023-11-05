import { deleteActions, renameActions, filesActions, viewActions, registerActions, notificationActions } from "./modal-actions.js";

const modals = document.querySelectorAll(".modal");

modals.forEach(modal => {
    const modalBackground = document.querySelector(`#${modal.id} .modal__background`);
    const modalCloseBtn = document.querySelector(`#${modal.id} .modal__close-button`);

    const closeModal = () => {
        modal.classList.remove("modal--show");

        const modalAudio = document.querySelector(`#${modal.id} .content--audio`);
        const modalVideo = document.querySelector(`#${modal.id} .content--video`);
        if (modalAudio != null) modalAudio.pause();
        if (modalVideo != null) modalVideo.pause();
    };

    modalBackground?.addEventListener("click", closeModal);
    modalCloseBtn?.addEventListener("click", closeModal);

    if (modal.id === "delete-modal")
        deleteActions({ modal, closeModal });

    if (modal.id === "rename-modal")
        renameActions({ modal });

    if (modal.id === "files-modal")
        filesActions({ modal });

    if (modal.id === "view-modal")
        viewActions({ modal });

    if (modal.id === "register-modal")
        registerActions({ modal });

    if (modal.id === "notification-modal")
        notificationActions({ modal });
});