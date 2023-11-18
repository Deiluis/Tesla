<div class="content-wrapper" id="inventario">
    <div class="content-section">

        <div class="title">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                </svg>
            </div>
            <span>Inventario</span>
        </div>

        <?php

        if (isset($_GET['items_id'])) {
            $items = $conn->query("
                SELECT * FROM inventory 
                WHERE laboratory_id = '$_GET[items_id]'
            "); ?>

            <table> <?php

                    if ($items->num_rows > 0) { ?>
                    <tr>
                        <th style="width:300px">Nombre</th>
                        <th style="width:80px">Imagen</th>
                        <th style="width:90px">Cantidad</th>
                        <th style="width:120px">Ultimo Uso</th>
                        <th>Descripción</th>
                        <th style="width:140px">Opciones</th>
                    </tr> <?php

                            while ($row = $items->fetch_assoc()) { ?>

                        <tr>
                            <td><?php echo $row["name"] ?></td>
                            <td>Imagen</td>
                            <td><?php echo $row["quantity"] ?></td>
                            <td>Ayer</td>
                            <td><?php echo $row["description"] ?></td>
                            <td>
                                <div class="button-wrapper">
                                    <a onClick="inventorySearch(this)" data-item="<?php echo $row["id"] ?>">
                                        <button class='content-button status-button' style="display: flex;">
                                            <svg style="margin:0" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                            </svg>
                                        </button>
                                    </a> <?php

                                            if ($rol_id > 0) { ?>
                                        <div class="menu">
                                            <button class="dropdown">
                                                <ul>
                                                    <li>
                                                        <a href="./inventory/delete?id=<?php echo $row['id'] ?>&laboratory=<?php echo $_GET['items_id'] ?>">Borrar</a>
                                                    </li>
                                                </ul>
                                            </button>
                                        </div>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php
                            } ?> <tr>
                        <form action="./actions/create" method="post">
                            <td><input type="text" name="name" placeholder="Nombre"></td>
                            <td><input type="file" name="photo"></td>
                            <td><input type="number" min="1" placeholder="1" name="quantity"></td>
                            <td><input type="hidden" name="laboratory" value="<?php echo $_GET['items_id'] ?>"></td>
                            <td><input type="text" name="desc" placeholder="Descripcion"></td>
                            <td>
                                <div class="button-wrapper">
                                    <button class='content-button status-button' type="submit" name="inventory">Agregar</button>
                                    <button type="reset">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z" />
                                            <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </form>
                    </tr>
                <?php

                    } else { ?> <tr><span>No hay items en este laboratorio.</span></tr> <?php } ?>
            </table> <?php

                    } else {
                        print('<ul>');
                        $labs = $conn->query("SELECT id from laboratories");

                        while ($row = $labs->fetch_assoc()) { ?>
                <li>
                    <a href="?items_id=<?php echo $row['id'] ?>#inventario"><?php echo $row["id"] ?></a>
                </li> <?php
                        }
                        print('<ul>');
                    } ?>

    </div>
    <script>
        function inventorySearch(e) {
            $.ajax({
                type: "POST",
                url: 'inventory-search.php',
                data: {
                    lab: $(location).attr('search').split('=')[1],
                    itemId: e.getAttribute("data-item")
                },
                success: function(response) {
                    const res = JSON.parse(response)
                    if (res) {
                        document.querySelector("#inventory-modal .modal__container .main-info").innerHTML =
                            `
                        <div class="item">
                            <img src="./assets/windows.png" width="100" />
                            <div class="objects">
                                <span><b>ID:</b> ${res.id}</span>
                                <span><b>Nombre:</b> ${res.name}</span>
                                <span><b>Cantidad:</b> ${res.quantity}</span>
                                <span><b>Descripcion:</b> ${res.description}</span>
                            </div>
                        </div>
                        <div class="reservations">
                            <table>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Inicio</th>
                                    <th>Finalizacion</th>
                                    <th>Area de uso</th>
                                    <th>Descripcion</th>
                                <tr>
                                <tr>
                                    <td>John Doe</td>
                                    <td>2023-01-23</td>
                                    <td>10:00</td>
                                    <td>14:00</td>
                                    <td>EMATP</td>
                                    <td>Tenia que cambiar unas cosas</td>
                                <tr>
                                <tr>
                                    <td>John Doe</td>
                                    <td>2023-01-25</td>
                                    <td>10:00</td>
                                    <td>14:00</td>
                                    <td>EMATP</td>
                                    <td>Se rompio de nuevo y la volvi a usar</td>
                                <tr>
                            </table>
                            <div>
                                Reservar:
                                <form action="" method="post">
                                    <div class="mb-4">
                                        <label for="day">
                                            Dia
                                        </label>
                                        <input type="date" name="date" id="day" />
                                    </div>
                                    <div class="flex mb-4">
                                        <div class="w-1/2 pr-2">
                                            <label for="start-time">
                                                Start Time
                                            </label>
                                            <input type="time" name="start" id="start-time" />
                                        </div>
                                        <div class="w-1/2 pl-2">
                                            <label for="end-time">
                                                End Time
                                            </label>
                                            <input type="time" name="end" id="end-time" />
                                        </div>
                                </form>
                                <button type="submit">
                                    Confirm Reservation
                                </button>
                            </div>
                        </div>
                        `
                        // document.querySelector(".modal-pc .container .objects").innerHTML += `
                        // <span> ${info.so.name} <img src="../assets/windows.png" width="26" /></span>
                        // <span> ${info.cpu}</span>
                        // <span> ${info.ram.memory} ${info.ram.model}</span>
                        // `
                        // info.storage.forEach(e => {
                        //     document.querySelector(".modal-pc .container .objects").innerHTML += `<span> ${e.name} - ${e.memory}</span>`;
                        // })
                        // document.querySelector(".modal-pc .container .objects").innerHTML += `<div class="programs" onclick="active(this)"><span>Programas <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16"><path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg></span></div>`
                        // info.programs.forEach(e => {
                        //     if(e == "" || e == "'") return;
                        //     document.querySelector(".modal-pc .container .objects .programs").innerHTML += `<span>${e}</span>`
                        // })
                        // document.querySelector(".modal-pc .container .objects").innerHTML += `<span>Tiempo de encendido: ${info.varios.lastboot}</span>`
                        document.querySelector("#inventory-modal").classList.add('modal--show')
                    }
                }
            });
        }
    </script>
</div>