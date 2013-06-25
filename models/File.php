<?php

Yii::import('ygin.ext.ImageUtils', true);

/**
 * This is the model class for table "da_files".
 *
 * The followings are the available columns in table 'da_files':
 * @property integer $id_file
 * @property string $file_path
 * @property integer $id_file_type
 * @property integer $count
 * @property integer $id_object
 * @property integer $id_instance
 * @property integer $id_parameter
 * @property integer $id_property
 * @property integer $create_date
 * @property integer $id_parent_file
 * @property string $id_tmp
 * @property integer $status_process
 */
class File extends DaActiveRecord {

  const FILE_IMAGE = 1;
  const ID_OBJECT = 37;

  protected $idObject = self::ID_OBJECT;

  // нужны только ресайза картинок (см. метод resizeImage).
  private static $_initSize = false;
  private static $_maxWidth = 0;
  private static $_maxHeight = 0;


  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return File the static model class
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'da_files';
  }

  public function getFileType() {
    return $this->id_file_type;
  }
  public function definitionFileType() {
    $extension = HFile::getExtension($this->getFilePath());
    $images = array('jpg', 'gif', 'png', 'bmp');
    if (in_array($extension, $images)) {
      return File::FILE_IMAGE;
    }
    return null;
  }
  public function getStatusProcess() {
    return $this->status_process;
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    return array(
      array('file_path', 'required'),
      array('id_file_type, count, id_instance, id_property, create_date, id_parent_file, status_process', 'numerical', 'integerOnly' => true),
      array('id_parameter, id_object, file_path', 'length', 'max' => 255),
      array('id_tmp', 'length', 'max' => 32),
    );
  }

  public function byInstance(DaActiveRecord $model) {
    $alias = $this->getTableAlias();
    $this->getDbCriteria()->mergeWith(array(
        'condition' => $alias . '.id_object=:id_object AND ' . $alias . '.id_instance=:id_instance',
        'params' => array(':id_object' => $model->getIdObject(), ':id_instance' => $model->getIdInstance()),
    ));
    return $this;
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    return array(
      'childs' => array(self::HAS_MANY, 'File', 'id_parent_file'),
      'parameters' => array(self::BELONGS_TO, 'ObjectParamterer', 'id_parameter'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'id_file' => 'Id File',
        'file_path' => 'File Path',
        'id_file_type' => 'Id File Type',
        'count' => 'Count',
        'id_object' => 'Id Object',
        'id_instance' => 'Id Instance',
        'id_parameter' => 'Id Parameter',
        'id_property' => 'Id Property',
        'create_date' => 'Create Date',
        'id_parent_file' => 'Id Parent File',
        'id_tmp' => 'Id Tmp',
        'status_process' => 'Status Process',
    );
  }

  public function behaviors() {
    return array(
      'CTimestampBehavior' => array(
        'class' => 'zii.behaviors.CTimestampBehavior',
        'createAttribute' => 'create_date',
        'updateAttribute' => null
      ),
    );
  }

  protected function beforeDelete() {
    //Рекурсивно удаляем дочерние файлы:
    $this->deleteChildFile();

    //Удаляем файл:
    HFile::removeFile($this->getFilePath());
    
    //Удаляем папку где был файл (если пустая)
    HFile::removeDir(HFile::getDir($this->getFilePath()));
   
    return parent::beforeDelete();
  }
  public function deleteChildFile() {
    $files = $this->childs;
    foreach ($files AS $f)
      $f->delete();
  }

    
  public function getFilePath($absolute=false) {
    $root = ($absolute ? Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR : '');
    return $root.$this->file_path;
  }
  public static function translatePath($res, $host="/") {  //static
    $res = htmlentities(rawurlencode($res));
    $res = $host.str_replace("%2F", "/", $res);
    return $res;
  }
  /**
   * Возвращает абсолютный путь к файлу по урл
   * @return string
   */
  public function getUrlPath($absolute = false) {
    if ($this->file_path == null) {
      return null;
    }
    $res = $this->file_path;
    
    // Файлы хранят данные в разрезе домена:
//    $idDomain = $this->getIdDomainInstance();
/*
    $domain = null;
    $host = "/";
    if (DA_USE_FULL_LINK && $this->getIdInstanceOwner() != null && $this->getIdObjectOwner() != null) {
      $idDomain = Instance::getIdDomainFromObjectInstanceInfo($this->getIdObjectOwner(), $this->getIdInstanceOwner());
      if ($idDomain == null) {
        $idDomain = getSysParamValue("id_domain_default");
      }
      $domain = Domain::loadByIdDomain($idDomain);
    }
    if ($domain != null) {
      $path2file = $domain->getPath2File();
      $path2fileByHttp = $domain->getPath2FileByHttp();
      if ($path2file != null) {
        // Убираем из пути
        $len = mb_strlen($path2file) + 1; // + "/"
        if (mb_substr($res, 0, $len) == $path2file."/") {
          $res = mb_substr($res, $len);
        }
      }
      if ($path2fileByHttp != null) {
        // Добавляем в путь
        $res = $path2fileByHttp."/".$res;
      }

      // если домен не текущий, то добавляем http://domain.ru
      global $daDomain;
      if ($daDomain->getIdDomain() != $domain->getIdDomain()) {
        $host = "http://".$domain->getDomainName()."/";
      }
    }
  */
    $baseUrl = Yii::app()->getBaseUrl();
    if (empty($baseUrl)) {
      $host = '/';
    }
    if ($absolute) {
      $host = Yii::app()->request->getHostInfo().$host;
    }
    return self::translatePath($res, $host);
  }
  
  
  /**
   * Обработка создания превью картинки, сохранение в той же директории, что и оригинал с
   * постфиксом $postfix и регистрации превью, если она до этого не существовала
   * @param integer $w Ширина превью, если ноль, то ширина растягивается пропорционально высоте.
   * @param integer $h Высота превью, если ноль, то высота растягивается пропорционально широте.
   * @param string cropType - если не пустое, то картинка не растягивается, а вырезается под нужный размер. В этом случае нулей в ширине и высоте быть не может.
   * Возможные варианты: top|left(обрезается по верху, а если она растянута по ширине - то по центру)|right
   * @param string $postfix Постфикс, добавляется к имени файла
   * @param integer $quality Качество, в процентах
   * @param $resize Нужно ли масштабировать
   * @return File Превью
   */
  public function getPreview($w, $h, $postfix = '_p', $cropType = null, $quality = 80, $resize = false) {
    
    //Если не изображение
    if (!$this->getIsImage()) {
      return null;
    }
    
    if (!is_numeric($quality)) {
      $quality = 80;
    }
    
    //if ($f->getStatusProcess() == 1) return null;

    $root = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR;
    $fp = $this->file_path;
    $fotobig = $root.$fp;
    
    if (empty($fp) || !file_exists($fotobig)) {
      return null;
    }
    
    // если размеры меньше, то не увеличиваем
    $img = new ImageUtils();
    $a = $img->info($fotobig);
    if (($w > 0) && ($a['width'] <= $w) && (empty($cropType))) {
      $w = 0;
    }
    if (($h > 0) && ($a['height'] <= $h) && (empty($cropType))) {
      $h = 0;
    }
    $previewAfter = HFile::addPostfix($fotobig, $postfix);
    $need2register = !file_exists($previewAfter);
    
    if ($w == 0) $w = null;
    if ($h == 0) $h = null;

    $img = new ImageUtils();
    // нужно ли проверять размер превью
    $needResize = false;
    if (file_exists($previewAfter)) {
      if ($resize) {
        $prevInfo = $img->info($previewAfter);
        $rh = $h;
        $rw = $w;
        
         //Вписывает изображение в прямоугольник $w x $h
         if ($resize === 'auto') {
          if ($w > 0 && $h > 0) {
            $kw = $w / $a['width'];
            $kh = $h / $a['height'];
            
            $rh = round($kw * $a['height']);
            $rw = round($kw * $a['width']);
            
            if ($rh > $h) {
              $rh = round($kh * $a['height']);
              $rw = round($kh * $a['width']);
              $w = null;
            } else {
              $h = null;
            }
          }
        }
        $needResize = ($rw != null && $prevInfo['width'] != $rw) || ($rh != null && $prevInfo['height'] != $rh);
      }
    }
    // Создание превью
    if (!file_exists($previewAfter) || $needResize) {
      // 0-0
      if ($h == null && $w == null) {
        return $this;
      } else {
        //if (DA_CONTROL_PROCESS_FILE) $f->updateStatusProcess(1);
        if (!$img->open($fotobig)) {
          return null;
        }

        // 1-1
        if (!empty($cropType)) {
          $img->crop($w, $h, true, $cropType);
          // 1-0
        } else if ($h == null) {
          $k = $w / $img->width;
          $h = round($img->height * $k);
          $img->resize($w, $h);
          // 0-1
        } else if ($w == null) {
          $k = $h / $img->height;
          $w = round($img->width * $k);
          $img->resize($w, $h);
          // 1-1
        } else {
          $img->crop($w, $h, true, 'center');
        }
        $img->save($previewAfter, $quality);
        //if (DA_CONTROL_PROCESS_FILE) $f->updateStatusProcess(0);
      }
    }

    //if ($object == null) $object = $f->getIdObjectOwner();
    //if ($id == null) $id = $f->getIdInstanceOwner();

    $previewFile = new File();
    
    $previewFile->id_object = $this->id_object;
    $previewFile->id_instance = $this->id_instance;
    $previewFile->id_file_type = self::FILE_IMAGE;
    $previewFile->id_tmp = $this->id_tmp;
    $previewFile->id_parameter = $this->id_parameter;
      $previewFile->id_property = $this->id_property;
    $previewFile->file_path = mb_substr($previewAfter, mb_strlen($root));
    // регистрация
    if ($this->id_object != null && $previewAfter != null && $need2register && file_exists($previewAfter)) {
      $previewFile->id_parent_file = $this->id_file;
      $previewFile->insert();
      chmod($previewAfter, 0777);
    }
    
    return $previewFile;
  }

  public function resizeImage() {
    if ($this->getFileType() != self::FILE_IMAGE) return false;

    // узнаем ширину и высоту
    $w = self::$_maxWidth;
    $h = self::$_maxHeight;

    if (!self::$_initSize) {
      $w = Yii::app()->params['upload_image_width'];
      $h = Yii::app()->params['upload_image_height'];
      if ($w == null || !is_numeric($w) || $w < 0) {
        $w = 0;
      }
      if ($h == null || !is_numeric($h) || $h < 0) {
        $h = 0;
      }
      self::$_maxWidth = intval($w);
      self::$_maxHeight = intval($h);
      self::$_initSize = true;
    }

    if ($w == 0 && $h == 0) {
      return false;
    }

    $path = $this->getFilePath(true);
    if ($path == null || !file_exists($path)) {
      return false;
    }

    // если размеры меньше
    $img = new ImageUtils();
    $a = $img->info($path);
    if ($a['width'] <= $w) {
      $w = 0;
    }
    if ($a['height'] <= $h) {
      $h = 0;
    }

    if ($w == 0 && $h == 0) {
      return false;
    }

    if (!$img->open($path)) {
      return false;
    }

    // определяем по ширине или высоте делать ресайз:
    $newW = $w;
    $newH = $h;
    if ($w == 0 && $h != 0) {
      $newW = round(($h * $img->width) / $img->height);
    } else if ($h == 0 && $w != 0) {
      $newH = round(($w * $img->height) / $img->width);
    } else {
      $tmpH = round(($w * $img->height) / $img->width);
      if ($tmpH > $h) {
        $newW = round(($h * $img->width) / $img->height);
      } else {
        $newH = round(($w * $img->height) / $img->width);
      }
    }
    $img->resize($newW, $newH);
    $img->save($path, 94);
    return true;
  }

  protected function beforeSave() {
    if (empty($this->id_file_type)) {
      $this->id_file_type = FileExtension::getTypeByExt($this->getExtension());
    }
    $this->resizeImage();
    return parent::beforeSave();
  }
  public function getIsImage() {
    return HFile::isImage(HFile::getExtension($this->file_path));
  }
  public function getName() {
    return HFile::getFileNameByPath($this->file_path);
  }
  public function getExtension() {
    return HFile::getExtension($this->file_path);
  }
  public function getReadableFileSize($verbose = false) {
    return Yii::app()->format->formatSize($this->getSize(), $verbose);
  }
  public function getSize() {
    $size = null;
    if (file_exists($this->getFilePath(true))) {
      $size = filesize($this->getFilePath(true));
    }
    return $size;
  }
}
