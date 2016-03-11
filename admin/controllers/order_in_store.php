<?php
print_r($_POST);

if ($_POST['submit_bt'] == 'บันทึกข้อมูล' || $_POST['submit_bt'] == 'บันทึกข้อมูล และแก้ไขต่อ') {



    if ($_POST['submit_bt'] == 'บันทึกข้อมูล') {

        $redirect = true;
    } else {

        $redirect = false;
    }

    $arrData = array();


    //$arrData = $functions->replaceQuote($_POST);
//
//    if ($arrData['ref'] != "") {
//
//        $arrData['product_name_ref'] = $functions->seoTitle($arrData['ref']);
//    } else {
//
//        $arrData['product_name_ref'] = $functions->seoTitle($arrData['product_name']);
//    }


    foreach ($_POST['product_id'] as $p_ids) {
        
    }

    // $order_in_store->SetValues($arrData);
    if ($order_in_store->GetPrimary() == '') {


        $order_in_store->SetValue('created_at', DATE_TIME);


        $order_in_store->SetValue('updated_at', DATE_TIME);
    } else {


        $order_in_store->SetValue('updated_at', DATE_TIME);
    }


    if ($order_in_store->Save()) {


        SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ', 'success');
        echo "SUCCESS";
        die();

        //Redirect if needed

        if (isset($_FILES['file_array'])) {


            $Allfile = "";


            $Allfile_ref = "";


            for ($i = 0; $i < count($_FILES['file_array']['tmp_name']); $i++) {

                if ($_FILES["file_array"]["name"][$i] != "") {

                    unset($arrData['webs_money_image']);
                    $targetPath = DIR_ROOT_GALLERY . "/";
                    $newImage = DATE_TIME_FILE . "_" . $_FILES['file_array']['name'][$i];

                    $cdir = getcwd(); // Save the current directory
                    chdir($targetPath);
                    copy($_FILES['file_array']['tmp_name'][$i], $targetPath . $newImage);
                    chdir($cdir); // Restore the old working directory   


                    $product_files->SetValue('file_name', $newImage);

                    if ($_POST['alt_tag'][$i] == '') {

                        //$Allfile_ref .= "|_|" . $newImage;
                        //$product_files->SetValue('file_name', substr($Allfile, 3));


                        $product_files->SetValue('alt_tag', $newImage);
                    } else {

                        //$Allfile_ref .= "|_|" .   $functions->seoTitle($_POST['alt_tag'][$i]);


                        $product_files->SetValue('alt_tag', $functions->seoTitle($_POST['alt_tag'][$i]));
                    }

                    $product_files->SetValue('product_id', $products->GetPrimary());
                    //$product_files->Save();

                    if ($product_files->Save()) {

                        //SetAlert('เพิ่ม แก้ไข ข้อมูลสำเร็จ','success');
                        $product_files->ResetValues();
                    } else {
                        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
                    }
                }
            }

            if ($_POST['products_file_name_cover'] == '') {


                $arrOrder = array(
                    'products_file_name_cover' => $product_files->getDataDesc("file_name", "product_id = '" . $products->GetPrimary() . "' ORDER BY id ASC LIMIT 0,1"),
                    'updated_at' => DATE_TIME
                );


                $arrOrderID = array('id' => $products->GetPrimary());





                $products->updateSQL($arrOrder, $arrOrderID);
            }
        }


        ////////

        if ($redirect) {


            header('location:' . ADDRESS_ADMIN_CONTROL . 'order_in_store');


            die();
        } else {


            header('location:' . ADDRESS_ADMIN_CONTROL . 'order_in_store&action=edit&id=' . $order_in_store->GetPrimary());


            die();
        }
    } else {


        SetAlert('ไม่สามารถเพิ่ม แก้ไข ข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['gallery_file_id'] != '' && $_GET['action'] == 'edit') {





    $product_files->SetPrimary((int) $_GET['gallery_file_id']);





    if ($product_files->Delete()) {


        // Set alert and redirect


        if (unlink(DIR_ROOT_GALLERY . $product_files->GetValue('file_name'))) {


            //	fulldelete($location); 


            SetAlert('Delete Data Success', 'success');
        }
    } else {


        SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


        //	echo $_GET['gallery_file_id'];
    }
}

// If Deleting the Page


if ($_GET['id'] != '' && $_GET['action'] == 'del') {


    // Get all the form data
    ///$arrDel = array('id' => $_GET['id']);
    //$products->SetValues($arrDel);
    // Remove the info from the DB


    if ($products->DeleteMultiID($_GET['id'])) {


        // Set alert and redirect


        SetAlert('Delete Data Success', 'success');


        header('location:' . ADDRESS_ADMIN_CONTROL . 'product');


        die();
    } else {


        SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}


if ($_GET['id'] != '' && $_GET['action'] == 'edit') {


    // For Update


    $products->SetPrimary((int) $_GET['id']);


    // Try to get the information


    if (!$products->GetInfo()) {


        SetAlert('ไม่สามารถค้นหาข้อมูลได้ กรุณาลองใหม่อีกครั้ง');


        $products->ResetValues();
    }
}

//
if ($_GET['product_files_id'] != '') {


    // Get all the form data


    $arrDel = array('id' => $_GET['product_files_id']);


    $product_files->SetValues($arrDel);


    // Remove the info from the DB


    if ($product_files->Delete()) {


        // Set alert and redirect


        SetAlert('Delete Data Success', 'success');


        header('location:' . ADDRESS_ADMIN_CONTROL . 'product&action=edit&id=' . $products->GetPrimary());

        die();
    } else {
        SetAlert('ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง');
    }
}
?>

<?php if ($_GET['action'] == "add" || $_GET['action'] == "edit") { ?>
    <div class="row-fluid">
        <div class="span12">
            <?php
            // Report errors to the user
            Alert(GetAlert('error'));


            Alert(GetAlert('success'), 'success');
            ?>
            <div class="da-panel collapsible">
                <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-<?php echo ($products->GetPrimary() != '') ? 'application-edit' : 'add' ?>"></i> <?php echo ($products->GetPrimary() != '') ? 'แก้ไข' : 'เพิ่ม' ?> สินค้า </span> </div>
                <div class="da-panel-content da-form-container">
                    <form id="validate" enctype="multipart/form-data" action="<?php echo ADDRESS_ADMIN_CONTROL ?>product<?php echo ($products->GetPrimary() != '') ? '&id=' . $products->GetPrimary() : ''; ?>" method="post" class="da-form">
                        <?php if ($products->GetPrimary() != ''): ?>
                            <input type="hidden" name="id" value="<?php echo $products->GetPrimary() ?>" />
                            <input type="hidden" name="created_at" value="<?php echo $products->GetValue('created_at') ?>" />
                        <?php endif; ?>
                        <div class="da-form-inline">
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อสินค้า <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <input type="text" name="product_name" id="product_name" value="<?php echo ($products->GetPrimary() != '') ? $products->GetValue('product_name') : ''; ?>" class="span12 required" />
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">ชื่อใช้อ้างอิง / URL</label>
                                <div class="da-form-item large">
                                    <input type="text" name="ref" id="ref" value="<?php echo ($products->GetPrimary() != '') ? $products->GetValue('product_name_ref') : ''; ?>" class="span12" />
                                    <label class="help-block">ว่างไว้ถ้าต้องการให้สร้างชื่ออ้างอิงอัตโนมัติ</label>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">กลุ่มสินค้า <span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <select id="category_id" name="category_id" class="span12 select2 required">
                                        <option value=""></option>
                                        <?php $category->CreateDataList("id", "category_name", "status='ใช้งาน'", ($products->GetPrimary() != "") ? $products->GetValue('category_id') : "") ?>
                                    </select>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">รายละเอียดโดยย่อ<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <textarea name="product_title" id="product_title" class="span12 tinymce required"><?php echo ($products->GetPrimary() != '') ? $products->GetValue('product_title') : ''; ?></textarea>
                                    <label for="product_title" generated="true" class="error" style="display:none;"></label>
                                </div>
                            </div>
                            <div class="da-form-row">
                                <label class="da-form-label">รายละเอียด<span class="required">*</span></label>
                                <div class="da-form-item large">
                                    <textarea name="product_detail" id="product_detail" class="span12 tinymce required"><?php echo ($products->GetPrimary() != '') ? $products->GetValue('product_detail') : ''; ?></textarea>
                                    <label for="product_detail" generated="true" class="error" style="display:none;"></label>
                                </div>
                            </div>
                            <div class="da-form-inline">
                                <div class="da-form-row">
                                    <label class="da-form-label">ราคา (บาท)<span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <input type="number" name="product_cost" id="product_cost" value="<?php echo ($products->GetPrimary() != '') ? $products->GetValue('product_cost') : ''; ?>" class="span12 required" />
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">ขนาด (กรัม)</label>
                                    <div class="da-form-item large">
                                        <input type="number" name="product_weight" id="product_weight" value="<?php echo ($products->GetPrimary() != '') ? $products->GetValue('product_weight') : ''; ?>" class="span12"  placeholder="น้ำหนักของสินค้า"/>
                                    </div>
                                </div>

                                <div class="da-form-row">
                                    <label class="da-form-label">ไฟล์ที่อัพโหลด</label>
                                    <div class="da-form-item large">
                                        <ul style=" list-style-type: none;" class="da-form-list">
                                            <?php
                                            $sql = "SELECT * FROM " . $product_files->getTbl() . " WHERE product_id = '" . $products->GetPrimary() . "'";


                                            $query = $db->Query($sql);


                                            if ($db->NumRows($query) > 0) {
                                                ?>
                                                <ul>
                                                    <?php while ($row = $db->FetchArray($query)) { ?>
                                                        <li> <span >
                                                                <input type="radio" name="products_file_name_cover" value="<?php echo $row['file_name'] ?>"  <?php echo $k == '' ? 'checked=checked' : '' ?>>
                                                            </span> <span class="label success3"><a style="color:#FFF !important;" href="<?php echo ADDRESS_GALLERY . $row['file_name'] ?>" target="_blank"><?php echo $row['file_name'] ?> </a> <a href="<?php echo ADDRESS_ADMIN_CONTROL ?>product&action=edit&id=<?php echo $_GET['id'] ?>&product_files_id=<?php echo $row['id'] ?>" style="color:#FFF; size:20px; text-decoration: none;" onclick="return confirm('Are you sure you want to delete?')" >| ลบไฟล์ </a></span>
                                                            <?php $k++; ?>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">อัพโหลดไฟล์</label>
                                    <div class="da-form-item large" id="filecopy"> <span class="formNote"><strong>Alt Tag</strong> </span>
                                        <input type="text" placeholder="" name="alt_tag[]">
                                        <input type="file" name="file_array[]" id="image"  class="span4"/>
                                        <a href="javascript:addfile();" >เพิ่ม</a> <a href="javascript:delfile();" >ลบ</a>
                                        <label class="help-block">ไฟล์เอกสาร</label>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Meta Title</label>
                                    <div class="da-form-item large">
                                        <textarea name="meta_title" id="meta_title" class="span12"><?php echo ($products->GetPrimary() != '') ? $products->GetValue('meta_title') : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Meta Keywords</label>
                                    <div class="da-form-item large">
                                        <textarea name="meta_keywords" id="meta_keywords" class="span12"><?php echo ($products->GetPrimary() != '') ? $products->GetValue('meta_keywords') : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">Meta Descriptions</label>
                                    <div class="da-form-item large">
                                        <textarea name="meta_descriptions" id="meta_descriptions" class="span12"><?php echo ($products->GetPrimary() != '') ? $products->GetValue('meta_descriptions') : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="da-form-row">
                                    <label class="da-form-label">สถานะ <span class="required">*</span></label>
                                    <div class="da-form-item large">
                                        <ul class="da-form-list">
                                            <?php
                                            $getStatus = $products->get_enum_values('status');


                                            $i = 1;


                                            foreach ($getStatus as $status) {
                                                ?>
                                                <li>
                                                    <input type="radio" name="status" id="status" value="<?php echo $status ?>" <?php echo ($products->GetPrimary() != "") ? ($products->GetValue('status') == $status) ? "checked=\"checked\"" : "" : ($i == 1) ? "checked=\"checked\"" : "" ?> class="required"/>
                                                    <label><?php echo $status ?></label>
                                                </li>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-row">
                                <input type="submit" name="submit_bt" value="บันทึกข้อมูล" class="btn btn-success" />
                                <input type="submit" name="submit_bt" value="บันทึกข้อมูล และแก้ไขต่อ" class="btn btn-primary" />
                                <a href="<?php echo ADDRESS_ADMIN_CONTROL ?>product" class="btn btn-danger">ยกเลิก</a> 
                            </div>
                   
                </div>
                </form>
            </div>
        </div>
          </div>
    </div>


<?php } else { ?>

    <!-- ถ้ามีการเลือกสินค้าที่จะสั่งซื้อเข้าร้าน-->
    <?php if (isset($_POST['m_product_id']) || $_POST['product_id'] != '') {
        ?>

        <div class="row-fluid">
            <div class="span12">
                <?php
                // Report errors to the user


                Alert(GetAlert('error'));


                Alert(GetAlert('success'), 'success');
                ?>

                <div class="da-panel collapsible">
                    <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-add"></i>  ข้อมูลการสั่งซื้อสินค้าเข้าร้าน </span> </div>
                    <div class="da-panel-content da-form-container">
                        <form enctype="multipart/form-data" action="<?= ADDRESS_ADMIN_CONTROL ?>order_in_store" method="post" class="da-form">

                            <div class="da-form-inline">
                                <fieldset>
                                    <legend><b>วันที่ทำการสั่งซื้อ</b></legend>
                                    <div class="da-form-row">
                                        <label class="da-form-label">วันที่ทำการสั่งซื้อ <span class="required">*</span></label>
                                        <div class="da-form-item large">
                                            <input type="text" name="order_date" id="order_date" value="" class="span12" data-validate="required" readonly="readonly"/>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend><b>รายละเอียดในการสั่งซื้อ</b></legend>

                                    <div class="da-form-row ">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>

                                                    <th class="text-center" style="width: 2%;">รหัส</th>
                                                    <th class="text-center" style="width: 5%;">ชื่อสินค้า</th>
                                                    <th class="text-center" style="width: 5%;">เลือกตัวแทนจำหน่าย <span style="color: red;">*</span></th>
                                                    <th class="text-center" style="width: 1%;">จำนวน <span style="color: red;">*</span></th>
                                                    <th class="text-center" style="width: 5%;">หมายเหตุ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_POST['m_product_id'])) {

                                                    foreach ($_POST['m_product_id'] as $value) {
                                                        $p_id .= ',' . $value;
                                                    }
                                                    $p_id = substr($p_id, 1);
                                                }
                                                if ($_POST['product_id'] != '') {
                                                    $p_id = $_POST['product_id'];
                                                }
                                                $sql2 = "SELECT * FROM " . $products->getTbl() . " WHERE id in(" . $p_id . ")";

                                                $query2 = $db->Query($sql2);
                                                if ($db->NumRows($query2) > 0) {

                                                    while ($row2 = $db->FetchArray($query2)) {
                                                        ?>
                                                        <tr>
                                                    <input type="hidden" name="product_id[]" value="<?= $row2['id'] ?>">

                                                    <td class="text-center display-middle"><?= $row2['id'] ?></td>
                                                    <td class="text-center display-middle"><?= $row2['product_name'] ?></td>
                                                    <td class="text-center display-middle">
                                                        <select name="distributor_id[]" class="" data-validate="required">
                                                            <?php
                                                            $sql = "SELECT * FROM " . $distributor->getTbl();
                                                            $query = $db->Query($sql);
                                                            if ($db->NumRows($query) > 0) {
                                                                while ($row = $db->FetchArray($query)) {
                                                                    ?>
                                                                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select><span style="color: red;"></span>
                                                    </td>
                                                    <td class="text-center display-middle"><input type="text" name="qty[]" class="text-center" data-validate="required,number"><span style="color: red;"></span></td>
                                                    <td class="display-middle"><textarea name="comment[]" class="span12"></textarea></td>
                                                    </tr>

                                                <?php } ?>
                                            <?php } ?>        
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="da-form-row ">

                                    </div>

                                </fieldset>

                            </div>
                           
                            <div class="btn-row">
                                <button type="submit" name="submit_bt" value="บันทึกข้อมูล" class="btn btn-success" >บันทึกข้อมูล</button>

                                <a href="<?php echo ADDRESS_ADMIN_CONTROL ?>order_in_store" class="btn btn-danger">ยกเลิก</a> 
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    <?php } else { ?>
        <!-- แสดงสินค้าทั้งหมด-->
        <div class="row-fluid">
            <div class="span12">
                <?php
                // Report errors to the user


                Alert(GetAlert('error'));


                Alert(GetAlert('success'), 'success');
                ?>
                <form method="POST" action="">
                    <div class="da-panel collapsible">
                        <div class="da-panel-header"> <span class="da-panel-title"> <i class="icol-grid"></i> เลือกสินค้าที่จะสั่งซื้อเข้าร้าน </span> </div>
                        <div class="da-panel-toolbar ">
                            <div class="btn-toolbar">
                                <div class="btn-group"> 

                                    <button type="submit" class="btn" name="submit_bt" value="เลือก"><i class="icol-add"></i> เลือก</button>

                                    <a class="btn hidden" onClick="multi_delete()"><img src="http://icons.iconarchive.com/icons/awicons/vista-artistic/24/delete-icon.png" height="16" width="16"> Delete</a> 
                                </div>
                            </div>
                        </div>
                        <div class="da-panel-content da-table-container">
                            <table id="da-ex-datatable-sort" class="da-table" sort="3" order="asc" width="1000">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkAll"></th>
                                        <th>รหัส</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>กลุ่มสินค้า</th>
                                        <th>ภาพสินค้า</th>
                                        <th class="hidden">สถานะ</th>
                                        <th class="hidden">แก้ไขล่าสุด</th>
                                        <th class="hidden">ตัวเลือก</th>
                                        <th class="">เลือก</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM " . $products->getTbl() . " WHERE status = 'ใช้งาน'";


                                    $query = $db->Query($sql);


                                    while ($row = $db->FetchArray($query)) {
                                        ?>
                                        <tr>
                                            <td class="center" width="5%"><input type="checkbox" value="<?php echo $row['id']; ?>" id="m_product_id" name="m_product_id[]"></td>
                                            <td class="center"><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['product_name']; ?></td>
                                            <td><?php echo $category->getDataDesc("category_name", "id = '" . $row['category_id'] . "'") ?></td>
                                            <td class="center"><img src="<?php echo ADDRESS_GALLERY . $products->getDataDesc("products_file_name_cover", "id = '" . $row['id'] . "'") ?>" style="height:70px; width:70px;"></td>
                                            <td class="center hidden"><i class="icol-<?php echo ($row['status'] == 'ใช้งาน') ? 'accept' : 'cross' ?>" title="<?php echo $row['status'] ?>"></i></td>
                                            <td class="center hidden"><?php echo $functions->ShowDateThTime($row['updated_at']) ?></td>
                                            <td class="center hidden"><a href="<?php echo ADDRESS_ADMIN_CONTROL ?>product&action=edit&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-small">แก้ไข / ดู</a> <a href="#" onclick="if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                                                        document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>product&action=del&id=<?php echo $row['id'] ?>'
                                                                }" class="btn btn-danger btn-small">ลบ</a></td>
                                            <td class="center"> <button type="submit" class="btn" name="product_id" value="<?php echo $row['id']; ?>"><i class="icol-add"></i> เลือก</button></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            $("#checkAll").click(function (e) {
                $('input:checkbox').prop('checked', this.checked);
            });

            function multi_delete() {

                var msg_id = "";
                var res = "";

                $('input:checkbox[id^="chkboxID"]:checked').each(function () {


                    msg_id += ',' + $(this).val();
                    res = msg_id.substring(1);


                });
                if (res != '') {
                    if (confirm('คุณต้องการลบข้อมูลนี้หรือใม่?') == true) {
                        document.location.href = '<?php echo ADDRESS_ADMIN_CONTROL ?>product&action=del&id=' + res;
                    }
                }

            }

        </script>
    <?php } ?>
<?php } ?>
<script type="text/javascript">
    //$( document ).ready(function() {


    function addfile() {


        $("#filecopy:first").clone().insertAfter("div #filecopy:last");


    }


    function delfile() {


        //$("#filecopy").clone().insertAfter("div #filecopy:last");


        var conveniancecount = $("div #filecopy").length;


        if (conveniancecount > 2) {


            $("div #filecopy:last").remove();


        }
    }


    $(document).ready(function () {

        $('input:radio[name="products_file_name_cover"][value="<?php echo $products->getDataDesc("products_file_name_cover", "id = '" . $_GET['id'] . "'"); ?>"]').prop('checked', true);

    });

</script> 
<script>
    $(function () {


        // $( "#datepicker" ).datepicker();


        $("#activity_date").datepicker({dateFormat: "yy-mm-dd"}).val()


    });


</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>



<script>
    $(function () {
        $('#order_date').datepicker({
            minDate: '0',
            dateFormat: "yy-mm-dd",
        });
    });
    function cleartext(ele) {
        $(ele).val('');
    }
</script>
<style>
    /*Colored Label Attributes*/
    .error{
        display: block;
        color: #d44d24;
        font-size: 11px;
        margin-top: 1px;
    }
    .display-middle{
        display: table-cell;
        vertical-align: middle !important;
    }
    textarea{
        height: 6em;
    }
    .text-center{
        text-align: center !important;
    }
    .ui-datepicker{
        z-index: 9999 !important;
    }
    .hidden{
        display: none;
    }
    .label {
        background-color: #BFBFBF;
        border-bottom-left-radius: 3px;
        border-bottom-right-radius: 3px;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        color: #FFFFFF;
        font-size: 9.75px;
        font-weight: bold;
        padding-bottom: 2px;
        padding-left: 4px;
        padding-right: 4px;
        padding-top: 2px;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .label:hover {
        opacity: 80;
    }
    .label.success {
        background-color: #46A546;
    }
    .label.success2 {
        background-color: #CCC;
    }
    .label.success3 {
        background-color: #61a4e4;
    }
    .label.warning {
        background-color: #FC9207;
    }
    .label.failure {
        background-color: #D32B26;
    }
    .label.alert {
        background-color: #33BFF7;
    }
    .label.good-job {
        background-color: #9C41C6;
    }

    table {
        max-width: 100%;
        background-color: transparent;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .table {
        width: 100%;
        margin-bottom: 20px;
    }

    .table th,
    .table td {
        padding: 8px;
        line-height: 20px;
        text-align: left;
        vertical-align: top;
        border-top: 1px solid #dddddd;
    }

    .table th {
        font-weight: bold;
    }

    .table thead th {
        vertical-align: bottom;
    }

    .table caption + thead tr:first-child th,
    .table caption + thead tr:first-child td,
    .table colgroup + thead tr:first-child th,
    .table colgroup + thead tr:first-child td,
    .table thead:first-child tr:first-child th,
    .table thead:first-child tr:first-child td {
        border-top: 0;
    }

    .table tbody + tbody {
        border-top: 2px solid #dddddd;
    }

    .table-condensed th,
    .table-condensed td {
        padding: 4px 5px;
    }

    .table-bordered {
        border: 1px solid #dddddd;
        border-collapse: separate;
        *border-collapse: collapse;
        border-left: 0;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .table-bordered th,
    .table-bordered td {
        border-left: 1px solid #dddddd;
    }

    .table-bordered caption + thead tr:first-child th,
    .table-bordered caption + tbody tr:first-child th,
    .table-bordered caption + tbody tr:first-child td,
    .table-bordered colgroup + thead tr:first-child th,
    .table-bordered colgroup + tbody tr:first-child th,
    .table-bordered colgroup + tbody tr:first-child td,
    .table-bordered thead:first-child tr:first-child th,
    .table-bordered tbody:first-child tr:first-child th,
    .table-bordered tbody:first-child tr:first-child td {
        border-top: 0;
    }

    .table-bordered thead:first-child tr:first-child th:first-child,
    .table-bordered tbody:first-child tr:first-child td:first-child {
        -webkit-border-top-left-radius: 4px;
        border-top-left-radius: 4px;
        -moz-border-radius-topleft: 4px;
    }

    .table-bordered thead:first-child tr:first-child th:last-child,
    .table-bordered tbody:first-child tr:first-child td:last-child {
        -webkit-border-top-right-radius: 4px;
        border-top-right-radius: 4px;
        -moz-border-radius-topright: 4px;
    }

    .table-bordered thead:last-child tr:last-child th:first-child,
    .table-bordered tbody:last-child tr:last-child td:first-child,
    .table-bordered tfoot:last-child tr:last-child td:first-child {
        -webkit-border-radius: 0 0 0 4px;
        -moz-border-radius: 0 0 0 4px;
        border-radius: 0 0 0 4px;
        -webkit-border-bottom-left-radius: 4px;
        border-bottom-left-radius: 4px;
        -moz-border-radius-bottomleft: 4px;
    }

    .table-bordered thead:last-child tr:last-child th:last-child,
    .table-bordered tbody:last-child tr:last-child td:last-child,
    .table-bordered tfoot:last-child tr:last-child td:last-child {
        -webkit-border-bottom-right-radius: 4px;
        border-bottom-right-radius: 4px;
        -moz-border-radius-bottomright: 4px;
    }

    .table-bordered caption + thead tr:first-child th:first-child,
    .table-bordered caption + tbody tr:first-child td:first-child,
    .table-bordered colgroup + thead tr:first-child th:first-child,
    .table-bordered colgroup + tbody tr:first-child td:first-child {
        -webkit-border-top-left-radius: 4px;
        border-top-left-radius: 4px;
        -moz-border-radius-topleft: 4px;
    }

    .table-bordered caption + thead tr:first-child th:last-child,
    .table-bordered caption + tbody tr:first-child td:last-child,
    .table-bordered colgroup + thead tr:first-child th:last-child,
    .table-bordered colgroup + tbody tr:first-child td:last-child {
        -webkit-border-top-right-radius: 4px;
        border-top-right-radius: 4px;
        -moz-border-radius-topright: 4px;
    }

    .table-striped tbody tr:nth-child(odd) td,
    .table-striped tbody tr:nth-child(odd) th {
        background-color: #f9f9f9;
    }

    .table-hover tbody tr:hover td,
    .table-hover tbody tr:hover th {
        background-color: #f5f5f5;
    }

    table td[class*="span"],
    table th[class*="span"],
    .row-fluid table td[class*="span"],
    .row-fluid table th[class*="span"] {
        display: table-cell;
        float: none;
        margin-left: 0;
    }

    .table td.span1,
    .table th.span1 {
        float: none;
        width: 44px;
        margin-left: 0;
    }

    .table td.span2,
    .table th.span2 {
        float: none;
        width: 124px;
        margin-left: 0;
    }

    .table td.span3,
    .table th.span3 {
        float: none;
        width: 204px;
        margin-left: 0;
    }

    .table td.span4,
    .table th.span4 {
        float: none;
        width: 284px;
        margin-left: 0;
    }

    .table td.span5,
    .table th.span5 {
        float: none;
        width: 364px;
        margin-left: 0;
    }

    .table td.span6,
    .table th.span6 {
        float: none;
        width: 444px;
        margin-left: 0;
    }

    .table td.span7,
    .table th.span7 {
        float: none;
        width: 524px;
        margin-left: 0;
    }

    .table td.span8,
    .table th.span8 {
        float: none;
        width: 604px;
        margin-left: 0;
    }

    .table td.span9,
    .table th.span9 {
        float: none;
        width: 684px;
        margin-left: 0;
    }

    .table td.span10,
    .table th.span10 {
        float: none;
        width: 764px;
        margin-left: 0;
    }

    .table td.span11,
    .table th.span11 {
        float: none;
        width: 844px;
        margin-left: 0;
    }

    .table td.span12,
    .table th.span12 {
        float: none;
        width: 924px;
        margin-left: 0;
    }

    .table tbody tr.success td {
        background-color: #dff0d8;
    }

    .table tbody tr.error td {
        background-color: #f2dede;
    }

    .table tbody tr.warning td {
        background-color: #fcf8e3;
    }

    .table tbody tr.info td {
        background-color: #d9edf7;
    }

    .table-hover tbody tr.success:hover td {
        background-color: #d0e9c6;
    }

    .table-hover tbody tr.error:hover td {
        background-color: #ebcccc;
    }

    .table-hover tbody tr.warning:hover td {
        background-color: #faf2cc;
    }

    .table-hover tbody tr.info:hover td {
        background-color: #c4e3f3;
    }
</style>