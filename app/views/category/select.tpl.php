<form action="" method="POST" class="mt-5">
<h1>Gestion de la page d'accueil</h1>    
<div class="row">
        <!-- Parcours de toutes les catégories mises en avant -->
        <?php foreach ($categoriesHome as $categoryHome):?>  
            <div class="col">
                <div class="form-group">
                    <label for="emplacement<?= $categoryHome->getHomeOrder() ?>">Emplacement #<?= $categoryHome->getHomeOrder() ?></label>
                    <select class="form-control" id="<?= $categoryHome->getHomeOrder() ?>" name="emplacement[]">
                        <!-- Parcours de toutes les catégories du site -->
                    
                        <option value="<?= $categoryHome->getId() ?>"><?= $categoryHome->getName() ?></option>
                        <?php foreach ($categories as $category):?>   
                            <option <?php if ($categoryHome->getId() == $category->getId()): ?> selected <?php endif ?> value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
                        <?php endforeach;?>   

                        <!-- Fin de la boucle -->
                    </select>
                </div>
            </div>
        <!-- Fin de la boucle -->
        <?php endforeach;?>
    </div>
    <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
</form>