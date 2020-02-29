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
                $user = new User();
                $_SESSION['usr']->getVoornaam();
                $_SESSION['usr']->getNaam() ?>
            </p>
            <table class="table">
                <tr>
                    <th>Inloggen</th>
                    <th>Uitloggen</th>
                </tr>
                    <?php
                        $sql = "SELECT * FROM log_user WHERE log_usr_id=" . $_SESSION['usr']->getId() . " ORDER BY log_in" ;
                        $data = $Container->getPDOData($sql);

                        foreach( $data as $row )
                        {
                            echo "<tr>";
                            echo "<td>" . $row['log_in'] . "</td>";
                            echo "<td>" . $row['log_out'] . "</td>";
                            echo "</tr>" ;
                        }
                    ?>
            </table>

        </div>
    </div>
    </body>
</html>