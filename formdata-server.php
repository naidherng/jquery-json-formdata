<?php
//กำหนด response header
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//ต้องเป็น POST Method เท่านั้น
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    throw new Exception('Request method must be POST!');
}

//ตัวอย่างการทดสอบ
$code = 0; //กำหนดค่าตัวแปรเพื่อทดสอบ

//อ่านค่าตัวแปรจากข้อมูลที่ POST เข้ามาและเพิ่มเติมข้อความ
$msg = $_POST['code_message']. ' ด้วย Formdata';

//สตริงที่ ถูก stringify จาก client มีการ escape \\ จึงแทนที่ด้วยค่าว่างเพื่อให้เป็นรูปแบบ JSON สตริงที่ถูกต้อง
$other_str = str_replace('\\','',$_POST['other_data']);

//ดีโค้ด JSON สตริงให้เป็นอะเรย์
$other_data = json_decode($other_str, true);

//เพิ่มเติมข้อความ
$msg .= ' ' .$other_data['data1'];
$msg .= ' [' .implode(',', $other_data['data2']).']';

//ขั้นตอนการรับรูปภาพ/ไฟล์ที่อัพโหลดมาจากไคลเอ็นท์
$folderPath = "uploads/";

//ดึงรายละเอียดของไฟล์ที่อัพโหลดมา
$path_parts = pathinfo(basename($_FILES['picture']['name']));

//กำหนดนามสกุลของไฟล์
$image_type = $path_parts['extension'];
//กำหนดชื่อไฟล์และโฟลเดอร์ที่จะนำไฟล์ไปบันทึก
$picture_name = $folderPath . date('YmdHis') . ".".$image_type;

//หากมีไฟล์เดิมให้ลบก่อน
if(file_exists($picture_name)){
    unlink($picture_name);
}

//ย้ายไฟล์ไปบันทึกตามโฟลเดอร์และชื่อที่กำหนด
$filleUploadResult = move_uploaded_file($_FILES['picture']['tmp_name'], $picture_name) ;

//กำหนดค่าของ response ที่ต้องการส่งกลับ
$messageResponse = array('code'=>$code,'message'=>$msg, 'picture'=>$picture_name);
if ($filleUploadResult===FALSE) {
    $messageResponse = array('code'=>500,'message'=>'Upload picture error!' ,'picture'=>'');
}

//ส่ง JSON สตริงกลับ
echo json_encode($messageResponse);

?>