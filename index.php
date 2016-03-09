<?php 
session_start();

 include_once($_SERVER["DOCUMENT_ROOT"] .dirname($_SERVER['SCRIPT_NAME']). '/lib/application.php');
// echo ($_SERVER["DOCUMENT_ROOT"]);


?>

<!DOCTYPE html>
<html>
<head>
   <?php 
  include 'inc/head.php'; ?>
   <!-- Include one of jTable styles. -->

</head>
<body>
    
    <?php
  
  

    include_once 'inc/menu_top.php'; 
    ?>

    <div class="container">

        <?php include 'inc/header.php'; ?>
        

        <div class="row">

            <?php include 'inc/menu.php'; ?>

        </div>

        <div class="row">

           <?php include 'inc/crumb.php'; ?>

        </div>
<?php  

   if( PAGE_CONTROLLERS == '' || PAGE_CONTROLLERS == 'index'){
	   include "controllers/home.php";
	   
	}else{
		if(PAGE_CONTROLLERS == 'tag'){
			
			if($_GET['catID'] != '' && $_GET['productID'] == ''){
				
				$sub_url = $_GET['catID'] . ".html";
				
			}
			if($_GET['catID'] != '' && $_GET['productID'] != ''){
			
				$sub_url =  $_GET['catID'] ."/". $_GET['productID']  . ".html";
			
			}
			$convert_url_tag = ADDRESS . "product/" . $sub_url;
			
		
				header("location:".$convert_url_tag);
			
		}
		
			include "controllers/".PAGE_CONTROLLERS.".php";
		
	}

?>
    </div>

    <?php include "inc/footer.php"; ?>
 
</body>
</html>


<script type="text/javascript">

$(document).ready(function() {

    $(window).bind('scroll', function() {

        var navHeight = 168; // custom nav height

        ($(window).scrollTop() > navHeight) ? $('#navbar-main').addClass('navbar-fixed-top'): $('#navbar-main').removeClass('navbar-fixed-top');

    });

});

</script>

<style>

.scroll-top-wrapper {

    position: fixed;

    opacity: 0;

    visibility: hidden;

    overflow: hidden;

    text-align: center;

    z-index: 99999999;

    background-color: #B89745;

    color: #eeeeee;

    width: 50px;

    height: 48px;

    line-height: 48px;

    right: 30px;

    bottom: 30px;

    padding-top: 2px;

    border-top-left-radius: 5px;

    border-top-right-radius: 5px;

    border-bottom-right-radius: 5px;

    border-bottom-left-radius: 5px;

    -webkit-transition: all 0.5s ease-in-out;

    -moz-transition: all 0.5s ease-in-out;

    -ms-transition: all 0.5s ease-in-out;

    -o-transition: all 0.5s ease-in-out;

    transition: all 0.5s ease-in-out;

}



.scroll-top-wrapper:hover {

    opacity: 0.7 !important;

}



.scroll-top-wrapper.show {

    visibility: visible;

    cursor: pointer;

    opacity: 1.0;

}



.scroll-top-wrapper i.fa {

    line-height: inherit;

}
a{
font-family: serif !important;
}

</style>

<script>

$(function() {



    $(document).on('scroll', function() {



        if ($(window).scrollTop() > 100) {

            $('.scroll-top-wrapper').addClass('show');

        } else {

            $('.scroll-top-wrapper').removeClass('show');

        }

    });

});

</script>

<script>

$(function() {



    $(document).on('scroll', function() {



        if ($(window).scrollTop() > 100) {

            $('.scroll-top-wrapper').addClass('show');

        } else {

            $('.scroll-top-wrapper').removeClass('show');

        }

    });



    $('.scroll-top-wrapper').on('click', scrollToTop);

});



function scrollToTop() {

    verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;

    element = $('body');

    offset = element.offset();

    offsetTop = offset.top;

    $('html, body').animate({

        scrollTop: offsetTop

    }, 500, 'linear');

}

</script>

