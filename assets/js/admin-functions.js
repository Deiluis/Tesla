const relevamiento = (e) => {

    $.ajax({
        type: "POST",
        url: 'pc.php',
        data: { lab: e.getAttribute("data-lab"), pc_id: e.getAttribute("data-pc") },
        success: function(response) {

            const res = JSON.parse(response)
            if(res){
                const info = JSON.parse(res.information);

                console.log(res);

                // Le añade al container del modal la información principal del relevamiento.
                document.querySelector("#pc-modal .modal__container .main-info").innerHTML = `
                    <div class="computer-info">
                        <span class="modal__title">Computadora</span>
                        <div class="pc">
                            <img src="https://images.vexels.com/media/users/3/157318/isolated/preview/2782b0b66efa5815b12c9c637322aff3-computadora-de-escritorio-icono-computadora.png" width="100" />
                            <span>${res.laboratory_id} - ${res.computer}</span>
                            <span id="timestamp">${info.timestamp}</span>
                        </div>
                    </div>
                    <div class="objects"></div>
                `;

                const objects = document.querySelector("#pc-modal .modal__container .main-info .objects");

                // Añade la información principal del equipo.
                objects.innerHTML += `
                    <span> ${info.so.name} <img src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Windows_logo_-_2012.png" width="26" /></span>
                    <span> ${info.cpu}</span>
                    <span> ${info.ram.memory} ${info.ram.model}</span>
                `;

                // Mapea y añade las unidades de almacenamiento instaladas y su capacidad.
                info.storage.forEach(e => {
                    objects.innerHTML += `<span> ${e.name} - ${e.memory}</span>`;
                });

                objects.innerHTML += `
                    <div class="programs" onclick="active(this)">
                        <span>
                            Programas 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                            </svg>
                        </span>
                    </div>
                `;

                // Mapea y añade los programas encontrados.
                info.programs.forEach(e => {
                    if(e == "" || e == "'") return;

                    const programs = document.querySelector("#pc-modal .modal__container .main-info .objects .programs");
                    programs.innerHTML += `<span class="program">${e}</span>`
                });

                // Añade el tiempo de encendido.
                objects.innerHTML += `<span>Último encendido: ${info.varios.lastboot}</span>`

                document.querySelector("#pc-modal").classList.add('modal--show');
            }
        }
    });
}