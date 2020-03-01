<?php
require_once "lib/autoload.php";
$user = new User();
$user->setVzEid($_SESSION['data'][0]['usr_vz_eid']);
if ( ! $user->getVzEid() > "" )
{
    $MS->AddMessage("U moet uw E-id nog opladen!!!", "error");
}

$css = array( "style.css");
$PL->BasicHead( $css );
$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Uw profiel</h1>
</div>

<?php $PL->PrintNavBar(); ?>

<div class="container">

    <div class="row">

        <div class="col-sm-5">
            <?php
            $PS->GetUserDataFromDatabase();
            ?>
        </div> <!-- col-sm-5 -->

        <div class="col-sm-7">
            <?php
            $images = $PS->GetProfileImages();
            $template = $PL->LoadTemplate("profiel");
            print $PL->ReplaceContent( $images, $template);
            ?>
        </div> <!-- col-sm-7 -->

    </div> <!-- row -->
</div> <!-- container -->

</body>
</html>