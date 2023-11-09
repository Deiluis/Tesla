<div class="content-wrapper" id="inventario">
    <div class="content-section"> 
        
        <h2>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
            </svg>
            Inventario
        </h2>
        
        <?php

        if(isset($_GET['items_id'])) { 
            $items = $conn-> query("
                SELECT * FROM inventory 
                WHERE laboratory_id = '$_GET[items_id]'
            "); ?>

            <table> <?php 

                if ($items -> num_rows > 0) { ?>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th style="width:9%">Cantidad</th>
                        <th style="width:10%">Opciones</th>
                    </tr> <?php

                    while ($row = $items->fetch_assoc()) { ?>

                        <tr>
                            <td><?php echo $row["name"] ?></td>
                            <td><?php echo $row["description"] ?></td>
                            <td><?php echo $row["quantity"] ?></td>
                            <td>
                                <div class="button-wrapper">
                                    <a href="#" id="<?php echo $row['id'] ?>">
                                        <button class='content-button status-button' style="display: flex;">
                                            <svg style="margin:0" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>
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
                                        </div> <?php 
                                    } ?>
                                </div>
                            </td>
                        </tr> <?php 
                    }

                } else ?>
                    <tr><span>No hay items en este laboratorio.</span></tr>
            </table> <?php 

        } else { 
            print('<ul>');
            $labs = $conn -> query("SELECT id from laboratories");

            while ($row = $labs -> fetch_assoc()) { ?>
                <li>
                    <a href="?items_id=<?php echo $row['id'] ?>#inventario"><?php echo $row["id"] ?></a>
                </li> <?php 
            } 
            print('<ul>'); 
        } ?>

    </div>
</div>