<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div id="wrap">

<?php 


	global $wpdb;
	$page = isset($_REQUEST['page'])?$_REQUEST['page']:'';
	$mode = isset($_REQUEST['mode'])?$_REQUEST['mode']:'';
	
	
	$limit = 10;
	$adjacents = 2;  
	$targetpage = admin_url( 'admin.php?page=banner' );
	$condition = "";
	$total_records = aparnf_count_records();
	$total_pages     = $total_records/$limit;
	
	
	
	
	$pageid = $_GET['pageid'];
	if($pageid) 
		$start = ($pageid - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;	
		

/* ---------  Custom Function start here ------------ */
function aparnf_count_records()
{ global $wpdb;
	$res = $wpdb->get_results("select * from ".$wpdb->prefix."reg_form WHERE 1= 1 order by id DESC ", OBJECT);
	return count($res);	
}

function aparnf_get_status($id)
{ global $wpdb;
	$result = $wpdb->get_results("select list_status from ".$wpdb->prefix."reg_form WHERE id = '$id' ", OBJECT);
	foreach( $result as $entry ) {
		$list_order = $entry->list_status;
	}
	return $list_order;	
}


/* ---------  Custom Function ends here ------------ */
	
	
if($mode=='delete')
{
	$wpdb->query("delete from ".$wpdb->prefix."reg_form where id=$_REQUEST[pid]");
}





if($mode=='changeStatus')
{
	$result = $wpdb->get_results("select list_status from ".$wpdb->prefix."reg_form WHERE id = $_REQUEST[pid]", OBJECT);
	foreach( $result as $entry ) {
		if($entry->list_status == '1')
			{ $status_change_to = '0';
			  $status_change_message = 'Row successfully unpublished.';	
			}
		else{
			$status_change_to = '1';
			$status_change_message = 'Row successfully published.';	
			}	
		$wpdb->update($wpdb->prefix.'reg_form',array('list_status'=>$status_change_to),array('id'=>$_REQUEST['pid']));
	}
	
	
}


$result =  $wpdb->get_results("SELECT `page_title`,`page_url` ,COUNT(*) as total from ".$wpdb->prefix."reg_form GROUP BY page_url order by count(*) DESC"); 
				
?>
<div class="wrap"><h2>  Registration Summary
 
<span id="wp_paginate" > <div class="pagination-holder"><ul>  <?php 
require aparnf_FOLDER . 'paginations.php';
		   					echo $pagination;
		 ?> </ul> </div> </span> 
</h2>



</div>

<?php
if(isset($_REQUEST['status'])) : ?>
	<div id="message" class="updated" style="margin-left:0;">
    <?php if(isset($_REQUEST['status']) && $_REQUEST['status'] == 'add') { echo '<p>Banner successfully added.</p>';} ?>  
     <?php if(isset($_REQUEST['status']) && $_REQUEST['status'] == 'update') { echo '<p>Banner successfully updated.</p>';} ?> 
     <?php if(isset($_REQUEST['status']) && $_REQUEST['status'] == 'changeStatus') { echo '<p>'.$status_change_message.'</p>';} ?>  	
    </div>
<?php
	  endif; 
?>

<table class="widefat fixed comments">
    <thead>
    	<tr>
            <th width="5%">S.No.</th>
            <th width="13%">Page Title </th>
            <th width="19%"> Page Url</th>
             <th width="8%">Total</th>
            
    	</tr>
    </thead>
    
    <tbody>
    
    <?php if( $result ) { ?>
 
            <?php
            $count = 1;
            $class = '';
            foreach( $result as $entry ) {
               ?>
 
            <tr<?php echo $class; ?>>
                <td><?php echo (($pages->current_page -1) * $pages->items_per_page) + $count; ?></td>
                <td><?php echo $entry->page_title; ?></td> 
                <td><a href="<?php echo $entry->page_url; ?>" target="_blank"><?php echo $entry->page_url; ?></a></td> 
               
                            
               
                
                
			   
                
                
             
              <td><?php echo $entry->total; ?></td> 
            </tr> 
            <?php
                $count++;
            }
            ?>
 
        
       
    <?php } ?>
    </tbody>
    
    <tfoot>
        <tr>
             <th width="5%">S.No.</th>
            <th width="13%">Page Title </th>
            <th width="19%"> Page Url</th>
             <th width="8%">Total</th>

    	</tr>
    </tfoot>
    
 </table>

</div>
