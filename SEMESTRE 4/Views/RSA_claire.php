<?php

// Fonction pour générer des clés RSA
function generateRSAKeys($bitLength) {
    // Génère deux nombres premiers aléatoires de la taille spécifiée
    $p = generatePrime($bitLength);
    $q = generatePrime($bitLength);

    // Calcule n = p * q
    $n = gmp_mul($p, $q);
    // Calcule phi(n) = (p-1) * (q-1)
    $phi = gmp_mul(gmp_sub($p, 1), gmp_sub($q, 1));

    // Trouve un nombre e qui est copremier avec phi(n)
    $e = findCoprime($phi, $bitLength);
    // Calcule d, l'inverse modulaire de e mod phi(n)
    $d = modInverse($e, $phi);
    
    // Retourne la paire de clés publiques et privées
    return [
        'publicKey' => ['e' => gmp_strval($e), 'n' => gmp_strval($n)],
        'privateKey' => ['d' => gmp_strval($d), 'n' => gmp_strval($n)]
    ];
}

// Fonction pour générer un nombre premier de la taille spécifiée
function generatePrime($bitLength) {
    do {
        // Génère un nombre aléatoire de la taille spécifiée
        $randomNumber = gmp_random_bits($bitLength);
    } while (!gmp_prob_prime($randomNumber, 50)); // Vérifie si le nombre est probablement premier

    return $randomNumber;
}

// Fonction pour trouver un nombre copremier avec phi(n)
function findCoprime($phi, $bitLength) {
    $e = generatePrime($bitLength);
    $phi = gmp_init($phi);

    // Continue jusqu'à ce que gcd(e, phi) = 1 (c'est-à-dire qu'ils sont copremiers)
    while (gmp_cmp(gmp_gcd($e, $phi), 1) != 0) {
        $e = gmp_add($e, 1); // Incrémente e jusqu'à ce qu'il soit copremier avec phi
    }

    return $e;
}

// Fonction pour calculer l'inverse modulaire de a mod m
function modInverse($a, $m) {
    $a = gmp_init($a);
    $m = gmp_init($m);

    // Utilise la fonction GMP pour trouver l'inverse modulaire
    $inv = gmp_invert($a, $m);

    return $inv;
}

// Fonction pour effectuer l'exponentiation modulaire
function modPow($base, $exposant, $modulo) {
    $base = gmp_init($base);
    $exposant = gmp_init($exposant);
    $modulo = gmp_init($modulo);

    $resultatFinal = gmp_init(1);

    // Boucle pour calculer base^exposant % modulo
    while (gmp_cmp($exposant, 0) > 0) {
        if (gmp_cmp(gmp_mod($exposant, 2), 1) == 0) {
            $resultatFinal = gmp_mod(gmp_mul($resultatFinal, $base), $modulo);
        }

        $base = gmp_mod(gmp_mul($base, $base), $modulo);
        $exposant = gmp_div($exposant, 2);
    }

    return gmp_strval($resultatFinal);
}

// Fonction pour convertir une chaîne de caractères en nombre
function stringToNumber($string) {
    $result = gmp_init('0');
    $length = strlen($string);

    for ($i = 0; $i < $length; $i++) {
        $result = gmp_mul($result, '256');
        $result = gmp_add($result, ord($string[$i]));
    }

    return $result;
}

// Fonction pour convertir un nombre en chaîne de caractères
function numberToString($number) {
    $result = '';

    while (gmp_cmp($number, 0) > 0) {
        $byte = gmp_mod($number, '256');
        $result = chr((int)gmp_strval($byte)) . $result;
        $number = gmp_div($number, '256', GMP_ROUND_ZERO);
    }

    return $result;
}

// Fonction pour chiffrer un message avec RSA
function encryptRSA($message, $publicKey) {
    $numericMessage = stringToNumber($message);
    $encryptedMessage = modPow($numericMessage, $publicKey['e'], $publicKey['n']);
    return $encryptedMessage;
}

// Fonction pour déchiffrer un message avec RSA
function decryptRSA($encryptedMessage, $privateKey) {
    $decryptedNumericMessage = modPow($encryptedMessage, $privateKey['d'], $privateKey['n']);
    $decryptedMessage = numberToString($decryptedNumericMessage);
    return $decryptedMessage;
}

// Génère une paire de clés RSA
$keys = generateRSAKeys(1024);
$publicKey = $keys['publicKey'];
$privateKey = $keys['privateKey'];

// Affiche les clés générées
echo "Clé publique (n, e) : (" . $publicKey['n'] . ", " . $publicKey['e'] . ")" . PHP_EOL;
echo "Clé privée (n, d) : (" . $privateKey['n'] . ", " . $privateKey['d'] . ")" . PHP_EOL;

$message = "Salut, ceci est un nouveau message à chiffrer et déchiffrer.";

// Chiffre le message avec la clé publique
$encryptedMessage = encryptRSA($message, $publicKey);
echo "Message chiffré : " . $encryptedMessage . PHP_EOL;

// Déchiffre le message avec la clé privée
$decryptedMessage = decryptRSA($encryptedMessage, $privateKey);
echo "Message déchiffré : " . $decryptedMessage . PHP_EOL;

?>

indente correctement ce code