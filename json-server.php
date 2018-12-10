<?php
//กำหนด response header
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//ต้องเป็น POST Method เท่านั้น
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    throw new Exception('Request method must be POST!');
}
 
//Content type  ของ request ต้องเป็น application/json เท่านั้น
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if(strcasecmp($contentType, 'application/json') != 0){
    throw new Exception('Content type must be: application/json');
}
 
//ดึงข้อมูลจาก RAW post data
$content = trim(file_get_contents("php://input"));
 
//แปลง RAW post data จาก JSON เป็น อะเรย์
$decoded = json_decode($content, true);
 
//ตรวจสอบรูปแบบข้อมูลว่าถูกต้องหรือไม่
if(!is_array($decoded)){
    throw new Exception('Received content contained invalid JSON!');
}

//ตัวอย่างการทดสอบ
//อ่านค่าตัวแปรจากข้อมูลที่ POST เข้ามาและเพิ่มเติมข้อความ
$code = $decoded['code'];
$msg = $decoded['message']. ' ด้วย JSON';

//กำหนดค่าของ response ที่ต้องการส่งกลับ
$messageResponse = array('code'=>$code,'message'=>$msg);

//ส่ง JSON สตริงกลับ
echo json_encode($messageResponse);

?>