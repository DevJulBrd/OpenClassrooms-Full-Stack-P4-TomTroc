<?php
/** @var \App\Models\Entities\Book $book */
?>

<section class="book_edit-container">
    <a href="index.php?action=profile" class="discution-goBack book_edit-goBack"><- retour</a>
    <h1 class="register-title book-edit-title">Modifier les informations</h1>

    <div class="book_edit-infos-container">
        <?php if (!empty($errors)): ?>
            <div class="alert-errors">
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="book-edit-form" method="post" action="index.php?action=updateBook" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= (int)$book->getId() ?>">

            <div class="book-edit-part">
                <div class="book-edit-photo">
                    <div class="book-edit-photo-preview">
                        <p class="register-label book_edit-marge">Photo</p>
                        <?php
                            $img = $book->getImage_path() ?: '../images/book-default.jpg';
                        ?>
                        <img src="<?= htmlspecialchars($img) ?>" 
                             alt="Couverture du livre" 
                             class="book-preview-img">
                    </div>
                    <label class="book-edit-photo-label book_edit-img-modif">
                        <span class="profile-update">Modifier la photo</span>
                        <input type="file" name="image_file" accept="image/*" style="display:none;">
                    </label>
                </div>

                <div class="book-edit-fields">
                    <label class="register-label">
                        Titre<br>
                        <input
                            class="register-input"
                            name="title"
                            type="text"
                            required
                            value="<?= htmlspecialchars($book->getTitle()) ?>">
                    </label>

                    <label class="register-label">
                        Auteur<br>
                        <input
                            class="register-input"
                            name="author"
                            type="text"
                            required
                            value="<?= htmlspecialchars($book->getAuthor()) ?>">
                    </label>

                    <label class="register-label">
                        Commentaire<br>
                        <textarea
                            class="register-input"
                            name="description"
                            rows="6"><?= htmlspecialchars($book->getDescription()) ?></textarea>
                    </label>

                    <label class="register-label">
                        Disponibilité<br>
                        <?php $status = $book->getStatus(); ?>
                        <select class="register-input" name="status">
                            <option value="available"   <?= $status === 'available'   ? 'selected' : '' ?>>disponible</option>
                            <option value="unavailable" <?= $status === 'unavailable' ? 'selected' : '' ?>>non disponible</option>
                        </select>
                    </label>

                    <button class="register-button book-edit-button" type="submit">Valider</button>
                </div>
            </div>
        </form>
    </div>
</section>
