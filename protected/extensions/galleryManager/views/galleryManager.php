<?php
/**
 * @var $this GalleryManager
 * @var $model GalleryPhoto
 *
 * @author Bogdan Savluk <savluk.bogdan@gmail.com>
 */
?>
<?php echo CHtml::openTag('div', $this->htmlOptions); ?>
    <!-- Gallery Toolbar -->
    <div class="btn-toolbar gform">
        <span class="btn btn-success fileinput-button">
            <span class="glyphicon glyphicon-plus"></span>
            <?php echo Yii::t('galleryManager.main', 'Add…');?>
            <input type="file" name="image" class="afile" accept="image/*" multiple="multiple"/>
        </span>

        <div class="btn-group">
            <label class="btn">
                <input type="checkbox" style="margin: 0;" class="select_all"/>
                <?php echo Yii::t('galleryManager.main', 'Select all');?>
            </label>
            <span class="btn disabled edit_selected"><span class="glyphicon glyphicon-pencil"></span> <?php echo Yii::t('galleryManager.main', 'Edit');?></span>
            <span class="btn disabled remove_selected"><span class="glyphicon glyphicon-remove"></span> <?php echo Yii::t('galleryManager.main', 'Remove');?></span>
        </div>
    </div>
    <hr/>
    <!-- Gallery Photos -->
    <div class="sorter">
        <div class="images"></div>
        <br style="clear: both;"/>
    </div>

    <!-- Modal window to edit photo information -->
    <div class="modal fade editor-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title"><?php echo Yii::t('galleryManager.main', 'Edit information')?></h3>
                </div>
                <div class="modal-body">
                    <div class="form"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('galleryManager.main', 'Close')?></button>
                    <button type="button" class="btn btn-primary save-changes">
                        <?php echo Yii::t('galleryManager.main', 'Save changes')?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="overlay">
        <div class="overlay-bg">&nbsp;</div>
        <div class="drop-hint">
            <span class="drop-hint-info"><?php echo Yii::t('galleryManager.main', 'Drop Files Here…')?></span>
        </div>
    </div>
    <div class="progress-overlay">
        <div class="overlay-bg">&nbsp;</div>
        <!-- Upload Progress Modal-->
        <div class="progress-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3><?php echo Yii::t('galleryManager.main', 'Uploading images…')?></h3>
                    </div>
                    <div class="modal-body">
                        <div class="progress progress-striped active">
                            <div class="progress-bar bar upload-progress" role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo CHtml::closeTag('div'); ?>