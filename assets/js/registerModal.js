const modalRegister = $(".modal-register");
const registerButton = $("#register");

registerButton.click(() => {
    $(".modal-register").addClass("modal-register--show");
    
    $(".modal-register__close-button").click(() => {
        modalRegister.removeClass("modal-register--show");
    });
    
    $(document).click((e) => {
        if (!modalRegister.is(e.target) && !modalRegister.has(e.target)[0] && !registerButton.is(e.target))
            modalRegister.removeClass("modal-register--show");
    });
});

