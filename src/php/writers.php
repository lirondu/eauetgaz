<?
$articles = GetAllPublishedWritersArticles();
?>

<link rel="stylesheet" href="./css/article.css">
<link rel="stylesheet" href="./css/writers.css">

<div id="columns_container">
    <div id="page_columns">
        <div id="gallery_column" class="single-column">
                <div class="text-gallery-box">
                    <img src="/images/writers.jpg" alt="" class="text-gallery">
                    <h5 class="text-gallery-title">Title test: by test</h5>
                </div>
        </div>
        <div id="text_column" class="single-column">
            <div id="text_container">
				
				<ol class="breadcrumb">
                    <li>
                        <a href="<? echo GetMenuPageLink($pageMenuName); ?>">
                            <? echo $pageMenuName; ?>
                        </a>
                    </li>
                </ol>
				
				<?
				foreach ($articles as $article) {
					?>
					<h2 class="text-header"><? echo $article['title_en'] ?></h2>
					<p class="writer-article"><? echo $article['content_en']; ?></p>
					<?
				}
				?>
								
                
                <!--<ul id="writers_list">
                    <li><a href="/index?type=article&menu-name=Writers&id=4">Eugenia Lapteva</a></li>
                    <li><a href="">Margareth Kaserer</a></li>
                    <li><a href="">Marion Oberhofer</a></li>
                    <li><a href="">Stefano Riba</a></li>
                    <li><a href="">Elisabeth Obermeier</a></li>
                    <li><a href="">Piotr Piskozub</a></li>
                    <li><a href="">Sarah Oberrauch</a></li>
                </ul>
                <p>
                    Kathrin Oberrauch is a curator based in Berlin and Tel Aviv. She recently completed her postgraduate’s studies at Kunsthochschule Weißensee of Berlin. She is part of the artistic team of Singapore Pavilion at the Venice Biennale 2015.
                    Previously, she has worked as a researcher and curator for various institutions, including Association Arte all’Arte (San Gimignano), Arte Pollino (Basliciata), Forum Factory (Berlin), ArtBus (New York), Goethe Institute (Bangalore),
                    KunstHaus (Merano), and Transart Festival (Bolzano). Since 2009 she has been the director of the Contemporary Art Collection Finstral, where she curates group exhibitions by young international artists and organized satellite programs
                    in the region of South Tyrol, Italy.
                    <br>
                    <br> Sarah Oberauch lives and works in Berlin and is studing at Humboldt University and at the University of the Arts. Sarah Oberrauch’s video works and installations result from her personal response to a specific environment. Drawing
                    on real life observations and imaginative scenarios, Oberrauch creates short but thought-provoking visual vignettes which portray a setting or situation from an unusual point of view. Her documentary approach is often coupled with
                    humoristic interventions which lend her work a surreal quality and subversive impact.
                    <br>
                    <br> Eugenia Lapteva is a London based writer. Born and raised in Stock- holm she completed her BA in European Literature at University of Sussex and MA in Comparative Literature and Modern Literary Theory at Goldsmiths. She has written
                    for notable publications such as Tank, The White Review, Sang Bleu, ELLE and Husk magazine. Her main research interests revolve around questions of art and technology in modern culture and their impact on the nature of our social and
                    loving relationships today. She is currently pursuing her PhD at University of Sussex.
                    <br>
                    <br> Marion Oberhofer born 1982 in Bozen (Italy). Bachelor of media, art and design theory at the Zürcher Hochschule der Künste (Switzerland) in 2008. Since 2010 studies at the Academy of Fine Arts Vienna (Harun Farocki). Currently working
                    on the thesis. Realization of various exhibition- and film-projects with different accomplices. Working experiences as teacher, art-mediator (Manifesta7 and Generali Foundation) and journalist.
                    <br>
                    <br> Margareth Kaserer (*1983 in Bozen, Italy) Moving between Northern Italy, Belgium, Vienna and Berlin. Affinity for text, performance art, experimental set-ups, music at the edges, queer culture, research. Studied Comparative Literature
                    and Theatre-, Film- and Media Sciences at the University of Vienna (AT), thesis on “Sexuality and subversion. Sade, Jelinek and newer texts (Despentes, Roche and Faldbakken)” Postgraduate training a.pass (Advanced Performance and Scenography
                    Studies) in Antwerp (BE): artistic and scientific research on “The Unconscious”.
                    <br>
                    <br> Piotr Piskozub (born in Szczecinek, Poland) is a visual artist currently living and working in Antwerp, Belgium. He graduated from Royal Academy of Fine Arts in Antwerp. He works with drawings, objects and sculptures which are part
                    of his personal formative research within his intangible self using form as a mean of its expression.
                    <br>
                    <br> Elisabeth Obermeier is studying cultural studies and art history at Humboldt University, Berlin. She graduated in fine arts from UdK, University of the Arts Berlin in 2013. In her current studies, she focuses on the history of knowledge
                    and epistemology, as well as related notions of environment, milieu and technology. Accompanying all her interests are theoretical engagements with the image.
                </p>-->
            </div>
        </div>
    </div>
</div>