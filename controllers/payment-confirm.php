<script>
    $(function () {
        $("#transfer_date2").datepicker({
            dateFormat: 'yy-mm-dd'

        });
    });
</script>
<?php

if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {


    $arrData = array();


    $arrData = $functions->replaceQuote($_POST);

    $payment_confirm->SetValues($arrData);


    if ($payment_confirm->GetPrimary() == '') {


        $payment_confirm->SetValue('created_at', DATE_TIME);


        $payment_confirm->SetValue('updated_at', DATE_TIME);
    } else {


        $payment_confirm->SetValue('updated_at', DATE_TIME);
    }

    $payment_confirm->SetValue('transfer_date', $_POST['transfer_date2'] . " " . $_POST['transfer_hr'] . ":" . $_POST['transfer_min'] . ":00");
    $payment_confirm->SetValue('status', 'รอการชำระเงิน');


    if ($payment_confirm->Save()) {
		

        if (isset($_FILES['file_array'])) {
		

            $Allfile = "";

            $Allfile_ref = "";

            for ($i = 0; $i < count($_FILES['file_array']['tmp_name']); $i++) {

                if ($_FILES["file_array"]["name"][$i] != "") {

                    //   unset($arrData['webs_money_image']);
					

                    $targetPath = DIR_ROOT_BILL ;


                    $newImage = DATE_TIME_FILE . "_" . $_FILES['file_array']['name'][$i];


                      


                    $cdir = getcwd(); // Save the current directory

                    chdir($targetPath);

                    copy($_FILES['file_array']['tmp_name'][$i], $targetPath . $newImage);

                    chdir($cdir); // Restore the old working directory   

                 //   $payment_confirm->SetValue('image_receipt', $newImage);


                    if ($payment_confirm->GetPrimary() != '') {

                        $arrOrder = array(
                            'image_receipt' => $newImage,
                            'updated_at' => DATE_TIME
                        );

                        $arrOrderID = array('id' => $payment_confirm->GetPrimary());
                        if($payment_confirm->updateSQL($arrOrder, $arrOrderID)){
							
							echo "<script>alert('Success')</script>";
							
						}
						
                    } else {


                        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
                    }
                }
            }
        }


        SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');

        header('location:' . ADDRESS . 'payment-confirm.html');

        die();
    } else {


        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="product-name">
            <h1 class="title-bar">PAYMENT CONFIRM
                <div class="title-border"></div>
            </h1>
        </div>
    </div>
</div>
<div class="row">
    <p>&nbsp;</p>
    <form class="form-horizontal" enctype="multipart/form-data" style="padding: 20; border: 1px solid rgb(234, 234, 234);}" method="POST" action="<?php echo ADDRESS ?>payment-confirm.html">
        <p>&nbsp;</p>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <p for="inputEmail3" class="col-md-4 control-p text-right ">เลขที่ใบสั่งซื้อ<em>*</em></p>
                        <div class="col-md-8">
                            <input type="number" name="orders_id" class="form-control" id="orders_id" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <p for="inputEmail3" class="col-md-4 control-p text-right ">ชื่อและนามสกุล<em>*</em></p>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="name" name="name"  required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <p for="inputEmail3" class="col-md-4 control-p text-right ">จำนวนเงินที่ชำระ<em>*</em></p>
                        <div class="col-md-8">
                            <input type="number" class="form-control" id="transfer_amount" name="transfer_amount"  required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <p for="inputEmail3" class="col-md-4 control-p text-right ">วันที่โอน<em>*</em></p>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="transfer_date2" name="transfer_date2"  required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <p for="inputEmail3" class="col-md-4 control-p text-right ">เวลาที่โอนเงิน<em>*</em></p>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control" id="transfer_hr" name="transfer_hr" required>
                                        <option value="">-ชั่วโมง-</option>
                                        <?php
for ($h = 0; $h < 24; $h++) {
    echo "<option value=" . str_pad($h, 2, "0", STR_PAD_LEFT) . ">" . str_pad($h, 2, "0", STR_PAD_LEFT) . "</option>";
}
?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" id="transfer_min" name="transfer_min" required>
                                        <option value="">-นาที-</option>
                                        <?php
for ($m = 0; $m < 60; $m++) {
    echo "<option value=" . str_pad($m, 2, "0", STR_PAD_LEFT) . ">" . str_pad($m, 2, "0", STR_PAD_LEFT) . "</option>";
}
?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <p for="inputEmail3" class="col-md-4 control-p text-right ">อัพโหลดรูปสลิป (ถ้ามี)<em>*</em></p>
                        <div class="col-md-8">
                            <input type="file" class="form-control" name="file_array[]" id="file_array" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <p for="inputEmail3" class="col-md-4 control-p text-right ">ชำระเงินเข้าธนาคาร<em>*</em></p>
                        <div class="col-md-8">
                            <select class="form-control" id="bank_id" name="bank_id" required>
                                <option value="">-โปรดเลือก-</option>
                                <?php
$sql = "SELECT * FROM " . $bank->getTbl() . " WHERE status = 'ใช้งาน'";
$query = $db->Query($sql);
while ($row = $db->FetchArray($query)) {
    echo "<option value=" . $row['bank_id'] . ">" . $bank_company->getDataDesc("bank_name", "id = " . $row['bank_id']) . " สาขา " . $row['bank_branch'] . " เลขที่บัญชี " . $row['bank_number'] . "</option>";
}
?>
                            </select>
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
<p>&nbsp;</p>
<p>&nbsp;</p>
