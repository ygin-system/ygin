<?php

interface IApplicationPlugin {

  /**
   * Создание экземпляра плагина
   * @param array $config Конфигурация плагина, определенная в конфиге приложения
   * @return IApplicationPlugin
   */
  public static function createPlugin(array $config);

  /**
   * Имя плагина
   * @return string
   */
  public function getName();

  /**
   * Версия плагина
   * @return string
   */
  public function getVersion();

  /**
   * Дата обновления плагина
   * @return string
   */
  public function getVersionDate();

  /**
   * Краткое описание плагина для страницы списка плагинов
   * @return string
   */
  public function getShortDescription();

  /**
   * Подробное описание плагина на страницу настройки плагина
   * @return string
   */
  public function getDescription();

  /**
   * Путь к картинке. Картинка отображается в списке плагинов
   * @return string
   */
  public function getImage();

  /**
   * Внешняя ссылка
   * @return string
   */
  public function getLink();

  /**
   * Показывает надо ли обновить главное меню системы управления после установки/активации/деактивации/удаления плагина
   * @return boolean
   */
  public function isMenuChange();

  /**
   * Получает описание параметров, на основании которых будет отрисована форма для их редактирования
   * Каждый параметр представляет из себя ассоциативный массив. В качестве ключа используется имя параметра, в качестве значения ассоциативный массив с конфигурацией параметра.
   * Например:
   * <pre>
   * 'showCategories' => array(
   *   'type' => DataType::BOOLEAN, // тип параметра
   *   'default' => false, // значение по умолчанию
   *   'label' => 'Использовать ли на сайте категории новостей', // имя свойства
   *   'description' => null,  // дополнительное описание, отображается во всплывающей подсказке
   *   'required' => false,  // обязательное ли для заполнение
   * ),
   * </pre>
   * @return array
   */
  public function getSettingsOfParameters();

  /**
   * Формирует конфиг для приложения по значениям параметров плагина и данных плагина
   * @param array $paramsValue ассоциативный массив, ключом которого выступает имя параметра (определяется в описании параметров {@link getSettingsOfParameters()}), а значение - значение, введенное пользователем.
   * @param mixed $data дополнительные данные, которые также могут содержать данные необходимые разместить в конфигурации приложения (например ид объекта или ид типа события).
   * @return array Например: return array('modules' => array('ygin.news' => $paramsValue));
   */
  public function getConfigByParamsValue(array $paramsValue, $data);

  /**
   * Извлекает значение параметра из конфига приложения. Метод обратный {@link getSettingsOfParameters()}. Далее, полученные значения параметров будут использоваться для построения формы редактирования параметров плагина
   * @param array $config массив с конфигурацией приложения плагина
   * @param mixed $data дополнительные данные
   * @return array Например: return $config['modules']['ygin.news'];
   */
  public function getParametersValueFromConfig($config, $data);

  /**
   * Возвращает массив зависимых плагинов. Без этих установленных плагинов, данный плагин работать не будет, поэтому и не будет возможности его установить.
   * @return array Например: return array('ygin.photogallery');
   */
  public function getDepends();

  /**
   * Метод обновления плагина. Вызывается для обновления плагина в системе на более новую версию.
   * @param Plugin $plugin, плагин который будет обновлен
   */
  public function updatePlugin(Plugin $plugin);

  /**
   * Установка плагина в систему
   * @param Plugin $plugin
   */
  public function install(Plugin $plugin);

  /**
   * Активация плагина в системе
   * @param Plugin $plugin
   */
  public function activate(Plugin $plugin);

  /**
   * Отключение плагина
   * @param Plugin $plugin
   */
  public function deactivate(Plugin $plugin);

  /**
   * Удаление плагина из системы
   */
  public function uninstall();

  /**
   * Метод вызывается при изменении параметров плагина.
   * Здесь необходимо реализовать изменение в системе, связанные с включением/отключением разных опций в параметрах плагина.
   * Например, при включении категорий новостей в плагине Новостей необходимо установить в систему поддержку Категорий новостей
   * @param Plugin $plugin
   */
  public function onChangeConfig(Plugin $plugin);
}
