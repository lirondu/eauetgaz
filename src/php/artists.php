<link rel="stylesheet" href="./css/artists.css">

<!--Colomuns elements for js clone-->
<div id="columns_container">
    <div id="page_columns"></div>
</div>
<div id="single_column" class="single-column"></div>

<div id="single_artist_container" class="single-artist-container">
    <a href="">
        <span class="artist-name"></span>
        <img class="artist-thumb" src="" alt="">
    </a>
</div>



<div id="artists_pool">

<?php 
if (isset($_GET['year'])) {
	$artists = GetPublishedArtistsOfYear($_GET['year']);
} else {
    $artists = GetPublishedArtists();
}

foreach($artists as $artist) {
    ?>
    <div class="single-artist">
        <div class="name">
            <? echo $artist['name']; ?>
        </div>
        <div class="thumb">
            <? echo $artist['thumb']; ?>
        </div>
        <div class="id">
            <? echo $artist['article_id']; ?>
        </div>
    </div>

    <!--<div class="single-artist">
        <div class="name">Mrova</div>
        <div class="thumb">/images/mrova.jpg</div>
    </div>

    <div class="single-artist">
        <div class="name">Soari
            <br>Kuno</div>
        <div class="thumb">/images/saori.jpg</div>
        <div class="id">2</div>
    </div>

    <div class="single-artist">
        <div class="name">The Wa</div>
        <div class="thumb">/images/thewa.jpg</div>
    </div>

    <div class="single-artist">
        <div class="name">Vincent
            <br>Gruenwald</div>
        <div class="thumb">/images/vincent.jpg</div>
    </div>

    <div class="single-artist">
        <div class="name">Zohar
            <br>Gotesman</div>
        <div class="thumb">/images/zohar.jpg</div>
    </div>

    <div class="single-artist">
        <div class="name">Bjoer
            <br>Kaemmerer</div>
        <div class="thumb">/images/bjoern.jpg</div>
    </div>

    <div class="single-artist">
        <div class="name">MacLean
            <br>Herfurter </div>
        <div class="thumb">/images/cj.jpg</div>
    </div>

    <div class="single-artist">
        <div class="name">Luca
            <br>Pancrazzi</div>
        <div class="thumb">/images/luca.jpg</div>
    </div>

    <div class="single-artist">
        <div class="name">Monika
            <br>Grabuschnigg</div>
        <div class="thumb">/images/monika.jpg</div>
    </div>

    <div class="single-artist">
        <div class="name">Shahar
            <br>Binyamini</div>
        <div class="thumb">/images/shahar.jpg</div>
    </div>-->
    <?
	}
?>
</div>