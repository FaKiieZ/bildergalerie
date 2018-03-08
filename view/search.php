<?php 
session_start();
if($_SESSION['besucht'] != true){
    echo("Failed to login!");
    header("Location: /login");
    die();
}

foreach($result as $user) :?>
    
<?php 
if($user->profile_picture != null){
    $imagesrc = "var/www/uploads/" . $user->profile_picture;
}else{
    $imagesrc = "images/profile.png";
}
?>

<div id='profile' style="border: 1px solid #FFB2B2; padding-top: 1em; padding-left: 1em; padding-bottom: 1.5em;">
    <img id='profilbild' src='<?=$imagesrc?>'>
    <div id='content' class='searchname'>
        <a class='name' href="/profile?userId=<?=$user->id?>"><?=$user->username?></a><br><br>
        <p class='status'><?=$user->status ?></p>
        <h3><?=$user->followersCount?> Follower</h3>
    </div>
</div>
<br>
<br>

<?php endforeach;?>