<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.mingrana.com/
 * @since      1.0.0
 *
 * @package    Mingrana_Wp
 * @subpackage Mingrana_Wp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mingrana_Wp
 * @subpackage Mingrana_Wp/public
 * @author     Mingrana SL <info@mingrana.com>
 */
class Mingrana_Wp_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mingrana_Wp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mingrana_Wp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mingrana-wp-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mingrana_Wp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mingrana_Wp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mingrana-wp-public.js', array( 'jquery' ), $this->version, false );

	}

	public function showstamp () {

		$options = get_option($this->plugin_name);

		if ( $options['showstamp'] == 0 ) return false;

		return true;

	}

	/**
	 * Put post info after content.
	 *
	 * @since    1.0.0
	 */
	public function mingrana_after($content) {



		$queried_object = get_queried_object();

		$aftercontent = "";

		if ( $queried_object ) {
		    $post_id = $queried_object->ID;
		    global $table_prefix, $wpdb;

			$tblname = 'mingrana';
    		$mingrana_wp_table = $table_prefix . $tblname;

    		$sql = "SELECT * FROM $mingrana_wp_table WHERE post_id = " .  $post_id . " ORDER BY post_id DESC LIMIT 1";

			$registro = $wpdb->get_row( $sql ); 

			if ($registro->status == 2) {
				$MN = New Mingrana_Wp();
				$MNA = new Mingrana_Wp_Admin( $MN->get_plugin_name(), $MN->get_version() );
        		$MNA->update_local_registers();
			}

			if ($registro != null && $registro->pdf !='' && $registro->status == 3) {
			$upload_dir = wp_upload_dir();
			$a = 1;
			$aftercontent .= "";
			switch ($a) {
					case 1:

						$aftercontent .= "<div class='mingrana-container' style='text-align: center'>
		                <p><svg width='35' height='auto' enable-background='new 0 0 283.46 283.46' version='1.1' viewBox='0 0 155.86 204.07' xml:space='preserve' xmlns='http://www.w3.org/2000/svg' xmlns:cc='http://creativecommons.org/ns#' xmlns:dc='http://purl.org/dc/elements/1.1/' xmlns:rdf='http://www.w3.org/1999/02/22-rdf-syntax-ns#'><title>Logo mingrana</title><metadata><rdf:rdf><cc:work rdf:about=''><dc:format>image/svg+xml</dc:format><dc:type rdf:resource='http://purl.org/dc/dcmitype/StillImage'></dc:type><dc:title>Logo mingrana</dc:title></cc:work></rdf:rdf></metadata><g transform='translate(-63.8,-39.693)'><path d='m84.038 99.166-0.011 85.131c0 5.822-4.739 10.557-10.56 10.557h-9.341v21.977h12.837v0.283h0.488v26.373h21.77v-26.657h31.052v0.283h0.488v26.373h12.842v0.281h9.417v-26.654h31.052v26.654h22.264v-26.654h13.324v-22.26h-9.68c-5.82 0-10.56-4.734-10.56-10.557l0.012-85.131c0-5.821 4.738-10.56 10.56-10.56h9.343v-22.257h-13.33v-26.655h-22.258v26.655h-31.052v-26.655h-22.259v26.655h-31.051v-26.655h-22.255v26.655h-13.33v22.258h9.679c5.824-1e-3 10.559 4.738 10.559 10.56z' fill='#9d9d9c'></path><polygon points='111.09 181.78 111.09 127.97 141.96 171.52 172.37 128.13 172.37 181.78 180.66 181.78 180.66 101.68 141.94 157.02 102.79 101.73 102.79 181.78' fill='#fff'></polygon></g></svg>
		                </p>";

                        /*$aftercontent .= "<p>Este <a rel='nofollow' href='https://etherscan.io/tx/" .  $registro->transaction . "' target='_blank' title='HASH " .  $registro->hash_256 . "'>contenido</a> ha sido registrado en la <a rel='nofollow' href='https://etherscan.io/tx/" .  $registro->transaction . "' target='_blank' title='Transation " .  $registro->transaction . "'>BlockChain Ethereum</a> por <strong>Mingrana<strong></strong></strong></p>
            				</div>";*/

            			 $aftercontent .= "Contenido <a style='font-weight:normal;color: #000;text-decoration:none;border-bottom:1px solid #000;' rel='nofollow' href='https://etherscan.io/tx/" .  $registro->transaction . "' target='_blank' title='Ver transacción en la Blockchain'>Registrado en Blockchain</a> por Mingrana";
                    break;
					case 2:
					case 3:	
						 
				$url = $upload_dir['baseurl'] . '/mingrana/' . $registro->pdf;
				$aftercontent .= "<div class='mingrana-container' style='overflow:hidden;width:100%;border-size: border-box;border-radius:0px; padding:20px;background-color:#E6E6E6;font-size: 0.8em;word-wrap: break-word;'>";
				$aftercontent .= "<div class='mingrana-logo' style='width:10%;float:left;border-size: border-box;padding: 10px;'>";
				$aftercontent .= "<svg width='100%' height='auto' enable-background='new 0 0 283.46 283.46' version='1.1' viewBox='0 0 155.86 204.07' xml:space='preserve' xmlns='http://www.w3.org/2000/svg' xmlns:cc='http://creativecommons.org/ns#' xmlns:dc='http://purl.org/dc/elements/1.1/' xmlns:rdf='http://www.w3.org/1999/02/22-rdf-syntax-ns#'><title>Logo mingrana</title><metadata><rdf:RDF><cc:Work rdf:about=''><dc:format>image/svg+xml</dc:format><dc:type rdf:resource='http://purl.org/dc/dcmitype/StillImage'/><dc:title>Logo mingrana</dc:title></cc:Work></rdf:RDF></metadata><g transform='translate(-63.8,-39.693)'><path d='m84.038 99.166-0.011 85.131c0 5.822-4.739 10.557-10.56 10.557h-9.341v21.977h12.837v0.283h0.488v26.373h21.77v-26.657h31.052v0.283h0.488v26.373h12.842v0.281h9.417v-26.654h31.052v26.654h22.264v-26.654h13.324v-22.26h-9.68c-5.82 0-10.56-4.734-10.56-10.557l0.012-85.131c0-5.821 4.738-10.56 10.56-10.56h9.343v-22.257h-13.33v-26.655h-22.258v26.655h-31.052v-26.655h-22.259v26.655h-31.051v-26.655h-22.255v26.655h-13.33v22.258h9.679c5.824-1e-3 10.559 4.738 10.559 10.56z' fill='#9d9d9c'/><polygon points='111.09 181.78 111.09 127.97 141.96 171.52 172.37 128.13 172.37 181.78 180.66 181.78 180.66 101.68 141.94 157.02 102.79 101.73 102.79 181.78' fill='#fff'/></g></svg>";
				$aftercontent .= "</div>";

				$aftercontent .= "<div class='mingrana-texto' style='width:90%;float:left;border-size: border-box;padding: 10px;'><p>Este post y su contenido han sido registrados en la BlockChain Ethereum por <strong>Mingrana Bring to Chain</strong></p>";
				$aftercontent .= "<ul>";
				$aftercontent .= "<li>Contenido registrado: <a href='" . $url . "' target='_blank'>" .  $registro->pdf . "</a></li>";
				$aftercontent .= "<li>HASH (SHA256): " .  $registro->hash_256 . "</li>";
				$aftercontent .= "<li>Transaction: <a href='https://etherscan.io/tx/" .  $registro->transaction . "' target='_blank'>" .  $registro->transaction . "</a></li>";
				$aftercontent .= "</ul>";
				$aftercontent .= "</div>";
				$aftercontent .= "</div>";

				$aftercontent .= "<div class='mingrana-container' style='overflow:hidden;width:100%;border-size: border-box;border-radius:0px; padding:20px;background-color:#E6E6E6;font-size: 0.8em;word-wrap: break-word;border-top: 20px solid #000;'>";
				$aftercontent .= "<div class='mingrana-logo' style='width:10%;float:left;border-size: border-box;padding: 10px;'>";
				$aftercontent .= "<svg width='100%' height='auto' enable-background='new 0 0 283.46 283.46' version='1.1' viewBox='0 0 155.86 204.07' xml:space='preserve' xmlns='http://www.w3.org/2000/svg' xmlns:cc='http://creativecommons.org/ns#' xmlns:dc='http://purl.org/dc/elements/1.1/' xmlns:rdf='http://www.w3.org/1999/02/22-rdf-syntax-ns#'><title>Logo mingrana</title><metadata><rdf:RDF><cc:Work rdf:about=''><dc:format>image/svg+xml</dc:format><dc:type rdf:resource='http://purl.org/dc/dcmitype/StillImage'/><dc:title>Logo mingrana</dc:title></cc:Work></rdf:RDF></metadata><g transform='translate(-63.8,-39.693)'><path d='m84.038 99.166-0.011 85.131c0 5.822-4.739 10.557-10.56 10.557h-9.341v21.977h12.837v0.283h0.488v26.373h21.77v-26.657h31.052v0.283h0.488v26.373h12.842v0.281h9.417v-26.654h31.052v26.654h22.264v-26.654h13.324v-22.26h-9.68c-5.82 0-10.56-4.734-10.56-10.557l0.012-85.131c0-5.821 4.738-10.56 10.56-10.56h9.343v-22.257h-13.33v-26.655h-22.258v26.655h-31.052v-26.655h-22.259v26.655h-31.051v-26.655h-22.255v26.655h-13.33v22.258h9.679c5.824-1e-3 10.559 4.738 10.559 10.56z' fill='#9d9d9c'/><polygon points='111.09 181.78 111.09 127.97 141.96 171.52 172.37 128.13 172.37 181.78 180.66 181.78 180.66 101.68 141.94 157.02 102.79 101.73 102.79 181.78' fill='#fff'/></g></svg>";
				$aftercontent .= "</div>";

				$aftercontent .= "<div class='mingrana-texto' style='width:90%;float:left;border-size: border-box;padding: 10px;'><p>Este <a rel='nofollow' href='https://etherscan.io/tx/" .  $registro->transaction . "' target='_blank' title='HASH " . $registro->hash_256 . "'>post y su contenido</a> han sido registrados en la <a rel='nofollow' href='https://etherscan.io/tx/" .  $registro->transaction . "' target='_blank' title='Transation " . $registro->transaction . "'>BlockChain Ethereum</a> por <strong>Mingrana Bring to Chain<strong></p>";
				$aftercontent .= "</div>";
				$aftercontent .= "</div>";


				$aftercontent .= "<div class='mingrana-container' style='overflow:hidden;width:100%;border-size: border-box;border-radius:0px; padding:20px;background-color:#000;color: #fff;font-size: 0.8em;word-wrap: break-word;border-top: 20px solid #000;'>";
				$aftercontent .= "<div class='mingrana-logo' style='width:10%;float:left;border-size: border-box;padding: 10px;'>";
				$aftercontent .= "<svg width='100%' height='auto' enable-background='new 0 0 283.46 283.46' version='1.1' viewBox='0 0 155.86 204.07' xml:space='preserve' xmlns='http://www.w3.org/2000/svg' xmlns:cc='http://creativecommons.org/ns#' xmlns:dc='http://purl.org/dc/elements/1.1/' xmlns:rdf='http://www.w3.org/1999/02/22-rdf-syntax-ns#'><title>Logo mingrana</title><metadata><rdf:RDF><cc:Work rdf:about=''><dc:format>image/svg+xml</dc:format><dc:type rdf:resource='http://purl.org/dc/dcmitype/StillImage'/><dc:title>Logo mingrana</dc:title></cc:Work></rdf:RDF></metadata><g transform='translate(-63.8,-39.693)'><path d='m84.038 99.166-0.011 85.131c0 5.822-4.739 10.557-10.56 10.557h-9.341v21.977h12.837v0.283h0.488v26.373h21.77v-26.657h31.052v0.283h0.488v26.373h12.842v0.281h9.417v-26.654h31.052v26.654h22.264v-26.654h13.324v-22.26h-9.68c-5.82 0-10.56-4.734-10.56-10.557l0.012-85.131c0-5.821 4.738-10.56 10.56-10.56h9.343v-22.257h-13.33v-26.655h-22.258v26.655h-31.052v-26.655h-22.259v26.655h-31.051v-26.655h-22.255v26.655h-13.33v22.258h9.679c5.824-1e-3 10.559 4.738 10.559 10.56z' fill='#9d9d9c'/><polygon points='111.09 181.78 111.09 127.97 141.96 171.52 172.37 128.13 172.37 181.78 180.66 181.78 180.66 101.68 141.94 157.02 102.79 101.73 102.79 181.78' fill='#fff'/></g></svg>";
				$aftercontent .= "</div>";

				$aftercontent .= "<div class='mingrana-texto' style='width:90%;float:left;border-size: border-box;padding: 10px;'><p>Este <a rel='nofollow' href='https://etherscan.io/tx/" .  $registro->transaction . "' target='_blank' title='HASH " . $registro->hash_256 . "'>post y su contenido</a> han sido registrados en la <a rel='nofollow' href='https://etherscan.io/tx/" .  $registro->transaction . "' target='_blank' title='Transation " . $registro->transaction . "'>BlockChain Ethereum</a> por <strong>Mingrana Bring to Chain<strong></p>";
				$aftercontent .= "</div>";
				$aftercontent .= "</div>";
						//break;
					 
							$upload_dir = wp_upload_dir(); 
						$url = $upload_dir['baseurl'] . '/mingrana/' . $registro->pdf;
						$aftercontent .= "<div style='font-size: 0.8em;'>
						<p>Este <a rel='nofollow' href='https://etherscan.io/tx/" .  $registro->transaction . "' target='_blank' title='HASH " . $registro->hash_256 . "'>post y su contenido</a> han sido registrados en la <a rel='nofollow' href='https://etherscan.io/tx/" .  $registro->transaction . "' target='_blank' title='Transation " . $registro->transaction . "'>BlockChain Ethereum</a> por <strong>Mingrana Bring to Chain<strong></p>";						
						$aftercontent .= "</div>";

						break;
					default:
						# code...
						break;
				}	
				

			} 

			
		}

		   	
		
		// Show stamp if is configured

		if ($this->showstamp() == false) return  $content;
		
		

		$fullcontent =  $content . $aftercontent;

		return $fullcontent;

	}

}
