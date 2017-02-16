
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Структура таблицы `da_auth_assignment`
--

CREATE TABLE IF NOT EXISTS `da_auth_assignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY  (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `da_auth_item`
--

CREATE TABLE IF NOT EXISTS `da_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY  (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `da_auth_item`
--

INSERT INTO `da_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('create_object_101', 0, 'Операция создание экземпляра объекта Наборы модулей', NULL, 'N;'),
('create_object_103', 0, 'Операция создание экземпляра объекта Модули сайта', NULL, 'N;'),
('create_object_105', 0, 'Операция создание экземпляра объекта Голосование', NULL, 'N;'),
('create_object_106', 0, 'Операция создание экземпляра объекта Ответы на голосование', NULL, 'N;'),
('create_object_20', 0, 'Операция создание экземпляра объекта Объекты', NULL, 'N;'),
('create_object_21', 0, 'Операция создание экземпляра объекта Свойства объекта', NULL, 'N;'),
('create_object_22', 0, 'Операция создания для объекта Типы данных', NULL, 'N;'),
('create_object_23', 0, 'Операция создание экземпляра объекта Группы пользователей', NULL, 'N;'),
('create_object_24', 0, 'Операция создание экземпляра объекта Пользователи', NULL, 'N;'),
('create_object_250', 0, 'Операция создание экземпляра объекта Комментарии', NULL, 'N;'),
('create_object_26', 0, 'Операция создание экземпляра объекта Права доступа', NULL, 'N;'),
('create_object_260', 0, 'Операция создание экземпляра объекта Баннеры', NULL, 'N;'),
('create_object_261', 0, 'Операция создание экземпляра объекта Баннерные места', NULL, 'N;'),
('create_object_27', 0, 'Операция создание экземпляра объекта Справочники', NULL, 'N;'),
('create_object_28', 0, 'Операция создание экземпляра объекта Значения справочника', NULL, 'N;'),
('create_object_30', 0, 'Операция создание экземпляра объекта Настройки сайта', NULL, 'N;'),
('create_object_31', 0, 'Операция создание экземпляра объекта Домены сайта', NULL, 'N;'),
('create_object_33', 0, 'Операция создание экземпляра объекта Формат сообщения', NULL, 'N;'),
('create_object_34', 0, 'Операция создание экземпляра объекта Подписчики на события', NULL, 'N;'),
('create_object_35', 0, 'Операция создание экземпляра объекта Тип события', NULL, 'N;'),
('create_object_47', 0, 'Операция создание экземпляра объекта Права пользователей', NULL, 'N;'),
('create_object_50', 0, 'Операция создание экземпляра объекта Почтовые аккаунты', NULL, 'N;'),
('create_object_500', 0, 'Операция создание экземпляра объекта Фотогалереи', NULL, 'N;'),
('create_object_501', 0, 'Операция создание экземпляра объекта Фотографии', NULL, 'N;'),
('create_object_502', 0, 'Операция создание экземпляра объекта Новости', NULL, 'N;'),
('create_object_503', 0, 'Операция создание экземпляра объекта Категории новостей', NULL, 'N;'),
('create_object_505', 0, 'Операция создание экземпляра объекта Вопрос', NULL, 'N;'),
('create_object_506', 0, 'Операция создание экземпляра объекта Ответ', NULL, 'N;'),
('create_object_507', 0, 'Операция создание экземпляра объекта Отвечающий', NULL, 'N;'),
('create_object_508', 0, 'Операция создание экземпляра объекта Специализация отвечающего', NULL, 'N;'),
('create_object_509', 0, 'Операция создание экземпляра объекта Категории продукции', NULL, 'N;'),
('create_object_51', 0, 'Операция создание экземпляра объекта Планировщик', NULL, 'N;'),
('create_object_511', 0, 'Операция создание экземпляра объекта Продукция', NULL, 'N;'),
('create_object_512', 0, 'Операция создание экземпляра объекта Вопрос-ответ', NULL, 'N;'),
('create_object_513', 0, 'Операция создание экземпляра объекта OpenID провайдер', NULL, 'N;'),
('create_object_514', 0, 'Операция создание экземпляра объекта OpenId аккаунты', NULL, 'N;'),
('create_object_517', 0, 'Операция создание экземпляра объекта Обратная связь', NULL, 'N;'),
('create_object_520', 0, 'Операция создание экземпляра объекта Витрина', NULL, 'N;'),
('create_object_521', 0, 'Операция создание экземпляра объекта Викторины', NULL, 'N;'),
('create_object_522', 0, 'Операция создание экземпляра объекта Вопросы викторины', NULL, 'N;'),
('create_object_523', 0, 'Операция создание экземпляра объекта Варианты ответов', NULL, 'N;'),
('create_object_524', 0, 'Операция создание экземпляра объекта Ответ пользователя', NULL, 'N;'),
('create_object_525', 0, 'Операция создание экземпляра объекта Брэнды', NULL, 'N;'),
('create_object_529', 0, 'Операция создание экземпляра объекта Статусы остатка продукции', NULL, 'N;'),
('create_object_530', 0, 'Операция создание экземпляра объекта Отзывы клиентов', NULL, 'N;'),
('create_object_54', 0, 'Операция создание экземпляра объекта Доступные локализации', NULL, 'N;'),
('create_object_61', 0, 'Операция создание экземпляра объекта Инструкции', NULL, 'N;'),
('create_object_63', 0, 'Операция создание экземпляра объекта Представление', NULL, 'N;'),
('create_object_66', 0, 'Операция создание экземпляра объекта Колонка представления', NULL, 'N;'),
('create_object_80', 0, 'Операция создание экземпляра объекта php-скрипты', NULL, 'N;'),
('create_object_86', 0, 'Операция создание экземпляра объекта Интерфейс php-скрипта', NULL, 'N;'),
('create_object_ygin.menu', 0, 'Операция создания для объекта Меню', NULL, 'N;'),
('delete_object_101', 0, 'Операция удаления экземпляра объекта Наборы модулей', NULL, 'N;'),
('delete_object_103', 0, 'Операция удаления экземпляра объекта Модули сайта', NULL, 'N;'),
('delete_object_105', 0, 'Операция удаления экземпляра объекта Голосование', NULL, 'N;'),
('delete_object_106', 0, 'Операция удаления экземпляра объекта Ответы на голосование', NULL, 'N;'),
('delete_object_20', 0, 'Операция удаления экземпляра объекта Объекты', NULL, 'N;'),
('delete_object_21', 0, 'Операция удаления экземпляра объекта Свойства объекта', NULL, 'N;'),
('delete_object_22', 0, 'Операция удаления для объекта Типы данных', NULL, 'N;'),
('delete_object_23', 0, 'Операция удаления экземпляра объекта Группы пользователей', NULL, 'N;'),
('delete_object_24', 0, 'Операция удаления экземпляра объекта Пользователи', NULL, 'N;'),
('delete_object_250', 0, 'Операция удаления экземпляра объекта Комментарии', NULL, 'N;'),
('delete_object_26', 0, 'Операция удаления экземпляра объекта Права доступа', NULL, 'N;'),
('delete_object_260', 0, 'Операция удаления экземпляра объекта Баннеры', NULL, 'N;'),
('delete_object_261', 0, 'Операция удаления экземпляра объекта Баннерные места', NULL, 'N;'),
('delete_object_27', 0, 'Операция удаления экземпляра объекта Справочники', NULL, 'N;'),
('delete_object_28', 0, 'Операция удаления экземпляра объекта Значения справочника', NULL, 'N;'),
('delete_object_30', 0, 'Операция удаления экземпляра объекта Настройки сайта', NULL, 'N;'),
('delete_object_33', 0, 'Операция удаления экземпляра объекта Формат сообщения', NULL, 'N;'),
('delete_object_34', 0, 'Операция удаления экземпляра объекта Подписчики на события', NULL, 'N;'),
('delete_object_35', 0, 'Операция удаления экземпляра объекта Тип события', NULL, 'N;'),
('delete_object_47', 0, 'Операция удаления экземпляра объекта Права пользователей', NULL, 'N;'),
('delete_object_50', 0, 'Операция удаления экземпляра объекта Почтовые аккаунты', NULL, 'N;'),
('delete_object_500', 0, 'Операция удаления экземпляра объекта Фотогалереи', NULL, 'N;'),
('delete_object_501', 0, 'Операция удаления экземпляра объекта Фотографии', NULL, 'N;'),
('delete_object_502', 0, 'Операция удаления экземпляра объекта Новости', NULL, 'N;'),
('delete_object_503', 0, 'Операция удаления экземпляра объекта Категории новостей', NULL, 'N;'),
('delete_object_505', 0, 'Операция удаления экземпляра объекта Вопрос', NULL, 'N;'),
('delete_object_506', 0, 'Операция удаления экземпляра объекта Ответ', NULL, 'N;'),
('delete_object_507', 0, 'Операция удаления экземпляра объекта Отвечающий', NULL, 'N;'),
('delete_object_508', 0, 'Операция удаления экземпляра объекта Специализация отвечающего', NULL, 'N;'),
('delete_object_509', 0, 'Операция удаления экземпляра объекта Категории продукции', NULL, 'N;'),
('delete_object_51', 0, 'Операция удаления экземпляра объекта Планировщик', NULL, 'N;'),
('delete_object_511', 0, 'Операция удаления экземпляра объекта Продукция', NULL, 'N;'),
('delete_object_512', 0, 'Операция удаления экземпляра объекта Вопрос-ответ', NULL, 'N;'),
('delete_object_513', 0, 'Операция удаления экземпляра объекта OpenID провайдер', NULL, 'N;'),
('delete_object_514', 0, 'Операция удаления экземпляра объекта OpenId аккаунты', NULL, 'N;'),
('delete_object_517', 0, 'Операция удаления экземпляра объекта Обратная связь', NULL, 'N;'),
('delete_object_519', 0, 'Операция удаления экземпляра объекта Заказы пользователей', NULL, 'N;'),
('delete_object_520', 0, 'Операция удаления экземпляра объекта Витрина', NULL, 'N;'),
('delete_object_521', 0, 'Операция удаления экземпляра объекта Викторины', NULL, 'N;'),
('delete_object_522', 0, 'Операция удаления экземпляра объекта Вопросы викторины', NULL, 'N;'),
('delete_object_523', 0, 'Операция удаления экземпляра объекта Варианты ответов', NULL, 'N;'),
('delete_object_524', 0, 'Операция удаления экземпляра объекта Ответ пользователя', NULL, 'N;'),
('delete_object_525', 0, 'Операция удаления экземпляра объекта Брэнды', NULL, 'N;'),
('delete_object_529', 0, 'Операция удаления экземпляра объекта Статусы остатка продукции', NULL, 'N;'),
('delete_object_530', 0, 'Операция удаления экземпляра объекта Отзывы клиентов', NULL, 'N;'),
('delete_object_531', 0, 'Операция удаления экземпляра объекта Уведомления', NULL, 'N;'),
('delete_object_54', 0, 'Операция удаления экземпляра объекта Доступные локализации', NULL, 'N;'),
('delete_object_61', 0, 'Операция удаления экземпляра объекта Инструкции', NULL, 'N;'),
('delete_object_63', 0, 'Операция удаления экземпляра объекта Представление', NULL, 'N;'),
('delete_object_66', 0, 'Операция удаления экземпляра объекта Колонка представления', NULL, 'N;'),
('delete_object_80', 0, 'Операция удаления экземпляра объекта php-скрипты', NULL, 'N;'),
('delete_object_86', 0, 'Операция удаления экземпляра объекта Интерфейс php-скрипта', NULL, 'N;'),
('delete_object_ygin.menu', 0, 'Операция удаления для объекта Меню', NULL, 'N;'),
('dev', 2, 'Разработчик', NULL, 'N;'),
('editor', 2, 'Редактор', NULL, 'N;'),
('edit_object_101', 0, 'Операция изменения экземпляра объекта Наборы модулей', NULL, 'N;'),
('edit_object_103', 0, 'Операция изменения экземпляра объекта Модули сайта', NULL, 'N;'),
('edit_object_105', 0, 'Операция изменения экземпляра объекта Голосование', NULL, 'N;'),
('edit_object_106', 0, 'Операция изменения экземпляра объекта Ответы на голосование', NULL, 'N;'),
('edit_object_20', 0, 'Операция изменения экземпляра объекта Объекты', NULL, 'N;'),
('edit_object_21', 0, 'Операция изменения экземпляра объекта Свойства объекта', NULL, 'N;'),
('edit_object_22', 0, 'Операция изменения для объекта Типы данных', NULL, 'N;'),
('edit_object_23', 0, 'Операция изменения экземпляра объекта Группы пользователей', NULL, 'N;'),
('edit_object_24', 0, 'Операция изменения экземпляра объекта Пользователи', NULL, 'N;'),
('edit_object_250', 0, 'Операция изменения экземпляра объекта Комментарии', NULL, 'N;'),
('edit_object_26', 0, 'Операция изменения экземпляра объекта Права доступа', NULL, 'N;'),
('edit_object_260', 0, 'Операция изменения экземпляра объекта Баннеры', NULL, 'N;'),
('edit_object_261', 0, 'Операция изменения экземпляра объекта Баннерные места', NULL, 'N;'),
('edit_object_27', 0, 'Операция изменения экземпляра объекта Справочники', NULL, 'N;'),
('edit_object_28', 0, 'Операция изменения экземпляра объекта Значения справочника', NULL, 'N;'),
('edit_object_29', 0, 'Операция изменения экземпляра объекта Группы системных параметров', NULL, 'N;'),
('edit_object_30', 0, 'Операция изменения экземпляра объекта Настройки сайта', NULL, 'N;'),
('edit_object_31', 0, 'Операция изменения экземпляра объекта Домены сайта', NULL, 'N;'),
('edit_object_33', 0, 'Операция изменения экземпляра объекта Формат сообщения', NULL, 'N;'),
('edit_object_34', 0, 'Операция изменения экземпляра объекта Подписчики на события', NULL, 'N;'),
('edit_object_35', 0, 'Операция изменения экземпляра объекта Тип события', NULL, 'N;'),
('edit_object_47', 0, 'Операция изменения экземпляра объекта Права пользователей', NULL, 'N;'),
('edit_object_50', 0, 'Операция изменения экземпляра объекта Почтовые аккаунты', NULL, 'N;'),
('edit_object_500', 0, 'Операция изменения экземпляра объекта Фотогалереи', NULL, 'N;'),
('edit_object_501', 0, 'Операция изменения экземпляра объекта Фотографии', NULL, 'N;'),
('edit_object_502', 0, 'Операция изменения экземпляра объекта Новости', NULL, 'N;'),
('edit_object_503', 0, 'Операция изменения экземпляра объекта Категории новостей', NULL, 'N;'),
('edit_object_505', 0, 'Операция изменения экземпляра объекта Вопрос', NULL, 'N;'),
('edit_object_506', 0, 'Операция изменения экземпляра объекта Ответ', NULL, 'N;'),
('edit_object_507', 0, 'Операция изменения экземпляра объекта Отвечающий', NULL, 'N;'),
('edit_object_508', 0, 'Операция изменения экземпляра объекта Специализация отвечающего', NULL, 'N;'),
('edit_object_509', 0, 'Операция изменения экземпляра объекта Категории продукции', NULL, 'N;'),
('edit_object_51', 0, 'Операция изменения экземпляра объекта Планировщик', NULL, 'N;'),
('edit_object_511', 0, 'Операция изменения экземпляра объекта Продукция', NULL, 'N;'),
('edit_object_512', 0, 'Операция изменения экземпляра объекта Вопрос-ответ', NULL, 'N;'),
('edit_object_513', 0, 'Операция изменения экземпляра объекта OpenID провайдер', NULL, 'N;'),
('edit_object_514', 0, 'Операция изменения экземпляра объекта OpenId аккаунты', NULL, 'N;'),
('edit_object_517', 0, 'Операция изменения экземпляра объекта Обратная связь', NULL, 'N;'),
('edit_object_519', 0, 'Операция изменения экземпляра объекта Заказы пользователей', NULL, 'N;'),
('edit_object_520', 0, 'Операция изменения экземпляра объекта Витрина', NULL, 'N;'),
('edit_object_521', 0, 'Операция изменения экземпляра объекта Викторины', NULL, 'N;'),
('edit_object_522', 0, 'Операция изменения экземпляра объекта Вопросы викторины', NULL, 'N;'),
('edit_object_523', 0, 'Операция изменения экземпляра объекта Варианты ответов', NULL, 'N;'),
('edit_object_524', 0, 'Операция изменения экземпляра объекта Ответ пользователя', NULL, 'N;'),
('edit_object_525', 0, 'Операция изменения экземпляра объекта Брэнды', NULL, 'N;'),
('edit_object_529', 0, 'Операция изменения экземпляра объекта Статусы остатка продукции', NULL, 'N;'),
('edit_object_530', 0, 'Операция изменения экземпляра объекта Отзывы клиентов', NULL, 'N;'),
('edit_object_531', 0, 'Операция изменения экземпляра объекта Уведомления', NULL, 'N;'),
('edit_object_54', 0, 'Операция изменения экземпляра объекта Доступные локализации', NULL, 'N;'),
('edit_object_61', 0, 'Операция изменения экземпляра объекта Инструкции', NULL, 'N;'),
('edit_object_63', 0, 'Операция изменения экземпляра объекта Представление', NULL, 'N;'),
('edit_object_66', 0, 'Операция изменения экземпляра объекта Колонка представления', NULL, 'N;'),
('edit_object_80', 0, 'Операция изменения экземпляра объекта php-скрипты', NULL, 'N;'),
('edit_object_86', 0, 'Операция изменения экземпляра объекта Интерфейс php-скрипта', NULL, 'N;'),
('edit_object_ygin.menu', 0, 'Операция изменения для объекта Меню', NULL, 'N;'),
('list_object_101', 0, 'Просмотр списка данных объекта Наборы модулей', NULL, 'N;'),
('list_object_103', 0, 'Просмотр списка данных объекта Модули сайта', NULL, 'N;'),
('list_object_20', 0, 'Просмотр списка данных объекта Объекты', NULL, 'N;'),
('list_object_21', 0, 'Просмотр списка данных объекта Свойства объекта', NULL, 'N;'),
('list_object_22', 0, 'Просмотр списка данных объекта Типы данных', NULL, 'N;'),
('list_object_23', 0, 'Просмотр списка данных объекта Группы пользователей', NULL, 'N;'),
('list_object_24', 0, 'Просмотр списка данных объекта Пользователи', NULL, 'N;'),
('list_object_250', 0, 'Просмотр списка данных объекта Комментарии', NULL, 'N;'),
('list_object_26', 0, 'Просмотр списка данных объекта Права доступа', NULL, 'N;'),
('list_object_27', 0, 'Просмотр списка данных объекта Справочники', NULL, 'N;'),
('list_object_28', 0, 'Просмотр списка данных объекта Значения справочника', NULL, 'N;'),
('list_object_29', 0, 'Просмотр списка данных объекта Группы системных параметров', NULL, 'N;'),
('list_object_30', 0, 'Просмотр списка данных объекта Настройки сайта', NULL, 'N;'),
('list_object_31', 0, 'Просмотр списка данных объекта Домены сайта', NULL, 'N;'),
('list_object_32', 0, 'Просмотр списка данных объекта Настройка прав', NULL, 'N;'),
('list_object_33', 0, 'Просмотр списка данных объекта Формат сообщения', NULL, 'N;'),
('list_object_34', 0, 'Просмотр списка данных объекта Подписчики на события', NULL, 'N;'),
('list_object_35', 0, 'Просмотр списка данных объекта Тип события', NULL, 'N;'),
('list_object_43', 0, 'Просмотр списка данных объекта SQL', NULL, 'N;'),
('list_object_47', 0, 'Просмотр списка данных объекта Права пользователей', NULL, 'N;'),
('list_object_50', 0, 'Просмотр списка данных объекта Почтовые аккаунты', NULL, 'N;'),
('list_object_505', 0, 'Просмотр списка данных объекта Вопрос', NULL, 'N;'),
('list_object_506', 0, 'Просмотр списка данных объекта Ответ', NULL, 'N;'),
('list_object_507', 0, 'Просмотр списка данных объекта Отвечающий', NULL, 'N;'),
('list_object_508', 0, 'Просмотр списка данных объекта Специализация отвечающего', NULL, 'N;'),
('list_object_51', 0, 'Просмотр списка данных объекта Планировщик', NULL, 'N;'),
('list_object_513', 0, 'Просмотр списка данных объекта OpenID провайдер', NULL, 'N;'),
('list_object_514', 0, 'Просмотр списка данных объекта OpenId аккаунты', NULL, 'N;'),
('list_object_521', 0, 'Просмотр списка данных объекта Викторины', NULL, 'N;'),
('list_object_522', 0, 'Просмотр списка данных объекта Вопросы викторины', NULL, 'N;'),
('list_object_523', 0, 'Просмотр списка данных объекта Варианты ответов', NULL, 'N;'),
('list_object_524', 0, 'Просмотр списка данных объекта Ответ пользователя', NULL, 'N;'),
('list_object_528', 0, 'Управление объектом Плагины системы', NULL, 'N;'),
('list_object_531', 0, 'Просмотр списка данных объекта ид=531', NULL, 'N;'),
('list_object_54', 0, 'Просмотр списка данных объекта Доступные локализации', NULL, 'N;'),
('list_object_60', 0, 'Просмотр списка данных объекта Проверка файлов', NULL, 'N;'),
('list_object_61', 0, 'Просмотр списка данных объекта Инструкции', NULL, 'N;'),
('list_object_63', 0, 'Просмотр списка данных объекта Представление', NULL, 'N;'),
('list_object_66', 0, 'Просмотр списка данных объекта Колонка представления', NULL, 'N;'),
('list_object_80', 0, 'Просмотр списка данных объекта php-скрипты', NULL, 'N;'),
('list_object_86', 0, 'Просмотр списка данных объекта Интерфейс php-скрипта', NULL, 'N;'),
('list_object_89', 0, 'Просмотр списка данных объекта Очистить кэш', NULL, 'N;'),
('list_object_91', 0, 'Просмотр списка данных объекта Поисковый индекс', NULL, 'N;'),
('list_object_94', 0, 'Просмотр списка данных объекта Логи', NULL, 'N;'),
('list_object_a', 0, 'Просмотр списка данных объекта Фотографии', NULL, 'N;'),
('list_object_ygin.gii', 0, 'Просмотр списка данных объекта gii (debug=true)', NULL, 'N;'),
('list_object_ygin.menu', 0, 'Просмотр списка данных объекта Меню', NULL, 'N;'),
('list_object_ygin.override', 0, 'Просмотр списка данных объекта Переопределение представлений (debug=true)', NULL, 'N;'),
('showAdminPanel', 0, 'доступ к админке', NULL, 'N;'),
('view_object_26', 0, 'Операция просмотра экземпляра объекта Права доступа', NULL, 'N;'),
('view_object_30', 0, 'Операция просмотра экземпляра объекта Настройки сайта', NULL, 'N;'),
('view_object_32', 0, 'Операция просмотра экземпляра объекта Настройка прав', NULL, 'N;'),
('view_object_43', 0, 'Операция просмотра экземпляра объекта SQL', NULL, 'N;'),
('view_object_529', 0, 'Операция просмотра экземпляра объекта Статусы остатка продукции', NULL, 'N;'),
('view_object_531', 0, 'Операция просмотра экземпляра объекта Уведомления', NULL, 'N;'),
('view_object_60', 0, 'Операция просмотра экземпляра объекта Проверка файлов', NULL, 'N;'),
('view_object_89', 0, 'Операция просмотра экземпляра объекта Очистить кэш', NULL, 'N;'),
('view_object_91', 0, 'Операция просмотра для объекта Поисковый индекс', NULL, 'N;'),
('view_object_94', 0, 'Операция просмотра экземпляра объекта Логи', NULL, 'N;'),
('view_object_ygin.gii', 0, 'Операция просмотра для объекта gii (debug=true)', NULL, 'N;'),
('view_object_ygin.override', 0, 'Операция просмотра для объекта Переопределение представлений (debug=true)', NULL, 'N;');

-- --------------------------------------------------------

--
-- Структура таблицы `da_auth_item_child`
--

CREATE TABLE IF NOT EXISTS `da_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY  (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `da_auth_item_child`
--

INSERT INTO `da_auth_item_child` (`parent`, `child`) VALUES
('dev', 'create_object_101'),
('editor', 'create_object_101'),
('dev', 'create_object_103'),
('editor', 'create_object_103'),
('dev', 'create_object_105'),
('editor', 'create_object_105'),
('dev', 'create_object_106'),
('dev', 'create_object_20'),
('dev', 'create_object_21'),
('dev', 'create_object_22'),
('dev', 'create_object_23'),
('dev', 'create_object_24'),
('dev', 'create_object_250'),
('editor', 'create_object_250'),
('dev', 'create_object_26'),
('dev', 'create_object_260'),
('editor', 'create_object_260'),
('dev', 'create_object_261'),
('dev', 'create_object_27'),
('dev', 'create_object_28'),
('dev', 'create_object_30'),
('dev', 'create_object_31'),
('dev', 'create_object_33'),
('dev', 'create_object_34'),
('dev', 'create_object_35'),
('dev', 'create_object_47'),
('dev', 'create_object_50'),
('dev', 'create_object_500'),
('editor', 'create_object_500'),
('dev', 'create_object_501'),
('editor', 'create_object_501'),
('dev', 'create_object_502'),
('editor', 'create_object_502'),
('dev', 'create_object_503'),
('editor', 'create_object_503'),
('dev', 'create_object_505'),
('editor', 'create_object_505'),
('dev', 'create_object_506'),
('editor', 'create_object_506'),
('dev', 'create_object_507'),
('editor', 'create_object_507'),
('dev', 'create_object_508'),
('editor', 'create_object_508'),
('dev', 'create_object_509'),
('editor', 'create_object_509'),
('dev', 'create_object_51'),
('dev', 'create_object_511'),
('editor', 'create_object_511'),
('dev', 'create_object_512'),
('editor', 'create_object_512'),
('dev', 'create_object_513'),
('dev', 'create_object_514'),
('editor', 'create_object_514'),
('dev', 'create_object_517'),
('editor', 'create_object_517'),
('dev', 'create_object_520'),
('dev', 'create_object_521'),
('dev', 'create_object_522'),
('dev', 'create_object_523'),
('dev', 'create_object_524'),
('dev', 'create_object_525'),
('editor', 'create_object_525'),
('dev', 'create_object_529'),
('editor', 'create_object_529'),
('dev', 'create_object_530'),
('editor', 'create_object_530'),
('dev', 'create_object_61'),
('dev', 'create_object_63'),
('dev', 'create_object_66'),
('dev', 'create_object_80'),
('dev', 'create_object_86'),
('dev', 'create_object_ygin.menu'),
('editor', 'create_object_ygin.menu'),
('dev', 'delete_object_101'),
('editor', 'delete_object_101'),
('dev', 'delete_object_103'),
('editor', 'delete_object_103'),
('dev', 'delete_object_105'),
('editor', 'delete_object_105'),
('dev', 'delete_object_106'),
('dev', 'delete_object_20'),
('dev', 'delete_object_21'),
('dev', 'delete_object_22'),
('dev', 'delete_object_23'),
('dev', 'delete_object_24'),
('dev', 'delete_object_250'),
('editor', 'delete_object_250'),
('dev', 'delete_object_26'),
('dev', 'delete_object_260'),
('editor', 'delete_object_260'),
('dev', 'delete_object_261'),
('dev', 'delete_object_27'),
('dev', 'delete_object_28'),
('dev', 'delete_object_30'),
('dev', 'delete_object_33'),
('dev', 'delete_object_34'),
('dev', 'delete_object_35'),
('dev', 'delete_object_47'),
('dev', 'delete_object_50'),
('dev', 'delete_object_500'),
('editor', 'delete_object_500'),
('dev', 'delete_object_501'),
('editor', 'delete_object_501'),
('dev', 'delete_object_502'),
('editor', 'delete_object_502'),
('dev', 'delete_object_503'),
('editor', 'delete_object_503'),
('dev', 'delete_object_505'),
('editor', 'delete_object_505'),
('dev', 'delete_object_506'),
('editor', 'delete_object_506'),
('dev', 'delete_object_507'),
('editor', 'delete_object_507'),
('dev', 'delete_object_508'),
('editor', 'delete_object_508'),
('dev', 'delete_object_509'),
('editor', 'delete_object_509'),
('dev', 'delete_object_51'),
('dev', 'delete_object_511'),
('editor', 'delete_object_511'),
('dev', 'delete_object_512'),
('editor', 'delete_object_512'),
('dev', 'delete_object_513'),
('dev', 'delete_object_514'),
('editor', 'delete_object_514'),
('dev', 'delete_object_517'),
('editor', 'delete_object_517'),
('dev', 'delete_object_519'),
('dev', 'delete_object_520'),
('dev', 'delete_object_521'),
('dev', 'delete_object_522'),
('dev', 'delete_object_523'),
('dev', 'delete_object_524'),
('dev', 'delete_object_525'),
('editor', 'delete_object_525'),
('dev', 'delete_object_529'),
('editor', 'delete_object_529'),
('dev', 'delete_object_530'),
('editor', 'delete_object_530'),
('dev', 'delete_object_531'),
('dev', 'delete_object_61'),
('dev', 'delete_object_63'),
('dev', 'delete_object_66'),
('dev', 'delete_object_80'),
('dev', 'delete_object_86'),
('dev', 'delete_object_ygin.menu'),
('editor', 'delete_object_ygin.menu'),
('dev', 'editor'),
('dev', 'edit_object_101'),
('editor', 'edit_object_101'),
('dev', 'edit_object_103'),
('editor', 'edit_object_103'),
('dev', 'edit_object_105'),
('editor', 'edit_object_105'),
('dev', 'edit_object_106'),
('dev', 'edit_object_20'),
('dev', 'edit_object_21'),
('dev', 'edit_object_22'),
('dev', 'edit_object_23'),
('dev', 'edit_object_24'),
('dev', 'edit_object_250'),
('editor', 'edit_object_250'),
('dev', 'edit_object_26'),
('dev', 'edit_object_260'),
('editor', 'edit_object_260'),
('dev', 'edit_object_261'),
('editor', 'edit_object_261'),
('dev', 'edit_object_27'),
('dev', 'edit_object_28'),
('dev', 'edit_object_29'),
('dev', 'edit_object_30'),
('editor', 'edit_object_30'),
('dev', 'edit_object_31'),
('dev', 'edit_object_33'),
('dev', 'edit_object_34'),
('dev', 'edit_object_35'),
('dev', 'edit_object_47'),
('dev', 'edit_object_50'),
('dev', 'edit_object_500'),
('editor', 'edit_object_500'),
('dev', 'edit_object_501'),
('editor', 'edit_object_501'),
('dev', 'edit_object_502'),
('editor', 'edit_object_502'),
('dev', 'edit_object_503'),
('editor', 'edit_object_503'),
('dev', 'edit_object_505'),
('editor', 'edit_object_505'),
('dev', 'edit_object_506'),
('editor', 'edit_object_506'),
('dev', 'edit_object_507'),
('editor', 'edit_object_507'),
('dev', 'edit_object_508'),
('editor', 'edit_object_508'),
('dev', 'edit_object_509'),
('editor', 'edit_object_509'),
('dev', 'edit_object_51'),
('dev', 'edit_object_511'),
('editor', 'edit_object_511'),
('dev', 'edit_object_512'),
('editor', 'edit_object_512'),
('dev', 'edit_object_513'),
('dev', 'edit_object_514'),
('editor', 'edit_object_514'),
('dev', 'edit_object_517'),
('editor', 'edit_object_517'),
('dev', 'edit_object_519'),
('dev', 'edit_object_520'),
('dev', 'edit_object_521'),
('dev', 'edit_object_522'),
('dev', 'edit_object_523'),
('dev', 'edit_object_524'),
('dev', 'edit_object_525'),
('editor', 'edit_object_525'),
('dev', 'edit_object_529'),
('editor', 'edit_object_529'),
('dev', 'edit_object_530'),
('editor', 'edit_object_530'),
('dev', 'edit_object_531'),
('dev', 'edit_object_61'),
('dev', 'edit_object_63'),
('dev', 'edit_object_66'),
('dev', 'edit_object_80'),
('dev', 'edit_object_86'),
('dev', 'edit_object_ygin.menu'),
('editor', 'edit_object_ygin.menu'),
('editor', 'list_object_101'),
('editor', 'list_object_103'),
('dev', 'list_object_20'),
('dev', 'list_object_21'),
('dev', 'list_object_22'),
('dev', 'list_object_23'),
('dev', 'list_object_24'),
('editor', 'list_object_250'),
('dev', 'list_object_26'),
('dev', 'list_object_27'),
('dev', 'list_object_28'),
('dev', 'list_object_29'),
('dev', 'list_object_30'),
('editor', 'list_object_30'),
('dev', 'list_object_31'),
('dev', 'list_object_32'),
('dev', 'list_object_33'),
('dev', 'list_object_34'),
('dev', 'list_object_35'),
('dev', 'list_object_43'),
('dev', 'list_object_47'),
('dev', 'list_object_50'),
('editor', 'list_object_505'),
('editor', 'list_object_506'),
('editor', 'list_object_507'),
('editor', 'list_object_508'),
('dev', 'list_object_51'),
('dev', 'list_object_513'),
('dev', 'list_object_514'),
('editor', 'list_object_514'),
('dev', 'list_object_522'),
('dev', 'list_object_523'),
('dev', 'list_object_524'),
('dev', 'list_object_528'),
('dev', 'list_object_531'),
('dev', 'list_object_60'),
('dev', 'list_object_61'),
('dev', 'list_object_63'),
('dev', 'list_object_66'),
('dev', 'list_object_80'),
('dev', 'list_object_86'),
('dev', 'list_object_89'),
('dev', 'list_object_91'),
('editor', 'list_object_a'),
('dev', 'list_object_ygin.gii'),
('dev', 'list_object_ygin.menu'),
('editor', 'list_object_ygin.menu'),
('dev', 'list_object_ygin.override'),
('editor', 'showAdminPanel'),
('dev', 'view_object_26'),
('editor', 'view_object_30'),
('dev', 'view_object_32'),
('dev', 'view_object_43'),
('dev', 'view_object_529'),
('editor', 'view_object_529'),
('dev', 'view_object_531'),
('dev', 'view_object_60'),
('dev', 'view_object_89'),
('dev', 'view_object_91'),
('dev', 'view_object_ygin.gii'),
('dev', 'view_object_ygin.override');

-- --------------------------------------------------------

--
-- Структура таблицы `da_domain`
--

CREATE TABLE IF NOT EXISTS `da_domain` (
  `id_domain` int(8) NOT NULL COMMENT 'id',
  `domain_path` varchar(255) default NULL COMMENT 'Путь к содержимому домена',
  `name` varchar(255) NOT NULL COMMENT 'Доменное имя',
  `id_default_page` int(8) NOT NULL COMMENT 'ID страницы по умолчанию',
  `description` varchar(255) default NULL COMMENT 'Описание',
  `path2data_http` varchar(255) default NULL COMMENT 'Путь к данным по http',
  `settings` text COMMENT 'Настройки',
  `keywords` varchar(255) default NULL COMMENT 'Ключевые слова',
  `image_src` int(11) default NULL COMMENT 'Картинка для сохранения в закладках',
  `active` tinyint(1) NOT NULL default '1' COMMENT 'Активен',
  PRIMARY KEY  (`id_domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Домены сайта';

--
-- Дамп данных таблицы `da_domain`
--

INSERT INTO `da_domain` (`id_domain`, `domain_path`, `name`, `id_default_page`, `description`, `path2data_http`, `settings`, `keywords`, `image_src`, `active`) VALUES
(1, NULL, 'test.ru', 100, 'Название организации', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `da_domain_localization`
--

CREATE TABLE IF NOT EXISTS `da_domain_localization` (
  `id_domain` int(8) NOT NULL,
  `id_localization` int(8) NOT NULL,
  PRIMARY KEY  (`id_domain`,`id_localization`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `da_domain_localization`
--

INSERT INTO `da_domain_localization` (`id_domain`, `id_localization`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `da_event`
--

CREATE TABLE IF NOT EXISTS `da_event` (
  `id_instance` int(8) default NULL COMMENT 'ИД экземпляра',
  `id_event` int(8) NOT NULL auto_increment COMMENT 'id',
  `id_event_type` int(8) NOT NULL default '0' COMMENT 'Тип события',
  `event_message` longtext COMMENT 'Содержимое',
  `event_create` int(8) NOT NULL default '0' COMMENT 'Дата создания события',
  PRIMARY KEY  (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='События' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `da_event`
--


-- --------------------------------------------------------

--
-- Структура таблицы `da_event_format`
--

CREATE TABLE IF NOT EXISTS `da_event_format` (
  `id_event_format` int(8) NOT NULL COMMENT 'id',
  `description` varchar(255) NOT NULL COMMENT 'Описание',
  `place` int(1) NOT NULL default '1' COMMENT 'Расположение',
  `file_name` varchar(50) default NULL COMMENT 'Имя файла во вложении',
  `name` varchar(20) NOT NULL COMMENT 'Сокращённое название (для разработчика)',
  PRIMARY KEY  (`id_event_format`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Формат сообщения';

--
-- Дамп данных таблицы `da_event_format`
--

INSERT INTO `da_event_format` (`id_event_format`, `description`, `place`, `file_name`, `name`) VALUES
(1, 'Текстовое содержимое', 1, 'text.txt', 'TXT'),
(2, 'HTML-письмо', 1, NULL, 'HTML');

-- --------------------------------------------------------

--
-- Структура таблицы `da_event_process`
--

CREATE TABLE IF NOT EXISTS `da_event_process` (
  `id_event` int(8) NOT NULL default '0',
  `email` varchar(70) NOT NULL,
  `notify_date` int(10) default NULL,
  `id_event_subscriber` int(8) NOT NULL default '0',
  PRIMARY KEY  (`id_event`,`email`,`id_event_subscriber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `da_event_process`
--


-- --------------------------------------------------------

--
-- Структура таблицы `da_event_subscriber`
--

CREATE TABLE IF NOT EXISTS `da_event_subscriber` (
  `id_event_subscriber` int(8) NOT NULL auto_increment COMMENT 'id',
  `id_event_type` int(8) NOT NULL default '0' COMMENT 'Тип события',
  `id_user` int(8) default NULL COMMENT 'Пользователь',
  `format` int(2) NOT NULL COMMENT 'Формат сообщения',
  `archive_attach` int(1) NOT NULL default '0' COMMENT 'Архивировать ли вложение',
  `email` varchar(60) default NULL COMMENT 'E-mail адрес',
  `name` varchar(255) default NULL COMMENT 'Имя подписчика',
  PRIMARY KEY  (`id_event_subscriber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0 COMMENT='Подписчики на события' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `da_event_subscriber`
--


-- --------------------------------------------------------

--
-- Структура таблицы `da_event_type`
--

CREATE TABLE IF NOT EXISTS `da_event_type` (
  `id_event_type` int(8) NOT NULL auto_increment COMMENT 'id',
  `id_object` int(8) default NULL COMMENT 'Объект для работы',
  `last_time` int(10) default NULL COMMENT 'Дата последей обработки',
  `interval_value` int(8) default NULL COMMENT 'Интервал времени, через которое будет проходить обработка события',
  `sql_condition` varchar(255) default NULL COMMENT 'SQL получающая экемпляры ("AS id_instance")',
  `name` varchar(100) NOT NULL COMMENT 'Название',
  `condition_done` varchar(255) default NULL COMMENT 'SQL выражение, срабатывающее после обработки экземпляра (<<id_instance>>)',
  `id_mail_account` int(8) NOT NULL default '0' COMMENT 'Используемый почтовый аккаунт',
  PRIMARY KEY  (`id_event_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 PACK_KEYS=0 COMMENT='Тип события' AUTO_INCREMENT=103 ;

--
-- Дамп данных таблицы `da_event_type`
--

INSERT INTO `da_event_type` (`id_event_type`, `id_object`, `last_time`, `interval_value`, `sql_condition`, `name`, `condition_done`, `id_mail_account`) VALUES
(50, NULL, 1344593834, 300, NULL, 'Новый комментарий', NULL, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `da_files`
--

CREATE TABLE IF NOT EXISTS `da_files` (
  `id_file` int(8) NOT NULL auto_increment COMMENT 'id',
  `file_path` varchar(255) NOT NULL COMMENT 'Путь к файлу',
  `id_file_type` int(8) default NULL COMMENT 'Тип файла',
  `count` int(6) default NULL COMMENT 'Количество загрузок',
  `id_object` varchar(255) default NULL COMMENT 'Объект',
  `id_instance` int(8) default NULL COMMENT 'ИД экземпляра',
  `id_parameter` varchar(255) default NULL COMMENT 'Свойство объекта',
  `id_property` int(8) default NULL COMMENT 'Пользовательское свойство',
  `create_date` int(10) default NULL COMMENT 'Дата создания файла',
  `id_parent_file` int(8) default NULL COMMENT 'Родительский файл',
  `id_tmp` varchar(32) default NULL COMMENT 'Временный ИД',
  `status_process` tinyint(1) NOT NULL default '0' COMMENT 'Статус создания превью-файла',
  PRIMARY KEY  (`id_file`),
  KEY `id_tmp` (`id_tmp`,`id_object`,`id_instance`,`id_parameter`,`id_parent_file`,`id_file_type`,`file_path`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Файлы' AUTO_INCREMENT=501 ;

-- --------------------------------------------------------

--
-- Структура таблицы `da_file_extension`
--

CREATE TABLE IF NOT EXISTS `da_file_extension` (
  `id_file_extension` int(8) NOT NULL COMMENT 'id',
  `ext` varchar(20) NOT NULL COMMENT 'Расширение',
  `id_file_type` int(8) NOT NULL default '0' COMMENT 'Тип файла',
  PRIMARY KEY  (`id_file_extension`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Расширения файлов';

--
-- Дамп данных таблицы `da_file_extension`
--

INSERT INTO `da_file_extension` (`id_file_extension`, `ext`, `id_file_type`) VALUES
(1, 'jpg', 1),
(2, 'gif', 1),
(3, 'png', 1),
(4, 'doc', 2),
(5, 'xls', 2),
(6, 'txt', 2),
(9, 'css', 4),
(11, 'pdf', 2),
(12, 'docx', 2),
(13, 'jpeg', 1),
(14, 'flv', 5),
(201, 'bmp', 1),
(202, 'xlsx', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `da_file_type`
--

CREATE TABLE IF NOT EXISTS `da_file_type` (
  `id_file_type` int(8) NOT NULL COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT 'Название',
  PRIMARY KEY  (`id_file_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Типы файлов';

--
-- Дамп данных таблицы `da_file_type`
--

INSERT INTO `da_file_type` (`id_file_type`, `name`) VALUES
(1, 'Картинка'),
(2, 'Документ'),
(4, 'Стили'),
(5, 'Flash-видео');

-- --------------------------------------------------------

--
-- Структура таблицы `da_group_system_parameter`
--

CREATE TABLE IF NOT EXISTS `da_group_system_parameter` (
  `id_group_system_parameter` int(8) NOT NULL COMMENT 'id',
  `name` varchar(100) NOT NULL COMMENT 'Название',
  PRIMARY KEY  (`id_group_system_parameter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0 COMMENT='Группы системных параметров';

--
-- Дамп данных таблицы `da_group_system_parameter`
--

INSERT INTO `da_group_system_parameter` (`id_group_system_parameter`, `name`) VALUES
(1, 'Системные настройки'),
(2, 'Настройки сайта'),
(3, 'Локализация'),
(7, 'Голосование');

-- --------------------------------------------------------

--
-- Структура таблицы `da_instruction`
--

CREATE TABLE IF NOT EXISTS `da_instruction` (
  `id_instruction` int(8) NOT NULL COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `content` longtext NOT NULL COMMENT 'Описание',
  `desc_type` int(1) NOT NULL default '1' COMMENT 'Относится только к этому сайту',
  `visible` int(1) NOT NULL default '1' COMMENT 'Видимость',
  `num_seq` int(3) NOT NULL default '1' COMMENT 'п/п',
  PRIMARY KEY  (`id_instruction`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Инструкции';

--
-- Дамп данных таблицы `da_instruction`
--

INSERT INTO `da_instruction` (`id_instruction`, `name`, `content`, `desc_type`, `visible`, `num_seq`) VALUES
(6, 'Модуль Вопрос-ответ', '<ol>  <li>  <h2>Общий вид</h2>  <img style="float: left;" src="http://ygin.ru/instruction/engine/faq/faq-vid.jpg" alt=""></li>  <li>  <h2>Создание</h2>  <p>При нажатии на кнопку «Создать» появится страница с указанными полями:</p>  <ol style="list-style-type: lower-alpha;">  <li>  <p>Поле «Вопрос» отображает вопрос пришедший от пользователей на сайт.</p>  <img src="http://ygin.ru/instruction/engine/faq/faq-sozd-1.jpg" alt="Вопрос"></li>  <li>  <p>Поле «Ответ» позволяет написать ответ по вышеуказанному вопросу.</p>  <img src="http://ygin.ru/instruction/engine/faq/faq-sozd-2.jpg" alt="Ответ"></li>  <li>  <p>Поле «Дата» указывает дату подачи вопроса.</p>  <img src="http://ygin.ru/instruction/engine/faq/faq-sozd-3.jpg" alt="Дата"></li>  <li>  <p>Поле «Показать» отвечает за видимость данного вопроса и ответа для пользователей сайта. В любом случае, вопрос останется видимым в списке вопросов в панели администрирования. Как правило, данная галочка предназначена для того, чтобы скрыть нежелательные или не прошедшие модерацию вопросы.</p>  <img src="http://ygin.ru/instruction/engine/faq/faq-sozd-4.jpg" alt="Видимость"></li>  </ol></li>  </ol>', 0, 0, 18),
(11, 'Размещение видеороликов с Rutube', '<ol>  <li>Чтобы добавить видеоролик в раздел сайта, его необходимо загрузить на любой сервис, предоставляющий услуги хостинга видеоматериалов, например <a href="http://www.rutube.ru/">http://rutube.ru/register.html</a>.</li>  <li>Для загрузки видеороликов на сайте <a href="http://www.rutube.ru/">www.rutube.ru</a> необходимо зарегистрироваться и войти на сайт как авторизованный пользователь.</li>  <li>В меню пользователя появится возможность загрузки видеороликов.<br><span><img style="margin-top: 15px; cursor: pointer;" onclick="this.src=''http://ygin.ru/instruction/engine/rutube/3.png'';" src="http://ygin.ru/instruction/engine/rutube/3s.png" alt=""></span> <br><br><br><br></li>  <li>Для загрузки видеоролика нужно указать к нему путь, нажав кнопку «Обзор». Заполнить все необходимые поля и нажать на кнопку «Загрузить файл»<br> <img style="margin-top: 15px; cursor: pointer;" onclick="this.src=''http://ygin.ru/instruction/engine/rutube/4.png'';" src="http://ygin.ru/instruction/engine/rutube/4s.png" alt=""><br><br><br><br></li>  <li>После загрузки видеоролика необходимо зайти в раздел «мои ролики»<br> <img style="margin-top: 15px; cursor: pointer;" onclick="this.src=''http://ygin.ru/instruction/engine/rutube/5.png'';" src="http://ygin.ru/instruction/engine/rutube/5s.png" alt=""><br><br><br><br></li>  <li>Выбрать свой загруженный ролик, нажать на вкладку «ссылка и код» и скопировать ссылку на видеоролик.<br> <img style="margin-top: 15px; cursor: pointer;" onclick="this.src=''http://ygin.ru/instruction/engine/rutube/6.png'';" src="http://ygin.ru/instruction/engine/rutube/6s.png" alt=""><br><br><br><br></li>  <li>После копирования ссылки, нужно зайти в Систему администрирования сайта, открыть редактируемый раздел где необходимо вставить видеоролик, выделить курсором мыши место расположения видеоролика в содержании раздела и нажать кнопку «Вставить/редактировать медиа-объект»<br> <img style="margin-top: 15px; cursor: pointer;" onclick="this.src=''http://ygin.ru/instruction/engine/rutube/7.png'';" src="http://ygin.ru/instruction/engine/rutube/7s.png" alt=""><br><br><br><br></li>  <li>В сплывающем окне, в поле «Файл/адрес» нужно вставить скопированную ссылку на видеоролик, при необходимости отредактировать размеры и нажать кнопку «Вставить»<br> <img style="margin-top: 15px; cursor: pointer;" onclick="this.src=''http://ygin.ru/instruction/engine/rutube/8.png'';" src="http://ygin.ru/instruction/engine/rutube/8s.png" alt=""><br><br><br><br></li>  <li>После чего в редактируемом разделе появится вставленный видеоролик.<br> <img style="margin-top: 15px; cursor: pointer;" onclick="this.src=''http://ygin.ru/instruction/engine/rutube/9.png'';" src="http://ygin.ru/instruction/engine/rutube/9s.png" alt=""><br><br><br><br></li>  </ol>', 0, 1, 19),
(12, 'Размещение видеороликов с Youtube', '<ol>  <li class="noindent">Чтобы добавить видеоролик в раздел сайта, его необходимо загрузить на любой сервис, предоставляющий услуги хостинга видеоматериалов, например http://www.youtube.com/create_account?next=%2F</li>  <li>Для загрузки видеороликов на сайте www.youtube.ru необходимо зарегистрироваться и войти на сайт как авторизованный пользователь.</li>  <li>В меню пользователя появится возможность загрузки видеороликов.<br><br><img style="margin-top: 15px; cursor: pointer;" onclick="this.src=''http://ygin.ru/instruction/engine/youtube/3.png'';" src="http://ygin.ru/instruction/engine/youtube/3s.png" alt=""><br><br></li>  <li>Для загрузки видеоролика нужно указать к нему путь, нажав кнопку «Обзор» и после чего начнется загрузка файла.</li>  <li>По окончании загрузки нужно скопировать ссылку на видеоролик.<br><br><img style="margin-top: 15px; cursor: pointer;" onclick="this.src=''http://ygin.ru/instruction/engine/youtube/5.png'';" src="http://ygin.ru/instruction/engine/youtube/5s.png" alt=""><br><br></li>  <li>После копирования ссылки, нужно зайти в Систему администрирования сайта, открыть редактируемый раздел где необходимо вставить видеоролик, выделить курсором мыши место расположения видеоролика в содержании раздела и нажать кнопку «Вставить/редактировать медиа-объект»<br><br><img style="margin-top: 15px; cursor: pointer;" onclick="this.src=''http://ygin.ru/instruction/engine/youtube/6.png'';" src="http://ygin.ru/instruction/engine/youtube/6s.png" alt=""><br><br></li>  <li>В сплывающем окне, в поле «Файл/адрес» нужно вставить скопированную ссылку на видеоролик, при необходимости отредактировать размеры и нажать кнопку «Вставить»<br><br><img style="margin-top: 15px; cursor: pointer;" onclick="this.src=''http://ygin.ru/instruction/engine/youtube/7.png'';" src="http://ygin.ru/instruction/engine/youtube/7s.png" alt=""><br><br></li>  <li>После чего в редактируемом разделе появится вставленный видеоролик.<br><br><img style="margin-top: 15px; cursor: pointer;" onclick="this.src=''http://ygin.ru/instruction/engine/youtube/8.png'';" src="http://ygin.ru/instruction/engine/youtube/8s.png" alt=""><br><br></li>  </ol>', 0, 1, 20),
(13, 'Основные возможности', '<p>Интернет-сайт разработан с использованием системы управления сайтами <strong>ygin</strong>. В состав ее программного обеспечения входят:</p>  <ul>  <li>система взаимодействия с пользователем, реализующая графический оконный интерфейс;</li>  <li>система администрирования, обеспечивающая управление, ввод и  редактирование информации, используемой в процессе функционирования Интернет-сайта.</li>  </ul>  <p>Объектами автоматизации являются процессы вывода периодически изменяющейся информации, отправки сообщений, содержащих вопросы и предложения по различным проблемным областям. Основными субъектами информационного взаимодействия, реализуемого программным обеспечением Интернет-сайта, являются:</p>  <ol>  <li>посетители сайта, получающие доступ в открытые разделы;</li>  <li>редакторы сайта;</li>  <li>администраторы сайта.</li>  </ol>  <p> </p>  <ul></ul>', 0, 1, 1),
(14, 'Авторизация в системе', '<p>Для того чтобы начать работу в системе администрирования, потребуется выполнить ряд действий:</p>  <ol>  <li>Вход в систему администрирования начинается с ввода в адресной строке браузера особого адреса, который скрыт от пользователей. Для того чтобы попасть на скрытую страницу, необходимо ввести: http://название_сайта/admin/ , после чего откроется форма авторизации.  <p><img src="http://ygin.ru/instruction/engine/auto/clip_image001_0006.gif" alt="" height="204" width="274"><br><em>Авторизация в системе</em></p>  </li>  <li>В форму авторизации необходимо ввести логин и пароль, которые Вам сообщаются заранее администратором сайта.</li>  <li>В случае удачного входа, перед вами откроется основное меню с доступными для Вашего пользователя элементами.</li>  </ol>  <p style="text-align: center;"><img src="http://ygin.ru/instruction/engine/auto/clip_image003_0001.jpg" alt="" height="351" width="623"><br> <em>Главная страница системы управления сайтом</em></p>', 0, 1, 2),
(15, 'Структура системы управления', '<p>Раздел – структурная единица сайта, которая предназначена для выделения или объединения информации по какому-либо признаку. На сайте он представлен в виде странички с информацией. Раздел может иметь подразделы, которые в свою очередь могут иметь свои подразделы. Данное свойство называется вложенностью раздела.</p>  <p>Каталог разделов (папка) – раздел сайта, содержащий в себе другие разделы. <br> Обычно система каталогов имеет иерархическую структуру: каталог разделов (папка) может дополнительно содержать каталог более низкого уровня (подкаталог).</p>  <p style="text-align: center;"><img src="http://ygin.ru/instruction/engine/strukt/clip_image002_0009.jpg" alt="" height="463" width="623"></p>  <p style="text-align: center;">Структура панели управления</p>  <p>Основное меню – главный элемент навигации по панели администрирования (см. область 1), разбит на списки экземпляров, каждый из которых именуется согласно задачам, которые можно решить. Например, внутри раздела «Меню» находится инструментарий, предназначенный для редактирования основного содержимого сайта, то есть структуры меню.</p>  <p>Панель управления – набор кнопок, предназначенных для выполнения различных операций над элементами списка (см. область 2). Например, на изображении выше можно увидеть две кнопки – «Создать» и «Упорядочить», соответственно добавляющую новый элемент в список и упорядочивающую элементы списка.</p>  <p>Основное содержание – внутри этого блока находится основное содержимое страницы администрирования (списки экземпляров объектов или свойства редактируемого объекта), на изображении выше присутствует список, с помощью которого редактируется меню (см. область 3).</p>  <p><strong>Рассмотрим более подробно список экземпляров в основном содержании:</strong></p>  <ul>  <li>ИД – уникальный идентификационный номер, предназначенный для однозначного определения раздела системой управления сайтом, т.е. одному ИД всегда соответствует только один экземпляр списка (экземпляром списка может быть, например, раздел, новость и т.д.).</li>  <li>Позиция раздела – порядковый номер отображения раздела в меню сайта. Чем меньше номер, тем выше отображается данный раздел.</li>  <li>Видимость раздела – если галочка стоит, то этот раздел будет виден в меню. В противном случае раздел не будет виден в меню сайта, но при прямом обращении по ссылке в адресной строке браузера он, по-прежнему, доступен.</li>  <li>Просмотр вложенных объектов – нажав на данную кнопку, можно просмотреть все вложенные разделы. Даже при отсутствии таковых существует возможность перейти к вложенным разделам и создать их при необходимости.</li>  <li>Редактировать – при нажатии на кнопку открывается список свойств элемента списка, который позволяет, например, менять заголовок и текст разделов или дату новостей.</li>  <li>Удалить – удаляет указанный элемент списка без возможности восстановления.</li>  </ul>', 0, 1, 3),
(16, 'Переключение локализации данных (языков)', '<p>С помощью блока управления языками, у редактора есть возможность переключить текущую локализацию данных. При этом весь последующий ввод данных будет применим к выбранной локализации данных.</p>  <p style="text-align: center;"><img src="http://ygin.ru/instruction/engine/lokal/clip_image002_0009.jpg" alt="" height="29" width="134"></p>  <p style="text-align: center;"><em>Блок работы с локализацией</em></p>  <p style="text-align: center;"><img src="http://ygin.ru/instruction/engine/lokal/clip_image004_0000.jpg" alt="" height="322" width="661"></p>  <p style="text-align: center;"><em>Список разделов при работе с английской локализацией данных</em></p>  <p>Для удобства восприятия шапка таблицы со списком экземпляров данных раскрашивается в определённый цвет, разный для каждого языка. Для перевода на другие языки отдельных фраз, используемых на сайте, в системе управления предусмотрена страница «Interface localization» (Основное меню -&gt; Локализация -&gt; Interface localization), где все используемые фразы перечислены в списке.</p>', 0, 0, 4),
(17, 'Поиск по спискам экземпляров', '<p>Поиск по спискам является крайне необходимым, когда количество экземпляров какого-либо объекта становится слишком велико. Ярким примером такой ситуации является наличие большого количества новостей или разделов сайта. В такой ситуации бывает очень трудно отыскать нужный раздел сайта, особенно, учитывая их иерархическую вложенность.</p>  <p style="text-align: center;"><img src="http://ygin.ru/instruction/engine/poisk//clip_image002_0009.jpg" alt=""></p>  <p style="text-align: center;"><em>Элементы формы поиска</em></p>  <p style="text-align: left;"><strong>Форма поиска состоит из следующих элементов:</strong></p>  <ol>  <li>Список свойств объекта - перечень всех свойств объекта (см. область 1). Например, для объекта «Раздел» можно увидеть свойства «Заголовок», «Содержимое» и т.д. Из этого списка выбирается свойство, по которому будет вестись поиск.</li>  <li>Искомое значение свойства - указывается именно то значение свойства, которое нас интересует у экземпляров списка (см. область 2).</li>  <li>Кнопка «Найти» - после нажатия этой кнопки формируется список именно тех экземпляров списка, которые удовлетворяют условиям поиска (см. область 3).</li>  </ol>  <p>В качестве примера можно рассмотреть поиск нужного нам раздела по заголовку. Предположим, требуется найти на сайте раздел, заголовок которого «О компании». Для этого выполним ряд действий:</p>  <ol>  <li>В основном меню системы администрирования выбираем «Меню», чтобы перейти к списку всех разделов сайта.</li>  <li>В форме поиска, которая размещается над списком разделов, указываем свойство, по которому будет осуществляться поиск, т.е. «Заголовок раздела».</li>  <li>В качестве искомого значения свойства указываем «О компании» и нажимаем на кнопку «Найти»</li>  </ol>  <p><img src="http://ygin.ru/instruction/engine/poisk/clip_image004_0000.jpg" alt="" height="98" width="601"><br><em>Форма поиска пункта меню</em></p>  <p>В результате поиска мы получим только раздел, имеющий заголовок «О компании».</p>', 0, 1, 5),
(18, 'Элементы панели управления', '<table border="1" cellpadding="0" cellspacing="0">  <tbody>  <tr>  <td width="171">  <p align="center"><img src="http://ygin.ru/instruction/engine/uprav/clip_image001_0006.gif" alt="" height="25" width="98"></p>  </td>  <td valign="top" width="505">  <p>Кнопка «Создать». Данная кнопка предназначена для создания экземпляров открытого списка.</p>  </td>  </tr>  <tr>  <td width="171">  <p align="center"><img src="http://ygin.ru/instruction/engine/uprav/clip_image002_0006.gif" alt="" height="25" width="123"></p>  </td>  <td valign="top" width="505">  <p>Кнопка «Упорядочить» предназначена для упорядочивания элементов списка в каком-либо разделе основного меню, при этом порядок задаётся для каждой строки при помощи столбца «Порядковый номер».</p>  </td>  </tr>  <tr>  <td width="171">  <p align="center"><img src="http://ygin.ru/instruction/engine/uprav/clip_image003_0006.gif" alt="" height="25" width="76"></p>  </td>  <td valign="top" width="505">  <p>Кнопка «Вверх». Позволяет перейти из вложенной страницы на страницу уровнем выше.</p>  </td>  </tr>  </tbody>  </table>', 0, 1, 6),
(19, 'Редактор страниц', '<p></p>  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image002_0009.jpg" alt="" height="395" width="623"><br> Визуальный редактор</p>  <p>В данном поле находится всё содержимое раздела, которое будет отображаться на сайте. Для редактирования содержимого прилагается встроенный визуальный редактор. Редактор позволяет вводить и форматировать текст, таблицы, добавлять изображения, создавать в теле элемента ссылки на другие веб-ресурсы, вставлять текст из буфера обмена Windows, в том числе предварительно отформатированный, как например, из Microsoft Word.</p>  <p>Вставку форматированного текста из буфера обмена рекомендуется делать с использованием кнопки <img src="http://ygin.ru/instruction/engine/redaktor/clip_image003_0006.gif" alt="" height="14" width="16"> - Вставить из Word, чтобы имелась возможность удаления ненужного форматирования. После нажатия на кнопку выдается окно, в котором можно удалить определение стилей, шрифтов и лишние отступы и просмотреть результат. Затем производится форматирование текста по своему усмотрению в окне визуального редактора.</p>  <p><strong>Возможности редактора: </strong></p>  <table border="1" cellpadding="0" cellspacing="0">  <tbody>  <tr>  <td colspan="2" valign="top" width="676"><br> <em>Форматирование текста</em></td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image004.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>выравнивает текст по левому краю страницы</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image005.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>выравнивает текст по правому краю страницы</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image006.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>выравнивает текст по центру страницы</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image007.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>выравнивает текст по ширине страницы</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image008.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>делает текст Жирным</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image009.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>делает текст Курсивным</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image010.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>делает текст Зачёркнутым</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image011.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>делает текст Подчёркнутым</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image012.gif" alt="" height="22" width="86"></p>  </td>  <td valign="top" width="573">  <p>меняет формат текста</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image013.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>меняет цвет текста</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image014.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>меняет цвет фона</p>  </td>  </tr>  <tr>  <td colspan="2" valign="top" width="676">  <p><em>Работа с текстом</em></p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image015.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>вырезать текст</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image016.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>копировать текст</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image017.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>вставить</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image018.gif" alt="" height="14" width="16"></p>  </td>  <td valign="top" width="573">  <p>вставить как простой (без формата) текст</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image003_0007.gif" alt="" height="14" width="16"></p>  </td>  <td valign="top" width="573">  <p>вставить из Word (с форматом) текст</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image019.gif" alt="" height="13" width="15"></p>  </td>  <td valign="top" width="573">  <p>выделить весь текст</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image020.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>отменить последнее действие</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image021.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>повторить отменённое действие</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image022.gif" alt="" height="20" width="20"><img src="http://ygin.ru/instruction/engine/redaktor/clip_image023.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>задать отступы</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image024.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>рисует горизонтальную разделительную линию</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image025.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>позволяет для выделенного текста или картинки создать гиперссылку, указав адрес ссылки. В качестве гиперссылки можно указать раздел сайта или загруженный в текущий раздел файл при помощи выбора из выпадающего списка</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image026.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>позволяет убрать гиперссылку из текста</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image027.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>позволяет вставлять изображения в текст, указав при этом адрес картинки. Существует возможность выбрать изображение, загруженное ранее в раздел сайта, при помощи функционального блока «Файлы»</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image028.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>позволяет делать текст в виде нижнего индекса</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image029.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>позволяет делать текст в виде верхнего индекса</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image030.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>позволяет создавать маркированный список</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image031.gif" alt="" height="20" width="20"></p>  </td>  <td valign="top" width="573">  <p>позволяет создавать нумерованный список</p>  </td>  </tr>  <tr>  <td colspan="2" valign="top" width="676">  <p><em>Работа с таблицами</em></p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image032.gif" alt="" height="16" width="16"></p>  </td>  <td width="573">  <p>позволяет вставить новую таблицу или отредактировать свойства выделенной таблицы</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image033.gif" alt="" height="13" width="14"> <img src="http://ygin.ru/instruction/engine/redaktor/clip_image034.gif" alt="" height="13" width="14"></p>  </td>  <td width="573">  <p>позволяет просматривать свойства выделенной ячейки или строки</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image035.gif" alt="" height="15" width="16"></p>  </td>  <td width="573">  <p>позволяет вставить строку перед выделенной нами строкой</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image036.gif" alt="" height="15" width="16"></p>  </td>  <td width="573">  <p>позволяет вставить строку после выделенной нами строки</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image037.gif" alt="" height="13" width="16"></p>  </td>  <td width="573">  <p>позволяет удалить строку</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image038.gif" alt="" height="16" width="15"></p>  </td>  <td width="573">  <p>позволяет вставить столбец перед выделенным нами столбцом</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image039.gif" alt="" height="16" width="15"></p>  </td>  <td width="573">  <p>позволяет вставить столбец после выделенного нами столбца</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image040.gif" alt="" height="14" width="13"></p>  </td>  <td width="573">  <p>позволяет удалить столбец</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image041.gif" alt="" height="13" width="16"> <img src="http://ygin.ru/instruction/engine/redaktor/clip_image042.gif" alt="" height="13" width="16"></p>  </td>  <td width="573">  <p>позволяет объединять и разделять ячейки таблицы</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image043.gif" alt="" height="12" width="14"></p>  </td>  <td width="573">  <p>позволяет удалить любой формат заданного текста</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image044.gif" alt="" height="20" width="20"></p>  </td>  <td width="573">  <p>очищает исходный код страницы и исправление в нём ошибок</p>  </td>  </tr>  <tr>  <td width="103">  <p><img src="http://ygin.ru/instruction/engine/redaktor/clip_image045.gif" alt="*" height="5" width="18"></p>  </td>  <td width="573">  <p>позволяет просмотреть страницу в языке разметки (HTML)</p>  </td>  </tr>  </tbody>  </table>', 0, 1, 7),
(20, 'Работа с разделами и материалами сайта (Меню сайта)', '<p>Меню имеет иерархическую структуру с неограниченным уровнем вложенности. Список разделов в меню:</p>  <p style="text-align: center;"><br> <img src="http://ygin.ru/instruction/engine/rabota/clip_image002_0009.jpg" alt="" height="447" width="601"></p>  <p style="text-align: center;">Список разделов меню</p>  <p><strong>Создание нового раздела в меню:</strong></p>  <table border="1" cellpadding="0" cellspacing="0">  <tbody>  <tr>  <td colspan="2" valign="top" width="670"><em>Основные свойства</em></td>  </tr>  <tr>  <td valign="top" width="175">  <p>Имя</p>  </td>  <td valign="top" width="494">  <p>Введённое имя будет использоваться как название раздела в системе администрирования, а также в главном меню сайта.</p>  </td>  </tr>  <tr>  <td valign="top" width="175">  <p>Заголовок</p>  </td>  <td valign="top" width="494">  <p>Введённый текст будет использоваться в качестве заголовка страницы сайта (раздела) в тот момент, когда пользователь будет его просматривать на сайте.</p>  </td>  </tr>  <tr>  <td valign="top" width="175">  <p>Видимость</p>  </td>  <td valign="top" width="494">  <p>Признак, показывающий отображать ли раздел в меню сайта. <br> Несмотря на отсутствие видимости раздела в меню сайта, он всё равно будет доступен пользователям при наборе адреса раздела вручную.</p>  </td>  </tr>  <tr>  <td valign="top" width="175">  <p>Ссылка на страничку</p>  </td>  <td valign="top" width="494">  <p>В меню сайта для данного раздела будет сгенерирована ссылка на значение данного свойства</p>  </td>  </tr>  <tr>  <td valign="top" width="175">  <p>Файлы</p>  </td>  <td valign="top" width="494">  <p>При помощи функционального блока «Файлы» возможна загрузка файлов, доступных для данного раздела. Это могут быть изображения, архивы, документы и прочее. Для того чтобы загрузить файл, необходимо нажать на кнопку «Обзор», указать при помощи стандартного диалогового окна местоположение файла и нажать на кнопку «Загрузить» <br> Все загруженные файлы можно увидеть в выпадающем списке доступных файлов в этом же функциональном блоке.</p>  </td>  </tr>  <tr>  <td valign="top" width="175">  <p>Содержимое раздела</p>  </td>  <td valign="top" width="494">  <p>Заполняется с помощью визуального редактора. Подробное описание редактора см. в разделе «Редактор страниц»</p>  </td>  </tr>  <tr>  <td valign="top" width="175">  <p>При отсутствии контента</p>  </td>  <td valign="top" width="494">  <p>Признак перехода к потомкам (вложенным разделам) при отсутствии контента необходим, когда структура меню становится очень ветвистой, т.е. присутствует множество разделов вложенных друг в друга. Если данный признак установлен, то при обращении к разделу сначала произойдёт проверка на наличие содержимого. При отсутствии контента происходит либо переход к списку вложенных разделов сайта, либо к содержимому первого раздела, либо выводится сообщение о том, что раздел находится в стадии разработки.</p>  </td>  </tr>  <tr>  <td valign="top" width="175">  <p>Название раздела в адресной строке (на англ) - одно слово</p>  </td>  <td valign="top" width="494">  <p>Необходимо записать название раздела на английском языке без пробелов (например, для раздела «Контактная информация» можно вписать «contacts»). Вписанное значение будет дополняться в адресе к разделу (URL), например, <a href="http://www.site.ru/contacts/">www.site.ru/contacts/</a>. Ссылка формируется по иерархии меню, т.е. сначала идёт данный параметр для корневого раздела и далее по иерархии до редактируемого раздела (/parent-alias/child-alias/).</p>  </td>  </tr>  <tr>  <td colspan="2" valign="top" width="670">  <p><em>Дополнительные свойства</em></p>  </td>  </tr>  <tr>  <td valign="top" width="175">  <p>Модули</p>  </td>  <td valign="top" width="494">  <p>В данном пункте присутствует список доступных шаблонов модулей (наборов модулей) для раздела.</p>  </td>  </tr>  <tr>  <td valign="top" width="175">  <p>Имя папки для хранения данных</p>  </td>  <td valign="top" width="494">  <p>Свойство определяет имя папки на диске, в которой будут храниться данные раздела (изображения и прочие загружаемые файлы). Рекомендуем оставлять его пустым.</p>  </td>  </tr>  <tr>  <td valign="top" width="175">  <p>Мета тэг description</p>  </td>  <td valign="top" width="494">  <p>короткое описание содержимого странички. Если оставить это поле пустым, то будет взят заголовок данного раздела.</p>  </td>  </tr>  <tr>  <td valign="top" width="175">  <p>Мета тэг keywords</p>  </td>  <td valign="top" width="494">  <p>ключевые слова раздела</p>  </td>  </tr>  <tr>  <td valign="top" width="175">  <p>Значение тэга title</p>  </td>  <td valign="top" width="494">  <p>Установка значения заголовка окна браузера для данного раздела. При отсутствии заполняется автоматически.</p>  </td>  </tr>  </tbody>  </table>  <p>Для сохранения внесенных изменений необходимо нажать кнопку «Сохранить», при этом произойдет переход к списку элементов. При нажатии на кнопку «Применить», происходит сохранение всех данных без перехода куда-либо (обычно нужно, чтобы сохранить данные и продолжить работу со свойствами раздела). Для выхода из режима редактирования без сохранения изменений нажмите кнопку «Отменить».</p>', 0, 1, 8),
(21, 'Управление фотоальбомом и видеоматериалами', '<p></p>  <p style="text-align: center;"><img src="http://ygin.ru/instruction/engine/foto/clip_image002_0009.jpg" alt="" height="356" width="623"></p>  <p style="text-align: center;">Фотоальбомы</p>  <p style="text-align: left;">В фотогалерее есть возможность создавать новые фотоальбомы, а также создавать вложенные фотоальбомы, т.е. многоуровневую иерархию альбомов.</p>  <p style="text-align: left;">Для добавления альбома в текущий список (т.е. на данный уровень вложенности) служит кнопка «Создать», расположенная на панели управления.</p>  <p style="text-align: left;">Для создания вложенного альбома, нужно перейти на нужный уровень вложенности при помощи кнопки «Вложенные объекты» (см. область 1 рисунка 10) и воспользоваться кнопкой «Создать».</p>  <table border="1" cellpadding="0" cellspacing="0">  <tbody>  <tr>  <td colspan="2" valign="top" width="676"><em>Свойства альбома</em></td>  </tr>  <tr>  <td valign="top" width="162">  <p>Название</p>  </td>  <td valign="top" width="514">  <p>Заголовок фотоальбома.</p>  </td>  </tr>  <tr>  <td valign="top" width="162">  <p>Превью-фото</p>  </td>  <td valign="top" width="514">  <p>Изображение, отображаемое в списке фотоальбомов на сайте рядом с названием и текстом в списке галерей.</p>  </td>  </tr>  <tr>  <td valign="top" width="162">  <p>Текст в списке галерей</p>  </td>  <td valign="top" width="514">  <p>В разделе «Фотоальбом» на сайте выводится список имеющихся на сайте фотоальбомов. Если данное поле заполнено, то введённый в него текст отображается рядом с превью-фото фотоальбома в этом списке.</p>  </td>  </tr>  <tr>  <td valign="top" width="162">  <p>Текст в галерее</p>  </td>  <td valign="top" width="514">  <p>Если данное поле заполнено, то введённый в него текст отображается на сайте во время просмотра фотоальбома перед фотографиями.</p>  </td>  </tr>  </tbody>  </table>  <p>Для загрузки фотографий в нужный альбом необходимо перейти по ссылке «Фотографии» (см. область 2 рисунка 10) и воспользоваться кнопкой «Создать»</p>  <p style="text-align: center;"><img src="http://ygin.ru/instruction/engine/foto/clip_image004_0000.jpg" alt="" height="344" width="470"></p>  <p style="text-align: center;">Фотографии фотоальбома «Чудо России – столбы выветривания плато Маньпупунёр»</p>  <table border="1" cellpadding="0" cellspacing="0">  <tbody>  <tr>  <td colspan="2" valign="top" width="676"><em>Свойства фотографий</em></td>  </tr>  <tr>  <td valign="top" width="197">  <p>Название</p>  </td>  <td valign="top" width="479">  <p>Название фотографии (если введено) отображается на сайте рядом с фотографией.</p>  </td>  </tr>  <tr>  <td valign="top" width="197">  <p>Изображение</p>  </td>  <td valign="top" width="479">  <p>Исходное изображение, на основании которого будет сгенерирована превью-картинка (уменьшенная до небольшого размера) для просмотра в фотоальбоме</p>  </td>  </tr>  </tbody>  </table>  <p>Управление видеоматериалами производится аналогичным образом, с той разницей, что к видеоролику можно добавлять изображение для его первого кадра.</p>', 0, 0, 9);
INSERT INTO `da_instruction` (`id_instruction`, `name`, `content`, `desc_type`, `visible`, `num_seq`) VALUES
(22, 'Новостная система', '<p></p>  <p align="center"><img src="http://ygin.ru/instruction/engine/novosti/clip_image002_0009.jpg" alt="" height="360" width="494"> <br> Рис.12. Список новостей</p>  <p style="text-align: left;"><br> Для добавления новости необходимо нажать на кнопку «Создать», расположенную над списком новостей.<br> <strong>На экране редактирования свойств новости заполните поля:</strong></p>  <table border="1" cellpadding="0" cellspacing="0">  <tbody>  <tr>  <td colspan="2" valign="top" width="676">  <p><em>Свойства новости</em></p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Заголовок новости</p>  </td>  <td valign="top" width="513">  <p>Введённое значение будет использоваться как заголовок новости на сайте.</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Дата начала</p>  </td>  <td valign="top" width="513">  <p>Новость либо относится к данной дате, либо начинается с неё.</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Показывать время</p>  </td>  <td valign="top" width="513">  <p>Показывать ли время в датах новости.</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Дата окончания (анонс)</p>  </td>  <td valign="top" width="513">  <p>Иногда новость трактуется как событие, происходящее в определённый промежуток времени. Тогда «Дата анонса» (а позднее «Дата новости») на сайте отображается как «Дата начала — Дата окончания (анонс)».</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Дата для главной страницы (закрепление)</p>  </td>  <td valign="top" width="513">  <p>Используется только на главной странице портала. Предназначена для определения порядка новостей на ленте (закрепления новости до указанной даты).</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Показывать ли дату окончания</p>  </td>  <td valign="top" width="513">  <p>Признак, показывающий, отображать ли дату окончания события на сайте или нет.</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Картинка</p>  </td>  <td valign="top" width="513">  <p>Изображение, привязанное к новости. Отображается как на главной странице сайта, так и в разделе конкретной новости.</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Краткое содержание</p>  </td>  <td valign="top" width="513">  <p>Отображается на главной странице.</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Файлы</p>  </td>  <td valign="top" width="513">  <p>Список файлов, ссылки на которые (либо сами файлы) необходимо вставить в «Текст новости». Для того, чтобы загрузить файл, необходимо нажать на кнопку «Обзор», указать при помощи стандартного диалогового окна местоположение файла и нажать на кнопку «Загрузить». Все загруженные файлы можно увидеть в выпадающем списке доступных файлов.</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Текст новости</p>  </td>  <td valign="top" width="513">  <p>Заполняется с помощью визуального редактора. Выводится на сайте при отображении конкретной новости.</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Анонс</p>  </td>  <td valign="top" width="513">  <p>В системе анонс становится новостью после того, как дата начала становится больше текущего времени. Пока анонс новостью не стал, содержимое этого поля выводится на главной странице в блоке анонсов вместе с заголовком.</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Категории событий</p>  </td>  <td valign="top" width="513">  <p>Здесь перечислены категории, к которым может относиться новость. Одна новость может относиться к нескольким категориям.</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Видимость</p>  </td>  <td valign="top" width="513">  <p>Признак, отвечающий за отображение новости как на главной странице сайта, так и в архиве новостей.</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Видео</p>  </td>  <td valign="top" width="513">  <p>Видеоролик, связанный с новостью.</p>  </td>  </tr>  <tr>  <td valign="top" width="163">  <p align="left">Первый кадр видеоролика</p>  </td>  <td valign="top" width="513">  <p>Если есть видеоролик, то для его корректного отображения на странице (до начала воспроизведения) загружается изображение первого кадра. Оно отображается в плейере на странице новости на сайте.</p>  </td>  </tr>  </tbody>  </table>', 0, 0, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `da_instruction_rel`
--

CREATE TABLE IF NOT EXISTS `da_instruction_rel` (
  `id_instruction` int(8) NOT NULL,
  `rel_text` varchar(255) default NULL,
  `id_instruction_rel` int(8) NOT NULL,
  PRIMARY KEY  (`id_instruction`,`id_instruction_rel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `da_instruction_rel`
--

INSERT INTO `da_instruction_rel` (`id_instruction`, `rel_text`, `id_instruction_rel`) VALUES
(13, 'Структура системы управления', 15),
(14, 'Основные возможности', 13),
(14, 'Меню сайта', 20),
(15, 'Основные возможности', 13),
(15, 'Поиск данных', 17),
(15, 'Элементы панели управления', 18),
(17, 'Структура системы управления', 15),
(17, 'Элементы панели управления', 18),
(19, 'Размещение видео с Rutube', 11),
(19, 'Размещение видео с YouTube', 12),
(20, 'Редактор страниц', 19);

-- --------------------------------------------------------

--
-- Структура таблицы `da_job`
--

CREATE TABLE IF NOT EXISTS `da_job` (
  `id_job` varchar(255) NOT NULL COMMENT 'ИД задачи',
  `interval_value` int(8) NOT NULL default '0' COMMENT 'Интервал запуска задачи (в секундах)',
  `error_repeat_interval` int(8) NOT NULL default '0' COMMENT 'Интервал запуска задачи в случае ошибки (в секундах)',
  `first_start_date` int(10) default NULL COMMENT 'Дата первого запуска',
  `last_start_date` int(10) default NULL COMMENT 'Дата последнего запуска',
  `next_start_date` int(10) default NULL COMMENT 'Дата следущего запуска',
  `failures` int(2) NOT NULL default '0' COMMENT 'Количество ошибок',
  `name` varchar(255) NOT NULL COMMENT 'Имя задачи',
  `class_name` varchar(255) NOT NULL COMMENT 'Имя класса задачи',
  `active` tinyint(1) NOT NULL default '1' COMMENT 'Вкл.',
  `priority` tinyint(2) NOT NULL default '0' COMMENT 'Приоритет запуска',
  `start_date` int(11) default NULL COMMENT 'Дата запуска текущего потока',
  `max_second_process` int(10) default NULL COMMENT 'Максимальное число секунд выполнения задачи',
  PRIMARY KEY  (`id_job`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0 COMMENT='Планировщик';

--
-- Дамп данных таблицы `da_job`
--

INSERT INTO `da_job` (`id_job`, `interval_value`, `error_repeat_interval`, `first_start_date`, `last_start_date`, `next_start_date`, `failures`, `name`, `class_name`, `active`, `priority`, `start_date`, `max_second_process`) VALUES
('1', 90, 180, 1313061006, 1344593833, 1344593882, 0, 'Отсылка сообщений', 'ygin.modules.mail.components.DispatchEvents', 1, 0, NULL, 120);

-- --------------------------------------------------------

--
-- Структура таблицы `da_link_message_user`
--

CREATE TABLE IF NOT EXISTS `da_link_message_user` (
  `id_message` int(8) NOT NULL,
  `id_user` int(8) NOT NULL,
  PRIMARY KEY  (`id_message`,`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `da_link_message_user`
--


-- --------------------------------------------------------

--
-- Структура таблицы `da_localization`
--

CREATE TABLE IF NOT EXISTS `da_localization` (
  `id_localization` int(8) NOT NULL COMMENT 'id',
  `name` varchar(60) NOT NULL COMMENT 'Название',
  `code` char(3) NOT NULL COMMENT 'Код',
  `is_use` int(1) NOT NULL default '1' COMMENT 'Используется ли локализация',
  PRIMARY KEY  (`id_localization`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Доступные локализации';

--
-- Дамп данных таблицы `da_localization`
--

INSERT INTO `da_localization` (`id_localization`, `name`, `code`, `is_use`) VALUES
(1, 'Русская', 'ru', 1),
(2, 'Английская', 'en', 0),
(3, 'Финская', 'fi', 0),
(5, 'Немецкая', 'de', 0),
(6, 'Французская', 'fr', 0),
(7, 'Албанская', 'al', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `da_mail_account`
--

CREATE TABLE IF NOT EXISTS `da_mail_account` (
  `id_mail_account` int(8) NOT NULL COMMENT 'id',
  `email_from` varchar(50) default NULL COMMENT 'E-mail для поля "От"',
  `from_name` varchar(100) default NULL COMMENT 'Имя отправителя',
  `default_subject` varchar(255) default NULL COMMENT 'Тема по умолчанию',
  `host` varchar(50) NOT NULL COMMENT 'HOST',
  `user_name` varchar(50) default NULL COMMENT 'Имя пользователя для авторизации',
  `user_password` varchar(50) default NULL COMMENT 'Пароль для авторизации',
  `smtp_auth` int(1) NOT NULL default '1' COMMENT 'Требуется ли авторизация',
  PRIMARY KEY  (`id_mail_account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 PACK_KEYS=0 COMMENT='Почтовые аккаунты';

--
-- Дамп данных таблицы `da_mail_account`
--

INSERT INTO `da_mail_account` (`id_mail_account`, `email_from`, `from_name`, `default_subject`, `host`, `user_name`, `user_password`, `smtp_auth`) VALUES
(10, 'robot@test.ru', 'test.ru', NULL, 'smtp.test.ru', 'robot@test.ru', 'password', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `da_menu`
--

CREATE TABLE IF NOT EXISTS `da_menu` (
  `id` int(8) NOT NULL auto_increment COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT 'Название в меню',
  `caption` varchar(255) default NULL COMMENT 'Заголовок раздела',
  `content` longtext COMMENT 'Содержимое раздела',
  `visible` tinyint(1) default '1' COMMENT 'Видимость',
  `id_parent` int(8) default NULL COMMENT 'Смена родительского раздела',
  `sequence` int(2) NOT NULL default '1' COMMENT '&nbsp;',
  `handler` int(8) default NULL COMMENT 'Представление на сайте',
  `note` varchar(200) default NULL COMMENT 'Примечания',
  `alias` varchar(100) default NULL COMMENT 'Название в адресной строке',
  `title_teg` varchar(255) default NULL COMMENT '<title>',
  `meta_description` varchar(255) default NULL COMMENT '<meta name="description">',
  `meta_keywords` varchar(255) default NULL COMMENT '<meta name="keywords">',
  `go_to_type` tinyint(1) default '1' COMMENT 'При отсутствии контента:',
  `id_module_template` int(8) default NULL COMMENT 'Набор модулей',
  `external_link` varchar(255) default NULL COMMENT 'Ссылка (авто)',
  `external_link_type` tinyint(1) default NULL COMMENT 'Открывать в новом окне (авто)',
  `removable` tinyint(1) default '1' COMMENT 'Раздел можно удалить',
  `image` int(8) default NULL COMMENT 'Картинка для раздела',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `id` (`id`,`id_parent`,`sequence`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Меню' AUTO_INCREMENT=115 ;

--
-- Дамп данных таблицы `da_menu`
--

INSERT INTO `da_menu` (`id`, `name`, `caption`, `content`, `visible`, `id_parent`, `sequence`, `handler`, `note`, `alias`, `title_teg`, `meta_description`, `meta_keywords`, `go_to_type`, `id_module_template`, `external_link`, `external_link_type`, `removable`, `image`) VALUES
(100, 'Главная', 'Дорогие друзья!', '<p style="">Мы рады приветствовать вас на нашем сайте!</p>', 1, NULL, 1, NULL, NULL, '/', NULL, NULL, NULL, 1, 4, '', 0, 1, NULL),
(102, 'Поиск по сайту', 'Поиск по сайту', NULL, 0, NULL, 13, NULL, NULL, 'search', NULL, NULL, NULL, 1, 1, '', 0, 0, NULL),
(105, 'Консультации', 'Консультации', NULL, 0, NULL, 12, NULL, NULL, 'consultation', NULL, NULL, NULL, 1, 1, '', 0, 0, NULL),
(112, 'Модерирование комментариев', 'Модерирование комментариев', NULL, 0, NULL, 14, NULL, NULL, 'comment_moderation', NULL, NULL, NULL, 1, 1, '', 0, 0, NULL),
(114, 'Контакты', 'Контакты', '<table class="b-contact-table" border="0" cellpadding="0" cellspacing="0">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p style="text-align: left;"><strong>Телефоны:</strong><br>...</p>\r\n</td>\r\n<td>\r\n<p><strong>Адрес:</strong><br>...</p>\r\n</td>\r\n<td>\r\n<p style="text-align: left;"><strong>Электронная почта:</strong></p>\r\n<p>...</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', 1, NULL, 9, NULL, NULL, 'feedback', NULL, NULL, NULL, 1, 2, '', 0, 1, NULL);


-- --------------------------------------------------------

--
-- Структура таблицы `da_message`
--

CREATE TABLE IF NOT EXISTS `da_message` (
  `id_message` int(8) NOT NULL auto_increment COMMENT 'id',
  `text` longtext NOT NULL COMMENT 'Текст',
  `date` int(10) unsigned NOT NULL COMMENT 'Дата создания',
  `type` int(8) NOT NULL default '1' COMMENT 'тип',
  `sender` varchar(255) NOT NULL,
  PRIMARY KEY  (`id_message`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Уведомления' AUTO_INCREMENT=1 ;
