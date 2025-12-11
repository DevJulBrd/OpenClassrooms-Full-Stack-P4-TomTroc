<section class="home-present-container">
    <div class="home-img-present-container">
        <img src="./images/img1.png" alt="Photo d'un lecteur en touré de livres empilés" class="home-img-present">
        <p class="home-legend-present">Hamza</p>
    </div>
    <div class="home-text-present-container">       
        <h2 class="home-title-present">Rejoingez nos lecteurs passionés</h2> 
        <p class="home-text-present">Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres. </p>
        <div class="link-container">
            <a href="index.php?action=books" class="home-link-button-present">Découvrir</a>
        </div> 
    </div>

</section>

<section class="home-books-container">
    <h2 class="home-title-present home-title-books">Les derniers livres ajoutés</h2>

    <?php if ($books === []): ?>
        <p class="home-no-books">Aucun livre n'a encore été ajouté.</p>
    <?php else: ?>
        <div class="home-books-list-container">
            <?php foreach ($books as $b): ?>
                <div class="home-book-card">
                    <a href="index.php?action=book&id=<?= (int)$b->getId() ?>" class="home-book-link">
                        <div class="home-book-img-container">
                            <img 
                                src="<?= htmlspecialchars($b->getImage_path() ?? '') ?>" 
                                alt="couverture du livre <?= htmlspecialchars($b->getTitle()) ?>" 
                                class="home-book-img"
                            >
                        </div>
                        <div class="home-book-infos">
                            <div class="home-book-info-container">
                                <p class="home-book-title">
                                    <?= htmlspecialchars($b->getTitle()) ?>
                                </p>
                                <p class="home-book-author">
                                    <?= htmlspecialchars($b->getAuthor() ?? '') ?>
                                </p>
                            </div>
                            <div>
                                <p class="home-book-user">
                                    Vendu par : <?= htmlspecialchars($b->getUsername()) ?>
                                </p>
                            </div>
                        </div>   
                    </a>
                </div>           
            <?php endforeach; ?>
        </div>  
    <?php endif; ?> 

    <a href="index.php?action=books" class="home-link-button-present home-link-books home-link-padding">Découvrir</a>     
</section>


<section class="home-explain-container">
    <div class="home-explain-text-container">
        <h2 class="home-title-present home-title-explain">Comment ça marche ?</h2>
        <p class="home-explain-text">Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</p>
        <div class="home-explain-steps-container">
            <div class="home-explain-step">
                <p class="home-explain-step-text">Inscrivez-vous gratuitement sur notre plateforme.</p>
            </div>
            <div class="home-explain-step">
                <p class="home-explain-step-text">Ajoutez les livres que vous souhaitez échanger à votre profil.</p>
            </div>
            <div class="home-explain-step">
                <p class="home-explain-step-text">Parcourez les livres disponibles chez d'autres membres.</p>
            </div>
            <div class="home-explain-step">
                <p class="home-explain-step-text">Proposez un échange et discutez avec d'autres passionnés de lecture.</p>
            </div> 
        </div>
        <div class="link-conntainer">
            <a href="index.php?action=books" class="register-button profile-button home-explain-button">Voir tous les livres</a>
        </div>
    </div>
    <img src="./images/img2.png" alt="Dame de dos, au milieu d'une bibliothèque remplie de livre" class="home-img-explain">
</section>

<section class="home-valeurs-container">
    <h2 class="home-title-present home-title-valeurs">Nos valeurs</h2>
    <div class="home-explain-text-container">
        <p class="home-valeurs-text">Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.
        <br/>
        <br/>
        Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé. 
        <br/>
        <br/>
        Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.</p>
        <p class="home-legend-present home-legend-valeurs">L'équipe Tom Troc</p>
    </div>
    <div class="home-img-valeurs">
        <img src="./images/img3.svg" alt="Coeur">
    </div>
</section>
    