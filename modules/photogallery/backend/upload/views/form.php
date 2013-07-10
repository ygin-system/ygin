<?php
$cs = Yii::app()->clientScript;
  
$cs->registerScript('list-file-upload#'.$this->id, '
  $("#'.$this->id.'")
    .on("fileuploadfailed", function(e, data) {
      var msg = data.jqXHR.responseText;
      $.daSticker({text: msg, type: "error"});
    }).on("fileuploadfailed", function(e, data) {
      data.context.find(".delete").closest(".template-download").remove();
    });
  ', CClientScript::POS_READY);
?>

<!-- The file upload form used as target for the file upload widget -->

  <div class="fileupload-buttonbar" style="overflow:hidden;">
  	<div class="span5">
  		<!-- The fileinput-button span is used to style the file input field as button -->
  		<span class="btn fileinput-button">
              <i class="icon-plus"></i>
              <span><?php echo $this->t('1#Add files|0#Choose file', $this->multiple); ?></span>
  			<?php
              if ($this -> hasModel()) :
                  echo CHtml::activeFileField(
                    $this -> model,
                    $this -> attribute,
                    CMap::mergeArray($htmlOptions, array('accept' => 'image/*'))
                  ) . "\n";
              else :
                  echo CHtml::fileField($name, $this -> value, $htmlOptions) . "\n";
              endif;
              ?>
  		</span>
  		<?php if ($this->mainModel->isNewRecord) : ?>
    <?php echo CHtml::hiddenField(CHtml::activeName($this->mainModel, 'tmpId'), $this->model->tmpId); ?>
    <?php endif ?>
  	</div>
  	<div class="span6 fileupload-progress fade">
    <!-- The global progress bar -->
    <div class="progress progress-success progress-striped active">
        <div class="bar" style="width:0%;"></div>
    </div>
    <!-- The extended global progress information -->
    <div class="progress-extended" style="font-size: 12px">&nbsp;</div>
  </div>
  </div>
  <!-- The loading indicator is shown during image processing -->
  <div class="fileupload-loading"></div>
  <br>
  <!-- The table listing the files available for upload/download -->
  <table class="table table-striped">
  	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
  </table>

