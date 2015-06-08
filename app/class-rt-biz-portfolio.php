<?php

/**
 * Created by PhpStorm.
 * User: faishal
 * Date: 18/04/14
 * Time: 6:57 PM
 */
class RT_Biz_Portfolio {

	var $menu_position = 38;
     
	function __construct() {
		add_action( 'plugins_loaded', 'plugins_loaded' );
		add_action( 'init', array( &$this, 'init_0' ), 0 );
		add_filter( 'rtbiz_modules', array( $this, 'register_rt_portfolio_testimonial_module' ) );
		add_action( 'activated_plugin', 'flush_rewrite_rules' );
		add_action( 'deactivate_plugin', 'flush_rewrite_rules' );
		add_action( 'after_switch_theme', 'flush_rewrite_rules' );
	}

	function register_rt_portfolio_testimonial_module( $modules ) {
		$module_key = ( function_exists( 'rtbiz_sanitize_module_key' ) ) ? rtbiz_sanitize_module_key( RT_BIZ_PORTFOLIO ) : '';
		$modules[ $module_key ] = array(
			'label' => __( 'rtBiz Portfolio' ),
			'post_types' => array(
				'portfolio'
			),
		);
		return $modules;
	}

	function plugins_loaded(){

	}

	function init_0() {
		$this->register_custom_post_type();
		$this->register_p2p_connections();
	}

	function register_p2p_connections(){
		if ( function_exists( 'p2p_register_connection_type' ) ) {
			p2p_register_connection_type(
				array(
					'name'        => 'portfolio_testimonial',
					'to'          => 'testimonial',
					'from'        => 'portfolio',
					'cardinality' => 'one-to-one',
					'title'       => array(
						'to'   => 'Related Portfolio',
						'from' => 'Related Testimonial',
					)
				)
			);
			p2p_register_connection_type(
				array(
					'name'        => 'portfolio_' . rtbiz_get_company_post_type(),
					'to'          => rtbiz_get_company_post_type(),
					'from'        => 'portfolio',
					'cardinality' => 'one-to-one',
					'title'       => array(
						'to'   => 'Portfolio',
						'from' => 'Organization',
					)
				)
			);


		}

	}


	function register_custom_post_type() {
		register_post_type(
			'portfolio',
			array(
				'labels'      => array(
					'name' => 'Portfolio',
				),
				'description' => __( 'Manage Portfolio items easily' ),
				'public'      => true,
				'show_ui'     => true,
				'capability_type' => 'portfolio',
				'menu_icon'   => RT_PORTFOLIO_URL.'app/assets/img/portfolio-16X16.png',
				'menu_position' => $this->menu_position,
				'taxonomies'  => array( 'post_tag' ),
				'supports'    => array(
					'title',
					'editor',
					'excerpt',
					'thumbnail',
					'custom-fields',
					'revisions',
				),
				'rewrite'     => array(
					'slug'       => 'portfolio',
					'with_front' => false,
				),
				'has_archive' => true,
			)
		);


		add_rewrite_rule( '^portfolio/tag/([^/]*)/([^/]*)/([^/]*)/?','index.php?post_type=portfolio&tag=$matches[1]&paged=$matches[3]', 'top' );
		add_rewrite_rule( '^portfolio/tag/([^/]*)/?','index.php?post_type=portfolio&tag=$matches[1]', 'top' );
	}
} 