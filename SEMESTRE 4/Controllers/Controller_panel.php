<?php

class Controller_panel extends Controller
{
    // Cette fonction est appelée par défaut lors de l'accès au panneau
    public function action_default()
    {
        $this->action_panel();
    }

    // Action principale du panneau
    public function action_panel()
    {
        // Vérifie si l'utilisateur a accès
        $user = checkUserAccess();

        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
            return;
        }

        // Obtient le rôle de l'utilisateur
        $role = getUserRole($user);

        // Obtient le modèle
        $model = Model::getModel();

        // Vérifie si l'utilisateur est un administrateur ou un modérateur
        $isAdmin = $model->verifAdmin($user['id_utilisateur']);
        $isModo = $model->verifModerateur($user['id_utilisateur']);

        // Prépare les données à passer à la vue
        $data = [
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'photo_de_profil' => $user['photo_de_profil'],
            'role' => $role
        ];

        // Si l'utilisateur n'est ni admin ni modo, affiche un message d'erreur
        if (!$isAdmin && !$isModo) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
            return;
        } elseif ($isModo) {
            // Si l'utilisateur est un modérateur, récupère les discussions et les utilisateurs non affranchis
            $data['discussions'] = $model->recupererToutesDiscussions();
            $data['utilisateurs'] = $model->recupererUtilisateursNonAffranchis();
            $this->render('panel_moderateur', $data);
        } else {
            // Si l'utilisateur est un admin, récupère les formateurs avec leur statut de modérateur
            $data['formateurs'] = $model->listeFormateursAvecStatutModerateur();
            $this->render('panel_administrateur', $data);
        }
    }

    // Gère les actions de gestion des modérateurs
    public function action_manage_moderator()
    {

        // Vérifie la méthode de la requête
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            header('Location: ?controller=panel');
            exit();
        }

        // Vérifie l'accès de l'utilisateur
        $user = checkUserAccess();

        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
            return;
        }

        // Obtient le rôle de l'utilisateur
        $role = getUserRole($user);

        // Obtient le modèle
        $model = Model::getModel();

        // Obtient l'identifiant du formateur à gérer
        $formateurId = isset($_GET['id']) ? e($_GET['id']) : null;
        if (!$formateurId) {
            header('Location: ?controller=panel');
            exit();
        }

        // Vérifie si l'utilisateur est un administrateur
        $isAdmin = $model->verifAdmin($user['id_utilisateur']);

        if (!$isAdmin) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
            return;
        }

        // Gère les actions de promotion ou de rétrogradation des modérateurs
        $manage = isset($_GET['manage']) ? strtolower(trim(e($_GET['manage']))) : '';

        if ($manage === 'promote') {
            $model->addModerator($user['id_utilisateur'], $formateurId);
        } elseif ($manage === 'demote') {
            $model->removeModerator($formateurId);
        } else {
            echo "Accès non autorisé.";
            $this->render('auth', []);
            return;
        }

        header('Location: ?controller=panel');
        exit();
    }

    // Ajoute une activité au panneau
    public function action_add_activity()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controller=discussion');
            exit();
        }

        // Vérifie l'accès de l'utilisateur
        $user = checkUserAccess();

        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
            return;
        }

        // Obtient le rôle de l'utilisateur
        $role = getUserRole($user);

        // Obtient le modèle
        $model = Model::getModel();

        // Vérifie si l'utilisateur est un administrateur
        $isAdmin = $model->verifAdmin($user['id_utilisateur']);

        if (!$isAdmin) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
            return;
        }

        // Récupère les données de la requête POST
        $nom_activite = isset($_POST['name']) ? e($_POST['name']) : null;
        $description = isset($_POST['description']) ? e($_POST['description']) : null;

        // Gère le téléchargement d'image
        $image = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'Content/data/';
            $uploadPath = $uploadDir . basename($_FILES['photo']['name']);

            // Assure l'existence du répertoire de téléchargement
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Déplace le fichier téléchargé vers le répertoire spécifié
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
                $image = $_FILES['photo']['name'];
            } else {
                // Gère les erreurs de téléchargement si nécessaire
                echo "Échec du téléchargement de l'image.";
                exit();
            }
        }

        // Appelle la méthode addActivity avec les données récupérées
        $model->addActivity($nom_activite, $image, $description, $user['id_utilisateur']);

        header('Location: ?controller=panel');
        exit();
    }

    // Ajoute un utilisateur affranchi
    public function action_add_affranchi()
    {

        // Vérifie la méthode de la requête
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            header('Location: ?controller=panel');
            exit();
        }

        // Vérifie l'accès de l'utilisateur
        $user = checkUserAccess();

        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
            return;
        }

        // Obtient le rôle de l'utilisateur
        $role = getUserRole($user);

        // Obtient le modèle
        $model = Model::getModel();

        // Obtient l'identifiant de l'utilisateur à affranchir
        $userId = isset($_GET['id']) ? e($_GET['id']) : null;
        if (!$userId) {
            header('Location: ?controller=panel');
            exit();
        }

        // Vérifie si l'utilisateur est un modérateur
        $isModo = $model->verifModerateur($user['id_utilisateur']);

        if (!$isModo) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
            return;
        }

        // Affranchit l'utilisateur
        $model->affranchirUtilisateur($user['id_utilisateur'], $userId);

        header('Location: ?controller=panel');
        exit();
    }
}
