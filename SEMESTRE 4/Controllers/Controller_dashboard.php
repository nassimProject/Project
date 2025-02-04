<?php

// Définition d'une classe Controller_dashboard
class Controller_dashboard extends Controller
{
    // Méthode pour l'action par défaut
    public function action_default()
    {
        // Appelle la méthode action_dashboard
        $this->action_dashboard();
    }

    // Méthode pour l'action dashboard
    public function action_dashboard()
    {

        // Vérifie si l'utilisateur a accès
        $user = checkUserAccess();

        // Si l'utilisateur n'est pas autorisé, affiche un message et redirige vers l'authentification
        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }

        // Récupère le rôle de l'utilisateur
        $role = getUserRole($user);

        // Récupère le modèle
        $model = Model::getModel();

        // Récupère les discussions de l'utilisateur
        $discussions = $model->recupererDiscussion($user['id_utilisateur']);

        // Initialise une liste vide de discussions
        $discussionList = [];

        // Parcourt chaque discussion
        foreach ($discussions as $discussion) {
            // Détermine l'identifiant de l'interlocuteur en fonction du rôle
            $interlocuteurId = ($role === 'Client') ? $discussion['id_utilisateur_1'] : $discussion['id_utilisateur'];

            // Récupère les informations de l'interlocuteur
            $interlocuteur = $model->getUserById($interlocuteurId);

            // Si l'interlocuteur n'existe pas, passe à la discussion suivante
            if (!$interlocuteur) {
                continue;
            }

            // Récupère les informations sur le dernier message de la discussion
            $lastMessage = $model->getLastMessageInfo($interlocuteurId, $discussion['id_discussion']);

            // Ajoute les informations de la discussion à la liste des discussions
            $discussionList[] = [
                'discussion_id' => $discussion['id_discussion'],
                'nom_interlocuteur' => $interlocuteur['nom'],
                'prenom_interlocuteur' => $interlocuteur['prenom'],
                'photo_interlocuteur' => $interlocuteur['photo_de_profil'],
                'lastMessage' => $lastMessage,
            ];
        }

        // Rend la vue du tableau de bord avec les données récupérées
        $this->render('dashboard', [
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'photo_de_profil' => $user['photo_de_profil'],
            'role' => $role,
            'discussions' => $discussionList
        ]);
    }
}
