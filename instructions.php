<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$pageName = "Инструкции (Beta)";
$APPLICATION->SetTitle($pageName);
CJSCore::Init(array('jquery2'));
\Bitrix\Main\Loader::includeModule('disk'); 
?>

<?php

$APPLICATION->IncludeComponent(
	'bitrix:ui.sidepanel.wrapper',
	'',
	array(
		'POPUP_COMPONENT_NAME' => 'bitrix:disk.common',
		'POPUP_COMPONENT_TEMPLATE_NAME' => '',
		'POPUP_COMPONENT_PARAMS' => [
			"SEF_MODE" => "Y",
            "SEF_FOLDER" => "/docs/instruktsii",
            "STORAGE_ID" => "4283"
		],
		'USE_PADDING' => false,
		'PAGE_MODE'=> false,
		'PAGE_MODE_OFF_BACK_URL' =>	'/local/tools/bi/index.php',
		'BUTTONS' => ['close'],
	)
);

?>