<?php
error_reporting(E_ERROR);
/*
Plugin Name: RAX - Google XML Sitemap
Plugin URI:  http://www.phpfreelancedevelopers.com/wordpress-rax-google-xml-sitemap/
Description: RAX - Google XML Sitemap will automatically generate xml sitemap whenever post or page is published/deleted. This helps to crowl your blog content, get the search engine optimization and get the more traffic from search engine. XML sitemap is made for Google Webmaster Tools. You just need to put the generated XML sitemap in your Google Webmaster Tools account.
Version: 1.0
Author: Rakshit Patel
Author URI: http://www.phpfreelancedevelopers.com
License: GPL2
*/

/*  Copyright 2010  Rakshit Patel  (email : raxit4u2@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

	// define options for form elements
	add_option("rax_google_sitemap_home_frequency","always");
	add_option("rax_google_sitemap_home_priority","0.1");
	add_option("rax_google_sitemap_other_frequency","always");
	add_option("rax_google_sitemap_other_priority","0.0");

	// call function to add link in menu
	add_action('admin_menu', 'rax_google_xml_sitemap_menu_options');
	
	// Generate sitemap when plugin activate publish post, publish page and trash ppst or page
	add_action ( 'activate_plugin', 'rax_google_xml_sitemap_generate' );
	add_action ( 'publish_post', 'rax_google_xml_sitemap_generate' );
	add_action ( 'publish_page', 'rax_google_xml_sitemap_generate' );
	add_action ( 'trashed_post', 'rax_google_xml_sitemap_generate' );

	
	function rax_google_xml_sitemap_menu_options() {
	
	  add_options_page('RAX - Google XML Sitemap', ' RAX - Google XML Sitemap', 'manage_options', 'rax-google-xml-sitemap-options', 'rax_google_xml_sitemap_options');
	
	}

	function rax_google_xml_sitemap_options() {
	
	  if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	  }
?>	
	  <div style="width:95%; font-size:11px; padding:3px 3px 3px 15px;">
	  <p style="font-size:20px; background-color:#4086C7; color:#FFF; width:94%; padding:2px;">Set Options for RAX - Google XML Sitemap</p>
	  <p>
			<form method="post" action="options.php">
				<?php wp_nonce_field('update-options');?>
				<table width="95%" border="0" cellspacing="8" cellpadding="0">
                  <tr>
                    <td align="left" valign="top" colspan="2" style="background-color:#E6FFE6; margin-right:10%; padding:1%;">[Copy below URL and submit it into your Google Webmaster tools account]<br /><strong>Sitemap URL:</strong>&nbsp;<?php echo get_option('siteurl').'/sitemap.xml';?></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" colspan="2"><input type="submit" value="<?php _e('Update Options')?>" /></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" colspan="2" style="background-color:#FFFFDD; margin-right:10%; padding:1%; font-weight:bold;">Set Change Frequency and Priority for Home page</td>
                  </tr>
                  <tr>
                  	<td width="20%" align="left" valign="top" style="padding-left:1%;">Change Frequency:</td>
                  	<td width="80%" align="left" valign="top">
						<?php
                           $rax_google_sitemap_home_frequency = get_option('rax_google_sitemap_home_frequency');
                        ?>
                    	<select name="rax_google_sitemap_home_frequency" id="rax_google_sitemap_home_frequency" style="width:80px;">
                           <option value="always" <?php if($rax_google_sitemap_home_frequency == "always") echo 'selected = "selected"'; ?>>always</option>
                           <option value="hourly" <?php if($rax_google_sitemap_home_frequency == "hourly") echo 'selected = "selected"'; ?>>hourly</option>
                           <option value="weekly" <?php if($rax_google_sitemap_home_frequency == "weekly") echo 'selected = "selected"'; ?>>weekly</option>
                           <option value="monthly" <?php if($rax_google_sitemap_home_frequency == "monthly") echo 'selected = "selected"'; ?>>monthly</option>
                           <option value="yearly" <?php if($rax_google_sitemap_home_frequency == "yearly") echo 'selected = "selected"'; ?>>yearly</option>
                           <option value="never" <?php if($rax_google_sitemap_home_frequency == "never") echo 'selected = "selected"'; ?>>never</option>
                        </select>
                    </td>
                  </tr>
                  <tr>
                  	<td align="left" valign="top" style="padding-left:1%;">Change Priority:</td>
                  	<td align="left" valign="top">
						<?php
                           $rax_google_sitemap_home_priority = get_option('rax_google_sitemap_home_priority');
                        ?>
                    	<select name="rax_google_sitemap_home_priority" id="rax_google_sitemap_home_priority" style="width:80px;">
                           <?php
						   	for($rax = 0.0; $rax <= 1; $rax = $rax + 0.1) {
						   ?>
                           <option value="<?php echo $rax;?>" <?php if($rax_google_sitemap_home_priority == $rax) echo 'selected = "selected"'; ?>><?php echo $rax;?></option>
                           <?php
						   	}
						   ?>
                        </select>
                    </td>
                  </tr>
                  
                  <tr>
                    <td align="left" valign="top" colspan="2" style="background-color:#FFFFDD; margin-right:10%; padding:1%; font-weight:bold;">Set Change Frequency and Priority for Other page</td>
                  </tr>
                  <tr>
                  	<td align="left" valign="top" style="padding-left:1%;">Change Frequency:</td>
                  	<td align="left" valign="top">
						<?php
                           $rax_google_sitemap_other_frequency = get_option('rax_google_sitemap_other_frequency');
                        ?>
                    	<select name="rax_google_sitemap_other_frequency" id="rax_google_sitemap_other_frequency" style="width:80px;">
                           <option value="always" <?php if($rax_google_sitemap_other_frequency == "always") echo 'selected = "selected"'; ?>>always</option>
                           <option value="hourly" <?php if($rax_google_sitemap_other_frequency == "hourly") echo 'selected = "selected"'; ?>>hourly</option>
                           <option value="weekly" <?php if($rax_google_sitemap_other_frequency == "weekly") echo 'selected = "selected"'; ?>>weekly</option>
                           <option value="monthly" <?php if($rax_google_sitemap_other_frequency == "monthly") echo 'selected = "selected"'; ?>>monthly</option>
                           <option value="yearly" <?php if($rax_google_sitemap_other_frequency == "yearly") echo 'selected = "selected"'; ?>>yearly</option>
                           <option value="never" <?php if($rax_google_sitemap_other_frequency == "never") echo 'selected = "selected"'; ?>>never</option>
                        </select>
                    </td>
                  </tr>
                  <tr>
                  	<td align="left" valign="top" style="padding-left:1%;">Change Priority:</td>
                  	<td align="left" valign="top">
						<?php
                           $rax_google_sitemap_other_priority = get_option('rax_google_sitemap_other_priority');
                        ?>
                    	<select name="rax_google_sitemap_other_priority" id="rax_google_sitemap_other_priority" style="width:80px;">
                           <?php
						   	for($rax = 0.0; $rax <= 1; $rax = $rax + 0.1) {
						   ?>
                           <option value="<?php echo $rax;?>" <?php if($rax_google_sitemap_other_priority == $rax) echo 'selected = "selected"'; ?>><?php echo $rax;?></option>
                           <?php
						   	}
						   ?>
                        </select>
                    </td>
                  </tr>
                  
				  <tr>
                    <td align="left" valign="top" colspan="2"><input type="submit" value="<?php _e('Update Options')?>" /></td>
                  </tr>
				</table>
				
				
				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="page_options" value="rax_google_sitemap_home_frequency,rax_google_sitemap_home_priority,rax_google_sitemap_other_frequency,rax_google_sitemap_other_priority" />
			</form>
	  </p>
	  </div>
<?php				
	
	}
	
	// Generrate the xml sitemap as per sitemaps.org
	function rax_google_xml_sitemap_generate() {
		 
		$filename = "../sitemap.xml";
			 
		$fp = fopen($filename,"w+") or die('error');
		global $wpdb;
		$rax_table = $wpdb->prefix . "posts";
		
		$rax_google_sitemap_home_frequency = get_option('rax_google_sitemap_home_frequency');
		$rax_google_sitemap_home_priority = get_option('rax_google_sitemap_home_priority');
		$rax_google_sitemap_other_frequency = get_option('rax_google_sitemap_other_frequency');
		$rax_google_sitemap_other_priority = get_option('rax_google_sitemap_other_priority');
		
		$rax_sql = "SELECT 	post_modified, 
							ID,
							post_title, 
							post_name, 
							post_parent 
					FROM ".$rax_table." 
					WHERE 	post_status = 'publish' 
							AND 
							(
							post_type = 'page' 
								OR post_type = 'post'
							) 
					ORDER BY post_date DESC";
					
		$rax_res_rows = $wpdb->get_results($rax_sql);
		
		$rax_xml_sitemap =  '<?xml version="1.0" encoding="UTF-8"?>
						<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		
		// for home page
		$rax_xml_sitemap .= "
						<url>
						  <loc>".get_option( 'siteurl' )."/</loc>
						  <lastmod>".date('Y-m-d')."</lastmod>
						  <changefreq>".$rax_google_sitemap_home_frequency."</changefreq>
						  <priority>".$rax_google_sitemap_home_priority."</priority>
						 </url>";
		
		// for posts and pages 
		foreach ($rax_res_rows as $rax_single) {
		
		$rax_last_mod_date = date('Y-m-d',strtotime($rax_single->post_modified));
		$rax_id = $rax_single->ID;
		$rax_url = get_permalink($rax_id);
	
		$rax_xml_sitemap .= "
						<url>
						  <loc>".$rax_url."</loc>
						  <lastmod>".$rax_last_mod_date."</lastmod>
						  <changefreq>".$rax_google_sitemap_other_frequency."</changefreq>
						  <priority>".$rax_google_sitemap_other_priority."</priority>
						 </url>";
		
		}
		
		$rax_xml_sitemap .= '
						</urlset>';
		
		
		fwrite($fp, $rax_xml_sitemap);
		fclose($fp);
	}
?>