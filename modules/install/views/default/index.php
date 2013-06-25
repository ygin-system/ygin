<?php
/* @var DefaultController $this
 * @var CActiveForm $form
 * @var DbSettings $dbSettings
 * @var UserSettings $userSettings
 */

$this->pageTitle = 'Установка Ygin';

Yii::app()->clientScript->registerScriptFile(
  CHtml::asset($this->module->getBasePath().'/assets/twitter-bootstrap-wizard/jquery.bootstrap.wizard.js')
);

Yii::app()->clientScript->registerCss('wizard.css', '
  #loader-overlay {position:absolute; background-color: white; opacity:0.3}
  #loader {position:absolute;}
  .control-group.error .errorMessage {color: #b94a48}
  .tab-content .tab-finish {overflow: hidden;}
');
?>
<?php if (file_exists($this->getLocalConfigFile())): ?>
<div class="alert alert-error">
Файл с конфигурацией <?php echo $this->getLocalConfigFile(); ?> уже существует.
Возможно, вы произвели установку ранее.
После установки файл будет перезаписан.
</div>
<?php endif; ?>

<?php if (empty($this->dumpFiles)): ?>
  <div class="alert alert-error">
    Файл <?php echo $this->getDumpFile(); ?> с дампом базы отсутствует.
    Установка невозможна.
  </div>
<?php return; endif; ?>

  <div id="rootwizard">
		 <div class="nav">
			<ul class="nav-pills">
			  <li><a href="#step1" data-toggle="tab">1. Необходимые требования</a></li>
				<li><a href="#step2" data-toggle="tab">2. Подключение к базе данных</a></li>
				<li><a href="#step3" data-toggle="tab">3. Создание пользователя администратора</a></li>
				<li><a href="#tabFinish" data-toggle="tab">4. Завершение установки</a></li>
			</ul>
		</div>
		<div class="tab-content">
		    <div class="tab-pane" id="step1">
		      <table class="table table-bordered">
           <thead><tr><th>Необходимо</th><th>Установлено</th></tr></thead>
           <?php foreach($requirements as $requirement): ?>
           <tr class="<?php echo $requirement['pass']?'success':'error'?>">
             <td><?php echo $requirement['require']; ?></td>
             <td><?php echo $requirement['current']; ?></td>
           </tr>
           <?php endforeach; ?>
          </table>
		    </div>
		    <div class="tab-pane" id="step2">
		      <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'db-settings-form',
                'method' => 'post',
                'action' => $this->createUrl('step2'),
                'enableClientValidation' => true,
                'enableAjaxValidation' => true,
                'clientOptions' => array(
                  'validateOnChange' => false,
                  'validateOnSubmit' => true,
                  'inputContainer' => '.control-group',
                  'afterValidate' => 'js:function($form, data, hasError) {
                    formValid["#step2"] = !hasError;
                    if (!hasError) {
                      $("#rootwizard").bootstrapWizard("next");
                    }
                    return false;
                  }',
                ),
                'htmlOptions' => array('class' => 'form-horizontal'),
              )); ?>
            <div class="control-group">
              <?php echo $form->labelEx($dbSettings, 'host', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo $form->textField($dbSettings, 'host', array('placeholder' => 'localhost')); ?>
                <?php echo $form->error($dbSettings, 'host'); ?>
              </div>
            </div>
            <div class="control-group">
              <?php echo $form->labelEx($dbSettings, 'port', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo $form->textField($dbSettings, 'port'); ?>
                <?php echo $form->error($dbSettings, 'port'); ?>
              </div>
            </div>
            <div class="control-group">
              <?php echo $form->labelEx($dbSettings, 'dbname', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo $form->textField($dbSettings, 'dbname'); ?>
                <?php echo $form->error($dbSettings, 'dbname'); ?>
              </div>
            </div>
            <div class="control-group">
              <?php echo $form->labelEx($dbSettings, 'user', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo $form->textField($dbSettings, 'user'); ?>
                <?php echo $form->error($dbSettings, 'user'); ?>
              </div>
            </div>
             <div class="control-group">
              <?php echo $form->labelEx($dbSettings, 'password', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo $form->passwordField($dbSettings, 'password'); ?>
                <?php echo $form->error($dbSettings, 'password'); ?>
              </div>
            </div>
            <div class="control-group">
              <div class="controls">
                <?php echo CHtml::label(
                  $form->checkBox($dbSettings, 'createDb').$dbSettings->getAttributeLabel('createDb'),
                  CHtml::activeId($dbSettings, 'createDb'),
                  array('class' => 'checkbox'));
                ?>
                <?php echo $form->error($dbSettings, 'password'); ?>
              </div>
            </div>
          <?php $this->endWidget(); ?>
		    </div>
			<div class="tab-pane" id="step3">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'user-settings-form',
                'method' => 'post',
                'action' => $this->createUrl('step3'),
                'enableClientValidation' => true,
                'enableAjaxValidation' => true,
                'clientOptions' => array(
                  'validateOnChange' => false,
                  'validateOnSubmit' => true,
                  'inputContainer' => '.control-group',
                  'afterValidate' => 'js:function($form, data, hasError) {
                    formValid["#step3"] = !hasError;
                    if (!hasError) {
                      $("#rootwizard").bootstrapWizard("next");
                    }
                    return false;
                  }',
                ),
                'htmlOptions' => array('class' => 'form-horizontal'),
              )); ?>
            <div class="control-group">
              <?php echo $form->labelEx($userSettings, 'fullName', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo $form->textField($userSettings, 'fullName'); ?>
                <?php echo $form->error($userSettings, 'fullName'); ?>
              </div>
            </div>
            <div class="control-group">
              <?php echo $form->labelEx($userSettings, 'name', array('class' => 'control-label')); ?>
              <div class="controls">
                 <?php echo $form->textField($userSettings, 'name'); ?>
                <?php echo $form->error($userSettings, 'name'); ?>
              </div>
            </div>
            <div class="control-group">
              <?php echo $form->labelEx($userSettings, 'email', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo $form->textField($userSettings, 'email'); ?>
                <?php echo $form->error($userSettings, 'email'); ?>
              </div>
            </div>
             <div class="control-group">
              <?php echo $form->labelEx($userSettings, 'password', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo $form->passwordField($userSettings, 'password'); ?>
                <?php echo $form->error($userSettings, 'password'); ?>
              </div>
            </div>
             <div class="control-group">
              <?php echo $form->labelEx($userSettings, 'passwordRepeat', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo $form->passwordField($userSettings, 'passwordRepeat'); ?>
                <?php echo $form->error($userSettings, 'passwordRepeat'); ?>
              </div>
            </div>
          <?php $this->endWidget(); ?>
		    </div>
		    <div class="tab-pane tab-finish" id="tabFinish">
        <div id="install-detail">
          <h3>Все готово к завершению установки!</h3>
          <div class="detail"></div>
          <button type="submit" class="btn btn-success btn-large pull-right btn-finish">Завершить установку</button>
        </div>
        <div id="install-setup" style="display:none;">
          <h3>Подождите немного...</h3>
          <div class="console"></div>
        </div>
		    </div>
			<ul class="pager wizard">
				<li class="previous"><a href="javascript:;">Назад</a></li>
			  <li class="next"><a href="javascript:;">Далее</a></li>
			</ul>
		</div>	
	</div>
 
	<script type="text/javascript">
  /**
   * Переменная, хранящая валидность форм
   * @type {{}}
   */
  var formValid = {'#step1': true};
	$(document).ready(function() {
	  	$('#rootwizard').bootstrapWizard({
    	 	onTabShow: function(tab, navigation, index) {
    	 	  if (tab.find('a').attr('href') == '#tabFinish') {
      	 	  $.get('<?php echo $this->createUrl('getSettingsDetail'); ?>', function(data) {
        	 	  $("#tabFinish .detail").html(data);
        	 	});
          }
    		}, 
    		onNext: function(tab, navigation, index) {
      		var href = tab.find('a').attr('href');
          if (/^#step/.test(href) &&
              formValid[href] != true) {
            $(href).find('form').submit();
            return false;
          }
    		  return true;
    		},
        onPrevious: function(tab, navigation, index) {
          var href = navigation.find('li:eq('+(index)+')').find('a').attr('href');
          if (/^#step/.test(href) && index > 0) {
            formValid[href] = false;
          }
          return true;
        },
    		onTabClick: function(tab, navigation, index) {
    		  return false
    	  } 
	  	});
    var log = function(str, type) {
      var classes = ['log-row'];
      if (type == 'success') {
        classes.push('text-success');
      } else if (type == 'error') {
        classes.push('text-error');
      }
      $('#tabFinish .console').append('<div class="'+classes.join(' ')+'">'+str+'</div>');
    }

    var importDumps = function() {
      var cntDumpFiles = <?php echo count($this->getDumpFiles()); ?>;
      var installDump = function(dumpFile, callback) {
        log('Импорт файла дампа '+dumpFile+ ' из '+cntDumpFiles);
        $.post('<?php echo $this->createUrl('importDump'); ?>', {dumpFile: dumpFile}, function(data) {
          if (data.success) {
            log('Файл импортирован успешно', 'success');
            if (dumpFile < cntDumpFiles) {
              installDump(dumpFile + 1);
            } else {
              executeMigrations();
            }
          } else if (data.error) {
            log('Ошибка импорта: '+data.error, 'error');
          }
        }, 'json').error(function(jXhr) {
          log('Ошибка импорта: '+jXhr.responseText, 'error');
        });
      }
      log('Подключение к базе и импорт дампов, '+cntDumpFiles+' шт.');
      installDump(1);
    }
    var executeMigrations = function() {
      log('Актуализация базы данных (прогон миграций)');
      $.post('<?php echo $this->createUrl('migrate'); ?>', function(data) {
        if (data.success) {
          log('Миграции выполнены успешно', 'success');
          createUser();
        }
      }, 'json').error(function(jXhr) {
        log('Ошибка миграций: '+jXhr.responseText, 'error');
      });
    }
    var createUser = function() {
      log('Создание пользователя');
      $.post('<?php echo $this->createUrl('createUser'); ?>', function(data) {
        if (data.success) {
          log('Пользователь создан успешно', 'success');
          log('Установка завершена! Теперь вы можете зайти в <a href="/admin/">систему управления</a> со своими учетными данными.', 'success');
        }
      }, 'json').error(function(jXhr) {
        log('Ошибка создания пользователя: '+jXhr.responseText, 'error');
      });
    } 
    $('#tabFinish .btn-finish').on('click', function(e) {
      $('#rootwizard .pager').hide();
      var $btn = $(this);
      $('#install-detail').hide();
      $('#install-setup').show();
      importDumps();
    });
	});
	
	$(document).ajaxStart(function() {
	  $('#loader-overlay, #loader').remove();
	  $('<div id="loader-overlay"></div>').appendTo('body');
	   var $wiz = $('#rootwizard');
	  $('#loader-overlay').offset($wiz.offset()).width($wiz.width()).height($wiz.height());
	  $('<img id="loader" src="<?php echo CHtml::asset($this->module->getBasePath().'/assets/ajax-loader.gif'); ?>">').appendTo('body');
	  $('#loader').offset({top:$wiz.offset().top + ($wiz.height() / 2), left: $wiz.offset().left + ($wiz.width() / 2)});	
	});
	$(document).ajaxStop(function() {
	  $('#loader-overlay, #loader').remove();
	});

	</script>