<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$templateFolder = $this->GetFolder();

if ($_POST['ajax'] == 'Y') {

	define("NO_KEEP_STATISTIC", true);
	echo '<script src="' . $templateFolder . '/script.js"></script>';
	//echo '<link rel="stylesheet/less" type="text/css" href="'.$templateFolder.'/style.css">';
	echo '<link rel="stylesheet" type="text/css" href="' . $templateFolder . '/style.css">';
}
?>

<?/*<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.0.7/swiper-bundle.min.js" integrity="sha512-WlN87oHzYKO5YOmINf1+pSkbt4gm+lOro4fiSTCjII4ykJe/ycHKIaa9b2l9OMkbqEA4NxwTXAGFjSXgqEh19w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>*/?>

