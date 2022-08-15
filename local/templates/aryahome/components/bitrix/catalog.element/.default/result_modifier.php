<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$templateFolder = $this->GetFolder();

if ($_POST['ajax']=='Y'){

	define("NO_KEEP_STATISTIC", true);
	echo '<script src="'.$templateFolder.'/script.js"></script>';
	//echo '<link rel="stylesheet/less" type="text/css" href="'.$templateFolder.'/style.css">';
    echo '<link rel="stylesheet" type="text/css" href="'.$templateFolder.'/style.css">';
}
