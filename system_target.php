<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Системные цели и задачи");

global $USER;
$id = $USER->GetID();
$accesusers = [3906, 3907];
?>



<? 
if(in_array($id ,$accesusers)) {
	echo '<iframe title="KSG_dashbord_ver3" width="100%" height="950" 
src="https://app.powerbi.com/view?r=eyJrIjoiYmNkNDRjYjAtYTRlZi00ZTlhLWJhYTYtYzY4ZTFmY2EwMmQxIiwidCI6ImI3MjkwOTZkLTJiZGEtNDlkZi05NWVhLWZjZjNjMjcwNzM5ZiIsImMiOjl9" frameborder="0" allowFullScreen="true"></iframe>';
} else {
	echo "<p>У Вас нет прав на просмотр данного отчета</p>";
}
?>





<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>