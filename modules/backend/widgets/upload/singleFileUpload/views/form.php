<?php
$cs = Yii::app()->clientScript;

//отображаем список загруженных файлов
$files = $this->getFilesForJson();
$cs->registerScript('single-file-upload-exist-model#'.$this->id, '
  var $fileUpload = $("#'.$this->id.'");
  $fileUpload.find(".files").html(tmpl("'.$this->downloadTemplate.'", '.
  CJavaScript::encode(array(
    'files' => $files,
  )).')).find(".template-download").addClass("in");
  BackendUploadedFiles.addList('.CJavaScript::encode($files).');
', CClientScript::POS_READY);

$cs->registerScript('single-file-upload#'.$this->id, '
  $("#'.$this->id.'")
    .on("fileuploadfailed", function(e, data) {
      if (!data.jqXHR) {
        return;
      }
      if (data.jqXHR.statusText == "abort") {
        return;
      }
      var msg = data.jqXHR.responseText;
      $.daSticker({text: msg, type: "error"});
    })
    .on("fileuploadcompleted", function(e, data) {
      var fu = $(this).data("blueimp-fileupload");
      fu._enableFileInputButton();
      fu._adjustMaxNumberOfFiles(1);
      var $children = $(this).find(".files").children();
      $children = $children.filter(":gt(0)");
      $children.remove();
      var fileId = "";
      if (data.result.files[0]) {
        fileId = data.result.files[0].fileId;
        BackendUploadedFiles.add(data.result.files[0]);
      }
      $("#'.CHtml::activeId($this->mainModel, $this->objectParameter->getFieldName()).'").val(fileId);
    }).on("fileuploaddestroyed", function(e, data) {
      var $btn = $(e.srcElement).closest(".template-download").find(".delete");
      var fileId = $btn.data("fileid");
      if (fileId) {
        $("#'.CHtml::activeId($this->mainModel, $this->objectParameter->getFieldName()).'").val("");
        BackendUploadedFiles.remove(fileId);
      }
    }).on("fileuploadfailed", function(e, data) {
      data.context.find(".delete").closest(".template-download").remove();
    });
  
', CClientScript::POS_READY);
?>

<!-- The file upload form used as target for the file upload widget -->

  <div class="fileupload-buttonbar">
  	<div class="span5">
  		<!-- The fileinput-button span is used to style the file input field as button -->
  		<span class="btn fileinput-button field-file <?php echo ($this->objectParameter->not_null?'b-field-notnull':'');?>">
              <i class="icon-plus"></i>
              <span><?php echo $this->t('1#Add files|0#Choose file', $this->multiple); ?></span>
  			<?php
              if ($this -> hasModel()) :
                  echo CHtml::activeFileField($this -> model, $this -> attribute, $htmlOptions) . "\n";
              else :
                  echo CHtml::fileField($name, $this -> value, $htmlOptions) . "\n";
              endif;
              ?>
  		</span>
  		<?php
  		 echo CHtml::activeHiddenField($this->mainModel, $this->objectParameter->getFieldName());
     echo $this->owner->form->error($this->mainModel, $this->objectParameter->getFieldName());
    ?>
    <?php if ($this->mainModel->isNewRecord) : ?>
    <?php echo CHtml::hiddenField(CHtml::activeName($this->mainModel, 'tmpId'), $this->model->tmpId); ?>
    <?php endif ?>
  	</div>
  	<div class="span5">
  		<!-- The global progress bar -->
  		<div class="progress progress-success progress-striped active fade">
  			<div class="bar" style="width:0%;"></div>
  		</div>
  	</div>
  </div>
  <!-- The loading indicator is shown during image processing -->
  <div class="fileupload-loading"></div>
  <!-- The table listing the files available for upload/download -->
  <table class="table table-striped">
  	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
  </table>

