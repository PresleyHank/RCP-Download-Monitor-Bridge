<?php
/*
 * Plugin name: RCP - Download Monitor Bridge
 * Description: Limit file downloads to paid subscribers
 * Author: Pippin Williamson
 */


class RCP_Download_Monitor {

	/**
	 * @var RCP_Download_Monitor The one true RCP_Download_Monitor
	 * @since 1.0
	 */
	private static $instance;


	/**
	 * Main RCP_Download_Monitor Instance
	 *
	 * Insures that only one instance of RCP_Download_Monitor exists in memory at any one
	 * time.
	 *
	 * @var object
	 * @access public
	 * @since 1.0
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof RCP_Download_Monitor ) ) {
			self::$instance = new RCP_Download_Monitor;
			self::$instance->init();
		}
		return self::$instance;
	}


	/**
	 * Setup filters and actions
	 *
	 * @access private
	 * @since 1.0
	 */
	private function init() {
		// Check for RCP and WP Job Manager
		if( ! function_exists( 'rcp_is_active' ) || ! class_exists( 'WP_DLM' ) )
			return;

		// Check if user can post a job
		add_filter( 'dlm_can_download', array( $this, 'can_download' ) );

	}


	/**
	 * Can the current user download files?
	 *
	 * @access public
	 * @since 1.0
	 * @return bool
	 */
	public function can_download() {
		return rcp_is_active();
	}


}
add_action( 'plugins_loaded', array( 'RCP_Download_Monitor', 'get_instance' ) );