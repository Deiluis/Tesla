document.querySelectorAll(".content-section ul li").forEach((dropdown) => {
    dropdown.addEventListener("click", (e) => {
        e.stopPropagation();
        dropdown.classList.toggle("is-active");
    });
}); 

document.querySelectorAll(".dropdown").forEach((dropdown) => {
    dropdown.addEventListener("click", (e) => {
        e.stopPropagation();
        
        // Cerrar todos los dropdowns excepto el actual
        document.querySelectorAll(".dropdown").forEach((otherDropdown) => {
        if (otherDropdown !== dropdown)
            otherDropdown.classList.remove("is-active");
        });

        // Abrir o cerrar el dropdown actual
        dropdown.classList.toggle("is-active");
    });
});

$(document).click(function (e) {
    const container = $(".status-button");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        $(".dropdown").removeClass("is-active");
        document.querySelectorAll(".content-section ul li").forEach((c) => c.classList.remove("is-active"));
    }
});