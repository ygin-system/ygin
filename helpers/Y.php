<?php
/**
 * Класс-ярлык для часто употребляемых выражений Yii framework
 *
 * @author Leonid Svyatov <leonid@svyatov.ru>
 * @copyright Copyright (c) 2010-2011, Leonid Svyatov
 * @license http://www.yiiframework.com/license/
 * @version 1.2.1 / 25.01.2012
 * @link http://github.com/Svyatov/Yii-shortcut
 */
class Y
{
    /**
     * @var array Кэш компонентов приложения
     * @since 1.2.0
     */
    private static $_componentsCache = array();

    /**
     * Возвращает format-компонент приложения
     * @return CFormatter
     * @since 1.2.0
     */
    public static function format()
    {
        return self::_getComponent('format');
    }

    /**
     * Возвращает clientScript-компонент приложения
     * @return CClientScript
     * @since 1.2.0
     */
    public static function script()
    {
        return self::_getComponent('clientScript');
    }

    /**
     * Возвращает session-компонент приложения
     * @return CHttpSession
     * @since 1.2.0
     */
    public static function session()
    {
        return self::_getComponent('session');
    }

    /**
     * Удаляет переменную сессии
     * @param string $key Имя переменной
     * @return mixed Удаленное значение переменной или null, если такой переменной не найдено
     * @since 1.2.0
     */
    public static function sessionDelete($key)
    {
        return self::_getComponent('session')->remove($key);
    }

    /**
     * Возвращает переменную сессии
     * @param string $key Имя переменной
     * @param mixed $defaultValue Значение, возвращаемое если переменная не найдена
     * @return mixed
     * @since 1.2.0
     */
    public static function sessionGet($key, $defaultValue = null)
    {
        return self::_getComponent('session')->get($key, $defaultValue);
    }

    /**
     * Устанавливает значение переменной сессии
     * @param string $key Имя переменной
     * @param mixed $value Значение переменной
     * @since 1.2.0
     */
    public static function sessionSet($key, $value)
    {
        self::_getComponent('session')->add($key, $value);
    }

    /**
     * Создает и возвращает команду БД для исполнения
     * Можно использовать как для обращения к построителю запросов, так и для непосредственного выполнения SQL строки
     * @param string|array $query Строка SQL или массив частей запроса (смотри {@link CDbCommand::__construct}),
     * если аргумент не указан, то далее необходимо вызывать методы построителя запросов {@link CDbCommand}
     * @param string $dbId ID компонента базы данных, по умолчанию - 'db'
     * @return CDbCommand
     * @since 1.1.5
     */
    public static function dbCmd($query = null, $dbId = 'db')
    {
        return self::_getComponent($dbId)->createCommand($query);
    }

    /**
     * Возвращает значение параметра $name из глобального GET-массива
     * Если параметра с таким именем нет, то возвращает значение указанное в $defaultValue
     * @param $name Имя параметра или вложенных параметров через точку
     * Например, запрос значения параметра 'Post.post_text' будет искаться в $_GET['Post']['post_text']
     * @param mixed $defaultValue Значение, возвращаемое в случае отсутствия указанного параметра
     * @return mixed
     * @since 1.1.2
     */
    public static function getGet($name, $defaultValue = null)
    {
        return self::_getValueByComplexKeyFromArray($name, $_GET, $defaultValue);
    }

    /**
     * Возвращает значение параметра $name из глобального POST-массива
     * Если параметра с таким именем нет, то возвращает значение указанное в $defaultValue
     * @param $name Имя параметра или вложенных параметров через точку
     * Например, запрос значения параметра 'Post.post_text' будет искаться в $_POST['Post']['post_text']
     * @param mixed $defaultValue Значение, возвращаемое в случае отсутствия указанного параметра
     * @return mixed
     * @since 1.1.2
     */
    public static function getPost($name, $defaultValue = null)
    {
        return self::_getValueByComplexKeyFromArray($name, $_POST, $defaultValue);
    }

    /**
     * Возвращает значение параметра $name из глобального REQUEST-массива
     * Если параметра с таким именем нет, то возвращает значение указанное в $defaultValue
     * @param $name Имя параметра или вложенных параметров через точку
     * Например, запрос значения параметра 'Post.post_text' будет искаться в $_REQUEST['Post']['post_text']
     * @param mixed $defaultValue Значение, возвращаемое в случае отсутствия указанного параметра
     * @return mixed
     * @since 1.1.2
     */
    public static function getRequest($name, $defaultValue = null)
    {
        return self::_getValueByComplexKeyFromArray($name, $_REQUEST, $defaultValue);
    }

