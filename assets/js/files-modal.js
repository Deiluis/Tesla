const filesModal = document.querySelector('.files-modal');
const filesModalBackground = document.querySelector(".files-modal .modal__background");
const filesModalCloseBtn = document.querySelector(".files-modal .modal__close-button");
const addFilesBtn = document.querySelector(".add-files");

const closeFilesModal = () => {
    filesModal.classList.remove("modal--show");

    // const modalAudio = document.querySelector(".modal .content--audio");
    // const modalVideo = document.querySelector(".modal .content--video");
    // if (modalAudio != null) modalAudio.pause();
    // if (modalVideo != null) modalVideo.pause();
};

addFilesBtn.addEventListener('click', () => {
    filesModal.classList.add("modal--show");
});

filesModalBackground.addEventListener("click", closeFilesModal);
filesModalCloseBtn.addEventListener("click", closeFilesModal);