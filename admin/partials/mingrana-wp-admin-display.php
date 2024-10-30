<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.mingrana.com/
 * @since      1.0.0
 *
 * @package    Mingrana_Wp
 * @subpackage Mingrana_Wp/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
     <?php 
        $MN = New Mingrana_Wp();
        $MNA = new Mingrana_Wp_Admin( $MN->get_plugin_name(), $MN->get_version() );
        $MNA->update_local_registers();
        $account_data = $MNA->get_account_data();
        
        $status = array ( 0 => __('No protected', 'mingrana-wp'),
                          1 => __('Register pending', 'mingrana-wp'),
                          2 => __('Protected', 'mingrana-wp'));

        $action = array ( 0 => __('Send to Mingrana', 'mingrana-wp'),
                          1 => __('Be patient', 'mingrana-wp'),
                          2 => __('You can rest asure', 'mingrana-wp'));

    ?>
<div style="width:20%;float:left;box-sizing:border-box;padding:20px;">
    <a href="<?php echo admin_url( "options-general.php?page=".$_GET["page"] . "&refresh" );?>" class="button button-primary"><?php echo __('Refresh status', 'mingrana-wp');?></a>
</div>
<div style="width:20%;float:left;box-sizing:border-box;padding:20px;">
    <table class="wp-list-table widefat fixed striped" style="width:300px;float:right;">
        <thead>
            <tr>
                <th style="text-align: center;"><strong>API KEY</strong></th>
                <th style="text-align: center;"><strong>BALANCE</strong></th> 
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;"><?php echo ( $account_data['registered'] != 1 ? "<span style='color:red;font-weight:bold'>K.O.</span>" : "<span style='color:green;font-weight:bold'>OK</span>");?></td>
                <td style="text-align: center;"><span style="font-size: 2em;"><?php echo $account_data['balance']; ?></span></td>

            </tr>
        </tbody>
    </table>
</div>
<div style="width:50%;float:left;box-sizing:border-box;padding:20px;">
    <form method="post" name="mingrana-wp_options" action="options.php">

    	 <?php
        //Grab all options
        $options = get_option($this->plugin_name);

        // Cleanup
        $test = $options['test'];
        $email = $options['email'];
        $apikey = $options['apikey'];
        $showstamp = $options['showstamp'];
        if ( $options == false ) $showstamp = 1;
		    ?>
		    <?php
		        settings_fields($this->plugin_name);
		        do_settings_sections($this->plugin_name);
            ?>

         <fieldset>
            <table>
                <tr>
                    <td><label style="display:inline-block;width:60px;" for="<?php echo $this->plugin_name; ?>-email"><span><?php esc_attr_e('Email', $this->plugin_name); ?></span></label></td>
                    <td><input type="text" id="<?php echo $this->plugin_name; ?>-email" name="<?php echo $this->plugin_name; ?>[email]" value="<?php echo $email;?>" size="50"/>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td> <label style="display:inline-block;width:60px;" for="<?php echo $this->plugin_name; ?>-apikey"><span><?php esc_attr_e('Api Key', $this->plugin_name); ?></span></label>
                    </td>
                    <td><input type="text" id="<?php echo $this->plugin_name; ?>-apikey" name="<?php echo $this->plugin_name; ?>[apikey]" value="<?php echo $apikey;?>" size="50"/>  
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-showstamp" name="<?php echo $this->plugin_name; ?>[showstamp]" value="1" <?php echo ($showstamp == 1 ? "checked" : "");?>><label for="<?php echo $this->plugin_name; ?>-showstamp">Mostrar sello de registro al final del post</label></td>
                    <td><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo __('Save all changes', 'mingrana-wp');?>"></td>
                </tr>

            </table>
            <br/>
           
            
            
            
        </fieldset>
        <!-- remove some meta and generators from the <head> -->
		

    </form>
</div>

    <?php if(isset($_GET['refresh'])) { ?>
        <div class="notice notice-info is-dismissible">
            <p><?php echo __('Registers updated.', 'mingrana-wp');?></p>
        </div>
    <?php } ?>

    <?php if ( $account_data['registered'] != 1) { ?>

         <div class="notice notice-error is-dismissible">
            <p><?php echo __('Api Key not valid.', 'mingrana-wp');?></p>
        </div>


    <?php } else { ?>

    <?php if ($options['apikey'] == ""): ?>
         <div class="notice notice-info is-dismissible">
            <p><?php echo __('Your <strong>Api Key is empty</strong>. If you do not have an Api Key, you can get one at', 'mingrana-wp');?>  <a href="https://mingrana.com/solicitar-prueba" target="_blank">Mingrana</a></p>
        </div>
    <?php else: ?>
        <?php if ($account_data['balance'] < 1) : ?>
            <div class="notice notice-warning is-dismissible">
                <p><?php echo __('Your account balance is 0. If you need credits, check your email account in order to obtain more.', 'mingrana-wp');?></p>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php } ?>

    <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr>
            <th><?php esc_attr_e('Title', $this->plugin_name); ?></th>
            <th><?php esc_attr_e('Status', $this->plugin_name); ?></th> 
            <th><?php esc_attr_e('Pdf', $this->plugin_name); ?></th>                     
            <th style="width:50%"><?php esc_attr_e('Register data', $this->plugin_name); ?></th>
            
            <!--<th><?php esc_attr_e('Action', $this->plugin_name); ?></th>-->
        </tr>
        </thead>
        <tbody>
            <?php foreach($account_data['registers'] as $register) { ?>
                <tr>
                    
                    <td><?php echo get_the_title($register['post_id']);?></td>
                    <td>
                        
                <?php switch ($register['status']) {
                case 1 :
                    echo "<span style='display:inline-block;width: 16px; height: 16px; background-color: orange; border-radius: 8px;margin-right:10px;'></span><span style='color:orange;'>" . __('Pending', 'mingrana-wp') . "</span>";
                    break;
                case 2 :
                    echo "<span style='display:inline-block;width: 16px; height: 16px; background-color: green; border-radius: 8px;margin-right:10px;'></span><span style='color:green;'>" . __('Protected', 'mingrana-wp') . "</span>";
                    break;
                default:
                    echo "<span style='display:inline-block;width: 16px; height: 16px; background-color: red; border-radius: 8px;margin-right:10px;'></span><span style='color:red;'>" . __('No Protected', 'mingrana-wp') . "</span>";
                } ?>
                        <?php //echo $status[$register['status']];?>
                        
                    </td> 
                    <td><?php echo $register['pdf'];?></td> 
                    <td><strong>HASH:</strong> <?php echo $register['hash_256'];?><br/><strong>TX:</strong> <?php echo $register['transaction'];?></td>
                                     
                    
                    
                    <!--<td>
                        <?php switch ($register['status']) {
                            case 1:
                                echo $action[$register['status']];
                                break;
                            case 2:
                                echo $action[$register['status']];
                                break;
                            
                            default:
                                echo $action[$register['status']];
                                break;
                        } ?>
                    </td> -->
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>