<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link https://fr.wordpress.org/support/article/editing-wp-config-php/ Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'database' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'database' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'database' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'db' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'jb|zLSY0;oRAIf$6Y;n3Y%<a0QOtfTha?8&/l)Fmq9tP7/]X.nzQ5 0@S-HY``Q_' );
define( 'SECURE_AUTH_KEY',  'mpQ0WEeN5]#-10^`4Bs4jSzl!SH[!lw?G40s[3,iLD/DC/#jxvIt29Q P=#.pB|B' );
define( 'LOGGED_IN_KEY',    '[4-aU!%6;`(h{e8LDlMx8,YwJ2i4YwEQ9![>ISo3G1Co~YuXG]yNRrazcX#!#!nr' );
define( 'NONCE_KEY',        'Ey<)uRFe5):PW7HAe~&nhNoQ1nIz4^w!K|W{v~rqNAD4*u(GqoMs=++2iB2[ORtm' );
define( 'AUTH_SALT',        ']T8&4,n;lAxw Q_`vg[%1ZKybt04jR)D({1+SI/p64!digr75rn*VapZN>dU?N&i' );
define( 'SECURE_AUTH_SALT', '6;eCqf4-F-9uR[AKp}W~0gn>x4 ,BtU`cZwku4LA22s`6vU/U~Y4@CsbJQt3!{H|' );
define( 'LOGGED_IN_SALT',   '?vbD{MKXIVdION3cBkJ2T#r<N<kTFy,.lpaQ5rmcailqhZ#aa<A;yXF N:?1%aKF' );
define( 'NONCE_SALT',       'TBnIkHKMGdpg,*+zP&Dqi,;s6uM~%c%s;2CHpd=@N(-@}>W3kmVQW>4Xf*!7/><:' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs et développeuses : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs et développeuses d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur la documentation.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
