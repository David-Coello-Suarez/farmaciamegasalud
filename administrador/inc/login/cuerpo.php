<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="img/ico.ico?v=<? echo $random ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title>Inicio Session | Farmacia Mega Salud</title>


    <link rel="stylesheet" href="./css/signin.css?v=<? echo $random; ?>" />
</head>

<body class="text-center">

    <main class="form-signin">
        <form id="formLogin">
            <img class="mb-4" src="./img/icons-v2.png?v=<? echo $random; ?>" alt="" width="200" height="57">
            <h1 class="h3 mb-3 fw-normal">Por favor, <br />Ingrese sus credenciales</h1>

            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInput" required autocomplete="off" name="usuario" placeholder="ususario@dominio.com">
                <label for="floatingInput">Dirección de correo electrónico</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" required  autocomplete="off" name="contrasena" placeholder="Controseña">
                <label for="floatingPassword">Contraseña</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Iniciar Session</button>
            <p class="mt-5 mb-3 text-muted">&copy; <? echo date("Y") ?> – <? echo date("Y") + 3 ?></p>

        </form>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/login.js?v=<? echo $random; ?>"></script>
</body>

</html>