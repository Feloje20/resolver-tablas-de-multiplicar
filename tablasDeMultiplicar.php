<?php
    /**
    * Generador de preguntas sobre tablas de multiplicar usando formularios, con dos solicitudes.
    * @autor = Jesús Ferrer López
    * @date = 20/10/2024
    */

    // Incialización de variables
    $numTablas; // Número de tablas d emultiplicar
    $numPreguntas; // Número de huecos en blanco en la tabla
    $tabla; // Esta variable almacenará el array de la tabla.
    $min = 0; // Mínimo en la generación aleatoria de nuestra tabla.
    $max;   // Máximo en la generación aleatoria de nuestra tabla.
    $lprocesaformulario = false;

    // Comprobamos que el formulario se ha enviado.
    if((isset($_POST["generar"]))){
        $lprocesaformulario = true;
    }

    // Validamos el formulario, y creamos las cookies de ser necesario.
    if ($lprocesaformulario){
        // Recoger datos
        $numTablas = $_POST["numTablas"];
        $numPreguntas = $_POST["numPreguntas"];

        // validamos que los campos tengan un valor mínimo.
        if ($numTablas < 5) {
            $lprocesaformulario = false;
            $errorTablas = "Mínimo 5 tablas";
        }
        if ($numPreguntas < 5) {
            $lprocesaformulario = false;
            $errorPreguntas = "Mínimo 5 preguntas";
        }

        // Si los datos introducidos son correctos, generamos la tabla con las preguntas.
        if ($lprocesaformulario) {
            // Generamos una tabla solo con valores "X"
            $tabla = array_fill(0, $numTablas, array_fill(0, $numTablas, "X"));
            $max = $numTablas - 1;
            // Ahora cambiamos campos de X por nuevos inpus de preguntas del usuario.
            for($i = 0; $i < $numPreguntas; $i++) {
                // Vamos a generar combinaciones aleatorias que no tengan un input ya.
                while (True) {
                    $random1 = random_int($min, $max);
                    $random2 = random_int($min, $max);
                    // Si en esa posición del array hay una X, podemos poner un input
                    if ($tabla[$random1][$random2] === "X") {
                        break;
                    }
                }
                // Ahora, asignamos el input en esa posición de nuestro array.
                $tabla[$random1][$random2] = "<input type='number' class='small' name='respuesta$random1-$random2' value=''>";
            }
        }
    }

?>
<!-- VISTA -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problemas de tabla de multiplicar</title>
    <style>
    td {
        text-align: center;
        width: 40px;
        height: 20px;
    }

    .small {
        width: 40px;
        height: 20px;
        border: 2px solid black; 
    }
</style>
</head>
<body>
    <h1>Generador de problemas de tablas de multiplicar</h1>
    <h3>Jesús Ferrer López</h3>
    <form action="" method="post"> 
        <label>Número de tablas de multiplicar</label>
        <input type="number" name="numTablas" placeholder="5" value="<?php echo $numTablas;?>"><?php echo $errorTablas;?></br>
        <label>Número de tablas de preguntas</label>
        <input type="number" name="numPreguntas" placeholder="5" value ="<?php echo $numPreguntas;?>"><?php echo $errorPreguntas;?></br>
        <input type="submit" name="generar" value="generar tabla">
        <input type="reset" name="resetear" value="resetear"></br>
        <?php if ($lprocesaformulario){ ?>
            <table border="1">
                <thead>
                    <tr>
                        <?php
                            echo "<th>X</th>"; 
                            for($i=0; $i <$numTablas ; $i++) {
                                echo "<th>" . ($i + 1) . "</th>";
                            } 
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for($i=0; $i < $numTablas; $i++) {
                            echo "<tr>";
                            echo "<td>" . ($i + 1) ."</td>"; 
                            for ($j = 0; $j < $numTablas; $j++) {
                                echo "<td>" . $tabla[$i][$j] . "</td>";
                            }
                            echo "</tr>";
                        } 
                    ?>
                </tbody>
            </table>
        <?php } ?>
    </form>
    <div class="ver_codigo">
        <button type="button"><a href="https://github.com/Feloje20/resolver-tablas-de-multiplicar/blob/main/tablasDeMultiplicar.php">Ver código</a></button>
    </div>   
</body>
</html>