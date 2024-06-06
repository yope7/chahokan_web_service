<?php require '../basic/header.php'; ?>

<?php
session_start();

$_SESSION['confirm'] = 1;
?>
<container class="content">
<div class="headline">
    現在のカート<br>
    <?php 
        if(isset($_SESSION['my']['all_items'])){
        print_r($_SESSION['my']['all_items'][0]['item_name'].'<br>');
        print_r('必要ポイントは'.$_SESSION['my']['all_items'][0]['cost'].'pです');
        print_r('<br>よろしいですか？');?>
    <?php
    } 
    // }
    else{
        echo("カートに商品がありません。");
    ?>
    <div><a href="trade.php" class="myButton">戻る</a>
    <?php }?>

    

<form  method="post" action="buy.php">
    <a href="trade.php" class="myButton">戻る</a>
    <input type="hidden" name="buy" value="1"/>
    <button type="submit" class="myButton">確認</button>
</form>
    </div>

</container>
<?php require '../basic/footer.php'; ?>