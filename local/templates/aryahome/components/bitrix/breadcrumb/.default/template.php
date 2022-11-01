<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';

$strReturn .= '<div class="breadcrumbs d-md-block d-none w-100 mt-4 pt-2" itemscope itemtype="http://schema.org/BreadcrumbList">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	$arrow = ($index > 0? '

		<span class="mx-2">
            <svg fill="#262626" width="8" height="8" viewBox="0 0 8 8" xmlns="http://www.w3.org/2000/svg">
                <g>
                <path d="M6.27995 4.00002C6.27995 4.1434 6.22521 4.28676 6.11595 4.39607L2.67609 7.83589C2.45728 8.0547 2.1025 8.0547 1.88377 7.83589C1.66504 7.61716 1.66504 7.26245 1.88377 7.04362L4.92755 4.00002L1.88388 0.956413C1.66515 0.737596 1.66515 0.382927 1.88388 0.164216C2.10261 -0.0547075 2.45738 -0.0547076 2.6762 0.164216L6.11606 3.60398C6.22533 3.71334 6.27995 3.8567 6.27995 4.00002Z"></path>
                </g>
            </svg>
        </span>

		' : '');

	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
			<span id="bx_breadcrumb_'.$index.'" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				'.$arrow.'
				<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="item">
					<span itemprop="name">'.$title.'</span>
				</a>
				<meta itemprop="position" content="'.($index + 1).'" />
			</span>';
	}
	else
	{
		$strReturn .= '
			<span class="text-gray">
				'.$arrow.'
				'.$title.'
			</span>';
	}
}

$strReturn .= '<div style="clear:both"></div></div>';

return $strReturn;
