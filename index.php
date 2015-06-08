<?php
/*
Plugin Name: rtBiz Portfolio
Plugin URI: http://rtcamp.com/
Description: This plugin add Portfolio support
Version: 0.2-beta
Author: rtcamp
Author URI: http://rtcamp.com/
*/

define( 'RT_BIZ_PORTFOLIO', 'portfolio' );

if ( ! defined( 'RT_PORTFOLIO_URL' ) ) {
	define( 'RT_PORTFOLIO_URL', plugin_dir_url( __FILE__ ) );
}


add_action( 'rtbiz_init', 'rt_biz_portfolio_init', 1 );

function rt_biz_portfolio_init(){
	$rt_biz_portfolio_loader = new RT_WP_Autoload( trailingslashit( dirname( __FILE__ ) ) . 'app' );

	$rt_biz_init = new RT_Biz_Portfolio();
}