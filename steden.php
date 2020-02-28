<?php
require_once "lib/autoload.php";

$css = array( "style.css");
$PL->BasicHead( $css );

$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Leuke plekken in Europa</h1>
    <p>Tips voor citytrips voor vrolijke vakantiegangers!</p>
</div>

<?php $PL->PrintNavBar(); ?>

<div class="container">
    <div class="row">

        <?php
        $cityHandler = $Container->getCityHandler();
        $cityHandler->LoadCityTemplate("steden");
        ?>

    </div>
</div>

</body>
</html>