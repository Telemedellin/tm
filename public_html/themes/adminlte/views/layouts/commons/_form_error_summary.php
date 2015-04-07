<?php if($form->errorSummary($model)): ?>
<div class="row">
    <div class="col-sm-8">
        <div class="alert alert-warning alert-dismissable">
            <i class="fa fa-warning"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $form->errorSummary($model); ?>
        </div>
    </div>
</div>
<?php endif ?>