    /**
     * Возвращает значение параметра $name из глобального FILES-массива
     * Если параметра с таким именем нет, то возвращает значение указанное в $defaultValue
     * @param $name Имя параметра или вложенных параметров через точку
     * Например, запрос значения параметра 'userfile.name' будет искаться в $_FILES['userfile']['name']
     * @param mixed $defaultValue Значение, возвращаемое в случае отсутствия указанного параметра
     * @return mixed
     * @since 1.2.1
     */
    public static function getFile($name, $defaultValue = null)
    {
        return self::_getValueByComplexKeyFromArray($name, $_FILES, $defaultValue);
    }

    /**
     * Возвращает объект PDO
     * @param string $dbId ID компонента базы данных
     * @return \PDO
     * @since 1.1.3
     */
    public static function getPdo($dbId = 'db')
    {
        return self::_getComponent($dbId)->getPdoInstance();
    }

    /**
     * Возвращает относительный URL приложения
     * @param bool $absolute Вернуть ли абсолютный URL, по умолчанию false (@since 1.1.0)
     * @return string
     */
    public static function baseUrl($absolute = false)
    {
        return self::_getComponent('request')->getBaseUrl($absolute);
    }

    /**
     * Возвращает true, если текущее соединение является защищенным (HTTPS), иначе false
     * @return bool
     * @since 1.1.0
     */
    public static function isSecureConnection()
    {
        return self::_getComponent('request')->getIsSecureConnection();
    }

    /**
     * Возвращает true, если текущий запрос является Ajax запросом, иначе false
     * @return bool
     * @since 1.1.0
     */
    public static function isAjaxRequest()
    {
        return self::_getComponent('request')->getIsAjaxRequest();
    }

    /**
     * Возвращает true, если текущий запрос является PUT запросом, иначе false
     * @return bool
     * @since 1.1.0
     */
    public static function isPutRequest()
    {
        return self::_getComponent('request')->getIsPutRequest();
    }

    /**
     * Возвращает true, если текущий запрос является DELETE запросом, иначе false
     * @return bool
     * @since 1.1.0
     */
    public static function isDeleteRequest()
    {
        return self::_getComponent('request')->getIsDeleteRequest();
    }

    /**
     * Возвращает true, если текущий запрос является POST запросом, иначе false
     * @return bool
     * @since 1.1.0
     */
    public static function isPostRequest()
    {
        return self::_getComponent('request')->getIsPostRequest();
    }

    /**
     * Возвращает cache-компонент приложения
     * @param string $cacheId ID кэш-компонента (@since 1.1.3)
     * @return ICache
     */
    public static function cache($cacheId = 'cache')
    {
        return self::_getComponent($cacheId);
    }

    /**
     * Удаляет кэш с ключом $id
     * @param string $id Имя ключа
     * @param string $cacheId ID кэш-компонента (@since 1.1.3)
     * @return boolean
     */
    public static function cacheDelete($id, $cacheId = 'cache')
    {
        return self::_getComponent($cacheId)->delete($id);
    }

    /**
     * Возвращает значение кэша с ключом $id
     * @param string $id Имя ключа
     * @param string $cacheId ID кэш-компонента (@since 1.1.3)
     * @return mixed
     */
    public static function cacheGet($id, $cacheId = 'cache')
    {
        return self::_getComponent($cacheId)->get($id);
    }

    /**
     * Сохраняет значение $value в кэш с ключом $id на время $expire (в секундах)
     * @param string $id Имя ключа
     * @param mixed $value Значение ключа
     * @param integer $expire Время хранения в секундах
     * @param ICacheDependency $dependency Смотри {@link ICacheDependency}
     * @param string $cacheId ID кэш-компонента (@since 1.1.3)
     * @return boolean
     */
    public static function cacheSet($id, $value, $expire = 0, $dependency = null, $cacheId = 'cache')
    {
        return self::_getComponent($cacheId)->set($id, $value, $expire, $dependency);
    }

    /**
     * Удаляет куку
     * @param string $name Имя куки
     * @return CHttpCookie|null Объект удаленной куки или null, если куки с таким именем нет
     */
    public static function cookieDelete($name)
    {
        return self::_getComponent('request')->getCookies()->remove($name);
    }

    /**
     * Возвращает значение куки, если оно есть, иначе значение $defaultValue
     * @param string $name Имя куки
     * @param mixed $defaultValue Значение, возвращаемое в случае отсутствия куки с заданным именем (@since 1.1.0)
     * @return mixed
     */
    public static function cookieGet($name, $defaultValue = null)
    {
        $cookie = self::_getComponent('request')->getCookies()->itemAt($name);

        if ($cookie) {
            return $cookie->value;
        }

        return $defaultValue;
    }

