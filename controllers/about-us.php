<div class="row">
    <div class="col-md-9">
        <div class="product-name">
            <h1 class="title-bar">ABOUT US
                <div class="title-border"></div>
            </h1>
        </div>
        <p>&nbsp;</p>
        <article>
		
        <?php 
		 echo $about->getDataDesc("about_detail", "id= 1");
		?>
        </article>
    </div>
    <div class="col-md-3">
        <?php include 'inc/fb.php'?>
    </div>
</div>

