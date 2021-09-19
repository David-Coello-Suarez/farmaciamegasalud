<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/ico.ico?v=<? echo $random ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><? echo ucfirst($pagina); ?> | <? print_r($parametro['nombreweb']) ?></title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
    <?
    if (file_exists("css/$pagina.css")) {

        echo "<link rel='stylesheet' href='css/$pagina.css?v=$random'>";
    }
    ?>
</head>

<body class="d-flex flex-column h-100">

    <header class="p-3 bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="inicio" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img src="img/ico.ico?v=<? echo $random ?>" width="40" />
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <?
                    $itemMenu = "";
                    foreach ($menu as $key => $item) {
                        if (file_exists("inc/".$item['ventana'])) {
                            $itemMenu .= "
                                <li>
                                    <a href='" . $item['ventana'] . "' class='nav-link px-2 " . ($pagina == $item['ventana'] ? 'text-white' : 'text-secondary') . "'>
                                        " . ucfirst($item['nombre']) . "
                                    </a>
                                </li>
                            ";
                        }
                    }
                    print_r($itemMenu);
                    ?>
                </ul>

                <!-- <div class="text-end">
                    <button type="button" class="btn btn-warning">Salir</button>
                </div> -->
                <ul class="text-end nav">
                    <li>
                        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle me-5">
                    </li>
                    <li>
                        <a href="logout.php" role="button" class="btn btn-warning">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container pt-4">