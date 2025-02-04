<?php //require "view_begin.php"; ?> 

<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"> <!-- Lien vers la feuille de style de boxicons -->
<link rel="stylesheet" href="Content/css/menu.css" /> <!-- Lien vers la feuille de style du menu -->

<!-- Sidebar -->
<div class="sidebar"> <!-- Début de la barre latérale -->
    <div class="logo-details"> <!-- Détails du logo -->
        <div class="logo_name"><nobr>Perform Vision</nobr></div> <!-- Nom du logo -->
        <i class='bx bx-menu' id="btn"></i> <!-- Icône de menu -->
    </div>
    <ul class="nav-list"> <!-- Liste de navigation -->

        <!-- Dashboard -->
        <li>
            <a <?php echo ($_GET['controller'] == 'dashboard') ? 'class="actu"' : ''; ?> href="?controller=dashboard">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>

        <!-- Formateurs -->
        <?php if ($role == 'Client') : ?> <!-- Vérifie le rôle de l'utilisateur -->
            <li>
                <a <?php echo ($_GET['controller'] == 'formateurs') ? 'class="actu"' : ''; ?> href="?controller=formateurs">
                    <i class='bx bx-folder'></i>
                    <span class="links_name">Formateurs</span>
                </a>
                <span class="tooltip">Formateurs</span>
            </li>
        <?php endif; ?>

        <!-- Discussions -->
        <li>
            <a <?php echo ($_GET['controller'] == 'discussion') ? 'class="actu"' : ''; ?> href="?controller=discussion">
                <i class='bx bx-chat'></i>
                <span class="links_name">Discussions</span>
            </a>
            <span class="tooltip">Discussions</span>
        </li>

        <!-- Mon Profil -->
        <li>
            <a <?php echo ($_GET['controller'] == 'profile') ? 'class="actu"' : ''; ?> href="?controller=profile">
                <i class='bx bx-user'></i>
                <span class="links_name">Profile</span>
            </a>
            <span class="tooltip">Profile</span>
        </li>

        <!-- Paramètre -->
        <!-- <li>
            <a <?php //echo ($_GET['controller'] == 'parametre') ? 'class="actu"' : ''; ?> href="?controller=parametre">
                <i class='bx bx-cog'></i>
                <span class="links_name">Paramètre</span>
            </a>
            <span class="tooltip">Paramètre</span>
        </li> -->

        <li class="profile"> <!-- Profil utilisateur -->
            <div class="profile-details"> <!-- Détails du profil -->
                <?php
                // Assuming $userDetails is an associative array containing user details
                echo '<img src="Content/img/' . $photo_de_profil . '" alt="profileImg">'; // Affiche l'image de profil
                echo '<div class="name_job">'; // Div pour le nom et le rôle
                echo '<div class="name">' . $prenom . '</div>'; // Affiche le prénom de l'utilisateur
                echo '<div class="job">' . $role . '</div>'; // Affiche le rôle de l'utilisateur
                echo '</div>';
                ?>
            </div>
            <i class='bx bx-log-out' id="log_out"></i> <!-- Icône de déconnexion -->
        </li>

    </ul>
</div> <!-- Fin de la barre latérale -->

<script src="Content/script/side.js"></script> <!-- Script pour la barre latérale -->

<?php //require "view_end.php"; ?> 
