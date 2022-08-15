<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}
?>

<? if(!empty($arResult['FORM_DESCRIPTION'])): ?>
    <?= $arResult['FORM_DESCRIPTION']; ?>
<? endif; ?>

<? if($arResult['isFormErrors'] == 'Y'): ?>
    <?= $arResult['FORM_ERRORS_TEXT']; ?>
<? endif; ?>

<?= $arResult['FORM_HEADER']; ?>
    <div class="row">
        <? foreach ($arResult['QUESTIONS'] as $FIELD_SID => $arQuestion): ?>
            <? if($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'): ?>
                <?= $arQuestion['HTML_CODE']; ?>
            <? else: ?>
            <div class="form-group col-md-6 col-12 mb-3">
                <div class="form-label">
                    <? if($arQuestion['REQUIRED'] == 'Y'): ?><?= $arResult['REQUIRED_SIGN'];?><? endif; ?> <?= $arQuestion['CAPTION']; ?>
                </div>
                <div class="form-field">
                    <?= $arQuestion['HTML_CODE']; ?>
                </div>
            </div>
            <? endif; ?>
        <? endforeach; ?>
    </div>
    <input type="submit" class="btn d-block bg-active round text-uppercase text-center text-white py-3 px-4 px-md-5" name="web_form_submit" value="Отправить" />
<?= $arResult['FORM_FOOTER']; ?>