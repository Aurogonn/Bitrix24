<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Задать вопрос");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
\Bitrix\Main\UI\Extension::load('ui.sidepanel-content');
?>

<?
global $USER;
$name = $USER->GetFullName();
$id = $USER->GetID();

$resUser = CUser::GetByID($id);
$arUser = $resUser->Fetch();

$user_name = $arUser['NAME'];
$user_lastname = $arUser['LAST_NAME'];
$user_secondname = $arUser['SECOND_NAME'];
$user_email = $arUser['EMAIL'];

/////////////array iblock==180
$arr_result = [];
$bs_filter = array("IBLOCK_ID"=>180);
$bs_result = CIBlockElement::GetList(array(), $bs_filter, false);
while($ob = $bs_result->GetNextElement()) {
	$bs_Props = $ob->GetProperties();
	$proc_name = $bs_Props["PROTSESS"]["~VALUE"]["TEXT"];
	array_push($arr_result, $proc_name);
}
?>

<style>
.form {

	margin-left: 40px;

}

.questions {margin-top: 30px;}

.name-process {
	border: 1px solid;
	border-radius: 5px;
	height: 30px;
	width: 500px;
	margin-top: 10px;
}
.text-questions {
	border: 1px solid;
	border-radius: 5px;
	height: 100px;
	width: 500px;
	margin-top: 10px;
}


.my {
	width: 0.1px;
	height: 0.1px;
	opacity: 0;
	overflow: hidden;
	position: absolute;
	z-index: -1;
}

.label {
    width: 180px;
    height: 50px;
    border-radius: 4px;
    text-align: center;
    cursor: pointer;
    display: block;
    font: 14px/50px Tahoma;
    transition: all 0.18s ease-in-out;
    border: 1px solid #333;
    color: #333;
	margin-top: 10px;
}

.label:hover {
    color: white;
    background: #333;
}

.text-questions2 {
	border: 1px solid;
	border-radius: 5px;
	height: 100px;
	width: 500px;
}

/*.button {
	margin-top: 30px;
	width: 138px;
	height: 40px;
	background-color: #bbed21;
	border-radius: 1px;
	font-size: 16px;
	cursor: pointer;
}*/

.button_q {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	color: #535c69;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
	background-color: #bbed21;
	border: 1px solid #bbed21;
	padding: .375rem .75rem;
	font-size: 12px;
	font-weight: 600;
	line-height: 1.5;
	transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
	position: relative;
	cursor: pointer;
	width: 138px;
	height: 40px;
	border-radius: 2px;
}

.input-file {
	margin-top: 10px;
	position: relative;
	display: inline-block;
	/*border: 1px solid;*/
	/*border-radius: 1px;*/
}
.input-file span {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	font-weight: 600;
	color: #535c69;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
	background-color: #bbed21;
	border: 1px solid #bbed21;
	padding: .375rem .75rem;
	font-size: 12px;
	line-height: 1.5;
	border-radius: 2px;
	transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
	position: relative;
	cursor: pointer;
	/* width: 138px;
	height: 40px; */
}
.input-file input[type=file] {
	position: absolute;
	z-index: -1;
	opacity: 0;
	display: block;
	width: 0;
	height: 0;
	margin-top: 10px;
}
 
/* Focus */
.input-file input[type=file]:focus + span {
	box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}
 


.btn-success {
	margin-top: 30px;
}

textarea {
	resize: vertical;
}

</style>

<?php
if($_FILES) {
	echo "<pre>"; print_r($_FILES); echo "</pre>";

}


?>
<!-- <h2> Здравствуйте, <?php echo $user_lastname, '  ', $user_name, '  ', $user_secondname ?> </h2> -->
<div class="form" method="POST">
	<h2>Задайте свой вопрос</h2>
	<p><i>Ваши вопросы и предложения позволяют развивать и оптимизировать процессы.<br>
	Мы будем благодарны Вам, если Вы полностью заполните форму</i></p>
	
	<form actions="check.php" method="POST" enctype='multipart/form-data'>
	
		<p style="margin-top: 30px;">Задайте свой вопрос / изложите свое предложение:<br></p>
		<textarea name="other" type="text" id="questions2" class="text-questions2" minlength="2" maxlength="5000" required="required"></textarea>
	
		<div class="questions">Прикрепите файлы (при необходимости)</div>
		<label class="input-file">
			<input type="file" name="attach[]" multiple>		
			<span>ВЫБЕРИТЕ ФАЙЛ</span>
		</label>
	


        <div class="btn-success">
          <button type="submit" class="button_q">ЗАДАТЬ ВОПРОС</button>
        </div>
	</form>

