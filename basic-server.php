<?php
//กำหนด response header
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//ไม่เจาะจง Method จะเป็นอะไรก็ได้ GET, POST, PUT ... ได้หมดถ้าสดชื่น
//ตัวอย่างการทดสอบ
//อ่านค่าตัวแปรจากข้อมูลที่ REQUEST เข้ามาและเพิ่มเติมข้อความ
$code = $_REQUEST['code'];
$msg = $_REQUEST['message'];

//กำหนดค่าของ response ที่ต้องการส่งกลับ
$messageResponse = array('code'=>$code,'message'=>$msg);

//ส่ง JSON สตริงกลับ
echo json_encode($messageResponse);

?>