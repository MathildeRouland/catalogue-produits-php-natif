
  
  
  <div class="container my-4">
    <p class="display-4">
      Bienvenue dans le backOffice <strong>Dans les shoe</strong>...
    </p>
    <?php if (isset($_SESSION['userId'])): ?>
    <nav>
        <a href="<?= $router->generate('logout') ?>">Se déconnecter</a>
    </nav>
    <?php else: ?>
    <p>Vous n'êtes pas connecté(e).</p>
    <nav>
        <a href="<?= $router->generate('login') ?>">Se connecter</a>
    </nav>
    <?php endif ?>
    <div class="row mt-5">
      <div class="col-12 col-md-6">
        <div class="card text-white mb-3">
          <div class="card-header bg-primary">Liste des catégories</div>
          <div class="card-body">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nom</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 0 ?>
                <?php foreach ($categories as $category) : ?>
                  <?php $i++ ?>
                  <tr>
                    <th scope="row"><?php echo $i ?></th>
                    <td><?= $category->getName() ?></td>
                    <td class="text-end">
                      <a href="<?= $router->generate('category-edit', ['categoryId' => $category->getId()])?>" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                      </a>
                      <!-- Example single danger button -->
                      <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Oui, je veux supprimer</a>
                          <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php if ($i == 3) break; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div class="d-grid gap-2">
              <a href="<?= $router->generate('category-list') ?>" class="btn btn-success">Voir plus</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="card text-white mb-3">
          <div class="card-header bg-primary">Liste des produits</div>
          <div class="card-body">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nom</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 0 ?>
                <?php foreach ($products as $product) : ?>
                  <?php $i++ ?>
                  <tr>
                    <th scope="row"> <?php echo $i ?></th>
                    <td><?= $product->getName() ?></td>
                    <td class="text-end">
                      <a href="<?= $router->generate('product-edit', ['productId' => $product->getId()])?>" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                      </a>
                      <!-- Example single danger button -->
                      <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Oui, je veux supprimer</a>
                          <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php if ($i == 3) break; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div class="d-grid gap-2">
              <a href="<?= $router->generate('product-list') ?>" class="btn btn-success">Voir plus</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>