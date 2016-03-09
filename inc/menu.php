<nav class="navbar navbar-default navbar-main navbar-center" role="navigation" id="navbar-main" style="box-shadow: 0 4px 2px -2px rgba(128, 128, 128, 0.4);"> 
    
    <!-- Brand and toggle get grouped for better mobile display -->
    
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            <li><a href="<?php echo ADDRESS?>"> HOME </a>
            <li>
            <li class="dropdown"> <a id="all_product" href="<?php echo ADDRESS?>product.html" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown" aria-expanded="false">PRODUCT <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <?php 

		$sql = "SELECT * FROM " . $category->getTbl() . " WHERE status = 'ใช้งาน'";
		
		$query = $db->Query($sql);
        while($row = $db->FetchArray($query)){ ?>
                    <li><a href="<?php echo ADDRESS ."product/" .$row['category_name_ref']?>.html"><?php echo $row['category_name']?></a></li>
                    <?php }?>
                </ul>
            </li>
            <li><a href="<?php echo ADDRESS?>best-offer.html">REVIEWS</a></li>
            <li><a href="<?php echo ADDRESS?>order-pay.html">ORDER & PAY</a></li>
            <li><a href="<?php echo ADDRESS?>payment-confirm.html">PAYMENT CONFIRM</a></li>
            <li><a href="<?php echo ADDRESS?>about-us.html">ABOUT US</a></li>
            <li class="dropdown"> <a id="all_blog" href="<?php echo ADDRESS?>blog.html" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown" aria-expanded="false">BLOG <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <?php 

		$sql = "SELECT * FROM " . $blog_category->getTbl() . " WHERE status = 'ใช้งาน'";
		
		$query = $db->Query($sql);
        while($row = $db->FetchArray($query)){ ?>
                    <li><a href="<?php echo ADDRESS ."blog/" .$row['category_name_ref']?>.html"><?php echo $row['category_name']?></a></li>
                    <?php }?>
                </ul>
            </li>
            <li><a href="<?php echo ADDRESS?>contact-us.html">CONTACT US</a></li>
        </ul>
    </div>
</nav>
<script> //dropdrop when hover
$('.dropdown').hover(function(){ 
  $('.dropdown-toggle', this).trigger('click'); 
  	$(this).addClass( "open" );
});
$('.dropdown').mouseleave(function(){
	
	$(this).removeClass( "open" )
});


$("#all_product").click(function(e) {
    // window.location = "<?php // echo ADDRESS?>product.html";
});
</script>