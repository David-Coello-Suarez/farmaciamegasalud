</div>
<div class="container-fluid footer mt-auto py-3 bg-light">
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0 text-muted">© <? echo date("Y"); ?> Sotenet.net, Inc</p>

            <a href="inicio" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                <img src="img/ico.ico?v=<? echo $random ?>" width="40" />
            </a>

            <ul class="nav col-md-4 justify-content-end">
                <?
                $itemMenu = "";
                foreach ($menu as $key => $item) {
                    if ($key < 4) {
                        $itemMenu .= "
                            <li>
                                <a href='" . $item['ventana'] . "' class='nav-link px-2 " . ($pagina == $item['ventana'] ? 'text-black' : 'text-secondary') . "'>
                                    " . ucfirst($item['nombre']) . "
                                </a>
                            </li>
                        ";
                    }
                }
                print_r($itemMenu);
                ?>
            </ul>
        </footer>
    </div>
</div>

<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

<?
for ($i = 0; $i < count($arregloLib['libreria']); $i++) {
    switch ($arregloLib['libreria'][$i]) {
        case 'sweetalert':
            echo '<script type="text/javascript" language="javascript" src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            break;
        case 'daysjs':
            echo '<script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>';
            break;
        case 'momentjs':
            echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
            echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es-us.min.js" integrity="sha512-QfUPyAMVgJBoL2yYVx8xkXmPFL7IKoF+eP5hq5xF4O/Mz1eqvxdy/vBEWDiJNPwGw7K8FCcCllrppqLpSWK/ng==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
            break;
        case 'checkeditor':
            echo '<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>';
            break;
    }
}
?>

<script type="text/javascript" language="javascript" src="js/cabpie/funciones.js?v=<? echo $random ?>"></script>
<?
if (file_exists("js/$pagina.js")) {
    echo "<script type='text/javascript' language='javascript' src='js/$pagina.js?v=$random'></script>";
}
?>


</body>

</html>