</div>

<script src="https://snipp.ru/cdn/jquery/2.1.1/jquery.min.js"></script>
<script>
$('.input-file input[type=file]').on('change', function(){
	let file = this.files[0];
	$(this).next().html(file.name);
});
</script>

<?php 

if($_SERVER["REQUEST_METHOD"] == "POST"){

// $process = $_POST['process'];
// $quest = $_POST['questions'];
$file = $_POST['file'];
$other = $_POST['other'];



$attachs = [];
//require 'vendor/autoload.php';
$mail = new PHPMailer(true);

try {
	$mail->SMTPDebug = 2;
	$mail->ErrorInfo;
	$mail->isSMTP();
	$mail->CharSet = 'UTF-8';
	$mail->Encoding = 'base64';
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth   = true;
	$mail->Username   = 'artem.bulatov3@gmail.com';
	$mail->Password   = 'clcgtdhtgemhtfbo';
	$mail->Port = 587;
	$mail->setFrom($user_email, "Аналитическая отчетноть");
	//$mail->addAddress("g.vokin@sevensuns.ru");
	//$mail->addAddress("av.morozov@sevensuns.ru");
	$mail->addAddress("a.bulatov@sevensuns.ru");//Кому отправляем
	//$mail->addReplyTo("kudaotvetit@yandex.ru","Имя кому писать при ответе");
	$mail->SMTPSecure = 'tls';
	$mail->isHTML(true);//HTML формат
	$mail->Subject = "Вопрос по аналитической отчетности";
	$mail->Body    =   "
	<html>
	<head>
	<title></title>
	</head>
	<body>                
	<p><b>Вопрос от пользователя</b>: $user_lastname  $user_name  $user_secondname  ( $user_email )</p>                      
	<p><b>Вопрос</b>: $other</p>
	<p>Если к форме был прикреплен файл, то он будет во вложении.</p>           
	</body>
	</html>";
	//$mail->AltBody = "Альтернативное содержание сообщения";
	
	// if(!empty($_FILES['attach']['tmp_name'])) {
	// 	$filepath = __DIR__ . '/uploads/' . $_FILES['attach']['name'];
	// 	if(copy($_FILES['attach']['tmp_name'], $filepath)) {
	// 		$mail->addAttachment($filepath);
	// 	}
	// }
	if($_FILES['attach']['error'][0] == 0){
		foreach ($_FILES['attach']['name'] as $key => $attach) {
			$filepath = __DIR__ . '/uploads/' . $_FILES['attach']['name'][$key];
			$ext = mb_strtolower(pathinfo($_FILES['attach']['name'][$key], PATHINFO_EXTENSION));
			
			$name = basename($_FILES['attach']['name'][$key], $ext);
			$tmp = $_FILES['attach']['tmp_name'][$key];
			$newName = rtrim($name, '.') . '_' . uniqid() . '.' . $ext;
			echo $tmp."<br>";
			echo $filepath."<br>";
			echo $newName."<br>";
			if (!move_uploaded_file($tmp, $filepath . $newName)) {
			$data['result'] = 'error';
			$data['errors']['attach'][$key] = 'Ошибка при загрузке файла.';
			//itc_log('Ошибка при перемещении файла ' . $name . '.');
			} else {
			$attachs[] = $filepath . $newName;
			}
		}
		foreach ($attachs as $attach) {
			$mail->addAttachment($attach);
			}
		}

	$mail->send();
	echo "<script> alert('Сообщение отправлено')</script>";
} catch (Exception $e) {
	echo '<script>alert("Ошибка отправки: {$mail->ErrorInfo}?>")</script>';
  }
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
