<?php
/* @var $type string */
/* @var $activeTab bool */
/* @var $baselangdesc string */
/* @var $tolangdesc string */

extract($tabData);

?>

<div id='tab-<?php echo $type; ?>' class='tab-pane fade in <?php if ($activeTab) {
    echo "active";
             } ?>'>
    <?php
    Yii::app()->loadHelper('admin.htmleditor');
    echo PrepareEditorScript(true, Yii::app()->getController());
    ?>

    <div class='container-fluid translate'>
        <?php if (App()->getConfig('googletranslateapikey')) { ?>
            <input type='button' class='auto-trans' value='<?php eT("Auto Translate"); ?>'
                   id='auto-trans-tab-<?php echo $type; ?>'/>
            <img src='<?php echo Yii::app()->getConfig("adminimageurl"); ?>/ajax-loader.gif' style='display: none'
                 class='ajax-loader' alt='<?php eT("Loading..."); ?>'/>
        <?php } ?>

        <?php
        $threeRows = ($type == 'question' || $type == 'subquestion' || $type == 'answer');
        ?>
        <table class='table table-striped'>
            <thead>
            <?php if ($threeRows) { ?>
                <th class="col-md-2 text-strong"> <?= gT('Question code / ID') ?></th>
                <?php
            }
            $cssClass = $threeRows ? "col-sm-5 text-strong" : "col-sm-6";
            ?>
            <th class="<?= $cssClass ?>"> <?= $baselangdesc ?> </th>
            <th class="<?= $cssClass ?>"> <?= $tolangdesc ?> </th>
            </thead>

            <?php
            //table content should be rendered here translatefields_view
            //content of translatefields_view
            foreach ($singleTabFieldsData as $fieldData) {
                $textfrom = $fieldData['fieldData']['textfrom'];
                if (strlen(trim((string)$textfrom)) > 0) {
                    //there could be two fields ...
                    foreach ($fieldData['translateFields'] as $field) {
                        $this->renderPartial('translateFieldData', $field);
                    }
                } else { ?>
                    <input type='hidden' name='<?php echo $type; ?>_newvalue[<?php echo $i; ?>]'
                           value='<?php echo $textto; ?>'/>
                <?php }
            } ?>
        </table>

    </div>
    <?php if ($singleTabFieldsData[0]['all_fields_empty']) : ?>
        <p><?php eT("Nothing to translate on this page"); ?></p><br/>
    <?php endif; ?>
    <input type='hidden' name='<?php echo $type; ?>_size' value='<?php echo $singleTabFieldsData[0]['fieldData']['i']; ?>'/>
    <?php if ($singleTabFieldsData[0]['fieldData']['associated']) : ?>
        <input type='hidden' name='<?php echo $singleTabFieldsData[0]['fieldData']['type2']; ?>_size' value='<?php echo $singleTabFieldsData[0]['fieldData']['i']; ?>'/>
    <?php endif; ?>
</div>


