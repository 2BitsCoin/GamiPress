<?php
/**
 * Scripts
 *
 * @package     GamiPress\Scripts
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Register frontend scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_register_scripts() {
    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Stylesheets
    wp_register_style( 'gamipress-css', GAMIPRESS_URL . 'assets/css/gamipress' . $suffix . '.css', array( ), GAMIPRESS_VER, 'all' );

    // Scripts
    wp_register_script( 'gamipress-js', GAMIPRESS_URL . 'assets/js/gamipress' . $suffix . '.js', array( 'jquery' ), GAMIPRESS_VER, true );
}
add_action( 'init', 'gamipress_register_scripts' );

/**
 * Enqueue frontend scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_enqueue_scripts( $hook ) {
    // Stylesheets
    wp_enqueue_style('gamipress-css');

    // Localize scripts
    wp_localize_script( 'gamipress-js', 'gamipress', array(
        'ajaxurl' => esc_url( admin_url( 'admin-ajax.php', 'relative' ) )
    ) );

    // Scripts
    wp_enqueue_script( 'gamipress-js' );
}
add_action( 'wp_enqueue_scripts', 'gamipress_enqueue_scripts', 100 );

/**
 * Register admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_admin_register_scripts() {
    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Stylesheets
    wp_register_style( 'gamipress-admin-css', GAMIPRESS_URL . 'assets/css/gamipress-admin' . $suffix . '.css', array( ), GAMIPRESS_VER, 'all' );

    // Scripts
    wp_register_script( 'gamipress-admin-js', GAMIPRESS_URL . 'assets/js/gamipress-admin' . $suffix . '.js', array( 'jquery' ), GAMIPRESS_VER, true );
    wp_register_script( 'gamipress-admin-widgets-js', GAMIPRESS_URL . 'assets/js/gamipress-admin-widgets' . $suffix . '.js', array( 'jquery' ), GAMIPRESS_VER, true );
    wp_register_script( 'gamipress-points-awards-ui-js', GAMIPRESS_URL . 'assets/js/gamipress-points-awards-ui' . $suffix . '.js', array( 'jquery', 'jquery-ui-sortable' ), GAMIPRESS_VER, true );
    wp_register_script( 'gamipress-steps-ui-js', GAMIPRESS_URL . 'assets/js/gamipress-steps-ui' . $suffix . '.js', array( 'jquery', 'jquery-ui-sortable' ), GAMIPRESS_VER, true );
    wp_register_script( 'gamipress-log-extra-data-ui-js', GAMIPRESS_URL . 'assets/js/gamipress-log-extra-data-ui' . $suffix . '.js', array( 'jquery' ), GAMIPRESS_VER, true );

    // Libraries
    wp_register_style( 'gamipress-select2-css', GAMIPRESS_URL . 'assets/libs/select2/css/select2' . $suffix . '.css', array( ), GAMIPRESS_VER, 'all' );
    wp_register_script( 'gamipress-select2-js', GAMIPRESS_URL . 'assets/libs/select2/js/select2.full' . $suffix . '.js', array( 'jquery' ), GAMIPRESS_VER, true );
}
add_action( 'admin_init', 'gamipress_admin_register_scripts' );

/**
 * Enqueue admin scripts
 *
 * @since       1.0.0
 * @return      void
 */
function gamipress_admin_enqueue_scripts( $hook ) {
    global $post_type;
    //Stylesheets
    wp_enqueue_style( 'gamipress-admin-css' );

    //Scripts
    wp_enqueue_script( 'gamipress-admin-js' );

    if(
        $post_type === 'points-type'
        || in_array( $post_type, gamipress_get_achievement_types_slugs() )
        || $post_type === 'gamipress-log'
        || $hook === 'widgets.php'
    ) {
        wp_enqueue_script( 'gamipress-select2-js' );
        wp_enqueue_style( 'gamipress-select2-css' );
    }

    // Points type scripts
    if ( $post_type === 'points-type' ) {
        wp_localize_script( 'gamipress-points-awards-ui-js', 'gamipress_points_awards_ui', array(
            'post_placeholder' => __( 'Select a Post', 'gamipress' ),
            'specific_activity_triggers' => gamipress_get_specific_activity_triggers(),
        ) );

        wp_enqueue_script( 'gamipress-points-awards-ui-js' );
    }

    // Achievements scripts
    if ( in_array( $post_type, gamipress_get_achievement_types_slugs() ) ) {
        // Localize steps ui script
        wp_localize_script( 'gamipress-steps-ui-js', 'gamipress_steps_ui', array(
            'post_placeholder' => __( 'Select a Post', 'gamipress' ),
            'specific_activity_triggers' => gamipress_get_specific_activity_triggers()
        ) );

        wp_enqueue_script( 'gamipress-steps-ui-js' );
    }

    // Logs scripts
    if ( $post_type === 'gamipress-log' ) {
        wp_enqueue_script( 'gamipress-log-extra-data-ui-js' );
    }

    // Widgets scripts
    if( $hook === 'widgets.php' ) {
        wp_localize_script( 'gamipress-admin-widgets-js', 'gamipress_admin_widgets', array(
            'id_placeholder'          => __( 'Select a Post', 'gamipress' ),
            'id_multiple_placeholder' => __( 'Select Post(s)', 'gamipress' ),
            'user_placeholder'        => __( 'Select an User', 'gamipress' ),
            'post_type_placeholder'   => __( 'Default: All', 'gamipress' ),
        ) );

        wp_enqueue_script( 'gamipress-admin-widgets-js' );
    }
}
add_action( 'admin_enqueue_scripts', 'gamipress_admin_enqueue_scripts', 100 );