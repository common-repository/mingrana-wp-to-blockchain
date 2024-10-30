<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.mingrana.com/
 * @since      1.0.0
 *
 * @package    Mingrana_Wp
 * @subpackage Mingrana_Wp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mingrana_Wp
 * @subpackage Mingrana_Wp/admin
 * @author     Mingrana SL <info@mingrana.com>
 */

class Mingrana_Wp_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */

	public function enqueue_styles() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mingrana_Wp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mingrana_Wp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mingrana-wp-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mingrana-wp-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

	    /*
	     * Add a settings page for this plugin to the Settings menu.
	     *
	     * 
	     */
	    add_options_page( 'WP Mingrana ', 'Mingrana WP', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
	    );
	}

	 /**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {

	    /*
	    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	    */

	   $settings_link = array(
	    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
	    include_once( 'partials/mingrana-wp-admin-display.php' );
	}

	/**
	 * Update the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function options_update() {
		
    	register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
 	}

	/**
	 * Validate the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function validate($input) {

	    // All checkboxes inputs        
	    $valid = array();

	    //Cleanup

	    $valid['email'] = (isset($input['email']) && !empty($input['email'])) ? $input['email'] : '';
	    $valid['apikey'] = (isset($input['apikey']) && !empty($input['apikey'])) ? $input['apikey'] : '';
	    $valid['showstamp'] = (isset($input['showstamp']) && !empty($input['showstamp'])) ? $input['showstamp'] : 0;

	    return $valid;
 	}

 	/**
	 * Add metabox to admin edit post page
	 *
	 * @since    1.0.0
	 */

 	public function cyb_meta_boxes() {
    	add_meta_box( 'cyb-meta-box', __( 'Mingrana Bring to BlockChain', 'cyb_textdomain' ), array($this,'cyb_meta_box_callback'), 'post','side' );
	}

	/**
	 * Callback for metabox
	 *
	 * @since    1.0.0
	 */

	public function cyb_meta_box_callback($post) {

		$post_mingrana = $this->get_mingrana_post($post->ID);
		
		echo "<table style='width:100%;max-width: 100%;'>";
			echo "<tr>";
				echo "<td>";
					echo "Status:";
				echo "</td>";
				echo "<td id='mingrana_status'>";
					echo $this->get_mingrana_status($post_mingrana->status);
				echo "</td>";
		echo "</tr>";		
	    
		switch ($post_mingrana->status) {
			case 0:
			case 1:
				echo "<tr>";
				echo "<td colspan='2' style='text-align:left'>";
					echo "<button class='components-button is-button is-primary' id='mingrana_register' value='". $post->ID ."'>" . __('REGISTER IN BLOCKCHAIN','mingrana-wp') . "</button>";
				echo "</td>";
				echo "</tr>";
				if ($post_mingrana->pdf !== null && $post_mingrana->pdf !="") {
					echo "<tr>";
				echo "<td>";
					echo "Pdf:";
				echo "</td>";
				echo "<td id='mingrana_pdf'>"; 
					echo $post_mingrana->pdf;
				echo "</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>";
					echo "Hash:";
				echo "</td>";
				echo "<td id='mingrana_hash'>";
					echo $post_mingrana->hash_256;
				echo "</td>";
				echo "</tr>";

				}
				break;
			case 2:
				if ($post_mingrana->pdf !== null && $post_mingrana->pdf !="") {
					echo "<tr>";
				echo "<td>";
					echo "Pdf:";
				echo "</td>";
				echo "<td>";
					echo $post_mingrana->pdf;
				echo "</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>";
					echo "Hash:";
				echo "</td>";
				echo "<td>";
					echo $post_mingrana->hash_256;
				echo "</td>";
				echo "</tr>";

				}
				break;
			case 3:
				echo "<tr>";
				echo "<td>";
					echo "Pdf:";
				echo "</td>";
				echo "<td>";
					echo $post_mingrana->pdf;
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "Hash:";
				echo "</td>";
				echo "<td>";
					echo $post_mingrana->hash_256;
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td>";
					echo "Txt:";
				echo "</td>";
				echo "<td>";
					echo $post_mingrana->transaction;
				echo "</td>";
			echo "</tr>";
				break;
			
			default:
				
				break;
		}

	    echo "</table>";

	}


	/**
	 * Create PDF when send form in metabox
	 * Send to Mingrana Server
	 *
	 * @since    1.0.0
	 */

	public function send_form() {

		$id = $_GET['id'];

		$post = get_post( $id, ARRAY_A );
		$content = $post['post_content'];
		$content_f = apply_filters('the_content', $content);
		
		$doc = new DOMDocument();

		@$doc->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

		$tags = $doc->getElementsByTagName('img');

		$images = array();

		$n=0;

		foreach ($tags as $tag) {
		       $image = array();
		       $image['src'] = $tag->getAttribute('src');
		       $image['alt'] = $tag->getAttribute('alt');
		       $image['longdesc'] = $tag->getAttribute('longdesc'); 
		       $images[]=$image;	   						           
		}


		$i = $tags->length - 1;
		$n=1;
		while ($i > -1) { 
		    $node = $tags->item($i); 
		    $n = $i+1;
		    if ($node->hasAttribute('alt') && $node->getAttribute('alt') != '') {
		        $replacement = '[IMG ' . $n . ']: ('.$node->getAttribute('alt').')';
		    }
		    else {
		        $replacement = '[IMG ' . $n . ']';
		    } 

		    $text = $doc->createTextNode($replacement."\n");
		    $node->parentNode->replaceChild($text, $node);
		    $i--; 
		} 

		$content_no_img = $doc->saveHTML($doc->documentElement);

		$content = "<h1>" . $post['post_title'] . "</h1>" . $content_no_img;
		$content .= "<h2>" . __('ATTACHMENTS', 'mingrana-wp') . "</h2>";
		$content .= "<p><strong>URL: </strong>" . $post['guid'] .  "</p>";
		$content .= "<p><strong>" . __('PUBLISHED ON', 'mingrana-wp') . ": </strong>" . $post['post_date'] . "</p>";

		$i = 0;
		foreach ($images as $key_img => $img) {
			$i++;
		       $content .= "<p>" . __('Image', 'mingrana-wp') . " " . $i . ": " . $img['alt'] .  "</p><p>" . $img['longdesc'] . "</p><p><img style='max-width:100%;height: auto;' src='" . $img['src'] . "'></p>";
		}
		
		$class = "Dompdf\Dompdf";

		if (!class_exists($class)) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/lib/dompdf/autoload.inc.php';
		}
		

		// Instantiate and use the dompdf class

		$dompdf = new Dompdf\Dompdf();
		$dompdf->set_option('defaultFont', 'Courier');
		$dompdf->set_option('isRemoteEnabled', TRUE);

		// Load HTML content

		$dompdf->loadHtml($content);

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$output = $dompdf->output();

		$upload_dir = wp_upload_dir();

		$path_mingrana = $upload_dir['basedir'] . '/mingrana/';

		$file_pdf_name = 'post_ID_' . $id . date('_Ymd-his_') . $post['post_name'] . '.pdf';

		if (!file_exists($path_mingrana)) {
		    mkdir($path_mingrana, 0755, true);
		}
		
		file_put_contents($path_mingrana . $file_pdf_name, $output);

		$hash = hash_file ( 'sha256' , $path_mingrana . $file_pdf_name );

		global $table_prefix, $wpdb;

		$tblname = 'mingrana';
    	
    	$mingrana_wp_table = $table_prefix . $tblname;

		$success = $wpdb->insert($mingrana_wp_table, array(
		   "post_id" => $id,
		   "hash_256" => $hash,
		   "pdf" => $file_pdf_name,
		   "created_at" => date('Y-m-d h:i:s') ,
		));

		echo $this->send_mingrana($id);

		//echo $success;


		wp_die();

	}

	/**
	 * Send PDF to Mingrana Server in order to proccess by Notarius
	 * 
	 *
	 * @since    1.0.0
	 */

	public function send_mingrana($id=0) { 
		
		$id = $_GET['id'];

		$post_mingrana = $this->get_mingrana_post($id);

		$origin =  get_site_url();
		$description = "POST " . $id . " FROM " . get_site_url();
		$hash_sha256 = $post_mingrana->hash_256;
		$file_name = $post_mingrana->pdf;
		$upload_dir = wp_upload_dir();
		$path_mingrana = $upload_dir['basedir'] . '/mingrana/';
		$file_path = $path_mingrana . $file_name;
		$filedata =  file_get_contents($file_path);
		$file = base64_encode($filedata);
		

		$data = ['hash_sha1'  => '-',
				'hash_sha256'  => $hash_sha256,
				'hash_md5'  => '-',
				'description'  => $description,
				'app'  => 'plugin',
				'origen' => $origin,
				'origen_id' => $id,
				'file' => $file ,
				'file_name' => $file_name ];

		$result = $this->send_register($data);

		if (isset($result['result']) && $result['result'] == 'success') {

		$this->update_local(array('origen_id' => $id,'block' => '',
    			'transaction' => '',
    			'status' => 1));
		return json_encode(array('result' => 'success','message' =>   __('You post was sent to Mingrana Server. You will receive an email when it is registered in the blockchain.', 'mingrana-wp') ,'hash' => $hash_sha256, 'file' => $file_name,'status' => $this->get_mingrana_status(2)));
		}

		if (isset($result['result']) && $result['result'] == 'error') return json_encode(array('result' => 'error','message' =>  $result['message']));

		wp_die();
		


	}

	public function after_save_post($id) {

		return false;

		if (   wp_is_post_revision( $id) || wp_is_post_autosave( $id )  )
			return;

		$post = get_post( $id, ARRAY_A );
		$content = $post['post_content'];
		$content_f = apply_filters('the_content', $content);
		
		

		$doc = new DOMDocument();
		@$doc->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

		$tags = $doc->getElementsByTagName('img');

		$images = array();

		$n=0;

		foreach ($tags as $tag) {
		       $image = array();
		       $image['src'] = $tag->getAttribute('src');
		       $image['alt'] = $tag->getAttribute('alt');
		       $image['longdesc'] = $tag->getAttribute('longdesc'); 
		       $images[]=$image;	   						           
		}


		$i = $tags->length - 1;
		$n=1;
		while ($i > -1) { 
		    $node = $tags->item($i); 
		    $n = $i+1;
		    if ($node->hasAttribute('alt') && $node->getAttribute('alt') != '') {
		        $replacement = '[IMG ' . $n . ']: ('.$node->getAttribute('alt').')';
		    }
		    else {
		        $replacement = '[IMG ' . $n . ']';
		    } 

		    $text = $doc->createTextNode($replacement."\n");
		    $node->parentNode->replaceChild($text, $node);
		    $i--; 
		} 

		$content_no_img = $doc->saveHTML($doc->documentElement);

		$content = "<h1>" . $post['post_title'] . "</h1>" . $content_no_img;
		$content .= "<h2>" . __('ATTACHMENTS', 'mingrana-wp') . "</h2>";
		$content .= "<p><strong>URL: </strong>" . $post['guid'] .  "</p>";
		$content .= "<p><strong>" . __('PUBLISHED ON', 'mingrana-wp') . ": </strong>" . $post['post_date'] . "</p>";

		$i = 0;
		foreach ($images as $key_img => $img) {
			$i++;
		       $content .= "<p>Imagen " . $i . ": " . $img['alt'] .  "</p><p>" . $img['longdesc'] . "</p><p><img style='max-width:100%;height: auto;' src='" . $img['src'] . "'></p>";
		}
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/lib/dompdf/autoload.inc.php';

		// Instantiate and use the dompdf class
		$dompdf = new Dompdf\Dompdf();
		$dompdf->set_option('defaultFont', 'Courier');
		$dompdf->set_option('isRemoteEnabled', TRUE);

		// Load HTML content
		$dompdf->loadHtml($content);

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$output = $dompdf->output();

		require_once(ABSPATH . 'wp-admin/includes/file.php');

		$upload_dir = wp_upload_dir();

		$path_mingrana = $upload_dir['basedir'] . '/mingrana/';

		$file_pdf_name = 'post_ID_' . $id . date('_Ymd-His_') . $post['post_name'] . '.pdf';

		if (!file_exists($path_mingrana)) {

		    mkdir($path_mingrana, 0755, true);
		} else {

		}
		
		file_put_contents($path_mingrana . $file_pdf_name, $output);

		$hash = hash_file ( 'sha256' , $path_mingrana . $file_pdf_name );

		global $table_prefix, $wpdb;

		$tblname = 'mingrana';
    	$mingrana_wp_table = $table_prefix . $tblname;

		$success = $wpdb->insert($mingrana_wp_table, array(
		   "post_id" => $id,
		   "hash_256" => $hash,
		   "pdf" => $file_pdf_name,
		   "created_at" => date('Y-m-d H:i:s') ,
		));

		return true;

	}

	public function get_account_data() {

		// TODO: recoger datos de la API, Actualizar y pasarlos para que se vean en el panel administrativo.

		$options = get_option($this->plugin_name);


		$url_api = 'https://app.mingrana.com/api';
		$api_key = $options['apikey'];
		$url_blog = get_site_url();

		$m = new Mingrana_Server($url_api,$api_key,$url_blog);


		$balance = $m->balance();

		$registers = $m->registers();

		$blog_registers = array();
		
		if (is_array($registers)) {
		foreach ($registers as $r) {

			$register = array("id" => $r["id"],
							  "post_id" => $r["origen_id"],
							  "hash_256" => $r["hash_sha256"],
                           	  "block" => $r["n_block"],
                           	  "transaction" => $r["tx_hash"],
                           	  "register_at" => $r["updated_at"],
                           	  "status" => $r["status"],
                           	  "pdf" => $this->get_mingrana_post($r["origen_id"])->pdf);

			array_push($blog_registers, $register);

		}
	}

		$noreg = array( "registered" => ( $m->info['success'] == true ? true : false ),
						"balance" => $balance,
						"pending" => $this->pending_registers(),
						"registers" => $blog_registers,
						"registers_server" => $registers);

		return $noreg;

	}


	public function pending_registers() {

		/* Returns how many registers are pending to hash in blockchain*/
				
		/* 
		   STATUS
		   0: No protected
		   1: No protected. No send
		   2: Pregister penging
		   3: Registered
		*/

		global $table_prefix, $wpdb;

		$tblname = 'mingrana';
    	$mingrana_wp_table = $table_prefix . $tblname;

    	$registers_pending = $wpdb->get_results("SELECT * FROM " . $mingrana_wp_table . " WHERE status=2;");


    	return count($registers_pending);


	}

	public function update_local($reg_server = false) {

		global $table_prefix, $wpdb;

		$tblname = 'mingrana';
    	$mingrana_wp_table = $table_prefix . $tblname;

    	if ($reg_server == false) return false;

    	if ($reg_server['status'] == 2) {
    		$status = 3;
    	} else {
    		$status = 2;
    	}

    	$data =  array(
    			'block' => $reg_server['n_block'],
    			'transaction' => $reg_server['tx_hash'],
    			'status' => $status
    			);
    	$where = array('post_id' => $reg_server['origen_id']);



    	return $wpdb->update($mingrana_wp_table, $data, $where);


	}



	public function update_local_registers() {


		/* If there are not pending registers */

		if ( $this->pending_registers() == 0 ) return true;


		/* If there are pending registers */

		/* Connect to server and get status */

		$data_server = $this->get_account_data();

		$reg_server = $data_server['registers_server'];

		if (is_array($reg_server)) {
			foreach ($reg_server as $key => $reg) {
				$this->update_local($reg);
 			}
		}

	}


	public function send_register($data = array()) {

		$options = get_option($this->plugin_name);

		$url_api = 'https://app.mingrana.com/api';
		$api_key = $options['apikey'];
		$url_blog = get_site_url();

		$m = new Mingrana_Server($url_api,$api_key,$url_blog);

		$balance = $m->balance();

		$result = $m->send_register($data);

		return $m->info;

	}


	public function set_mingrana_column($columns) {
		$columns['mingrana_status'] = 'Authorship';
    	return $columns;
	}

	public function get_mingrana_post($post_id) {

		global $table_prefix, $wpdb;

			$tblname = 'mingrana';
    		$mingrana_wp_table = $table_prefix . $tblname;

    		$sql = "SELECT * FROM $mingrana_wp_table WHERE post_id = " .  $post_id . " ORDER BY id DESC LIMIT 1";

			$registro = $wpdb->get_row( $sql ); 

		return $registro;
	}

	public function get_mingrana_status($status) {

		switch ($status) {
        		case 2 :
        			return "<span style='display:inline-block;width: 16px; height: 16px; background-color: orange; border-radius: 8px;margin-right:10px;'></span><span style='color:orange;'>" . __('Pending', 'mingrana-wp') . "</span>";
        			return "<span style='display:inline-block;width: 16px; height: 16px; background-color: orange; border-radius: 8px;margin-right:10px;'></span><span style='color:orange;'>" . __('Pending', 'mingrana-wp') . "</span>&nbsp;<a href='" . admin_url( "options-general.php?page=mingrana-wp&refresh" ) . "' title='" . __('Refresh Status', 'mingrana-wp'). "' style='color:#000'><span class='dashicons dashicons-image-rotate'></span></a>";
        			break;
        		case 3 :
        			return "<span style='display:inline-block;width: 16px; height: 16px; background-color: green; border-radius: 8px;margin-right:10px;'></span><span style='color:green;'>" . __('Protected', 'mingrana-wp') . "</span>";
        			break;
        		default:
        			return "<span style='display:inline-block;width: 16px; height: 16px; background-color: red; border-radius: 8px;margin-right:10px;'></span><span style='color:red;'>" . __('No Protected', 'mingrana-wp') . "</span>";
        			break;
        	}

	}

	public function custom_mingrana_column( $column, $post_id ) {
    
    switch ( $column ) {

        case 'mingrana_status' :
        	// TODO: Crear una función que dependiendo del estado muestre un color u otro 

        	$post_mingrana = $this->get_mingrana_post($post_id);

        	if ($post_mingrana->status == 2) {

				$MN = New Mingrana_Wp();
				$MNA = new Mingrana_Wp_Admin( $MN->get_plugin_name(), $MN->get_version() );
        		$MNA->update_local_registers();

        	}

        	echo  $this->get_mingrana_status($post_mingrana->status);


            break;

    }
}

}
