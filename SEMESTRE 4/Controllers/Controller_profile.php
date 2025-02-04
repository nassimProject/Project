<?php

class Controller_profile extends Controller
{
    // Méthode par défaut, redirige vers action_profile
    public function action_default()
    {
        $this->action_profile();
    }

    // Affiche le profil de l'utilisateur
    public function action_profile()
    {
        // Vérifie l'accès de l'utilisateur
        $user = checkUserAccess();

        // Si l'utilisateur n'est pas autorisé, affiche un message et redirige vers la page d'authentification
        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }

        // Obtient le rôle de l'utilisateur
        $role = getUserRole($user);

        // Obtient les données du modèle
        $model = Model::getModel();

        // Prépare les données à afficher en fonction du rôle de l'utilisateur
        $data = [
            'mail' => $user['mail'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'photo_de_profil' => $user['photo_de_profil'],
            'role' => $role
        ];

        // Affiche le profil selon le rôle
        if ($role === 'Client') {
            $data['societe'] = $model->getClientById($user['id_utilisateur']);
            $this->render('monprofilclient', $data);
        } elseif ($role === 'Formateur') {
            $data['formateur'] = $model->getFormateurById($user['id_utilisateur']);
            $data['competences'] = $model->getCompetencesFormateurById($user['id_utilisateur']);
            $this->render('monprofilformateur', $data);
        } else {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }
    }

    // Affiche le formulaire de modification du profil
    public function action_modifier()
    {
        // Vérifie l'accès de l'utilisateur
        $user = checkUserAccess();

        // Si l'utilisateur n'est pas autorisé, affiche un message et redirige vers la page d'authentification
        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }

        // Obtient le rôle de l'utilisateur
        $role = getUserRole($user);

        // Obtient les données du modèle
        $model = Model::getModel();

        // Prépare les données à afficher en fonction du rôle de l'utilisateur
        $data = [
            'mail' => $user['mail'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'photo_de_profil' => $user['photo_de_profil'],
            'role' => $role
        ];

        // Affiche le formulaire de modification selon le rôle
        if ($role === 'Client') {
            $data['societe'] = $model->getClientById($user['id_utilisateur']);
            $this->render('modifiermonprofilClient', $data);
        } elseif ($role === 'Formateur') {
            $data['formateur'] = $model->getFormateurById($user['id_utilisateur']);
            $data['competences'] = $model->getCompetencesFormateurById($user['id_utilisateur']);
            $this->render('modifiermonprofilformateur', $data);
        } else {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }
    }

    // Modifie les informations du profil
    public function action_modifier_info()
    {
        // Si la requête n'est pas de type POST, redirige vers le profil
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controller=profile');
            exit();
        }

        // Vérifie l'accès de l'utilisateur
        $user = checkUserAccess();

        // Si l'utilisateur n'est pas autorisé, affiche un message et redirige vers la page d'authentification
        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }

        // Obtient le rôle de l'utilisateur
        $role = getUserRole($user);

        // Obtient les données du modèle
        $model = Model::getModel();

        // Modifie les informations du profil en fonction des données reçues en POST
        // Chaque champ est vérifié et mis à jour si nécessaire
        // Enfin, redirige vers le profil après la modification
        // Note: Les fonctions e() et trim() sont utilisées pour nettoyer les données

        header('Location: ?controller=profile');
        exit();
    }
}


}