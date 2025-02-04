<?php


/**
 * Fonction qui calcule l'inverse modulaire d'un nombre.
 * @param GMP $a Le nombre.
 * @param GMP $m Le modulo.
 * @return GMP L'inverse modulaire de $a modulo $m.
 */
function modInverse($a, $m) {
    // Initialise $a et $m en tant que GMP.
    $a = gmp_init($a);
    $m = gmp_init($m);

    // Calcule l'inverse modulaire de $a modulo $m.
    $inv = gmp_invert($a, $m);

    return $inv;
}

/**
 * Fonction qui calcule la puissance modulaire.
 * @param GMP $base La base.
 * @param GMP $exposant L'exposant.
 * @param GMP $modulo Le modulo.
 * @return string La puissance modulaire.
 */
function modPow($base, $exposant, $modulo) {
    // Initialise les variables en tant que GMP.
    $base = gmp_init($base);
    $exposant = gmp_init($exposant);
    $modulo = gmp_init($modulo);

    // Initialise le résultat final à 1.
    $resultatFinal = gmp_init(1);

    // Calcule la puissance modulaire.
    while (gmp_cmp($exposant, 0) > 0) {
        if (gmp_cmp(gmp_mod($exposant, 2), 1) == 0) {
            $resultatFinal = gmp_mod(gmp_mul($resultatFinal, $base), $modulo);
        }
        $base = gmp_mod(gmp_mul($base, $base), $modulo);
        $exposant = gmp_div($exposant, 2);
    }

    return gmp_strval($resultatFinal);
}

/**
 * Fonction qui convertit une chaîne en un nombre.
 * @param string $string La chaîne à convertir.
 * @return GMP Le nombre résultant.
 */
function stringToNumber($string) {
    // Initialise le résultat à 0.
    $result = gmp_init('0');
    $length = strlen($string);

    // Parcourt chaque caractère de la chaîne.
    for ($i = 0; $i < $length; $i++) {
        // Multiplie le résultat par 256 et ajoute la valeur ASCII du caractère.
        $result = gmp_mul($result, '256');
        $result = gmp_add($result, ord($string[$i]));
    }

    return $result;
}

/**
 * Fonction qui convertit un nombre en une chaîne.
 * @param GMP $number Le nombre à convertir.
 * @return string La chaîne résultante.
 */
function numberToString($number) {
    // Initialise la chaîne résultante.
    $result = '';

    // Convertit le nombre en une séquence de caractères.
    while (gmp_cmp($number, 0) > 0) {
        $byte = gmp_mod($number, '256');
        $result = chr((int)gmp_strval($byte)) . $result;
        $number = gmp_div($number, '256', GMP_ROUND_ZERO);
    }

    return $result;
}

/**
 * Fonction qui chiffre une chaîne avec une clé publique RSA.
 * @param string $message Le message à chiffrer.
 * @param array $publicKey La clé publique RSA.
 * @return string Le message chiffré.
 */
function encryptRSA($message, $publicKey) {
    // Convertit le message en un nombre.
    $numericMessage = stringToNumber($message);
    
    // Calcule la puissance modulaire avec la clé publique.
    $encryptedMessage = modPow($numericMessage, $publicKey['e'], $publicKey['n']);
    
    return $encryptedMessage;
}

/**
 * Fonction qui déchiffre une chaîne chiffrée avec une clé privée RSA.
 * @param string $encryptedMessage Le message chiffré.
 * @param array $privateKey La clé privée RSA.
 * @return string Le message déchiffré.
 */
function decryptRSA($encryptedMessage, $privateKey) {
    // Calcule la puissance modulaire inverse avec la clé privée.
    $decryptedNumericMessage = modPow($encryptedMessage, $privateKey['d'], $privateKey['n']);
    
    // Convertit le nombre en une chaîne.
    $decryptedMessage = numberToString($decryptedNumericMessage);
    
    return $decryptedMessage;
}

