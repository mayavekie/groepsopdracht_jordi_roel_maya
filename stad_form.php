<?php
require_once "lib/autoload.php";

$css = array( "style.css" );
BasicHead( $css );
?>
<body>

<div class="jumbotron text-center">
    <h1>Formulier Stad</h1>
</div>

<div class="container">
    <div class="row">

        <?php
        $container = new Container($configuration);
        $cityHandler = $container->getCityHandler();
        $cityHandler->LoadCityTemplate("stad_form", $_GET['id']);
        ?>

    </div>
</div>
</body>
</html>