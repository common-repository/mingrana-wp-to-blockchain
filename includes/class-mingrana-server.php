<?php

/**
 * Connect to Mingrana Api
 *
 * @link       https://www.mingrana.com/
 * @since      1.0.0
 *
 * @package    Mingrana_Wp
 * @subpackage Mingrana_Wp/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mingrana_Wp
 * @subpackage Mingrana_Wp/includes
 * @author     Mingrana SL <info@mingrana.com>
 */

class Mingrana_Server {

	public $info;
	private $url_api_info;
	private $url_api_store;
	private $api_key;
	private $url_blog;

	function __construct($url_api = "", $api_key = "", $url_blog = "") {

		$this->url_api_info = $url_api . '/info' ;
		$this->url_api_store = $url_api . '/store' ;
		$this->api_key = $api_key;
		$this->url_blog = $url_blog;

		$this->get_info();

	}


	function get_info() {

		/*if (!function_exists('curl_version')) {
			$this->info = array('registros' => array(),
								'saldo' => 'No CURL Inst.',
								);
			return true;
		}*/

		if (!function_exists('json_decode')) {
			$this->info = array('registros' => array(),
								'saldo' => 'No JSON Inst.',
								);
			return true;
		}

		try {


			$response = wp_remote_post( $this->url_api_info, array(
				'method' => 'POST',
				'timeout' => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array('x-api-key' => $this->api_key,
			    					'x-urlblog' => $this->url_blog),
				'cookies' => array()
			    )
			);

			if ( is_wp_error( $response ) ) {
			   $error_message = $response->get_error_message();
			   echo "Something went wrong connecting to the server: $error_message";
			   $server_output = false;
			} else {
			   /*echo 'Response:<pre>';
			   print_r( $response );
			   echo '</pre>';*/
			   $server_output = $response['body'];
			}

			/*$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$this->url_api_info);
			curl_setopt($ch, CURLOPT_POST, 1);
			//curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Deshabilita la comprobación SSL
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$headers = [
			    'x-api-key: ' . $this->api_key,
			    'x-urlblog: ' . $this->url_blog,
			];

			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$server_output = curl_exec ($ch);

			curl_close ($ch);*/

			//die();

			$server_json = json_decode($server_output, true);

			if (json_last_error() == JSON_ERROR_NONE) {

				$this->info =  json_decode($server_output, true);

			} else {

				$this->info = false;

			}
		} catch (Exception $e) {

			$this->info = array('registros' => array(),
								'saldo' => $e->getMessage(),
								);
			die(); 
		}
		
	}


	function send_register($data = array()) {


		$vars = $data;

		/*$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->url_api_store);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Deshabilita la comprobación SSL
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$headers = [
		    'x-api-key: ' . $this->api_key,
		    'x-urlblog: ' . $this->url_blog,
		];

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$server_output = curl_exec ($ch);

		curl_close ($ch);*/

		$response = wp_remote_post( $this->url_api_store, array(
				'method' => 'POST',
				'timeout' => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array('x-api-key' => $this->api_key,
			    					'x-urlblog' => $this->url_blog),
				'body' => $vars,
				'cookies' => array()
			    )
			);

			if ( is_wp_error( $response ) ) {
			   $error_message = $response->get_error_message();
			   echo "Something went wrong connecting to the server: $error_message";
			   $server_output = false;
			} else {
			   /*echo 'Response:<pre>';
			   print_r( $response );
			   echo '</pre>';*/
			   $server_output = $response['body'];
			}

		$server_json = json_decode($server_output, true);

		if (json_last_error() == JSON_ERROR_NONE) {

			$this->info =  json_decode($server_output, true);

		} else {

			$this->info = false;

		}

		
	}

	function balance() {

		if ($this->info === false) return 0;
		return $this->info['saldo'];

	}

	function registers() {

		if ($this->info === false) return 0;

		$registers_blog = array_filter (  (is_null($this->info['registros']) ? array() : $this->info['registros']) , array($this,'filter_blog_registers'));

		return $registers_blog;

	}

	function filter_blog_registers($reg) {

		return ($reg['origen'] == $this->url_blog);

	}



}