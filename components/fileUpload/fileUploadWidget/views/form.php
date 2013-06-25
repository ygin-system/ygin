<!-- The file upload form used as target for the file upload widget -->
<?php if ($this->showForm) echo CHtml::beginForm($this -> url, 'post', $this -> htmlOptions);?>
<div class="row fileupload-buttonbar">
	<div class="span7">
		<!-- The fileinput-button span is used to style the file input field as button -->
		<span class="btn btn-success fileinput-button">
            <i class="icon-plus icon-white"></i>
            <span><?php echo $this->t('1#Add files|0#Choose file', $this->multiple); ?></span>
			<?php
            if ($this -> hasModel()) :
                echo CHtml::activeFileField($this -> model, $this -> attribute, $htmlOptions) . "\n";
            else :
                echo CHtml::fileField($name, $this -> value, $htmlOptions) . "\n";
            endif;
            ?>
		</span>
		<?php if ($this->mainModel->isNewRecord) : ?>
  <?php echo CHtml::hiddenField(CHtml::activeName($this->mainModel, 'tmpId'), $this->model->tmpId); ?>
  <?php endif ?>
	</div>
	
 <!-- The global progress bar -->
 <div class="span5 fileupload-progress fade">
  <div class="progress progress-success progress-striped active">
      <div class="bar" style="width:0%;"></div>
  </div>
  <!-- The extended global progress information -->
  <div class="progress-extended">&nbsp;</div>
</div>

<!-- The loading indicator is shown during image processing -->
<div class="fileupload-loading"></div>
<br>
<!-- The table listing the files available for upload/download -->
<table class="table table-striped">
	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
</table>
<?php if ($this->showForm) echo CHtml::endForm();?>