    /**
     * Устанавливает куку
     * @param string $name Имя куки
     * @param string $value Значение куки
     * @param int $expire Время хранения в секундах
     * @param string $path Путь на сайте, для которого кука действительна
     * @param string $domain Домен, для которого кука действительна
     */
    public static function cookieSet($name, $value, $expire = null, $path = '/', $domain = null)
    {
        $cookie = new CHttpCookie($name, $value);
        $cookie->expire = $expire ? ($expire + time()) : 0;
        $cookie->path = $path ? $path : '';
        $cookie->domain = $domain ? $domain : '';
        self::_getComponent('request')->getCookies()->add($name, $cookie);
    }

    /**
     * Возвращает значение токена CSRF
     * @return string
     */
    public static function csrf()
    {
        return self::_getComponent('request')->getCsrfToken();
    }

    /**
     * Возвращает имя токена CSRF (по умолчанию YII_CSRF_TOKEN)
     * @return string
     */
    public static function csrfName()
    {
        return self::_getComponent('request')->csrfTokenName;
    }

    /**
     * Возвращает готовую строчку для передачи CSRF-параметра в ajax-запросе
     *
     * Пример с использованием jQuery:
     *      $.post('url', { param: 'blabla', <?=Y::csrfJsParam();?> }, ...)
     * будет соответственно заменено на:
     *      $.post('url', { param: 'blabla', [csrfName]: '[csrfToken]' }, ...)
     *
     * @return string
     */
    public static function csrfJsParam()
    {
        $request = self::_getComponent('request');

        return $request->csrfTokenName . ":'" . $request->getCsrfToken() . "'";
    }

    /**
     * Ярлык для функции dump класса CVarDumper для отладки приложения
     * @param mixed $var Переменная для вывода
     * @param boolean $doEnd Остановить ли дальнейшее выполнение приложения, по умолчанию - true
     */
    public static function dump($var, $doEnd = true)
    {
        echo '<pre>';
        CVarDumper::dump($var, 10, true);
        echo '</pre>';

        if ($doEnd) {
            Yii::app()->end();
        }
    }

    /**
     * Выводит текст и завершает приложение (применяется в ajax-действиях)
     * @param string $text Текст для вывода
     */
    public static function end($text = '')
    {
        echo $text;
        Yii::app()->end();
    }

    /**
     * Выводит данные в формате JSON / JSONP и завершает приложение (применяется в ajax-действиях)
     * @param mixed $data Данные для вывода
     * @param int $options JSON опции (JSON_HEX_QUOT, JSON_HEX_TAG, JSON_HEX_AMP, JSON_HEX_APOS,
     * JSON_NUMERIC_CHECK, JSON_PRETTY_PRINT, JSON_UNESCAPED_SLASHES, JSON_FORCE_OBJECT) (@since 1.1.3)
     * Поддерживается только при наличии функции json_encode
     * @param string $callback Имя callback-функции для JSONP-ответа
     */
    public static function endJson($data, $options = 0, $callback = '')
    {
        $result = function_exists('json_encode') ? json_encode($data, $options) : CJSON::encode($data);

        if ($callback) {
            header('Content-Type: application/javascript;');
            echo $callback . '(' . $result . ');';
        } else {
            header('Content-Type: application/json;');
            echo $result;
        }

        Yii::app()->end();
    }

    /**
     * Устанавливает/возвращает флэш-извещение для юзера
     * @param string $key Ключ извещения
     * @param string $msg Сообщение извещения или null, чтобы получить сообщение
     * @return string
     */
    public static function flash($key, $msg = null)
    {
        $user = self::_getComponent('user');

        if ($msg === null) {
            return $user->getFlash($key);
        } else {
            $user->setFlash($key, $msg);
        }
    }

    /**
     * Возвращает true, если у юзера есть флэш-извещение с указанных ключом, иначе false
     * @param string $key
     * @return bool
     * @since 1.1.2
     */
    public static function hasFlash($key)
    {
        return self::_getComponent('user')->hasFlash($key);
    }

    /**
     * Устанавливает флэш-извещение для юзера и редиректит по указанному маршруту
     * @param string $key Ключ извещения
     * @param string $msg Сообщение извещения
     * @param string $route Маршрут куда редиректить
     * @param array $params Дополнительные параметры маршрута
     */
    public static function flashRedir($key, $msg, $route, $params = array())
    {
        self::_getComponent('user')->setFlash($key, $msg);
        self::_getComponent('request')->redirect(self::url($route, $params));
    }

    /**
     * Проверяет наличие определенной роли у текущего юзера
     * @param string $roleName Имя роли
     * @return boolean
     * @since 1.0.2
     */
    public static function hasAccess($roleName)
    {
        return self::_getComponent('user')->checkAccess($roleName);
    }

    /**
     * Возвращает true, если пользователь авторизован, иначе - false
     * @return boolean
     */
    public static function isAuthed()
    {
        return !self::_getComponent('user')->getIsGuest();
    }

