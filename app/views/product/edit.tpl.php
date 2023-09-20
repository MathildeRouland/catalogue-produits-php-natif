<?php dump($tags);?>

<div class="container my-4">
    <h2>Mettre à jour un produit</h2>
<!-- Affichage des tags (seulement quand on modifie) -->
<?php if (! empty($product->getId())): ?>
<div class="form-group mt-3">
    <h3>Liste des tags</h3>
    <ul>
    <?php foreach($tags as $tag) : ?>
        <a href="#">
            <span class="badge badge-primary">
            <li><?= $tag->getName() ?></li>
            </span>
        </a>
    <?php endforeach; ?>
    </ul>
</div>
<?php endif ?>
    <a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-end">Retour</a>
    <h2>Editer un produit</h2>

    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" id="name" value="<?=$product->getName()?>">
        </div>
        <div class="mb-3">
            <label for="subtitle" class="form-label">Sous-titre</label>
            <input type="text" class="form-control" id="subtitle" name="description" value="<?=$product->getDescription()?>" aria-describedby="subtitleHelpBlock">
            
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Image</label>
            <input type="text" class="form-control" name="picture" id="picture" value="<?=$product->getPicture()?>" aria-describedby="pictureHelpBlock">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Prix</label>
            <input type="text" class="form-control" name="price" id="price" value="<?= $product->getPrice() ?>" aria-describedby="pictureHelpBlock">
                       
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Note</label>
            <input type="text" class="form-control" name="rate" id="rate" value="<?= $product->getRate() ?>" aria-describedby="pictureHelpBlock">
                       
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Statut</label>
            <input type="text" class="form-control" name="status" id="status" value="<?= $product->getStatus() ?>" aria-describedby="pictureHelpBlock">
                     
        </div>
        <div class="mb-3">
            <label for="brand_id" class="form-label">marque</label>
            <select class="form-control" id="brand" name="brand" aria-describedby="brandHelpBlock">
            <?php foreach ($brands as $brand): ?>
                <option value="<?= $brand->getId() ?>" <?php if ($product->getBrandId() == $brand->getId()): ?> selected <?php endif ?>><?= $brand->getName() ?></option>
            <?php endforeach ?>
        </select>
            
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">catégorie</label>
            <select class="form-control" id="category" name="category" aria-describedby="categoryHelpBlock">
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->getId() ?>" <?php if ($product->getCategoryId() == $category->getId()): ?> selected <?php endif ?>><?=$category->getName() ?> </option>
            <?php endforeach ?>
        </select>
            
        </div>
        <div class="mb-3">
            <label for="type_id" class="form-label">type</label>
            <select class="form-control" id="type" name="type" aria-describedby="typeHelpBlock">
            <?php foreach ($types as $type): ?>
                <option value="<?= $type->getId() ?>" <?php if ($product->getTypeId() == $type->getId()): ?> selected <?php endif ?>><?= $type->getName() ?></option>
            <?php endforeach ?>
        </select>
            
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>