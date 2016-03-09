
            <div class="row">
                <div class="col-md-12">
                    <div class="product-name">
                        <h2 class="title-bar" style="float:left;">Category
                            <div class="title-border"></div>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="well" style="">
                <div style="">
                    <ul class="nav nav-list">
                        <li>
                            <label class="tree-toggler nav-header"><a href="<?php echo ADDRESS ?>product.html" style="  color: #898989;
  text-decoration: none;">สินค้าทั้งหมด </a></label>
                        </li>
                        <?php
                        
							$sql = "SELECT * FROM " . $category->getTbl() . " WHERE status = 'ใช้งาน'";
							
							//$result_list = array();
							$query = $db->Query($sql);
							while($row = $db->FetchArray($query)){  ?>
                        <li>
                            <label class="tree-toggler nav-header"><a href="<?php echo ADDRESS ."product/" .$row['category_name_ref']?>.html" style="  color: #898989;
  text-decoration: none;"><?php echo $row['category_name'];?> </a></label>
                            <ul class="nav nav-list tree">
                                <?php
                        
							$sql2 = "SELECT * FROM " . $products->getTbl() . " WHERE status = 'ใช้งาน' AND category_id = ". $row['id'] ."";
							
							//$result_list = array();
							$query2 = $db->Query($sql2);
							while($row2 = $db->FetchArray($query2)){  ?>
                                <li><a href="<?php echo ADDRESS ."product/" .$row['category_name_ref'] . "/" . $row2['product_name_ref'] ?>.html"><?php echo $row2['product_name'];?></a></li>
                                <?php }?>
                                
                                <!--       <li>
                                    <label class="tree-toggler nav-header">Header 1.1</label>
                                    <ul class="nav nav-list tree">
                                        <li><a href="#">Link</a></li>
                                        <li><a href="#">Link</a></li>
                                        <li>
                                            <label class="tree-toggler nav-header">Header 1.1.1</label>
                                            <ul class="nav nav-list tree">
                                                <li><a href="#">Link</a></li>
                                                <li><a href="#">Link</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>-->
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <?php	}?>
                    </ul>
                </div>
            </div>
            
            <?php include("side_category_blog.php")?>
            
            <?php
			if($_GET['controllers'] != 'product'){ ?>
				 <iframe name="ffbbbc56c" width="285px" height="500px" frameborder="0" allowtransparency="true" scrolling="no" title="fb:page Facebook Social Plugin" src="http://www.facebook.com/v2.3/plugins/page.php?app_id=&amp;channel=http%3A%2F%2Fstatic.ak.facebook.com%2Fconnect%2Fxd_arbiter%2FKvoNGODIqPG.js%3Fversion%3D41%23cb%3Dfda35bf9c%26domain%3Dwww.nanobeautydrink.com%26origin%3Dhttp%253A%252F%252Fwww.nanobeautydrink.com%252Ff3e1db5508%26relation%3Dparent.parent&amp;container_width=273&amp;height=500&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2F%2Fnanobeautydrink&amp;locale=th_TH&amp;sdk=joey&amp;show_facepile=true&amp;show_posts=false&amp;width=285" style="border: none; visibility: visible; width: 280px; height: 224px;" class=""></iframe>
	
			<?php }?>
            
            
            
            
        
        
        
        
        <style>
		ul.nav.nav-list.tree li a{ padding:5px 10px !important; }
		</style>