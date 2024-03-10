<?php
get_header();
global $post;

$min_beds = isset($_GET['min_beds']) ? intval($_GET['min_beds']) : null;
$max_price = isset($_GET['max_price']) ? intval($_GET['max_price']) : null;

if ($min_beds != null ){
    $args = array(
        'posts_per_page'   => -1, 
        'post_type'        => 'guestrooms',
        'meta_query'       => array(
            array(
                'key'     => 'field_number_of_beds',
                'value'   => $min_beds,
                'type'    => 'NUMERIC',
                'compare' => '>=',
            )
        ),
    );
}elseif($max_price != null ){
    $args = array(
        'posts_per_page'   => -1, 
        'post_type'        => 'guestrooms',
        'meta_query'       => array(
            array(
                'key'     => 'field_price_indicative',
                'value'   => $max_price,
                'type'    => 'NUMERIC',
                'compare' => '>=',
            )
        ),
    );
}elseif ($max_price != null && $min_beds != NULL){
    $args = array(
        'posts_per_page'   => -1, 
        'post_type'        => 'guestrooms',
        'meta_query'       => array(
            'relation' => 'AND',
            array(
                'key'     => 'field_number_of_beds',
                'value'   => $min_beds,
                'type'    => 'NUMERIC',
                'compare' => '>=',
            ),
            array(
                'key'     => 'field_price_indicative',
                'value'   => $max_price,
                'type'    => 'NUMERIC',
                'compare' => '>=',
            )
        ),
    );
}else{
    $args = array(
        'posts_per_page'   => -1, 
        'post_type'        => 'guestrooms',
    );
}

$products = get_posts($args);
?>
<form method="get" action="/?post_type=guestrooms&">
    <label for="min_beds">Nombre minimum de lits:</label>
    <input type="number" name="min_beds" id="min_beds" value="<?php echo $min_beds; ?>" />

    <label for="max_price">Prix maximum:</label>
    <input type="number" name="max_price" id="max_price" value="<?php echo $max_price; ?>" />

    <input type="submit" value="Filtrer" />
</form>

<ul class="guestrooms-list-list">
    <?php
    foreach ($products as $post) : setup_postdata($post); ?>
        <li class="guestroom-list-item">
            <a href="<?php the_permalink(); ?>">
                <h2><?php the_title(); ?></h2>
                <div class="guestroom-list-thumbnail"><?php the_post_thumbnail() ?></div>
                <p><?php the_excerpt(); ?> beds</p>
                <p><?php the_field("field_number_of_beds"); ?> beds</p>
                <p><?php the_field("field_price_indicative"); ?> $/nuit</p>
            </a>
        </li>
    <?php endforeach;
    wp_reset_postdata();
    ?>
</ul>
<?php get_footer(); ?>
