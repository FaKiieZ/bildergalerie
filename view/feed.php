<?php 

// Kontrolliert ob eine gültige Session aktiv ist.
session_start();
if($_SESSION['besucht'] != true){
    echo("Failed to login!");
    header("Location: /login");
    die();
}
$countLikes = 0;

foreach($pictures as $picture) :?>

<?php
$picture->isLiked ? $heartClass = "glyphicon glyphicon-heart heartred" : $heartClass = "glyphicon glyphicon-heart-empty";

if($picture->profile_picture != null){
    $imagesrc = "var/www/uploads/" . $picture->profile_picture;
}else{
    $imagesrc = "images/profile.png";
}
?>

<div id="feed">
    <div class="feed-element">
        <div class="feed-header feed-username">
            <img class="feed-profilbild" src='<?=$imagesrc?>'>
            <a class="feed-usernam" href="/profile?userId=<?=$picture->userId?>"><?php echo $picture->username ?></a>
        </div>
        <div id="functionside">
            <ul>
            <li><a class="iconsside-count" ><?=$picture->likesCount?></a</li>
                <li><a class="iconsside-heart" href="/feed/like?pictureId=<?=$picture->id?>"><span class="<?=$heartClass?>"></a></span></li>
                <li><a class="iconsside" href=""><span class="glyphicon glyphicon-comment"></a></span></li>
            </ul>
        </div>
        <img src='/var/www/uploads/<?php echo $picture->name ?>' class="feed-photo">
    </div>
</div>

<?php endforeach;?>

