<?php
if ($_POST['submit_bt'] == 'Submit'){
	
	if($customer->CountDataDesc("id","login_email = '". $_POST['login_email']  ."'") > 0){ ?>
	<script type="text/javascript">
		$(document).ready(function(){
			alert('มีผู้ใช้นี้แล้ว ลองใหม่อีกครั้ง');
		});
	</script>
		

	<?php }else{
		$redirect = false;

		$arrData = array();


		$arrData = $functions->replaceQuote($_POST);
		
	/*	if($arrData['ref'] != ""){

			$arrData['product_name_ref'] = $functions->seoTitle($arrData['ref']);

		}else{

			$arrData['product_name_ref'] = $functions->seoTitle($arrData['product_name']);

		}
		*/
		$customer->SetValues($arrData);
		
		$customer->SetValue('status', 'ใช้งาน');
		$customer->SetValue('login_password', $functions->encode_login($_POST['login_password_encryt']) );
		
		if($customer->GetPrimary() == ''){


			$customer->SetValue('created_at', DATE_TIME);


			$customer->SetValue('updated_at', DATE_TIME);
			
			$customer->SetValue('register_date', DATE_TIME);


		}else{


			$customer->SetValue('updated_at', DATE_TIME);


		}
	//	$customer->Save();


		if($customer->Save()){		
				
			echo "<script>alert('สมัครสมาชิกเรียบร้อยแล้ว')</script>";
			header('location:' . ADDRESS. 'register/success.html');
			die();
			//Redirect if needed
			
		}
    }
}
?>

<div class="row">
    <div class="col-md-9">
        <div class="row">
            <h1 class="title-bar">REGISTER
                <div class="title-border"></div>
            </h1>
            <p>&nbsp; </p>
            <?php
    if($_GET['catID'] != ''){ ?>
            <div class="alert alert-success" role="alert"> <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> <span class="sr-only">Success:</span> สมัครสมาชิกสำเร็จ </div>
            <?php	} ?>
            <section>
            <form action="<?php echo ADDRESS?>register.html" method="post" id="form_register" onsubmit="return checkForm();">
            <fieldset class="well the-fieldset">
                <legend class="the-legend">Personal Information</legend>
                <div class="control-group">
                    <div class="col-xs-6" style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> ชื่อ: </label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $_POST['customer_name']?>"  required="required">
                    </div>
                    <div class="col-xs-6"  style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> นามสกุล : </label>
                        <input type="text" class="form-control" id="customer_lastname" name="customer_lastname" value="<?php echo $_POST['customer_lastname']?>"  required="required">
                    </div>
                    <div class="col-xs-12"  style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> ที่อยู่: </label>
                        <input type="text" class="form-control" id="customer_address" name="customer_address" value="<?php echo $_POST['customer_address']?>"  required="required">
                    </div>
                    <div class="col-xs-6"  style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> จังหวัด: </label>
                        <div class="da-form-item large">
                            <select name='province_id' id='province_id' class="form-control"  onchange="data_show(this.value,'amphur_id');" required="required">
                                <option value="">กรุณาเลือก</option>
                                <?php $province->CreateDataList2("PROVINCE_ID","PROVINCE_NAME")?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6"  style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> อำเภอ: </label>
                        <div class="da-form-item large">
                            <select name="amphur_id" id="amphur_id" onchange="data_show(this.value,'district_id');"  class="form-control" required="required">
                                <option value="">กรุณาเลือก</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6"  style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> ตำบล: </label>
                        <div class="da-form-item large">
                            <select name="district_id" id="district_id" class="form-control" required="required">
                                <option value="">กรุณาเลือก</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6"  style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> รหัสไปรษณีย์ : </label>
                        <input type="number" class="form-control" id="zipcode" name="zipcode" value="<?php echo $_POST['zipcode']?>" required="required">
                    </div>
                    <div class="col-xs-6"  style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> โทร : </label>
                        <input type="tel" class="form-control" id="customer_tel" name="customer_tel"  value="<?php echo $_POST['customer_tel']?>" required="required">
                    </div>
                </div>
            </fieldset>
            </section>
            <section>
                <fieldset class="well the-fieldset">
                    <legend class="the-legend">Login Information</legend>
                    <div class="control-group">
                    <div class="col-xs-12" style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> Email: </label>
                        <input type="email" class="form-control" id="login_email" name="login_email"  required="required">
                    </div>
                    <div class="col-xs-6"  style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> Password : </label>
                        <input type="password" class="form-control" id="login_password_encryt" name="login_password_encryt"  required="required"  minlength="6">
                    </div>
                    <div class="col-xs-6"  style="padding-bottom:10px;">
                        <label class="control-label input-label" for="startTime"><em>*</em> Confirm Password: </label>
                        <input type="password" class="form-control" id="login_confirm_password" name="login_confirm_password"   minlength="6" required="required">
                    </div>
                    <div class="col-xs-6 col-md-6"  style="padding-bottom:10px;">
                        <input type="submit" class="btn btn-primary" value="Submit" id="submit_bt" name="submit_bt"  >
                    </div>
                        <div class="col-xs-6 col-md-6 text-right"  style="padding-bottom:10px; color: red;font-weight: bold;">
                            <a href="<?php echo ADDRESS?>policy.html" class="policy"> นโยบายความเป็นส่วนตัว</a>
                        </div>
                </fieldset>
                </form>
            </section>
        </div>
        <p>&nbsp; </p>
    </div>
    <div class="col-md-3">
        <?php include "inc/side_category.php" ;?>
    </div>
</div>
<script language="javascript">
// Start XmlHttp Object
function uzXmlHttp(){
    var xmlhttp = false;
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(e){
            xmlhttp = false;
        }
    }
 
    if(!xmlhttp && document.createElement){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
// End XmlHttp Object

function data_show(select_id,result){

	var url = '../ajax/province.php?select_id='+select_id+'&result='+result;
	//alert(url);
	
    xmlhttp = uzXmlHttp();
    xmlhttp.open("GET", url, false);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
    xmlhttp.send(null);
	//alert(xmlhttp.responseText);
	document.getElementById(result).innerHTML =  xmlhttp.responseText;
}



//window.onLoad=data_show(5,'amphur'); 
</script> 
<script type="text/javascript">

  function checkForm()
  {
	  
	  
   
    if($("#login_password_encryt").val() != $("#login_confirm_password").val() ) {
     
        alert("รหัสผ่านไม่ตรงกัน");
        $("#login_confirm_password").focus();
        return false;
      
	}


	

  }

</script>
<style>
.the-legend {
    border-style: none;
    border-width: 0;
    font-size: 14px;
    line-height: 20px;
    margin-bottom: 0;
}
.the-fieldset {
    border: 2px groove threedface #444;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}
legend{
	padding:0 10px;
	width:auto !important;
	color:#898989;
	
}
    .policy{
        color: red;
    }
.policy:hover{
    color: red;
}



</style>
