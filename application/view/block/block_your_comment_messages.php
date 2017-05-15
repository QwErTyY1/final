<?php foreach ($your_comment_message as $messages):  ?>


    <div class="small"><h5><?php echo date("Y-m-d G:i", $messages['comment_created'])?></h5>
        <strong>Messages :</strong> <?=$messages['comment_message'] ;?>

        <button class="bg-danger "id="btnDel" data-itemDel="<?=$messages['comment_id']?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"> </span></button>
        <hr/>
    </div>
<?php endforeach;?>

