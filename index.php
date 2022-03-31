<?php
$api_key = "";
$person1 = "";
$person2 = "";
$user1 = 'user1.json';
$user2 = 'user2.json';
$cache_ttl = 43200;
if(file_exists($user1) && file_exists($user2) && (time() - filemtime($user1) < $cache_ttl) && (time() - filemtime($user2) < $cache_ttl))
{
    $json_decoded = json_decode(file_get_contents($user1), true);
    $json_decoded2 = json_decode(file_get_contents($user2), true);
} else {
    $steamuser1 = file_get_contents("https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?include_appinfo=true&key=".$api_key."&steamid=".$person1);
    $steamuser2 = file_get_contents("https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?include_appinfo=true&key=".$api_key."&steamid=".$person2);
    file_put_contents($user1,$steamuser1);
    file_put_contents($user2, $steamuser2);
    $json_decoded = json_decode(file_get_contents($user1), true);
    $json_decoded2 = json_decode(file_get_contents($user2), true);
}
?>
<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
<button onclick="reddel()">Удалить красные игры</button>
<button onclick="greendel()">Удалить зелёные игры</button>
    <div class="row">
    <?php
        $gamesort = array();
        $gamesort2 = array();
        $usergames = $json_decoded['response']['games'];
        $usergames2 = $json_decoded2['response']['games'];
        foreach ( $usergames as $gamelist => $arr  ) { $gamesort[$gamelist]  = $arr['name']; }
        foreach ( $usergames2 as $gamelist => $arr ) { $gamesort2[$gamelist] = $arr['name']; }
        array_multisort($gamesort, $usergames);array_multisort($gamesort2, $usergames2);?>
        <div class="col s6 m6" id="player">
            <?php foreach ($usergames as $gameslistuser => $value) { ?>
            <div class="card" style="background:#c53232;">
                <div class="card-image waves-effect waves-light">
                    <?php
                    if(!empty($value['img_icon_url'])) {
                    ?>
                    <img class="activator"
                        src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/<?php echo $value['appid'].'/'.$value['img_icon_url'];?>.jpg" width="100px" height="100px">
                        <?}?>
                </div>
                <div class="card-content" style="display: inline-block;">
                    <span class="card-title activator grey-text text-darken-4"><?php echo $value['name'];?></span>
                    <p><a href="https://steamcommunity.com/app/<?php echo $value['appid'];?>">Open Steam Link</a></p>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4"><?php echo $value['name'];?></span>
                    <p>This information for steam game.</p>
                </div>
            </div>
            <?php }?>
        </div>
        <div class="col s6 m6" id="player2">
            <?php foreach ($usergames2 as $games2) { ?>
            <div class="card" style="background:#c53232;">
                <div class="card-image waves-effect waves-light">
                <?php
                    if(!empty($games2['img_icon_url'])) {
                    ?>
                    <img class="activator"
                        src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/<?php echo $games2['appid'].'/'.$games2['img_icon_url'];?>.jpg" width="100px" height="100px">
                        <?}?>
                </div>
                <div class="card-content" style="display: inline-block;">
                    <span class="card-title activator grey-text text-darken-4"><?php echo $games2['name'];?></span>
                    <p><a href="https://steamcommunity.com/app/<?php echo $games2['appid'];?>">Open Steam Link</a></p>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4"><?php echo $games2['name'];?></span>
                    <p>This information for steam game.</p>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <footer><div class="copyright" align="center">
  <script>
    document.write('&copy;' );
    document.write(' 2022 - ');
    document.write(new Date().getFullYear());
    document.write(' <a href="https://github.com/SniffRx/">SniffRx</a> - All Rights Reserved.');
    document.write('<br/>Last Updated : ');
    document.write(document.lastModified);
  </script></footer>
</body>
</html>
<script>
let elements = Array.from(document.querySelectorAll('#player .card .card-content .card-title'));
let elements2 = Array.from(document.querySelectorAll('#player2 .card .card-content .card-title'));
console.log(elements[0].parentNode.parentNode.attributes[1].nodeValue);
for (let i = 0; i < elements.length; i++) {
    for (let j = 0; j < elements2.length; j++) {
        if(elements[i].innerHTML == elements2[j].innerHTML)
        {
            elements[i].parentNode.parentNode.style.background = "#719d37";
            elements2[j].parentNode.parentNode.style.background = "#719d37";
        }
    }
}
function greendel(){
    let elements = Array.from(document.querySelectorAll('#player .card .card-content .card-title'));
let elements2 = Array.from(document.querySelectorAll('#player2 .card .card-content .card-title'));
for (let i = 0; i < elements.length; i++) {
    for (let j = 0; j < elements2.length; j++) {
        if(elements[i].innerHTML == elements2[j].innerHTML)
        {
            elements[i].parentNode.parentNode.remove(elements[i]);
            elements2[j].parentNode.parentNode.remove(elements[j]);
        }
    }
}
}
function reddel(){
    let elements = Array.from(document.querySelectorAll('#player .card .card-content .card-title'));
let elements2 = Array.from(document.querySelectorAll('#player2 .card .card-content .card-title'));
for (let i = 0; i < elements.length; i++) {
    for (let j = 0; j < elements2.length; j++) {
        if(elements[i].parentNode.parentNode.attributes[1].nodeValue == 'background:#c53232;'){
            elements[i].parentNode.parentNode.remove(elements[i]);
        }
        if(elements2[j].parentNode.parentNode.attributes[1].nodeValue == 'background:#c53232;'){
            elements2[j].parentNode.parentNode.remove(elements2[j]);
        }
    }
}
}
</script>
