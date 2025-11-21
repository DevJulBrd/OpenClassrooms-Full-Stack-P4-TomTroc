<section>
    <div class="books-header-container">
        <h1 class="home-title-present books-title">Nos livres à l'échange</h1>
        
        <form class="searchbar" role="search" aria-label="Recherche de livres" method="get" action="index.php">
            <i class="fa-solid fa-magnifying-glass loop" aria-hidden="true"></i>

            <!-- action du routeur -->
            <input type="hidden" name="action" value="books">

            <label for="q" class="sr-only">Rechercher un livre</label>
            <input
                id="q"
                class="input-search"
                name="q"
                type="search"
                placeholder="Rechercher un livre"
                autocomplete="off"
                value="<?= htmlspecialchars($search ?? '') ?>"
            />
        </form>
    </div>
    
    <div class="books-cards-container">
        <?php if ($books === []): ?>
            <p class="home-no-books">
                <?php if (($search ?? '') !== ''): ?>
                    Aucun livre ne correspond à « <?= htmlspecialchars($search) ?> ».
                <?php else: ?>
                    Aucun livre n'a encore été ajouté.
                <?php endif; ?>
            </p>
        <?php else: ?>
            <div class="home-books-list-container">
                <?php foreach ($books as $b): ?>
                    <div class="home-book-card">
                        <a href="index.php?action=book&id=<?= $b->getId() ?>" class="home-book-link">
                            <div class="home-book-img-container">
                                <img
                                    src="<?= htmlspecialchars($b->getImage_path() ?? '') ?>" 
                                    alt="couverture du livre <?= htmlspecialchars($b->getTitle()) ?>" 
                                    class="home-book-img"
                                >
                            </div>
                            <div class="home-book-infos">
                                <div class="home-book-info-container">
                                    <p class="home-book-title"><?= htmlspecialchars($b->getTitle()) ?></p>
                                    <p class="home-book-author"><?= htmlspecialchars($b->getAuthor() ?? '') ?></p>
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
    </div>
</section>
