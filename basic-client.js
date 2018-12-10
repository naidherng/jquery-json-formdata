//กำหนดค่าเริ่มต้นให้กับ input ต่างๆ
$('#code').val('100');
$('input[name="message"]').val('สวัสดี เซิร์ฟเวอร์');
$('img[name="picture"]').hide();

//bind click event ให้กับปุ่ม bntGet
$('input[name="bntGet"]').click(function(){
    $('img[name="picture]').hide();
    //กำหนดค่าให้กับ request object 
    $.ajax({
        method: "GET",
        url: "basic-server.php",
        data: $( "form" ).serialize(), //serialize ฟอร์มที่ต้องการส่งข้อมูล
        dataType: "text"
    }).done(function(data){
        data = JSON.parse(data);
        console.log(data);
    });
});

//bind click event ให้กับปุ่ม bntPostJson
$('input[name="bntPostJson"]').click(function(){
    $('img[name="picture"]').hide();

    // สร้าง object
    var requestObj = {};
    requestObj.code = $('#code').val();
    requestObj.message = $('#message').val();

    //กำหนดค่าให้กับ request object 
    $.ajax({
        method: "POST",
        contentType: 'application/json',
        data: JSON.stringify(requestObj), //stringify object ให้เป็น JSON สตริง
        url: "json-server.php", 
        dataType: "text"
    }).done(function(data){
        data = JSON.parse(data);
        console.log(data);
    });
});

//bind click event ให้กับปุ่ม bntPostFormdata
$('input[name="bntPostFormdata"]').click(function(){
    $('img[name="picture"]').hide();

    //สร้าง FormData object
    var formData = new FormData();
    
    //เพิ่มข้อมูลเข้าไปใน formData โดยเอาค่าจาก input ในฟอร์ม
    formData.append('code_message', $('#code').val()+ "+"+ $('#message').val());

    //สร้าง object ใหม่เพิ่มขึ้นมา
    var otherObj = {};
    otherObj.data1 = 'data1';
    otherObj.data2 =  [1,2,3];

    //stringify object ใหม่และเพิ่มเข้าไปใน formData
    formData.append('other_data',JSON.stringify(otherObj));

    //อ่านค่าจาก input file
    var imgFile = document.querySelector('#attachment').files[0];
    if(imgFile){

        //เพิ่มค่าที่อ่านค่าจาก input file เข้าไปใน formData
        formData.append('picture', imgFile);

        //กำหนดค่าให้กับ request object 
        $.ajax({
            method: "POST",
            enctype: 'multipart/form-data',
            url: "formdata-server.php",
            data: formData,
            dataType: "text",
            processData: false,  //สำคัญมาก
            contentType: false,
            cache: false
        }).done(function(data){
            data = JSON.parse(data);
            console.log(data);

            //ลบค่าของ input file โดยที่ไม่กระทบกับ input อื่นๆ
            var elf = jQuery('#attachment');
   			elf.wrap('<form>').closest('form').get(0).reset();
            elf.unwrap();

            //แสดงรูป
            if(data.code!=500){
                $('img[name="picture"]').attr('src',data.picture);
                $('img[name="picture"]').show();
            }
            
        });
   }else{
        alert('Please select picture!.');
   }
});