<?php 

session_start();
if($_SESSION['user_id'] == $profile->id){
    $myProfile = "hidden";
    $bearbeiten = "show";
    $function = "/settings";
    $style = "show";
}else{
    $myProfile = "show";
    $bearbeiten = "hidden";
    $function = "/profile/follow";
    $style = "hidden";
}

if($profile->isFollowing){
    $followText = "Defollow";
}else{
    $followText = "Follow";
}

if($_SESSION['besucht'] != true){
    echo("Failed to login!");
    header("Location: /login");
    die();
}

if($profile->profile_picture != null){
    $imagesrc = "var/www/uploads/" . $profile->profile_picture;
}else{
    $imagesrc = "images/profile.png";
}

?>

<div id="profile">
    <img id="profilbild" src="<?=$imagesrc?>" width="100px">
    <div id="content">
        <h3 class="name"><?php echo $profile->username;?></h3><br><br>
        <p class="status"><?php echo $profile->status;?></p>
    </div>
    <div id="floatright">
        <div id="followbutton">
            <form action="<?=$function?>" method="GET" id="form">
                <input type="hidden" name="userId" id="follow" value="<?php echo $profile->id ?>">
                <input type="submit" class="btn btn-default <?=$myProfile?>" value="<?=$followText?>" id="follow">
            </form>
            <form action="<?=$function?>" method="GET" id="form" style="<?=$style?>">
                <input type="submit" class="btn btn-default <?=$bearbeiten?>" value="Bearbeiten" id="follow">
            </form>
        </div>
        <div id="followcount">
            <h3 id="count_follower"><?php echo $profile->followersCount;?> Follower</h3>
        </div>
    </div>
</div>
<br>
<hr id="line">
<div id="feed">
    <?php 

    $path = "var/www/uploads/";
    foreach ($profile->pictures as $picture){
        $picture->isLiked ? $heartClass = "glyphicon glyphicon-heart heartred" : $heartClass = "glyphicon glyphicon-heart-empty";
        echo "<div class='feed-element'>
        <div class='feed-header'>
            <img class='feed-profilbild' src='$imagesrc'>
            <h3 class='feed-username'>$profile->username</h3>
        </div>
        <div id='functionside'>
            <ul>
                <li><a class='iconsside-count' >$picture->likesCount</a</li>
                <li><a class='iconsside-heart' href='/profile/like?pictureId=$picture->id&userId=$profile->id'><span class='$heartClass'></a></span></li>
                <li><a class='iconsside' href=''><span class='glyphicon glyphicon-comment'></a></span></li>
            </ul>
        </div>
        <img src='" . $path . $picture->name . "' class='feed-photo'>
    </div>";
    }

    ?>
</div>

