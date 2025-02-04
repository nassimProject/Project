<?php

class Controller_discussion extends Controller
{
    // Méthode par défaut, redirige vers action_list()
    public function action_default()
    {
        $this->action_list();
    }

    // Affiche la liste des discussions
    public function action_list()
    {
        // Vérifie l'accès utilisateur
        $user = checkUserAccess();

        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }

        // Récupère le rôle de l'utilisateur
        $role = getUserRole($user);

        // Récupère les discussions de l'utilisateur
        $model = Model::getModel();
        $discussions = $model->recupererDiscussion($user['id_utilisateur']);

        $discussionList = [];

        // Boucle à travers les discussions pour les formater
        foreach ($discussions as $discussion) {
            // Détermine l'interlocuteur en fonction du rôle
            $interlocuteurId = ($role === 'Client') ? $discussion['id_utilisateur_1'] : $discussion['id_utilisateur'];
            $interlocuteur = $model->getUserById($interlocuteurId);

            // Ignore les interlocuteurs non valides
            if (!$interlocuteur) {
                continue;
            }

            // Compte les messages non lus dans la discussion
            $unreadMessages = $model->countUnreadMessages($interlocuteurId, $discussion['id_discussion']);

            // Ajoute la discussion formatée à la liste des discussions
            $discussionList[] = [
                'discussion_id' => $discussion['id_discussion'],
                'nom_interlocuteur' => $interlocuteur['nom'],
                'prenom_interlocuteur' => $interlocuteur['prenom'],
                'photo_interlocuteur' => $interlocuteur['photo_de_profil'],
                'unread_messages' => ($unreadMessages > 0),
            ];
        }

        // Prépare les données pour le rendu de la vue
        $data = [
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'photo_de_profil' => $user['photo_de_profil'],
            'role' => $role,
            'discussions' => $discussionList
        ];

