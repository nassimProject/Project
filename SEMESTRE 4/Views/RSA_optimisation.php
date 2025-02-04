<?php

// Fonction modPow originale
function modPowOriginal($base, $exposant, $modulo) {
    // Initialisation des variables en utilisant GMP (bignum)
    $base = gmp_init($base);
    $exposant = gmp_init($exposant);
    $modulo = gmp_init($modulo);

    $resultatFinal = gmp_init(1);

    // Boucle qui sert a faire l'exponentiation
    while (gmp_cmp($exposant, 0) > 0) {
        // Si l'exposant est impair, multiplier le résultat final par la base et prendre le modulo
        if (gmp_cmp(gmp_mod($exposant, 2), 1) == 0) {
            $resultatFinal = gmp_mod(gmp_mul($resultatFinal, $base), $modulo);
        }
        // Carré de la base et réduction modulo
        $base = gmp_mod(gmp_mul($base, $base), $modulo);
        // Division entière de l'exposant par 2
        $exposant = gmp_div($exposant, 2);
    }

    return gmp_strval($resultatFinal); // Retourne le résultat sous forme de chaîne de caractères
}

// Fonction modPow optimisée
function modPowOptimisee($base, $exposant, $modulo) {
    // Initialisation des variables en utilisant GMP (bignum)
    $base = gmp_init($base);
    $exposant = gmp_init($exposant);
    $modulo = gmp_init($modulo);

    $result = gmp_init(1);

    // Boucle pour effectuer l'exponentiation modulaire
    while (gmp_cmp($exposant, 0) > 0) {
        // Si l'exposant est impair (utilisation de gmp_and pour vérifier le bit de poids faible)
        if (gmp_intval(gmp_and($exposant, 1)) == 1) {
            $result = gmp_mod(gmp_mul($result, $base), $modulo);
        }
        // Carré de la base et réduction modulo
        $base = gmp_mod(gmp_mul($base, $base), $modulo);
        // Division entière de l'exposant par 2
        $exposant = gmp_div($exposant, 2);
    }

    return gmp_strval($result); // Retourne le résultat sous forme de chaîne de caractères
}

// Variables d'entrée
$base = "123456789";  
$exposant = "987654321";  
$modulo = "999999999";  

// Mesure du temps d'exécution pour la fonction originale
$debutOriginal = microtime(true);
$resultatOriginal = modPowOriginal($base, $exposant, $modulo);
$finOriginal = microtime(true);
$tempsExecutionOriginal = $finOriginal - $debutOriginal;

// Affichage du résultat et du temps d'exécution pour la fonction originale
echo "Résultat de modPow original : {$resultatOriginal}<br>";
echo "Temps d'exécution pour la fonction modPow originale : {$tempsExecutionOriginal} secondes<br><br>";

// Mesure du temps d'exécution pour la fonction optimisée
$debutOptimisee = microtime(true);
$resultatOptimisee = modPowOptimisee($base, $exposant, $modulo);
$finOptimisee = microtime(true);
$tempsExecutionOptimisee = $finOptimisee - $debutOptimisee;

// Affichage du résultat et du temps d'exécution
echo "Résultat de modPow optimisée : {$resultatOptimisee}<br>";
echo "Temps d'exécution pour la fonction modPow optimisée : {$tempsExecutionOptimisee} secondes<br>";

?>