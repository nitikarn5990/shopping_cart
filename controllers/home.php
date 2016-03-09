
<div class="row">
    <?php include 'inc/slides.php'; ?>
</div>
<div class="row" style="  padding-bottom: 15px;">
    <?php 

		$sql = "SELECT * FROM " . $ads->getTbl() . " WHERE status = 'ใช้งาน' ORDER BY sort ASC ";
		
		$query = $db->Query($sql);
		$i = 0;
        while($row = $db->FetchArray($query)){ 
		$i += 1;
			if($i == 2){ ?>
				 <div class="col-sm-4 text-center">  
					<iframe  src="https://www.youtube.com/embed/9Hwjhj42_Yg" frameborder="0" allowfullscreen style="max-width:100%; height:300px;"></iframe>
				 </div>
			<?php }
			
			if( $row['link_to'] != '' ){
				$arr_link =  explode("-", $row['link_to']);
				$arr_cat = $arr_link[0];
				$arr_id = $arr_link[1];
				
				if($arr_cat == 'product'){
					$pro_id = $arr_id ;
					$cat_id = $products->getDataDesc("category_id", "id = ".$pro_id) ;
					
					$cat_name_ref = $category->getDataDesc("category_name_ref", "id = ".$cat_id);
					$res_link = ADDRESS . "product/". $cat_name_ref . "/" .$products->getDataDesc("product_name_ref", "id = ".$arr_id) . ".html";
				
				}
				if($arr_cat == 'category'){
					
					$res_link = ADDRESS . "product/" .$category->getDataDesc("category_name_ref", "id = ".$arr_id) . ".html";
					
				}
			}
			?>
         		
    		<div class="col-sm-4 text-center"> <a href="<?php echo $res_link == '' ? '#' : $res_link  ?>"><img class="img-responsive" src="<?php echo ADDRESS_ADS . $ads_files->getDataDescLastID("file_name", "ads_id = ". $row['id']) ?>" alt="<?php echo  $ads_files->getDataDescLastID("alt_tag", "ads_id = ". $row['id']) ?>" style="width:319px;"></a> </div>
    <?php }?>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="product-name">
            <h1 class="title-bar">INFORMATION
                <div class="title-border"></div>
            </h1>
        </div>
    </div>
</div>
<div class="row">
    <p>&nbsp;</p>
    <div class="col-md-9 col-xs-12"> 
    <?php 

		$sql = "SELECT * FROM " . $blog->getTbl() . " WHERE status = 'ใช้งาน' ORDER BY id DESC";
		
		$query = $db->Query($sql);
		$i = 0;
        while($row = $db->FetchArray($query)){  ?>
        
               <div id="blog-article" class="col-xs-12"  style="  padding: 0 0;">
                <div class="col-xs-12 blog-title">
                    <div class="col-xs-12"><a href="<?php echo ADDRESS ."blog/". $blog_category->getDataDesc("category_name_ref", "id =".$row['blog_category_id'] )  . "/" . $row['blog_name_ref'] . ".html"?>" title="<?php echo $row['blog_name'] ?>"> <?php echo  str_replace("../files", "files", $row['blog_cover'] ); ?> </a></div>
                    <div class="col-xs-12"><a href="<?php echo ADDRESS ."blog/". $blog_category->getDataDesc("category_name_ref", "id =".$row['blog_category_id'] ) . "/" . $row['blog_name_ref'] . ".html"?>" title="<?php echo $row['blog_name'] ?>" style="text-decoration:none;">
                        <h2> <?php echo $row['blog_name'] ?></h2>
                        </a></div>
                    <div class="col-xs-12" style="  padding-bottom: 15px;"> <?php echo $row['blog_short_detail'] ?> </div>
                    <div class="col-xs-12" style="  border-top: 1px solid#EDEDED; padding-left: 0px ; padding-right: 0px; padding-top: 10px;">
                        <div class="col-xs-9"> <i class="fa fa-folder-open"></i> <a href="<?php echo ADDRESS ."blog/". $blog_category->getDataDesc("category_name_ref", "id =".$row['blog_category_id'] ) .  ".html"?>" title="<?php echo $blog_category->getDataDesc("category_name_ref", "id =".$row['blog_category_id'] ) ?>"> <?php echo $blog_category->getDataDesc('category_name',"id = " . $row['blog_category_id']); ?> </a> </div>
                        <div class="col-xs-3 text-right">
                     
                            <a class="btn btn-primary " href="<?php echo ADDRESS ."blog/". $blog_category->getDataDesc("category_name_ref", "id =".$row['blog_category_id'] ) . "/" . $row['blog_name_ref'] . ".html"?>" title="<?php echo $blog_category->getDataDesc("category_name_ref", "id =".$row['blog_category_id'] ) ?>"> อ่านต่อ</a>
                            
                        </div>
                    </div>
                </div>
                <p>&nbsp; </p>
            </div>
        
        
        
        <?php }?>
	
	<?php // echo $home->getDataDesc("home_detail", "id = 1") ?>
    
    
    </div>
    <div class="col-md-3 col-xs-12">
       
   		<?php include "inc/side_category.php" ;?>
        
   
    </div>
    <p>&nbsp;</p>
</div>
	<style>
      @media (min-width: 100px) and (max-width: 480px) {
		  .btn{
			  padding:5px !important;
			}
			
	  }


a > h2  { font-size:30px; text-decoration:none;}


.blog-title{
	
	  padding: 10px;
  border: 1px solid #EDEDED;
  -webkit-box-shadow: 0px 2px 5px -1px rgba(184, 184, 184, 0.32);
  -moz-box-shadow: 0px 2px 5px -1px rgba(184, 184, 184, 0.32);
  box-shadow: 0px 2px 5px -1px rgba(184, 184, 184, 0.32);
  border-radius: 5px;
}
</style>
<style>
      @media (min-width: 100px) and (max-width: 480px) {
		  .btn{
			  padding:5px !important;
			}
			
	  }


a > h2  { font-size:30px; text-decoration:none;}


.blog-title{
	
	  padding: 10px;
  border: 1px solid #EDEDED;
  -webkit-box-shadow: 0px 2px 5px -1px rgba(184, 184, 184, 0.32);
  -moz-box-shadow: 0px 2px 5px -1px rgba(184, 184, 184, 0.32);
  box-shadow: 0px 2px 5px -1px rgba(184, 184, 184, 0.32);
  border-radius: 5px;
}
</style>