    /**
     * Возвращает true, если пользователь гость и неавторизован, иначе - false
     * @return boolean
     */
    public static function isGuest()
    {
        return self::_getComponent('user')->getIsGuest();
    }

    /**
     * Возвращает пользовательский параметр приложения
     * @param string $key Ключ параметра или ключи вложенных параметров через точку
     * Например, 'Media.Foto.thumbsize' преобразуется в ['Media']['Foto']['thumbsize']
     * @param mixed $defaultValue Значение, возвращаемое в случае отсутствия ключа
     * @return mixed
     */
    public static function param($key, $defaultValue = null)
    {
        return self::_getValueByComplexKeyFromArray($key, Yii::app()->getParams(), $defaultValue);
    }

    /**
     * Редиректит по указанному маршруту
     * @param string $route Маршрут
     * @param array $params Дополнительные параметры маршрута
     */
    public static function redir($route, $params = array())
    {
        self::_getComponent('request')->redirect(self::url($route, $params));
    }

    /**
     * Редиректит по указанному роуту, если юзер авторизован
     * @param string $route Маршрут
     * @param array $params Дополнительные параметры маршрута
     */
    public static function redirAuthed($route, $params = array())
    {
        if (!self::_getComponent('user')->getIsGuest()) {
            self::_getComponent('request')->redirect(self::url($route, $params));
        }
    }

    /**
     * Редиректит по указанному роуту, если юзер гость
     * @param string $route Маршрут
     * @param array $params Дополнительные параметры маршрута
     */
    public static function redirGuest($route, $params = array())
    {
        if (self::_getComponent('user')->getIsGuest()) {
            self::_getComponent('request')->redirect(self::url($route, $params));
        }
    }

    /**
     * Возвращает request-компонент приложения
     * @return CHttpRequest
     */
    public static function request()
    {
        return self::_getComponent('request');
    }

    /**
     * Выводит статистику использованных приложением ресурсов
     * @param boolean $return Определяет возвращать результат или сразу выводить
     * @return string
     */
    public static function stats($return = false)
    {
        $stats = '';
        $dbStats = Yii::app()->getDb()->getStats();

        if (is_array($dbStats)) {
            $stats = 'Выполнено запросов: ' . $dbStats[0] . ' (за ' . round($dbStats[1], 5) . ' сек.)<br />';
        }

        $logger = Yii::getLogger();
        $memory = round($logger->getMemoryUsage() / 1048576, 3);
        $time = round($logger->getExecutionTime(), 3);

        $stats .= 'Использовано памяти: ' . $memory . ' Мб<br />';
        $stats .= 'Время выполнения: ' . $time . ' сек.';

        if ($return) {
            return $stats;
        }

        echo $stats;
    }

    /**
     * Возвращает URL, сформированный на основе указанного маршрута и параметров
     * @param string $route Маршрут
     * @param array $params Дополнительные параметры маршрута
     * @return string
     */
    public static function url($route, $params = array())
    {
        if (is_object($controller = Yii::app()->getController())) {
            return $controller->createUrl($route, $params);
        }

        return Yii::app()->createUrl($route, $params);
    }

    /**
     * Возвращает user-компонент приложения
     * @return CWebUser
     */
    public static function user()
    {
        return self::_getComponent('user');
    }

    /**
     * Возвращает Id текущего юзера
     * @return mixed
     */
    public static function userId()
    {
        return self::_getComponent('user')->getId();
    }

    /**
     * Возвращает компонтент приложения
     * Экономит лишние вызовы методов для получения компонентов путем кэширования компонентов
     * @param string $componentName Имя компонента приложения
     * @return CComponent
     * @since 1.2.0
     */
    private static function _getComponent($componentName)
    {
        if (!isset(self::$_componentsCache[$componentName])) {
            self::$_componentsCache[$componentName] = Yii::app()->getComponent($componentName);
        }

        return self::$_componentsCache[$componentName];
    }

    /**
     * Возвращает значения ключа в заданном массиве
     * @param string $key Ключ или ключи точку
     * Например, 'Media.Foto.thumbsize' преобразуется в ['Media']['Foto']['thumbsize']
     * @param array $array Массив значений
     * @param mixed $defaultValue Значение, возвращаемое в случае отсутствия ключа
     * @return mixed
     */
    private static function _getValueByComplexKeyFromArray($key, $array, $defaultValue = null)
    {
        if (strpos($key, '.') === false) {
            return (isset($array[$key])) ? $array[$key] : $defaultValue;
        }

        $keys = explode('.', $key);

        if (!isset($array[$keys[0]])) {
            return $defaultValue;
        }

        $value = $array[$keys[0]];
        unset($keys[0]);

        foreach ($keys as $k) {
            if (!isset($value[$k]) && !array_key_exists($k, $value)) {
                return $defaultValue;
            }
            $value = $value[$k];
        }

        return $value;
    }
}