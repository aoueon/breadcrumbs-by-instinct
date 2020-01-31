<?php 
/**
 * Plugin Name: Breadcrumbs by instinct
 * -Plugin URI: https://aniomalia.com/plugins/breadcrumbs-by-instinct/
 * Author: Aniomalia
 * Author URI: https://aniomalia.com/
 * Description: Format breadcrumbs the way you like them using the generate array, or use our recommended solution.
 * Version: 1.0
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

/* Enqueue necessary assets */
function aniomalia_breadcrumbs_assets() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'style',  $plugin_url . 'css/style.css');
}
add_action( 'wp_enqueue_scripts', 'aniomalia_breadcrumbs_assets' );

/* Output array of breadcrumbs */
function get_aniomalia_breadcrumbs() {

    global $post;
    $breadcrumbs = array();

    /* First Page */
    $frontpage = get_option( 'show_on_front' );
    $homepage = get_option('page_on_front');

    $breadcrumbs[] = array(
        'title' => ( $frontpage == 'posts' ) ? get_bloginfo('name') : get_the_title($homepage),
        'url' => get_home_url('/'),
        'type' => 'home'
    );

    if ( ! is_front_page() ) {

        /* Archive or Single */
    
        if ( is_singular('post') || is_home() ) {
            if ( $frontpage != 'posts' ) {
                $blog = get_option( 'page_for_posts' );
                $breadcrumbs[] = array(
                    'title' => get_the_title($blog),
                    'url' => get_the_permalink($blog),
                    'type' => 'blog'
                );
            }
        } else if ( is_single( $post->ID ) || is_post_type_archive() ) {
            $post_type = get_post_type_object( get_post_type($post) );
            $breadcrumbs[] = array(
                'title' => $post_type->label,
                'url' => get_post_type_archive_link($post_type->name),
                'type' => 'archive'
            );
        } else if ( is_archive() ) {
            if ( is_category() ) {
                $archive_title = single_cat_title( '', false );
                $archive_url = get_category_link( get_queried_object() );
                $archive_type = 'category';
            } elseif ( is_tag() ) {
                $archive_title = single_tag_title( '', false );
                $archive_url = get_term_link( get_queried_object() );
                $archive_type = 'tag';
            } elseif ( is_tax() ) {
                $archive_title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
                $archive_url = get_term_link( get_queried_object() );
                $archive_type = 'taxonomy';
            }
            } elseif ( is_author() ) {
                $archive_title = get_the_author();
                $archive_url = get_author_posts_url( get_the_author_meta('ID') );
                $archive_type = 'author';
            $breadcrumbs[] = array(
                'title' => $archive_title,
                'url' => $archive_url,
                'type' => $archive_type
            );
        }

        /* Page Parents */
        if ( is_page() ) {
            $page_parents = array_reverse(get_post_ancestors($post));
            if ( $page_parents ) {
                foreach ( $page_parents as $parent ) {
                    $breadcrumbs[] = array(
                        'title' => get_the_title($parent),
                        'url' => get_the_permalink($parent),
                        'type' => 'parent'
                    );
                }
            }
        }

        /* Current Page */
        if ( ! is_archive() && ! is_home() ) {
            $breadcrumbs[] = array(
                'title' => get_the_title($post),
                'url' => get_permalink($post),
                'type' => 'current'
            );
        }

    }

    return $breadcrumbs;
}

// Output formatted breadcrumbs
function aniomalia_breadcrumbs() {
    $breadcrumbs = get_aniomalia_breadcrumbs();
    if ( $breadcrumbs ) :
    ?>

    <nav class="aniomalia-breadcrumbs">
        <ul>
            <?php foreach ( $breadcrumbs as $key => $item ) : ?>
            <li class="aniomalia-breadcrumbs-item type-<?php echo $item['type']; ?><?php echo ( $key == 0 ) ? ' is-first' : ''; ?><?php echo ( $key == count($breadcrumbs) - 1 ) ? ' is-last' : ''; ?>"> 
                <?php if ( $key != count($breadcrumbs) - 1 ) : ?><a href="<?php echo $item['url']; ?>"><?php endif; ?>
                <?php echo wp_trim_words($item['title'], 10, '...'); ?>
                <?php if ( $key != count($breadcrumbs) - 1 ) : ?></a><?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <?php
    endif;
}
