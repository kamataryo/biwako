<?php
/**
 * birder Theme Customizer.
 *
 * @package birder
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function birder_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'birder_customize_register' );

/**
 * Add other customizing terms.
 */
function birder_customize_register_general( $wp_customize ) {

	$wp_customize->add_section(
		'privacy_settings',
		array(
			'title'    => __( 'Privacy Settings', 'birder' ),
			'priority' => 0,
		)
	);


	$users = get_users( array( 'fields' => array( 'ID', 'display_name' ) ) );
	$default = $users[0]->ID;
	$choices = array( -1 => __('- No Display -', 'birder' ) );
	foreach ( $users as $user ) {
		$choices[$user->ID] = $user->display_name;
	}
	$wp_customize->add_setting( 'display_profile_at_footer', array( 'default' => $default ) );
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'display_profile_at_footer',
			array(
				'label'       => __( 'Representative at footer', 'birder' ),
				'description' => __( 'This term determines whose profile to display on footer as representative. You may also need to update menus and to alter the SNS links for new one.', 'birder' ),
				'section'     => 'privacy_settings',
				'settings'    => 'display_profile_at_footer',
				'type'        => 'select',
				'choices'     => $choices,
			)
		)
	);

	$wp_customize->add_setting( 'display_author_on_posts', array( 'default' => '1' ) );
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'display_author_on_posts',
			array(
				'label'       => __( "Display post's author", 'birder' ),
				'description' => __( 'This term determines whether display authors name on post header or not.', 'birder' ),
				'section'     => 'privacy_settings',
				'settings'    => 'display_author_on_posts',
				'type'        => 'radio',
				'choices'     => array(
					'1' => _x( 'Yes', 'whether display author name on post or not', 'birder' ),
					'0' => _x( 'No', 'whether display author name on post or not', 'birder' ),
				),
			)
		)
	);

}
add_action( 'customize_register', 'birder_customize_register_general' );

/**
 * sanitizer for customizer
 */
function birder_sanitize_username() {

}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function birder_customize_preview_js() {
	wp_enqueue_script( 'birder_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'birder_customize_preview_js' );
