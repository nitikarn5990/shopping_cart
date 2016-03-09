<?php

if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {


    $arrData = array();


    $arrData = $functions->replaceQuote($_POST);

    $contact_message->SetValues($arrData);


    if ($contact_message->GetPrimary() == '') {


        $contact_message->SetValue('created_at', DATE_TIME);


        $contact_message->SetValue('updated_at', DATE_TIME);
    } else {


        $contact_message->SetValue('updated_at', DATE_TIME);
    }

   // $contact_message->SetValue('transfer_date', $_POST['transfer_date2'] . " " . $_POST['transfer_hr'] . ":" . $_POST['transfer_min'] . ":00");
   // $contact_message->SetValue('status', 'รอการชำระเงิน');

	$contact_message->SetValue('status', 'ยังไม่ได้อ่าน');
    if ($contact_message->Save()) {
		
	} else {


        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}
?>
<div class="row">
    <div class="col-md-9">
    <div class="row">
	    	<div class="col-md-12">
	    	<?php echo $google_map->getDataDesc("google_iframe","id = 1");?>
	    	
	    	</div>
	    	</div>
    	<p>&nbsp;</p>
        <div class="product-name">
            <h1 class="title-bar">CONTACT US
                <div class="title-border"></div>
            </h1>
            <article> <?php echo $contact->getDataDesc("contact_detail","id = 1")?> </article>
        </div>
        <div class="row">
            
            <form class="form-horizontal" enctype="multipart/form-data" style="padding: 20; border: 1px solid rgb(234, 234, 234);}" method="POST" action="<?php echo ADDRESS ?>contact-us.html">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p>&nbsp;</p>
                                <p for="inputEmail3" class="col-md-4 control-p text-right ">ชื่อและนามสกุล<em>*</em></p>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="name" name="txt_name" placeholder="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p for="inputEmail3" class="col-md-4 control-p text-right ">เบอร์โทร<em>*</em></p>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="transfer_amount" name="txt_tel" placeholder="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p for="inputEmail3" class="col-md-4 control-p text-right ">E-mail<em>*</em></p>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="transfer_date2" name="txt_email" placeholder="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p for="inputEmail3" class="col-md-4 control-p text-right ">เรื่อง<em>*</em></p>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="transfer_date2" name="txt_subject" placeholder="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p for="inputEmail3" class="col-md-4 control-p text-right ">ข้อความ<em>*</em></p>
                                <div class="col-md-8">
                                    <textarea type="text" class="form-control" id="transfer_date2" name="txt_message" rows="5" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <p for="inputEmail3" class="col-md-4 control-p text-right "></p>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-default" name="submit_bt" value="บันทึกข้อมูล">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p>&nbsp;</p>
            </form>
        </div>
    </div>
    <div class="col-md-3">
      <?php include 'inc/fb.php'?>
    </div>
</div>

<style>
<!--
iframe{
border: 0px;
}
-->
</style>
