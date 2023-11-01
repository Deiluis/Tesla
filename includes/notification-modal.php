<div class="modal-notification">
    <div class="header-menu">
        <span>Crear observación</span>
        <div href="#" class="close-button">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
            </svg>
        </div>
    </div>

    <div class="container">
        <form action="./" method="post">
            <label for="laboratory">Laboratorio</label>
            <select name="laboratory" id="laboratory">
                <option>Selecciona un laboratorio</option>
                <?php
                while($row = $notifications -> fetch_assoc()) { ?>
                    <option><?php echo $row['id'] ?></option> <?php
                } 
                ?>
            </select>
            <label for="computer">Computadora</label>
            <input type="number" min="1" max="20" name="computer" id="computer"/>
            <label for="description">Descripción del problema</label>
            <textarea name="description" id="description"></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>
</div>