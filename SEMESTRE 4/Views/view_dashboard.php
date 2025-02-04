<?php require "view_begin.php"; ?>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet" /> 
<link rel="stylesheet" href="Content/css/dashboard.css" /> 

<div class="container"> 
  <!-- Colonne de gauche pour le menu -->
  <aside class="left-column"> 
    <div class="top"> 
      <div class="close" id="close-btn"> 
        <span class="material-icons-sharp">close</span> 
      </div>
    </div>

    <?php require "view_menu.php"; ?> 

  </aside>
  <!-- Fin de la colonne de gauche -->

  <main> 
    <h1>Mes Formations</h1> 
    <div class="insights"> 
	
	  <!-- Schéma de Progression 1-->
      <div class="sales">
        <span class="material-icons-sharp">stacked_line_chart</span> <!-- Icône -->
        <div class="middle"> 
          <div class="left"> 
            <h3>En Cours</h3> <!-- Sous-titre -->
            <h1>2</h1> <!-- Nombre de formations en cours -->
          </div>
          <div class="progress"> <!-- Section de la barre de progression -->
            <svg>
              <circle cx="38" cy="38" r="36"></circle> <!-- LE Cercle SVG -->
            </svg>
            <div class="number">
              <p>81%</p> <!-- Pourcentage de progression -->
            </div>
          </div>
        </div>
        <small class="text-muted">Dernier Mois</small> 
      </div>
      <!-- Fin du schéma de progression 1-->
	  
	  <!-- Schéma de Progression 2-->
      <div class="expenses"> 
        <span class="material-icons-sharp">bar_chart</span> <!-- Icône -->
        <div class="middle"> 
          <div class="left"> 
            <h3>Formations Fini</h3> <!-- Sous-titre -->
            <h1>4</h1> <!-- Nombre de formations terminées -->
          </div>
          <div class="progress"> <!-- Section de la barre de progression -->
            <svg>
              <circle cx="38" cy="38" r="36"></circle> <!-- LE Cercle SVG -->
            </svg>
            <div class="number">
              <p>62%</p> <!-- Pourcentage de progression -->
            </div>
          </div>
        </div>
        <small class="text-muted">Dernier Mois</small> 
      </div>
      <!-- Fin du schéma de progression 2-->

	  <!-- Schéma de Progression 3-->
      <div class="income"> 
        <span class="material-icons-sharp">account_circle</span> <!-- Icône -->
        <div class="middle">
          <div class="left">
            <h3>Mon Profil</h3>
            <a href="?controller=profile"><button class="button4">Accéder à mon profil</button></a> <!-- Bouton d'accès au profil -->
          </div>
          <div class="progress"> <!-- Section de la barre de progression -->
            <svg>
              <circle cx="38" cy="38" r="36"></circle> <!-- Cercle SVG -->
            </svg>
            <div class="number">
              <p>44%</p> <!-- Pourcentage de progression -->
            </div>
          </div>
        </div>
      </div>
      <!-- Fin du schéma de progression 3-->
	  
    </div>

	<!-- Section des orders récentes -->
    <div class="recent-orders"> 
      <h2>Mes orders</h2> 
      <table> <!-- Tableau des orders -->
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Dernier message</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $order): ?> <!-- Boucle pour chaque order -->
            <tr>
              <td><?= htmlspecialchars($order['nom_interlocuteur']) ?></td> <!-- Nom de l'interlocuteur -->
              <td><?= htmlspecialchars($order['prenom_interlocuteur']) ?></td> <!-- Prénom de l'interlocuteur -->
              <?php if ($order['lastMessage']): ?> <!-- Si dernier message existe -->
                <td><?= htmlspecialchars($order['lastMessage']['date_heure']) ?></td> <!-- Date et heure du dernier message -->
                <td><?= ($order['lastMessage']['lu']) ? 'Lu' : 'Pas Lu' ?></td> <!-- Statut du message -->
              <?php else: ?>
                <td colspan="2">Aucun dernier message disponible</td> <!-- Message si pas de dernier message -->
              <?php endif; ?>
              <td>
                <a href="?controller=order&action=order&id=<?= $order['order_id'] ?>">
                  <button class="butto"><span>Voir orders</span></button> <!-- Bouton pour voir la order -->
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
	  <!-- Fin de la section des orders récentes -->
	  
      <a href="#">Show All</a> <!-- Lien pour afficher toutes les orders -->
    </div>

  </main>

  <div class="right"> <!-- Colonne de droite -->
    <div class="top">
      <button id="menu-btn">
        <span class="material-icons-sharp">menu</span> <!-- Icône du menu -->
      </button>
      <div class="theme-toggler">
        <span class="material-icons-sharp active">light_mode</span> <!-- Icône mode clair -->
        <span class="material-icons-sharp">dark_mode</span> <!-- Icône mode sombre -->
      </div>
      <div class="profile"> 
        <div class="info"> <!-- Informations du profil -->
          <p>Salut, <b><?= $prenom ?></b></p> <!-- Message de salutation -->
          <small class="text-muted"><?= $role ?></small> <!-- Rôle de l'utilisateur -->
        </div>
        <div class="profile-photo"> 
          <img src="Content/img/<?= $photo_de_profil ?>" /> <!-- Photo de profil -->
        </div>
      </div>
    </div>
  </div>
</div>

<script src="Content/script/dashboard.js"></script> <!-- Lien vers le script JavaScript pour le tableau de bord -->

<?php require "view_end.php"; ?> 
