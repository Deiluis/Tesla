const viewModal = document.querySelector(".view-modal");
const viewModalBackground = document.querySelector(".view-modal .modal__background");
const viewModalCloseBtn = document.querySelector(".view-modal .modal__close-button");

const closeViewModal = () => {
    viewModal.classList.remove("modal--show");

    const modalAudio = document.querySelector(".view-modal .content--audio");
    const modalVideo = document.querySelector(".view-modal .content--video");
    if (modalAudio != null) modalAudio.pause();
    if (modalVideo != null) modalVideo.pause();
};

document.querySelectorAll('table .library-items').forEach(button => {
    button.addEventListener("click", (e) => {
        e.preventDefault();
        viewModal.classList.add("modal--show");
        obtainFileById(button.id);
    });
});

viewModalBackground.addEventListener("click", closeViewModal);
viewModalCloseBtn.addEventListener("click", closeViewModal);
