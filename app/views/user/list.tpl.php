<div class="container my-4">
    <a href="<?= $router->generate('user-add') ?>" class="btn btn-success float-end">Ajouter</a>
    <h2>Liste des Utilisateurs</h2>
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
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Email</th>
                <th scope="col">Prénom</th>
                <th scope="col">Nom</th>
                <th scope="col">Rôle</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
                <?php foreach ($users as $user) : ?>
                
                <tr>
                    <th scope="row"> <?= $user->getId() ?> </th>
                    <td><?= $user->getEmail() ?> </td>
                    <td><?= $user->getFirstName() ?> </td>
                    <td><?= $user->getLastName() ?> </td>
                    <td><?= $user->getRole() ?> </td>
                    <td><?= $user->getStatus() == 1 ? "Actif" : "Désactivé/Bloqué" ?></td>
                    <td><?= $user->getCreatedAt() ?> </td>
                    <td><?= $user->getUpdatedAt() ?> </td>
                    <td class="text-end">
                        <!--a href="?= $router->generate('user-edit', ['userId' => $user->getId()])?!" class="btn btn-sm btn-warning">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                        <!-- Example single danger button -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Oui, je veux supprimer</a>
                                <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>