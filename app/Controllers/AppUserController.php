<?php

namespace App\Controllers;
use App\Models\AppUser;

class AppUserController extends CoreController
{
    public function list()
    {

        // // Seuls les utilisateurs qui ont le rôle admin peuvent aller sur cette page
        // $this->checkAuthorization(['admin']);

        $users = AppUser::findAll();
        $dataToSend['users'] = $users;
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller

        // Affichage du template (vue) list.tpl.php qui se trouve dans le dossier category
        $this->show('user/list', $dataToSend);

    }

    public function add()
    {
        // // Seuls les utilisateurs qui ont le rôle admin peuvent aller sur cette page
        // $this->checkAuthorization(['admin']);
        // La ligne new AppUser permet de créer une variable $user dans le template car elle est utilisée lors de la validation du formulaire
        $this->show('user/add', [
            'user' => new AppUser()    // On ajoute cette ligne pour gérer les erreurs et avoir une catégorie vide par défaut
        ]);
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('user/add');
    }

    public function create()
    {
        // // Seuls les utilisateurs qui ont le rôle admin peuvent aller sur cette page
        // $this->checkAuthorization(['admin']);
        // 1. Récupération des données du formulaire
        $email = htmlspecialchars(filter_input(INPUT_POST, 'email'));
        $password = htmlspecialchars(filter_input(INPUT_POST, 'password'));
        $firstName = htmlspecialchars(filter_input(INPUT_POST, 'firstname'));
        $lastName = htmlspecialchars(filter_input(INPUT_POST, 'lastname'));
        $role = htmlspecialchars(filter_input(INPUT_POST, 'role'));
        $status = htmlspecialchars(filter_input(INPUT_POST, 'status'));

        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        /* Validation des données
        * 1. Champs bien remplis
        * 2. Format de l'email
        * 3. Longueur du mot de passe et complexité
        * 4. Rôle et statut existant
        * 5. Vérifier que l'email n'existe pas encore dans la base de données (est unique)
        */

        $formErrors = [];

        // Vérification des champs vides
        if (empty($email) || empty($password)) {
            $formErrors[] = "Les champs email et mot de passe ne doivent pas être vides";
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $formErrors[] = "L'email doit avoir le bon format";
        }
        if (strlen($password) < 8) {
            $formErrors[] = "Le mot de passe doit contenir au-moins 8 caractères";
        }
        /** 
         * Complexité du mot de passe :
         * Mettre en place une expression régulière (regex)
         * Utiliser la fonction preg_match pour vérifier que le format correspond à ce qui est attendu
         * Voir vidéo dans Ressources sur Slack
         */

         $regex = "/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}/";
        
        // Est-ce que le mot de passe correspond au format demandé ?
        if (! preg_match($regex, $password)) {
            // Si le mot de passe ne correspond pas
            $formErrors[] = "Le mot de passe doit contenir une majuscule, un caractère spécial et 8 caractères";
        }
        // Vérifier que l'email n'existe pas déjà dans la base de données ?
        // => On récupère l'utilisateur correspondant dans la base de données
        // S'il existe alors l'email est déjà pris
        $user = AppUser::findByEmail($email);

        // Si l'utilisateur n'est pas vide (s'il existe un utilisateur)
        // alors l'email est déjà pris
        if (! empty($user)) {
            $formErrors[] = "L'email est déjà utilisé";
        }

        if (! empty($formErrors)) {
            $this->show('user/add', [
                'errors' => $formErrors
            ]);

             // On arrête le script car il y a des erreurs et on continue pas par l'enregistrement
             exit();
        }

        // Création de l'utilisateur
        $user = new AppUser();
        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setRole($role);
        $user->setStatus($status);
        $user->save();
        
        // Redirection
        header('Location: /user/list');
        exit();
    }

    public function login()
    {
        $this->show('user/login');
    }

    public function authenticate()
    {

    //on appelle la méthode findByEmail pour récupérer les données user en fonction de la variable email
    $user = AppUser::findByEmail(filter_input(INPUT_POST, 'email'));
    $dataToSend['user'] = $user;

    // on récupère la liste des utilisateurs
    // $users = AppUser::findAll();
    // $dataToSend['users'] = $users;
    $this->show('/user/login', $dataToSend);

    if (empty($user)) {
        // L'utilisateur est vide (false) => l'utilisateur tapé n'existe pas
        echo "Cet utilisateur n'existe pas";
    } else {
        // L'utilisateur existe bien => on vérifie si le mot de passe est bon

        // Récupération du mot de passe soumis dans le formulaire
        $password = filter_input(INPUT_POST, 'password');

        // Si le mot de passe tapé dans le formulaire ($password) et 
        // le mot de passe en base de données ($user->getPassword())
        // ne correspondent pas on affiche une erreur
        // Il faut utiliser password_verify pour vérifier la correspondance (et pas une simple égalité)
        if (! password_verify($password, $user->getPassword())) {
            echo "Le mot de passe est faux";
        } else {
            // Identifiants corrects => on connecte l'utilisateur
            // Stockage des informations dans la session
            $_SESSION['userId'] = $user->getId();
            $_SESSION['appUser'] = $user;

            // Rediriger vers la page d'accueil
            header('Location: /');
            exit();
        }
    }
}

    public function logout()
    {
        // Déconnexion de l'utilisateur => on supprime les clés userId et appUser de $_SESSION
        unset($_SESSION['userId']);
        unset($_SESSION['appUser']);

        // Rediriger vers la page d'accueil
        header('Location: /');
        exit();
        }
        
}
