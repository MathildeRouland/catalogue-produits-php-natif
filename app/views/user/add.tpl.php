


<div class="container my-4">
    <a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-end">Retour</a>
    <h2>Ajouter un utilisateur</h2>

<!-- Si la variable $errors existe on affiche les erreurs -->
<?php if (isset($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>
    <form action="<?= $router->generate('user-add') ?>" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="email" value="<?= $user->getEmail() ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="mot de passe" value="<?= $user->getPassword() ?>" aria-describedby="subtitleHelpBlock">
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" class="form-control" name="firstname" id="firstname" value="<?= $user->getFirstname() ?>" placeholder="prénom" aria-describedby="pictureHelpBlock">
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Nom</label>
            <input type="text" class="form-control" name="lastname" id="lastname" value="<?= $user->getLastname() ?>" placeholder="nom" aria-describedby="pictureHelpBlock">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Rôle</label>
            <select class="form-control" id="role" name="role" aria-describedby="statusHelpBlock">
            <option value="choisir"></option>
            <option value="1">catalog-manager</option>
            <option value="2">admin</option>
        </select>
        <small id="statusHelpBlock" class="form-text text-muted">
            Le rôle de l'utilisateur
        </small>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select class="form-control" id="status" name="status" aria-describedby="statusHelpBlock">
            <option value="0">-</option>
            <option value="1">actif</option>
            <option value="2">désactivé</option>
        </select>
        <small id="statusHelpBlock" class="form-text text-muted">
            Le statut de l'utilisateur
        </small>
        </div>
        

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
        <input type="hidden" name="tokenCSRF" value="<?= $_SESSION['tokenCSRF'] ?>">
    </form>
    