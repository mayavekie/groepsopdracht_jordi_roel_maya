<?php
require_once "lib/autoload.php";

$css = array( "style.css");
$PL->BasicHead( $css );

$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Landen in de wereld</h1>
    <p>Reeds bezochte landen!</p>
</div>

<?php $PL->PrintNavBar(); ?>

<div class="container">
    <div class="row">

        <?php
        $countryHandler = $Container->getCountryHandler();
        $countryHandler->LoadCityTemplate("landen");
        ?>

    </div>
</div>

</body>
</html>