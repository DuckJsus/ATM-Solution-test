<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arParams['NAME_TEMPLATE'] = $arParams['NAME_TEMPLATE'] ? $arParams['NAME_TEMPLATE'] : CSite::GetNameFormat(false);

$structure = \CIntranetUtils::GetStructure()['DATA'];
foreach ($structure as $section) {
    $arHeads[] = $section['UF_HEAD'];
}
$heads = implode(' | ', $arHeads);

$dbUsers = \CUser::getList(
    '',
    'ASC',
    ['ID' => $heads],
    []
);
while ($arUser = $dbUsers->Fetch()) {
    $arUsers[] = $arUser;
}

$arResult['USERS'] = $arUsers;

foreach ($arResult['USERS'] as $key => $arUser)
{
	if ($arUser['PERSONAL_PHOTO'])
	{
		$imageFile = CFile::GetFileArray($arUser['PERSONAL_PHOTO']);
		if ($imageFile !== false)
		{
			$arUser["PERSONAL_PHOTO"] = CFile::ResizeImageGet(
				$imageFile,
				array("width" => 100, "height" => 100),
				BX_RESIZE_IMAGE_EXACT,
				true
			);
		}
		else
			$arUser["PERSONAL_PHOTO"] = false;
	}
	
	$arResult['USERS'][$key] = $arUser;
}
?>