<?php
require_once "lib/autoload.php";

$css = array( "style.css" );
$PL->BasicHead( $css );

$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Formulier Stad</h1>
</div>

<?php $PL->PrintNavBar(); ?>

<div class="container">
    <div class="row">

        <?php
        $cityHandler = $Container->getCityHandler();
        $cityHandler->LoadCityTemplate("stad_form");
        ?>

    </div>
</div>
</body>
</html>