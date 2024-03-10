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
define( 'DB_NAME', 'tp_wordpress' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '125[LA( )cnj3hh,Zv{)D&Z-EYjq|(vtCFoI17e/W@U]l}6X[uMJ1FC}a3>xER~&' );
define( 'SECURE_AUTH_KEY',  'ZV5<bvM$!1LgG-$Tj`9f%#_0~v0bhE_. 0ns|g-$1nwPvlfm-2fvjD*G7eG#?I5W' );
define( 'LOGGED_IN_KEY',    'P;.KZhs?0^8G0+ID?.>(SAiru+ q~gGn?@N,;]+tG~(74g/I$2_s#r-uFl-:5G>9' );
define( 'NONCE_KEY',        'drO|;vl*LGSy~D<*5k_hL?+Po3pjY4M&xYU}_s}[U^SHdgj<R,fFWMq&~d?O{tMn' );
define( 'AUTH_SALT',        '1!j_dN,v? QQA&ttaz$]Lg0Q&O-`W.~F<us*eRNN>&1(RdQlqF/^5uWR(`pRzTN=' );
define( 'SECURE_AUTH_SALT', 'z6Xgw-n/hjQyucILu.3A%N!}/ze5~ FpmG;Z[G}D3CSFA1bYou]KG&g0`?f/8iP!' );
define( 'LOGGED_IN_SALT',   'ya*N,OoN33!,LldB_5*[oYof!=):wQ}oFG7Yt0[c<j;C4jk.izaZ0z:BVpEr#-$,' );
define( 'NONCE_SALT',       'V9_E_@JY<&];~4}c~|8zp*b[7nTb-8.;I_gyM& Z@QiBT(ac-sAtOG/I`j!tzCb/' );
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
