<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if(CSite::InGroup( array(1, 66) )) {
$APPLICATION->SetTitle("Актуальный сводный бюджет СМР по проектам Спб и МСК");
?><iframe title="Проект - Страница 1" width="100%" height="950" src="https://app.powerbi.com/view?r=eyJrIjoiYjBkYTRlYWEtMDJhMS00Y2JmLWFjYmItYTNjNzI1YmQzMWQ1IiwidCI6ImI3MjkwOTZkLTJiZGEtNDlkZi05NWVhLWZjZjNjMjcwNzM5ZiIsImMiOjl9" frameborder="0" allowFullScreen="true"></iframe><?
} else {
	echo 'Нет доступа';
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>