        // Rend la vue de la liste des discussions
        $this->render('discussion_list', $data);
    }

    // Affiche une discussion spécifique
    public function action_discussion()
    {
        // Vérifie l'accès utilisateur
        $user = checkUserAccess();

        // Vérifie si l'utilisateur est autorisé
        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }

        // Récupère le modèle
        $model = Model::getModel();

        // Récupère l'identifiant de la discussion depuis la requête
        $discussionId = isset($_GET['id']) ? e($_GET['id']) : null;

        // Redirige si aucun identifiant de discussion n'est fourni
        if (!$discussionId) {
            header('Location: ?controller=discussion');
            exit();
        }

        // Vérifie les autorisations de l'utilisateur dans la discussion
        $isModo = $model->verifModerateur($user['id_utilisateur']);
        $discussion = $model->getDiscussionById($discussionId);

        // Redirige si l'utilisateur n'est pas autorisé
        if (!$discussion || !($isModo || isUserInDiscussion($user['id_utilisateur'], $discussion))) {
            header('Location: ?controller=discussion');
            exit();
        }

        // Récupère les détails de l'interlocuteur
        $role = getUserRole($user);
        $receiverId = ($role === 'Client') ? $discussion['id_utilisateur_1'] : $discussion['id_utilisateur'];
        $receiver = $model->getUserById($receiverId);

        // Redirige si l'interlocuteur n'est pas valide
        if (!$receiver) {
            header('Location: ?controller=discussion');
            exit();
        }

        // Récupère les messages de la discussion
        $messages = $model->messagesDiscussion($discussionId);

        // Prépare les données pour le rendu de la vue
        $data = [
            'nom_receiver' => $receiver['nom'],
            'prenom_receiver' => $receiver['prenom'],
            'photo_receiver' => $receiver['photo_de_profil'],
            'messages' => $messages,
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'photo_de_profil' => $user['photo_de_profil'],
            'role' => $role,
            'user_id' => $user['id_utilisateur'],
            'isModo' => $isModo
        ];

        // Rend la vue de la discussion
        $this->render('discussion', $data);
    }

    // Envoie un message dans une discussion
    public function action_envoi_message()
    {
        // Vérifie si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controller=discussion');
            exit();
        }

        // Vérifie l'accès utilisateur
        $user = checkUserAccess();

        // Redirige si l'accès est refusé
        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }

        // Récupère le modèle
        $model = Model::getModel();

        // Récupère l'identifiant de la discussion depuis la requête
        $discussionId = isset($_POST['discussionId']) ? e($_POST['discussionId']) : null;

        // Redirige si aucun identifiant de discussion n'est fourni
        if (!$discussionId) {
            header('Location: ?controller=discussion');
            exit();
        }

        // Récupère les détails de la discussion
        $discussion = $model->getDiscussionById($discussionId);

        // Redirige si la discussion n'est pas valide ou si l'utilisateur n'y participe pas
        if (!$discussion || !isUserInDiscussion($user['id_utilisateur'], $discussion)) {
            header('Location: ?controller=discussion');
            exit();
        }

        // Récupère le texte du message depuis la requête
        $texteMessage = isset($_POST['texte_message']) ? e($_POST['texte_message']) : '';

        // Vérifie les privilèges de l'utilisateur
        $isAdmin = $model->verifAdmin($user['id_utilisateur']);
        $isModo = $model->verifModerateur($user['id_utilisateur']);
        $isAffranchi = $model->verifAffranchiModerateur($user['id_utilisateur']);

        // Détermine si le message doit être validé par la modération
        $validation_moderation = ($isAdmin || $isModo || $isAffranchi);

        // Ajoute le message à la discussion
        $result = $model->addMessageToDiscussion($texteMessage, $discussion['id_utilisateur'], $discussion['id_utilisateur_1'], $discussionId, $validation_moderation, $user['id_utilisateur']);

        // Redirige vers la discussion après l'envoi du message
        header('Location: ?controller=discussion&action=discussion&id=' . $discussionId);
        exit();
    }

    // Démarre une nouvelle discussion
    public function action_start_discussion()
    {

        // Vérifie si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?controller=discussion');
            exit();
        }

        // Vérifie l'accès utilisateur
        $user = checkUserAccess();

        // Redirige si l'accès est refusé
        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }

        // Récupère le modèle
        $model = Model::getModel();

        // Récupère l'identifiant du client et du formateur depuis la requête
        $id_client = $user['id_utilisateur'];
        $id_formateur = isset($_POST['id_formateur']) ? e($_POST['id_formateur']) : null;

        // Redirige si l'identifiant du formateur n'est pas fourni
        if (!$id_formateur) {
            header('Location: ?controller=discussion');
            exit();
        }

        // Démarre une nouvelle discussion et récupère son identifiant
        $discussion_id = $model->startDiscussion($id_client, $id_formateur);

        // Redirige vers la discussion nouvellement créée
        if (!$discussion_id) {
            header('Location: ?controller=discussion');
            exit();
        }

        header('Location: ?controller=discussion&action=discussion&id=' . $discussion_id);
        exit();
    }

    // Valide un message par la modération
    public function action_validate_message()
    {
        // Vérifie l'accès utilisateur
        $user = checkUserAccess();

        // Redirige si l'accès est refusé
        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }

        // Récupère le modèle
        $model = Model::getModel();

        // Vérifie si l'utilisateur est modérateur
        $isModo = $model->verifModerateur($user['id_utilisateur']);
        if (!$isModo) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }

        // Récupère l'identifiant du message à valider depuis la requête GET
        $id_message = isset($_GET['id_message']) ? e($_GET['id_message']) : null;

        // Redirige si aucun identifiant de message n'est fourni
        if (!$id_message) {
            // Redirige ou affiche un message d'erreur si l'id du message n'est pas fourni
            header('Location: ?controller=discussion');
            exit();
        }

        // Valide le message et récupère l'identifiant de la discussion
        $discussion_id = $model->validateMessage($id_message);

        // Redirige après la validation du message
        if (!$discussion_id) {
            echo "Erreur lors de la validation du message.";
            exit();
        }

        // Redirige vers la discussion
        header('Location: ?controller=discussion&action=discussion&id=' . $discussion_id);
        exit();
    }
}
