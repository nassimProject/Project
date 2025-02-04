<?php

class Controller_auth extends Controller
{
    // Page d'authentification
    public function action_auth()
    {
        $this->render("auth", []); // Afficher la page d'authentification
    }

    // Page par défaut, redirige vers l'authentification
    public function action_default()
    {
        $this->action_auth(); // Rediriger vers la page d'authentification
    }

    // Processus de connexion
    public function action_login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Si la requête est de type POST

            // Vérification des champs email et mot de passe
            if (isset($_POST['email'], $_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                $email = e(trim($_POST['email'])); // Récupérer et nettoyer l'email
                $password = e(trim($_POST['password'])); // Récupérer et nettoyer le mot de passe

                // Vérification des longueurs des données
                if (strlen($password) <= 256 && strlen($email) <= 128) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Vérifier le format de l'email

                        // Récupérer l'utilisateur en fonction des identifiants
                        $user = Model::getModel()->getUserByCredentials($email, $password);

                        if ($user) { // Si l'utilisateur existe

                            // Création d'une session pour l'utilisateur
                            session_start();
                            $_SESSION['user_id'] = $user['id_utilisateur'];
                            $_SESSION['user_token'] = $user['token'];
                            $_SESSION['expire_time'] = time() + (30 * 60); // 30 minutes d'expiration

                            // Redirection vers le tableau de bord après la connexion
                            header("Location: ?controller=dashboard");
                            exit();
                        } else {
                            echo "Identifiants incorrects."; // Identifiants incorrects
                        }
                    } else {
                        echo "Format d'e-mail invalide."; // Format d'email invalide
                    }
                } else {
                    echo "Les données saisies dépassent les limites autorisées."; // Données trop longues
                }
            } else {
                echo "Veuillez remplir tous les champs requis."; // Champs requis manquants
            }
        } else {
            echo "Accès non autorisé."; // Accès non autorisé
        }

        $this->render("auth", []); // Afficher la page d'authentification
    }

    // Processus d'inscription
    public function action_register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Si la requête est de type POST

            // Vérification des champs requis
            if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['password'], $_POST['tabs']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                $nom = e(trim($_POST['nom'])); // Récupérer et nettoyer le nom
                $prenom = e(trim($_POST['prenom'])); // Récupérer et nettoyer le prénom
                $email = e(trim($_POST['email'])); // Récupérer et nettoyer l'email
                $password = e(trim($_POST['password'])); // Récupérer et nettoyer le mot de passe

                // Vérification des longueurs des données
                if (strlen($nom) <= 64 && strlen($prenom) <= 64 && strlen($password) <= 256 && strlen($email) <= 128) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Vérifier le format de l'email

                        // Vérifier si le nom et le prénom ne contiennent que des lettres et des tirets
                        if (preg_match('/^[a-zA-Z\-]+$/', $nom) && preg_match('/^[a-zA-Z\-]+$/', $prenom)) {

                            // Récupérer le rôle de l'utilisateur
                            $role = isset($_POST['tabs']) ? ($_POST['tabs'] === 'client' ? 'client' : ($_POST['tabs'] === 'formateur' ? 'formateur' : '')) : '';

                            if ($role !== '') { // Si le rôle est valide

                                // Création de l'utilisateur
                                $result = Model::getModel()->creationUtilisateur($nom, $prenom, $password, $email, $role);

                                if ($result) {
                                    echo "Inscription réussie!<br>"; // Inscription réussie
                                    $verificationToken = Model::getModel()->getTokenUtilisateur($email);
                                    $verificationLink = 'http://localhost/perform_vision/?controller=auth&action=valide_email'. '&token=' . urlencode($verificationToken);

                                    // Envoi d'un e-mail de vérification
                                    EmailSender::sendVerificationEmail($email, 'Vérification de l\'adresse e-mail', 'Cliquez sur le lien suivant pour vérifier votre adresse e-mail: ' . $verificationLink);
                                    
                                    echo "<br> Un e-mail de vérification a été envoyé à votre adresse. <br>";

                                } else {
                                    echo "Erreur lors de l'inscription."; // Erreur lors de l'inscription
                                }
                            } else {
                                echo "Rôle invalide."; // Rôle invalide
                            }
                        } else {
                            echo "Le nom et le prénom ne doivent contenir que des lettres et des tirets."; // Format du nom et du prénom incorrect
                        }
                    } else {
                        echo "Format d'email invalide."; // Format d'email invalide
                    }
                } else {
                    echo "Les données saisies dépassent les limites autorisées."; // Données trop longues
                }
            } else {
                echo "Veuillez remplir tous les champs requis."; // Champs requis manquants
            }
        } else {
            echo "Accès non autorisé."; // Accès non autorisé
        }

        $this->render("auth", []); // Afficher la page d'authentification
    }

    // Validation de l'adresse e-mail
    public function action_valide_email()
    {
        // Récupérer le token depuis les paramètres de l'URL
        $token = isset($_GET['token']) ? $_GET['token'] : '';
    
        // Valider le token en appelant une fonction du modèle
        $validationResult = Model::getModel()->validerTokenUtilisateur($token);
    
        if ($validationResult) {
            echo "Adresse e-mail vérifiée avec succès!"; // Adresse e-mail vérifiée avec succès
        } else {
            echo "Erreur lors de la vérification de l'adresse e-mail. Le lien peut avoir expiré ou être invalide."; // Erreur lors de la vérification de l'adresse e-mail
        }
    
       
