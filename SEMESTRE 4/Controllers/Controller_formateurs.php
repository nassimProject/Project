<?php

class Controller_formateurs extends Controller
{
    // Cette fonction est exécutée par défaut quand aucune action spécifique n'est spécifiée
    public function action_default()
    {
        // Redirige vers la fonction action_formateurs
        $this->action_formateurs();
    }

    // Cette fonction affiche la liste des formateurs
    public function action_formateurs()
    {
        // Vérifie l'accès de l'utilisateur
        $user = checkUserAccess();

        // Si l'utilisateur n'est pas autorisé, affiche un message et redirige vers la page d'authentification
        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }

        // Récupère le rôle de l'utilisateur
        $role = getUserRole($user);

        // Initialise la page à afficher
        $page = 1;

        // Récupère le numéro de page à partir de la requête GET, s'il existe
        if (isset($_GET["page"]) and preg_match("/^\d+$/", $_GET["page"]) and $_GET["page"] > 0) {
            $page = e($_GET["page"]);
        }

        // Récupère les critères de recherche
        $search = isset($_POST['search']) ? trim(e($_POST['search'])) : '';

        // Récupère l'instance du modèle
        $model = Model::getModel();

        // Récupère l'ID de la catégorie sélectionnée
        $categorieId = isset($_POST['select-options']) ? $_POST['select-options'] : null;

        // Récupère les thèmes sélectionnés
        $themes = isset($_POST['selected-themes']) ? $_POST['selected-themes'] : null;

        // Initialise les variables pour l'ID de thème et de catégorie
        $themeId = null;

        // Récupère les informations sur les formateurs en fonction de la page, de la catégorie et des thèmes sélectionnés
        $formateurs = $model->getFormateursBasicInfoByPageAndCategoryOrTheme3($page, $categorieId, $themes);

        // Récupère le nombre de formateurs en fonction des thèmes ou de la catégorie sélectionnés
        $nbFormateurs = $model->getNbFormateurByThemeOrCategorie3($themes, $categorieId);

        // Récupère le nombre total de pages pour la pagination
        $nb_total_pages = $model->getFormateurPagesByCategoryOrTheme3($categorieId, $themeId);

        // Ajoute des informations supplémentaires (catégorie, thèmes, commentaire d'expertise) à chaque formateur
        if ($formateurs !== null) {
            foreach ($formateurs as &$formateur) {
                $userCategoryAndThemes = $model->getUserCategoryAndThemes($formateur['id_utilisateur'], $categorieId);
                if ($userCategoryAndThemes !== null) {
                    $formateur['category_name'] = $userCategoryAndThemes['nom_categorie'];
                    $formateur['theme_names'] = $userCategoryAndThemes['theme_names'];
                    $formateur['expertise_comment'] = $userCategoryAndThemes['expertise_comment'];
                } else {
                    $formateur['category_name'] = 'N/A';
                    $formateur['theme_names'] = [];
                    $formateur['expertise_comment'] = [];
                }
            }
        }

        // Détermine le début et la fin des numéros de page à afficher pour la pagination
        $debut = $page - 5;
        if ($debut <= 0) {
            $debut = 1;
        }

        $fin = $debut + 9;
        if ($fin > $nb_total_pages) {
            $fin = $nb_total_pages;
        }

        // Prépare les données à passer à la vue
        $data = [
            'selectedThemes' => $themes,
            'selectedCategoryId' => $categorieId,
            'categories' => $model->getAllCategories(),
            'themes' => $model->getThemesByCategoryId($categorieId),
            'formateurs' => $formateurs,
            'active' => $page,
            'debut' => $debut,
            'fin' => $fin,
            'nb_total_pages' => $nb_total_pages,
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'photo_de_profil' => $user['photo_de_profil'],
            'role' => $role
        ];

        // Affiche la vue des formateurs avec les données
        $this->render('formateurs', $data);
    }

    // Cette fonction affiche les détails d'un formateur spécifique
    public function action_details()
    {

        // Vérifie l'accès de l'utilisateur
        $user = checkUserAccess();

        // Si l'utilisateur n'est pas autorisé, affiche un message et redirige vers la page d'authentification
        if (!$user) {
            echo "Accès non autorisé.";
            $this->render('auth', []);
        }

        // Récupère le rôle de l'utilisateur
        $role = getUserRole($user);

        // Récupère l'instance du modèle
        $modele = Model::getModel();

        // Récupère l'ID du formateur à afficher
        $id_formateur = isset($_GET['id']) ? e($_GET['id']) : null;

        // Récupère les informations du formateur
        $formateur = $modele->getUserById($id_formateur);

        // Récupère les niveaux de compétence du formateur
        $niveaux = $modele->getLevelDataById($id_formateur);

        // Récupère l'expérience pédagogique du formateur
        $pedagogicalExperience = $modele->getPedagogicalExperienceDataById($id_formateur);

        // Récupère les catégories associées au formateur
        $categories = $modele->getCategorieDataById($id_formateur);

        // Récupère les thèmes associés au formateur
        $themes = $modele->getThemeDataById($id_formateur);

        // Récupère les expertises du formateur
        $expertises = $modele->getExpertiseDataById($id_formateur);

        // Affiche la vue des détails du formateur avec les données
        $this->render('formateurs_details', [
            'formateur' => $formateur,
            'niveaux' => $niveaux,
            'pedagogicalExperience' => $pedagogicalExperience,
            'categories' => $categories,
            'themes' => $themes,
            'expertises' => $expertises,
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'photo_de_profil' => $user['photo_de_profil'],
            'role' => $role
        ]);
    }
}
