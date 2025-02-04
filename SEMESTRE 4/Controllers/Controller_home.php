<?php

class Controller_home extends Controller
{
    // Cette fonction est exécutée par défaut lorsque la classe Controller_home est appelée
    public function action_default()
    {
        // Redirige vers la fonction action_home
        $this->action_home();
    }

    // Cette fonction est responsable de la gestion de la page d'accueil
    public function action_home()
    {

        // Obtient une instance du modèle
        $model = Model::getModel();

        // Récupère la liste des activités depuis le modèle
        $data = [
            'activites' => $model->getActivitiesList()
        ];

        // Affiche la vue 'home' avec les données récupérées
        $this->render('home', $data);
    }

    // Cette fonction est responsable de la gestion d'une activité spécifique
    public function action_activite()
    {

        // Obtient une instance du modèle
        $model = Model::getModel();

        // Récupère l'identifiant de l'activité depuis les paramètres GET
        $id_activite = isset($_GET['id']) ? e($_GET['id']) : null;

        // Si aucun identifiant n'est spécifié, affiche la liste des activités
        if (!$id_activite) {
            $data = [
                'activites' => $model->getActivitiesList()
            ];
            $this->render('home', $data);
            return;
        }

        // Récupère les détails de l'activité spécifiée par son identifiant
        $data = [
            'activite' => $model->getActivityById($id_activite)
        ];

        // Affiche la vue 'activite' avec les détails de l'activité spécifiée
        $this->render('activite', $data);
    }
}
