<?php
require_once "lib/autoload.php";

$css = array( "style.css");
$PL->BasicHead($css);
?>
    <body>

    <div class="jumbotron text-center">
        <h1>Mijn historiek</h1>
    </div>
    <?php $PL->PrintNavBar(); ?>

    <div class="container">
        <div class="row">

            <p>Gebruiker: <?php

            $userLoader = $Container->getUserLoader();
            $userLoader->getHistoriekUser();


                ?>
            </p>
            <table class="table">
                <tr>
                    <th>Inloggen</th>
                    <th>Uitloggen</th>
                </tr>
                    <?php

                        $userLoader = $Container->getUserLoader();
                        $userLoader->Historiek();

                    ?>
            </table>

        </div>
    </div>
    </body>
</html>