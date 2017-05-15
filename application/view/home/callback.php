
<h1 class="modal-title text-center">Your are from my Callback Title. its this!</h1>
<?php //echo $success->message; ?>
<div class="container-fluid">
    <div class="row col-md-12" >
        <?php  if (empty($error->message)):  ?>
        <h3 class="alert-success">You have successfully logged into Facebook</h3>
        <p>Your name: <strong><?=$user->getName();?></strong></p>
        <p> Your email: <strong><?=$user->getEmail();?></strong></p>
        <p>Your id: <strong><?=$user->getId();?></strong></p>
            <?php else: ?>
          <div class="alert-danger"><?=($error->message)?></div>
        <?php endif;?>

    </div>

</div>





<a href="<?php echo URL; ?>">home</a>

