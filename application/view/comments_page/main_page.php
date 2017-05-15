<div class="test">


<?php if (isset($_SESSION['message'])):?>
    <div class="container">
    <div class="col-md-9">
    <div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        <strong>Success!</strong> <?=$_SESSION['message'];?>.
    </div>
   </div>
   </div>
    <?php else: ?>
    <?=""?>
<?php endif;
    unset($_SESSION['message']);
?>

<?php if (!empty($messages->commment_message)):?>
    <div class="container">
    <div class="col-md-9">
    <div class="alert <?=$messages->class;?> fade in alert-dismissable" style="margin-top:18px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        <strong><?=$messages->act;?></strong> <?=$messages->commment_message;?>.
        <strong><?=$messages->act;?></strong> <?=$messages->date;?>.
    </div>
   </div>
   </div>
<?php endif;

    unset($messages->commment_message);
?>



<?php if (!empty($user->login)): ?>


        <div class="container">
            <div class="row col-md-12">
                <form method="post" action="<?=URL;?>comment/index" id="addFormComment">
                    <div class="col-md-8">
                        <div class="form-group">
                            <textarea class="form-control" name="comment_message" id="exText" rows="5"></textarea>
                        </div>
                        <input type="hidden" name="idUses" id="idUses" value="0">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="addcomment" id="addcomment" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>

        </div>

<?php else: unset($user->login) ?>

        <div class="row col-md-12 center-block">
    <div class="omb_login row omb_row-sm-offset-3 omb_socialButtons table table-bordered" style="background: #c8e5bc" >

   <?php require_once APP.'view/block/block_home.php'; ?>
    </div>
</div>

<?php endif; ?>





<div class="container">

<div class="Box row col-md-10">

    <?php if (!empty($user->login) && isset($_SESSION['user']['name'])):?>
    <span class="btn glyphicon glyphicon-chevron-right toggle-btn butT"> YOUR MESSAGES</span>

        <div class="container">
        <div class="row col-md-9">

            <div id="mySMethod" class="collapse">
                <div id="getOne" style="height: 550px">

                    <?php require_once APP.'view/block/block_your_comment_messages.php'; ?>
                 </div>
                <div class="row col-md-12 text-center">
                    <ul class="your_pagination">
                    <?php for ($i = 0; $i<$total_your_pages; $i++):?>

                        <button class="btn btn_your_pagenation" id="btn_your_pagenation" data-itemTwo="<?=$i+1;?>"><?=$i+1;?></button>

                    <?php endfor; ?>
                    </ul>
                </div>
            </div>



        </div>
    </div>
    <?php endif ?>


<span class="btn glyphicon glyphicon-chevron-right toggle-btn butD"> ALL POSTS</span>
    <div class="container" id="Go">
        <div class="row col-md-9">


            <div id="myFMethod" class="collapse">
                <div class="row col-md-12 text-center">
                    <ul class="pagination">
                        <button class="btn btn_pagenation" id="btn_pagenation" data-item="1">Prev</button>
                        <?php

                        for ($i=0; $i<$totalPages-1; $i++){
                            $date[$i] = $i;
                            ?>
                            <button class="btn btn_pagenation" id="btn_pagenation" data-item="<?=$i;?>"><?=$i+1?></button>
                            <?php
                        }
                        ;?>
                        <button class="btn btn_pagenation" id="btn_pagenation" data-item="<?=$totalPages;?>">Last</button>
                    </ul>
                </div>

                <div id="getAll" style="height: 550px">
                <?php echo $this->model->cat_list();?>
            </div>

            </div>
        </div>
    </div>

</div>




</div>
</div>

<?php
