const modalRegister = $(".modal-register");
const registerButton = $("#register");

registerButton.click(() => {
    $(".login-form").removeClass("login-form--show");
    $(".modal-register").addClass("modal-register--show");
    
    $(".modal-register .close-button").click(() => {
        modalRegister.removeClass("modal-register--show");
    });
    
    $(document).click((e) => {
        if (!modalRegister.is(e.target) && !modalRegister.has(e.target)[0] && !registerButton.is(e.target))
            modalRegister.removeClass("modal-register--show");
    });
});

