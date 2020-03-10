<?php
require_once "lib/autoload.php";

$css = array( "style.css" );
$PL->BasicHead( $css );

$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Formulier Land</h1>
</div>

<?php $PL->PrintNavBar(); ?>

<div class="container">
    <div class="row">

        <?php
        $countryHandler = $Container->getCountryHandler();
        $countryHandler->LoadCityTemplate("land_form");
        ?>

    </div>
</div>
</body>
</html>