<div class="content-wrapper" id="observaciones">
    <div class="content-section">
        <form action="./insertNotification" method="post">
            <label for="laboratory">Laboratorio</label>
            <select name="laboratory" id="laboratory">
                <option>Selecciona un laboratorio</option>
                <?php
                while($row = $notifications-> fetch_assoc()) { ?>
                    <option><?php echo $row['id'] ?></option> <?php
                } 
                ?>
            </select>
            <label for="computer">Computadora</label>
            <input type="number" name="computer" id="computer">
            <label for="description">Descripción del problema</label>
            <textarea name="description" id="description"></textarea>
            <button>Enviar</button>
        </form>
    </div>
</div>