$(document).click((e) => {
    const loginContainer = $(".login");
    const loginDropdown = $(".login-dropdown");
    const loginForm = $(".login-form");

    if (loginDropdown.is(e.target) || loginDropdown.has(e.target)[0])
        loginForm.toggleClass("login-form--show");

    if (!loginContainer.has(e.target)[0])
        loginForm.removeClass("login-form--show");
});