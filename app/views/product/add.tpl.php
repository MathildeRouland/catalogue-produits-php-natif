
<a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-end">Retour</a>

    
    <form action="<?= $router->generate('product-add-post') ?>" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" name="name"  id="name" placeholder="Nom du produit" value="<?= $product->getName() ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="<?= $product->getDescription() ?>" aria-describedby="subtitleHelpBlock">
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Sera affiché sur la page d'accueil comme bouton devant l'image
            </small>
        </div>
         
         
        <div class="mb-3">
            <label for="picture" class="form-label">Image</label>
            <input type="text" class="form-control" name="picture" id="picture" placeholder="image jpg, gif, svg, png" value="<?= $product->getPicture() ?>" aria-describedby="pictureHelpBlock">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
           
        </div>

        <div class="mb-3">
            <label for="picture" class="form-label">Image</label>
            <input type="text" class="form-control" name="picture" id="picture" placeholder="image jpg, gif, svg, png" value="<?= $product->getPrice() ?>" aria-describedby="pictureHelpBlock">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
           
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Image</label>
            <input type="text" class="form-control" name="picture" id="picture" placeholder="image jpg, gif, svg, png" value="<?= $product->getRate() ?>" aria-describedby="pictureHelpBlock">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
           
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">Image</label>
            <input type="text" class="form-control" name="picture" id="picture" placeholder="image jpg, gif, svg, png" value="<?= $product->getStatus() ?>" aria-describedby="pictureHelpBlock">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
           
        </div>
                
        <div class="mb-3">
            <label for="brand_id" class="form-label">marque</label>
            <select class="form-control" name="brand_id" id="brand_id">
            <?php foreach ($brands as $brand) :?>
                <option value="<?=$brand->getId();?>"><?=$brand->getName();?></option>               
            <?php endforeach; ?>
            </select>
            
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">catégorie</label>
            <select class="form-control" name="category_id" id="category_id">
            <?php foreach ($categories as $category) :?>
                <option value="<?=$category->getId();?>"><?=$category->getName();?></option>               
            <?php endforeach; ?>
            </select>
            
        </div>
        <div class="mb-3">
            <label for="type_id" class="form-label">type</label>
            <select class="form-control" name="type_id" id="type_id">
            <?php foreach ($types as $type) :?>
                <option value="<?=$type->getId();?>"><?=$type->getName();?></option>               
            <?php endforeach; ?>
            </select>
            
        </div>

        <div class="mb-3">
        <label for="price">Prix</label>
        <input type="number" class="form-control" id="price" name="price" placeholder="Prix" 
            aria-describedby="priceHelpBlock">
        <small id="priceHelpBlock" class="form-text text-muted">
            Le prix du produit 
        </small>
    </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>