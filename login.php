<?php
session_start();

require_once 'content/api/conexion.php';

// Verificar si el usuario ya ha iniciado sesión, redirigirlo a la página de contenido
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: content/client/index.php");
    exit;
}

// Verificar si se ha enviado el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener las credenciales ingresadas por el usuario
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Consultar la base de datos para verificar las credenciales
    $query = "SELECT * FROM usuarios WHERE username = '$username'";
    $result = $conectar -> query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        echo $storedPassword;
        echo $password;
        // Verificar la contraseña
        if ($storedPassword == $password) {
            // Iniciar sesión
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: content/client/index.php");
            exit;
        }
    }

    $error = "Nombre de usuario o contraseña incorrectos";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inicio de sesión</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-box">
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
