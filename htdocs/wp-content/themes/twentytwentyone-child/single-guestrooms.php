<?php
/*
Template Name: Single guestrooms
*/
?>

<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php 
                    the_title('<h2>', '</h2>');
                    ?>

                    <p>
                    <?php 
                    the_field('field_number_of_beds');
                    ?>
                    Lits sont disponibles dans cette chambre
                    </p>

                    <p>
                    Cette chambre coute 
                    <?php 
                    the_field('field_price_indicative');
                    ?>
                    $ par nuit
                    </p>
                </header>
                <div>
                    <?php the_post_thumbnail(); ?>
                </div>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>

        <?php endwhile; ?>
        <?php
        // Récupérer le prix de la chambre actuelle
        $current_price = get_field('field_price_indicative');
        var_dump($current_price);
        $min_price = $current_price - 20;
        $max_price = $current_price + 20;

        $related_args = array(
            'posts_per_page'   => 3, 
            'post_type'        => 'guestrooms',
            'post__not_in'     => array(get_the_ID()),  
            'meta_query'       => array(
                array(
                    'key'     => 'field_price_indicative',
                    'value'   => array($min_price, $max_price),
                    'type'    => 'NUMERIC',
                    'compare' => 'BETWEEN',
                ),
            ),
        );

        $related_rooms = get_posts($related_args);
        echo '<pre>';
        print_r($related_args);
        echo '</pre>';
        if ($related_rooms) : ?>
            <div class="related-rooms">
                <h3>Autres chambres avec un prix similaire :</h3>
                <ul>
                    <?php foreach ($related_rooms as $room) : ?>
                        <li>
                            <a href="<?php echo get_permalink($room->ID); ?>">
                                <?php echo get_the_title($room->ID); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php get_footer(); ?>
