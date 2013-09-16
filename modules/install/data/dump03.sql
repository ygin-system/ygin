
--
-- Структура таблицы `da_php_script`
--

CREATE TABLE IF NOT EXISTS `da_php_script` (
  `id_php_script` int(8) NOT NULL auto_increment,
  `id_php_script_type` varchar(255) NOT NULL,
  `id_module` int(8) default NULL,
  `params_value` longtext,
  PRIMARY KEY  (`id_php_script`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1028 ;

--
-- Дамп данных таблицы `da_php_script`
--

INSERT INTO `da_php_script` (`id_php_script`, `id_php_script_type`, `id_module`, `params_value`) VALUES
(1016, '1032', 1007, NULL),
(1023, '1042', 1014, 'a:7:{s:11:"htmlOptions";s:32:"array(''class'' => ''nav nav-list'')";s:14:"activeCssClass";s:6:"active";s:12:"itemCssClass";s:4:"item";s:11:"encodeLabel";s:5:"false";s:18:"submenuHtmlOptions";s:46:"array(''class'' => ''nav nav-list sub-item-list'')";s:13:"maxChildLevel";s:1:"2";s:12:"baseTemplate";s:42:"<div class="b-menu-side-list">{menu}</div>";}'),
(1027, '1045', 1000, 'a:0:{}');

-- --------------------------------------------------------

--
-- Структура таблицы `da_php_script_interface`
--

CREATE TABLE IF NOT EXISTS `da_php_script_interface` (
  `id_php_script_interface` int(8) NOT NULL auto_increment COMMENT 'id',
  `sequence` int(3) NOT NULL default '1' COMMENT 'Порядок',
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `template` longtext COMMENT 'Шаблон файла',
  PRIMARY KEY  (`id_php_script_interface`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Интерфейс php-скрипта' AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `da_php_script_interface`
--

INSERT INTO `da_php_script_interface` (`id_php_script_interface`, `sequence`, `name`, `template`) VALUES
(1, 1, 'Контент раздела сайта', 'class <<class_name>> extends ViewModule {\r\n  public function run() {\r\n\r\n  }\r\n}'),
(2, 2, 'Контент модуля сайта', 'class <<class_name>> extends ViewModule {\r\n  public function run() {\r\n\r\n  }\r\n}'),
(6, 6, 'Колонка представления', '<?php\r\n\r\nclass <<class_name>> implements ColumnType {\r\n\r\n  public function init($idObject, Array $arrayOfIdInstances, $idObjectParameter) {\r\n\r\n  }\r\n  \r\n  public function process($idInstance, $value, $idObjectParameter) {\r\n    return $value;\r\n  }\r\n  \r\n  public function getStyleClass() {\r\n    return null;\r\n  }\r\n}\r\n\r\n?>'),
(9, 9, 'Визуальный элемент', 'class <> extends VisualElement implements DaVisualElement {\r\n\r\n public function callBeforeProcessInstance() {\r\n\r\n }\r\n\r\n public function callAfterProcessInstance() {\r\n\r\n }\r\n\r\n protected function validate() {\r\n return true;\r\n }\r\n\r\n public function getValueFromClient() {\r\n return null;\r\n }\r\n}');

-- --------------------------------------------------------

--
-- Структура таблицы `da_php_script_type`
--

CREATE TABLE IF NOT EXISTS `da_php_script_type` (
  `id_php_script_type` varchar(255) NOT NULL COMMENT 'id',
  `file_path` varchar(255) NOT NULL COMMENT 'Путь к скрипту',
  `class_name` varchar(255) NOT NULL COMMENT 'Имя класса',
  `description` varchar(255) default NULL COMMENT 'Название скрипта',
  `id_php_script_interface` int(8) NOT NULL COMMENT 'Интерфейс',
  `active` tinyint(1) NOT NULL default '1' COMMENT 'Активен',
  PRIMARY KEY  (`id_php_script_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='php-скрипты';

--
-- Дамп данных таблицы `da_php_script_type`
--

INSERT INTO `da_php_script_type` (`id_php_script_type`, `file_path`, `class_name`, `description`, `id_php_script_interface`, `active`) VALUES
('1000', 'project/plugin/photogallery/PhotogalleryView.php', 'PhotogalleryView', 'Фотогалерея » Раздел сайта', 1, 1),
('1001', 'photogallery.backend.column.PhotoColumn', 'PhotoColumn', 'Фотогалерея » Колонка представления', 6, 1),
('1002', 'project/plugin/search/SearchView.php', 'SearchView', 'Поиск по всему сайту', 1, 1),
('1003', 'project/plugin/news/NewsView.php', 'NewsView', 'Новости » Список', 1, 1),
('1004', 'project/plugin/news/NewsCategoryView.php', 'NewsCategoryView', 'Новости » Список в категории', 1, 1),
('1005', 'news.widgets.news.NewsWidget', 'NewsWidget', 'Новости » Список последних на главной', 2, 0),
('1006', 'project/plugin/consultation/ConsultationView.php', 'ConsultationView', 'Консультации', 1, 1),
('1007', 'project/plugin/internet_magazin/OfferFormView.php', 'OfferFormView', 'Интернет-магазин » Форма оформления заказа', 1, 1),
('1008', 'project/plugin/internet_magazin/CatalogView.php', 'CatalogView', 'Интернет-магазин » Список товаров', 1, 1),
('1009', 'project/plugin/internet_magazin/CatalogModuleView.php', 'CatalogModuleView', 'Интернет-магазин » Модуль категорий каталога', 2, 0),
('1010', 'shop.widgets.cart.CartWidget', 'CartWidget', 'Интернет-магазин » Корзина', 2, 0),
('1011', 'project/plugin/news/newsRSS.php', 'MagicRSSNews', 'RSS » Новости', 8, 1),
('1012', 'project/plugin/faq/FaqView.php', 'FaqView', 'Вопрос-ответ', 1, 1),
('1027', 'project/plugin/internet_magazin/CatalogMainView.php', 'CatalogMainView', 'Интернет-магазин » Главная страница магазина', 1, 1),
('1029', 'project/plugin/comment/CommentModerationView.php', 'CommentModerationView', 'Модерирование комментариев', 1, 1),
('1032', 'user.widgets.login.LoginWidget', 'LoginWidget', 'Авторизация', 2, 1),
('1037', 'feedback.widgets.FeedbackWidget', 'FeedbackWidget', 'Кнопка обратной связи', 2, 1),
('1038', 'shop.widgets.category.CategoryWidget', 'CategoryWidget', 'Интернет-магазин » Категории', 2, 0),
('1039', 'ygin.widgets.vitrine.VitrineWidget', 'VitrineWidget', 'Витрина', 2, 0),
('1040', 'banners.widgets.specialOffer.SpecialOfferWidget', 'SpecialOfferWidget', 'Спецпредложения', 2, 0),
('1041', 'vote.widgets.VoteWidget', 'VoteWidget', 'Голосование', 2, 0),
('1042', 'menu.widgets.MenuWidget', 'MenuWidget', 'Меню', 2, 1),
('1043', 'shop.widgets.brand.BrandWidget', 'BrandWidget', 'Интернет-магазин » Брэнды', 2, 0),
('1044', 'ygin.widgets.cloudim.CloudimWidget', 'CloudimWidget', 'Онлайн-консультации Cloudim', 2, 0),
('1045', 'photogallery.widgets.randomPhoto.RandomPhotoWidget', 'photogallery.widgets.randomPhoto.RandomPhotoWidget', 'Случайное фото', 2, 0),
('1046', 'backend.components.column.abstract.StrippedColumn', 'StrippedColumn', 'Текст без тегов и заменой nl на br', 6, 1),
('250', 'engine-module/comment/Comment.php', 'CommentColumn', 'Количество комментариев экземпляра', 6, 1),
('251', 'engine-module/comment/Comment.php', 'CommentItemNameColumn', 'Комментируемый объект', 6, 1),
('3', 'menu.backend.column.InfoStatus', 'InfoStatus', 'Статус раздела в объекте Меню', 6, 1),
('300', 'project/modules/BannerModuleView.php', 'BannerModuleView', 'Баннер', 2, 0),
('4', 'menu.backend.column.SiteModuleInfoStatus', 'SiteModuleInfoStatus', 'Статус модуля сайта', 6, 1),
('443', 'project/plugin/comment/CommentProject.php', 'CommentLinkColumn', 'Комментарии » Ссылка на объект', 6, 1),
('5', 'engine/admin/column/abstract/PhpScriptTypeCacheClear.php', 'PhpScriptTypeCacheClear', 'Кэш в базе', 6, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `da_plugin`
--

CREATE TABLE IF NOT EXISTS `da_plugin` (
  `id_plugin` int(8) NOT NULL auto_increment COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `code` varchar(255) NOT NULL COMMENT 'Код',
  `status` int(8) NOT NULL default '1' COMMENT 'Статус',
  `config` longtext COMMENT 'Сериализованные настройки',
  `class_name` varchar(255) NOT NULL COMMENT 'Класс плагина',
  `data` longtext COMMENT 'data',
  PRIMARY KEY  (`id_plugin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Плагины системы' AUTO_INCREMENT=17 ;

--
-- Дамп данных таблицы `da_plugin`
--

INSERT INTO `da_plugin` (`id_plugin`, `name`, `code`, `status`, `config`, `class_name`, `data`) VALUES
(5, 'Новости', 'ygin.news', 3, 'a:1:{s:7:"modules";a:1:{s:9:"ygin.news";a:1:{s:14:"showCategories";b:0;}}}', 'ygin.modules.news.NewsPlugin', 'a:7:{s:25:"id_php_script_type_module";i:1005;s:37:"id_php_script_type_module_param_count";i:1002;s:17:"id_sysytem_module";i:1002;s:9:"id_object";i:502;s:18:"id_object_category";i:503;s:23:"id_menu_module_template";s:1:"6";s:17:"site_module_place";a:2:{i:0;a:3:{s:5:"place";s:1:"1";s:8:"sequence";s:1:"1";s:18:"id_module_template";s:1:"1";}i:1;a:3:{s:5:"place";s:1:"5";s:8:"sequence";s:1:"1";s:18:"id_module_template";s:1:"4";}}}'),
(6, 'Поиск по сайту', 'ygin.search', 3, 'a:1:{s:7:"modules";a:1:{s:11:"ygin.search";a:0:{}}}', 'ygin.modules.search.SearchPlugin', NULL),
(7, 'Обратная связь', 'ygin.feedback', 3, 'a:1:{s:7:"modules";a:1:{s:13:"ygin.feedback";a:1:{s:11:"idEventType";s:3:"108";}}}', 'ygin.modules.feedback.FeedbackPlugin', 'a:4:{s:25:"id_php_script_type_module";i:1037;s:17:"id_sysytem_module";i:1005;s:9:"id_object";i:517;s:17:"site_module_place";a:2:{i:0;a:3:{s:5:"place";s:1:"1";s:8:"sequence";s:1:"1";s:18:"id_module_template";s:1:"2";}i:1;a:3:{s:5:"place";s:1:"1";s:8:"sequence";s:1:"2";s:18:"id_module_template";s:1:"4";}}}'),
(8, 'Фотогалерея', 'ygin.photogallery', 3, 'a:1:{s:7:"modules";a:1:{s:17:"ygin.photogallery";a:0:{}}}', 'ygin.modules.photogallery.PhotogalleryPlugin', 'a:8:{s:17:"id_object_gallery";i:500;s:15:"id_object_photo";i:501;s:14:"handler_column";i:1001;s:10:"useGallery";b:1;s:23:"id_menu_module_template";s:1:"3";s:16:"id_system_module";i:1000;s:38:"id_php_script_type_widget_random_photo";i:1045;s:22:"id_widget_random_photo";s:3:"301";}'),
(9, 'Интернет-магазин', 'ygin.shop', 3, 'a:1:{s:7:"modules";a:1:{s:9:"ygin.shop";a:7:{s:8:"pageSize";i:10;s:19:"displayTypeElements";s:3:"all";s:15:"viewProductList";s:19:"_product_list_table";s:9:"showPrice";b:1;s:17:"subCategoryOnMain";b:1;s:19:"imageCategoryOnMain";b:1;s:16:"makeOfferByOrder";b:0;}}}', 'ygin.modules.shop.ShopPlugin', 'a:14:{s:34:"id_php_script_type_module_category";i:1038;s:30:"id_php_script_type_module_cart";i:1010;s:50:"id_php_script_type_module_cart_param_visible_count";i:1028;s:31:"id_php_script_type_module_brand";i:1043;s:17:"id_sysytem_module";i:1004;s:17:"id_object_product";i:511;s:18:"id_object_category";i:509;s:15:"id_object_offer";i:519;s:15:"id_object_brand";i:525;s:19:"idEventTypeNewOffer";i:106;s:23:"id_menu_module_template";s:1:"5";s:26:"site_module_place_category";a:1:{i:0;a:3:{s:5:"place";s:1:"1";s:8:"sequence";s:1:"3";s:18:"id_module_template";s:1:"5";}}s:22:"site_module_place_cart";a:1:{i:0;a:3:{s:5:"place";s:1:"1";s:8:"sequence";s:1:"1";s:18:"id_module_template";s:1:"5";}}s:23:"site_module_place_brand";a:1:{i:0;a:3:{s:5:"place";s:1:"1";s:8:"sequence";s:1:"2";s:18:"id_module_template";s:1:"5";}}}'),
(10, 'Вопрос-ответ', 'ygin.faq', 3, 'a:1:{s:7:"modules";a:1:{s:8:"ygin.faq";a:3:{s:8:"pageSize";i:15;s:8:"moderate";b:1;s:11:"idEventType";i:103;}}}', 'ygin.modules.faq.FaqPlugin', 'a:2:{s:9:"id_object";i:512;s:23:"id_menu_module_template";s:1:"3";}'),
(11, 'Опросы', 'ygin.vote', 3, 'a:1:{s:7:"modules";a:1:{s:9:"ygin.vote";a:4:{s:13:"expiredTimout";i:24;s:13:"checkByCookie";b:1;s:9:"checkByIp";b:1;s:9:"numVoteIp";i:1;}}}', 'ygin.modules.vote.VotePlugin', 'a:6:{s:25:"id_php_script_type_module";i:1041;s:17:"id_sysytem_module";i:1013;s:16:"id_object_voting";i:105;s:23:"id_object_voting_answer";i:106;s:23:"id_menu_module_template";N;s:17:"site_module_place";a:3:{i:0;a:3:{s:5:"place";s:1:"1";s:8:"sequence";s:1:"2";s:18:"id_module_template";s:1:"1";}i:1;a:3:{s:5:"place";s:1:"1";s:8:"sequence";s:1:"3";s:18:"id_module_template";s:1:"4";}i:2;a:3:{s:5:"place";s:1:"1";s:8:"sequence";s:1:"1";s:18:"id_module_template";s:1:"6";}}}'),
(12, 'Баннеры', 'ygin.banners', 3, 'a:1:{s:7:"modules";a:1:{s:12:"ygin.banners";a:0:{}}}', 'ygin.modules.banners.BannerPlugin', 'a:3:{s:17:"id_sysytem_module";i:300;s:22:"id_object_banner_place";i:261;s:16:"id_object_banner";i:260;}'),
(13, 'Спецпредложения', 'ygin.specoffers', 3, 'a:0:{}', 'ygin.modules.banners.widgets.specialOffer.SpecialOfferPlugin', 'a:4:{s:25:"id_php_script_type_module";i:1040;s:37:"id_php_script_type_module_param_place";i:1016;s:17:"id_sysytem_module";i:1012;s:17:"site_module_place";a:1:{i:0;a:3:{s:5:"place";s:1:"4";s:8:"sequence";s:1:"2";s:18:"id_module_template";s:1:"4";}}}'),
(14, 'Витрина', 'ygin.vitrine', 3, 'a:0:{}', 'ygin.widgets.vitrine.VitrinePlugin', 'a:4:{s:25:"id_php_script_type_module";i:1039;s:17:"id_sysytem_module";i:1011;s:9:"id_object";i:520;s:17:"site_module_place";a:1:{i:0;a:3:{s:5:"place";s:1:"4";s:8:"sequence";s:1:"1";s:18:"id_module_template";s:1:"4";}}}'),
(15, 'Онлайн-консультант', 'ygin.cloudim', 3, 'a:1:{s:10:"components";a:1:{s:13:"widgetFactory";a:1:{s:7:"widgets";a:1:{s:13:"CloudimWidget";a:1:{s:8:"htmlCode";s:0:"";}}}}}', 'ygin.widgets.cloudim.CloudimPlugin', 'a:3:{s:25:"id_php_script_type_module";i:1044;s:17:"id_sysytem_module";i:1015;s:17:"site_module_place";a:0:{}}'),
(16, 'Отзывы', 'ygin.review', 3, 'a:1:{s:7:"modules";a:1:{s:11:"ygin.review";a:3:{s:8:"pageSize";i:15;s:8:"moderate";b:1;s:11:"idEventType";i:107;}}} ', 'ygin.modules.review.ReviewPlugin', 'a:2:{s:9:"id_object";i:530;s:23:"id_menu_module_template";s:1:"1";}');

-- --------------------------------------------------------

--
-- Структура таблицы `da_references`
--

CREATE TABLE IF NOT EXISTS `da_references` (
  `id_reference` varchar(255) NOT NULL COMMENT 'id',
  `name` varchar(100) NOT NULL COMMENT 'Название справочника',
  PRIMARY KEY  (`id_reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Справочники';

--
-- Дамп данных таблицы `da_references`
--

INSERT INTO `da_references` (`id_reference`, `name`) VALUES
('100', 'Тип вопроса в викторине'),
('101', 'Статус заказа пользователя'),
('2', 'Расположение данные в почтовом сообщении'),
('30', 'Типы порядка'),
('31', 'Тип объекта'),
('32', 'Положение модулей'),
('33', 'Варианты обработки отсутсвия контента в разделе'),
('37', 'Место использования AJAX'),
('38', 'AJAX-движки'),
('50', 'Тип показа баннеров');

-- --------------------------------------------------------

--
-- Структура таблицы `da_reference_element`
--

CREATE TABLE IF NOT EXISTS `da_reference_element` (
  `id_reference` varchar(255) NOT NULL default '0' COMMENT 'Справочник',
  `id_reference_element` int(8) NOT NULL default '0' COMMENT 'Значение элемента',
  `value` varchar(255) NOT NULL COMMENT 'Описание значения',
  `image_element` varchar(150) default NULL COMMENT 'Картинка для значения',
  `id_reference_element_instance` varchar(255) NOT NULL COMMENT 'id',
  PRIMARY KEY  (`id_reference_element_instance`),
  UNIQUE KEY `id_reference` (`id_reference`,`id_reference_element`),
  UNIQUE KEY `id_reference_2` (`id_reference`,`id_reference_element`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Значения справочника';

--
-- Дамп данных таблицы `da_reference_element`
--

INSERT INTO `da_reference_element` (`id_reference`, `id_reference_element`, `value`, `image_element`, `id_reference_element_instance`) VALUES
('50', 1, 'Баннеры меняются поочерёдно в заданном порядке', NULL, '100'),
('50', 2, 'Баннеры меняются в произвольном порядке', NULL, '101'),
('50', 3, 'Вывод всех баннеров', NULL, '102'),
('30', 1, 'ASC', NULL, '16'),
('30', 2, 'DESC', NULL, '17'),
('31', 1, 'Стандартный', NULL, '18'),
('31', 3, 'Ручной (обработчик)', NULL, '19'),
('32', 1, 'Слева', NULL, '20'),
('32', 2, 'Справа', NULL, '21'),
('32', 3, 'Снизу', NULL, '22'),
('32', 4, 'Сверху', NULL, '23'),
('32', 5, 'В контенте', NULL, '24'),
('32', 7, 'Сверху в контенте', NULL, '25'),
('32', 95, 'В архиве', NULL, '26'),
('37', 1, 'Раздел', NULL, '38'),
('37', 2, 'Модуль', NULL, '39'),
('37', 3, 'Другое', NULL, '40'),
('38', 1, 'JsHttpRequest', NULL, '41'),
('38', 2, 'XAJAX', NULL, '42'),
('38', 3, 'jQuery', NULL, '43'),
('38', 4, 'ValumsFileUpload', NULL, '44'),
('31', 4, 'Наследник', NULL, '47'),
('2', 1, 'В тексте письма', NULL, '5'),
('33', 1, 'Отобразить список вложенных разделов', NULL, '50'),
('100', 1, 'один верный', NULL, '500'),
('100', 2, 'много верных', NULL, '501'),
('100', 3, 'произвольный', NULL, '502'),
('32', 6, 'Подвал', NULL, '503'),
('101', 1, 'Новый', NULL, '504'),
('101', 2, 'Согласован', NULL, '505'),
('101', 3, 'Оплачен', NULL, '506'),
('101', 4, 'Выполнен', NULL, '507'),
('101', 5, 'Отменен', NULL, '508'),
('33', 4, 'Не выводить предупреждение, отобразить пустую страницу', NULL, '509'),
('33', 2, 'Переходить к первому вложенному разделу', NULL, '51'),
('33', 3, 'Открыть первый загруженный файл', NULL, '52'),
('2', 2, 'Во вложении', NULL, '6'),
('31', 5, 'Ссылка', NULL, 'ygin.object.reference.type.link');

-- --------------------------------------------------------

--
-- Структура таблицы `da_search_data`
--

CREATE TABLE IF NOT EXISTS `da_search_data` (
  `id_object` int(8) NOT NULL,
  `id_instance` int(8) NOT NULL,
  `id_lang` int(8) NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY  (`id_object`,`id_instance`,`id_lang`),
  KEY `id_object` (`id_object`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Структура таблицы `da_search_history`
--

CREATE TABLE IF NOT EXISTS `da_search_history` (
  `id_search_history` int(8) NOT NULL auto_increment,
  `phrase` varchar(255) default NULL,
  `query` text,
  `info` varchar(255) default NULL,
  `date` int(11) NOT NULL,
  `ip` varchar(32) NOT NULL,
  PRIMARY KEY  (`id_search_history`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;


-- --------------------------------------------------------

--
-- Структура таблицы `da_site_module`
--

CREATE TABLE IF NOT EXISTS `da_site_module` (
  `id_module` int(8) unsigned NOT NULL auto_increment COMMENT 'id',
  `id_php_script` int(8) default NULL COMMENT 'Обработчик',
  `name` varchar(255) NOT NULL COMMENT 'Имя',
  `is_visible` tinyint(1) default '1' COMMENT 'Видимость',
  `content` text COMMENT 'Простой текст',
  `html` longtext COMMENT 'Форматированный текст',
  PRIMARY KEY  (`id_module`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 PACK_KEYS=0 COMMENT='Модули сайта' AUTO_INCREMENT=120 ;

--
-- Дамп данных таблицы `da_site_module`
--

INSERT INTO `da_site_module` (`id_module`, `id_php_script`, `name`, `is_visible`, `content`, `html`) VALUES
(108, 1016, 'Авторизация', 1, NULL, NULL),
(116, NULL, '2Gis-карта', 1, '<script charset="utf-8" type="text/javascript" src="http://firmsonmap.api.2gis.ru/js/DGWidgetLoader.js"></script>\r\n<script charset="utf-8" type="text/javascript">new DGWidgetLoader({"borderColor":"#a3a3a3","width":"620","height":"600","wid":"85cca48bc5e612adab3258add13119c4","pos":{"lon":"37.628682025721","lat":"55.754496096475","zoom":"10"},"opt":{"ref":"hidden","card":[""],"city":"moscow"},"org":[{"id":"4504127913658730"}]});</script>\r\n<noscript style="color:#c00;font-size:16px;font-weight:bold;">Виджет карты использует JavaScript. Включите его в настройках вашего браузера.</noscript>', ''),
(117, NULL, 'Контакты организации', 1, '<address class="vcard">\r\n  <div>\r\n<span class="tel">8 (495) 123-45-67</span>\r\n</div>\r\n<div>\r\n<span class="tel">8 (495) 123-45-68</span>\r\n  </div>\r\n<div>\r\n<a class="email" href="mailto:test@test.ru">test@test.ru</a>\r\n  </div>\r\n</address>', ''),
(118, NULL, 'Счётчики', 1, '<!-- Сюда вставлять код Яндекс.Метрики -->', NULL),
(119, 1023, 'Левое меню', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `da_site_module_rel`
--

CREATE TABLE IF NOT EXISTS `da_site_module_rel` (
  `id_module` int(8) NOT NULL default '0',
  `place` int(3) NOT NULL default '0',
  `sequence` int(3) NOT NULL default '1',
  `id_module_template` int(8) NOT NULL,
  PRIMARY KEY  (`id_module_template`,`id_module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `da_site_module_rel`
--

INSERT INTO `da_site_module_rel` (`id_module`, `place`, `sequence`, `id_module_template`) VALUES
(117, 6, 1, 1),
(118, 6, 2, 1),
(116, 3, 1, 2),
(117, 6, 1, 2),
(118, 6, 2, 2),
(117, 6, 1, 3),
(118, 6, 2, 3),
(117, 6, 1, 4),
(118, 6, 2, 4),
(117, 6, 1, 5),
(118, 6, 2, 5),
(117, 6, 1, 6),
(118, 6, 2, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `da_site_module_template`
--

CREATE TABLE IF NOT EXISTS `da_site_module_template` (
  `id_module_template` int(8) NOT NULL auto_increment COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT 'Название шаблона',
  `is_default_template` int(1) NOT NULL default '0' COMMENT 'Шаблон по умолчанию',
  PRIMARY KEY  (`id_module_template`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Наборы модулей' AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `da_site_module_template`
--

INSERT INTO `da_site_module_template` (`id_module_template`, `name`, `is_default_template`) VALUES
(1, 'Основной', 1),
(2, 'Контакты', 0),
(3, 'Без модулей', 0),
(4, 'Главная', 0),
(5, 'Каталог товаров', 0),
(6, 'Новости', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `da_stat_view`
--

CREATE TABLE IF NOT EXISTS `da_stat_view` (
  `id_object` int(11) NOT NULL,
  `id_instance` int(11) NOT NULL,
  `last_date_process` int(11) NOT NULL,
  `view_type` tinyint(2) NOT NULL,
  `view_count` int(11) NOT NULL,
  PRIMARY KEY  (`id_object`,`id_instance`,`view_type`,`last_date_process`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `da_stat_view`
--


-- --------------------------------------------------------

--
-- Структура таблицы `da_system_parameter`
--

CREATE TABLE IF NOT EXISTS `da_system_parameter` (
  `id_system_parameter` varchar(255) NOT NULL COMMENT 'id',
  `id_group_system_parameter` int(8) NOT NULL default '0' COMMENT 'Группа параметров',
  `name` varchar(60) NOT NULL COMMENT 'Имя для разработчика',
  `value` varchar(255) default NULL COMMENT 'Значение параметра',
  `note` varchar(255) default '-' COMMENT 'Описание',
  `id_parameter_type` int(8) default '2' COMMENT 'Тип\r\nданных',
  `long_text_value` longtext COMMENT 'Значение для больших текстовых данных (longtext)',
  PRIMARY KEY  (`id_system_parameter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Настройки сайта';

--
-- Дамп данных таблицы `da_system_parameter`
--

INSERT INTO `da_system_parameter` (`id_system_parameter`, `id_group_system_parameter`, `name`, `value`, `note`, `id_parameter_type`, `long_text_value`) VALUES
('10', 7, 'id_current_vote', '6', 'Идентификатор текущего голосования', 2, NULL),
('101', 2, 'translit_uploaded_file_name', '1', 'Выполнять транслитерацию имен загружаемых файлов', 9, NULL),
('12', 1, 'count_day_for_delete_event', '30', 'Срок, который хранятся отосланные события (в днях)', 2, NULL),
('20', 3, 'locale_data', '1', 'Current localization', 1, NULL),
('21', 3, 'locale_repository', '1', 'Локализация репозиторных данных', 1, NULL),
('3', 2, 'site_version', '20120706', 'Версия сайта', 2, NULL),
('30', 2, 'PR_TINY_STYLES_LINK', NULL, 'Дополнительные стили для ссылок (напр: Стиль 1=style_name;Стиль 2=style_name2;)', 2, NULL),
('31', 2, 'upload_image_width', '1024', 'Автоматически уменьшать до заданного размера ширину загружаемых изображений', 1, NULL),
('32', 2, 'upload_image_height', '768', 'Автоматически уменьшать до заданного размера высоту загружаемых изображений', 1, NULL),
('33', 1, 'theme_path', 'project/theme', 'Путь до папки с темами сайта', 2, NULL),
('4', 1, 'version', '2012.07.28', 'Версия системы', 2, NULL),
('500', 2, 'phone', '22-13-14', 'Телефон', 2, NULL),
('6', 2, 'id_domain_default', '1', 'ИД основного домена', 1, NULL),
('7', 1, 'count_sent_mail_for_session', '3', 'Количество отсылаемых сообщений за сессию (0 - все)', 2, NULL),
('8', 7, 'vote_max_available_answer', '10', 'Максимально возможное количество ответов для голосования', 2, NULL),
('9', 7, 'voting_timeout', '3600', 'Врямя, через которое пользователь может вновь голосовать (в сек)', 2, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `da_users`
--

CREATE TABLE IF NOT EXISTS `da_users` (
  `id_user` int(8) NOT NULL auto_increment COMMENT 'id',
  `name` varchar(100) character set utf8 collate utf8_bin NOT NULL COMMENT 'Логин',
  `user_password` varchar(150) character set utf8 collate utf8_bin default NULL COMMENT 'Пароль',
  `mail` varchar(255) NOT NULL COMMENT 'E-mail',
  `full_name` varchar(200) default NULL COMMENT 'Имя пользователя',
  `rid` varchar(64) default NULL COMMENT 'Регистрационный ИД',
  `create_date` int(10) NOT NULL default '0' COMMENT 'Дата регистрации пользователя',
  `count_post` int(8) NOT NULL default '0' COMMENT 'count_post',
  `active` tinyint(1) default '1' COMMENT 'Активен',
  `requires_new_password` tinyint(1) NOT NULL default '0' COMMENT 'Необходимо сменить пароль',
  `salt` varchar(255) default NULL COMMENT 'Соль для пароля',
  `password_strategy` varchar(255) default NULL COMMENT 'Стратегия для формирования пароля',
  PRIMARY KEY  (`id_user`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 PACK_KEYS=0 COMMENT='Пользователи' AUTO_INCREMENT=106 ;


-- --------------------------------------------------------

--
-- Структура таблицы `da_visit_site`
--

CREATE TABLE IF NOT EXISTS `da_visit_site` (
  `id_instance` int(8) NOT NULL default '0',
  `id_object` int(8) NOT NULL default '0',
  `date` int(10) NOT NULL default '0',
  `ip` int(10) unsigned NOT NULL,
  `type_visit` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id_object`,`id_instance`,`type_visit`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Структура таблицы `pr_banner`
--

CREATE TABLE IF NOT EXISTS `pr_banner` (
  `id_banner` int(8) NOT NULL auto_increment COMMENT 'ID',
  `unique_name` varchar(100) NOT NULL COMMENT 'Уникальное название баннера (на английском языке)',
  `link` varchar(255) default NULL COMMENT 'Ссылка на сайт',
  `alt` varchar(255) default NULL COMMENT 'Текстовое описание',
  `file` int(8) NOT NULL COMMENT 'Файл',
  `id_banner_place` int(11) NOT NULL COMMENT 'Баннерное место',
  `visible` tinyint(1) NOT NULL default '1' COMMENT 'Видимость',
  `sequence` int(5) NOT NULL COMMENT 'Порядок',
  PRIMARY KEY  (`id_banner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Баннеры' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_banner`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_banner_place`
--

CREATE TABLE IF NOT EXISTS `pr_banner_place` (
  `id_banner_place` int(11) NOT NULL auto_increment COMMENT 'ID',
  `id_object` int(11) default NULL COMMENT 'id_object',
  `id_instance` int(11) default NULL COMMENT 'id_instance',
  `title` varchar(255) NOT NULL COMMENT 'Название',
  `showing` tinyint(2) NOT NULL COMMENT 'Тип показа баннеров',
  `sequence` smallint(11) default '1' COMMENT 'Порядок',
  `id_parent` int(11) default NULL COMMENT 'Родительский ключ',
  `width` int(8) default NULL COMMENT 'Ширина',
  `height` int(8) default NULL COMMENT 'Высота',
  PRIMARY KEY  (`id_banner_place`),
  KEY `id_module` (`id_instance`,`sequence`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Баннерные места' AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `pr_banner_place`
--

INSERT INTO `pr_banner_place` (`id_banner_place`, `id_object`, `id_instance`, `title`, `showing`, `sequence`, `id_parent`, `width`, `height`) VALUES
(3, -1, NULL, 'Баннер слева', 3, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pr_client_review`
--

CREATE TABLE IF NOT EXISTS `pr_client_review` (
  `id_client_review` int(8) NOT NULL auto_increment COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT 'ФИО',
  `create_date` int(10) NOT NULL COMMENT 'Дата',
  `review` longtext NOT NULL COMMENT 'Текст отзыва',
  `ip` varchar(255) NOT NULL COMMENT 'ip',
  `visible` tinyint(1) default NULL COMMENT 'Видимость на сайте',
  `contact` varchar(255) default NULL COMMENT 'Контакты клиента',
  PRIMARY KEY  (`id_client_review`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Отзывы клиентов' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_client_review`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_comment`
--

CREATE TABLE IF NOT EXISTS `pr_comment` (
  `id_comment` int(8) NOT NULL auto_increment COMMENT 'id',
  `id_object` int(10) NOT NULL COMMENT 'Объект',
  `id_instance` int(10) NOT NULL COMMENT 'Экземпляр',
  `comment_name` varchar(255) default NULL COMMENT 'Автор',
  `id_user` int(8) default NULL COMMENT 'Пользователь',
  `comment_theme` varchar(255) default NULL COMMENT 'Тема',
  `comment_date` int(10) NOT NULL COMMENT 'Дата',
  `comment_text` text NOT NULL COMMENT 'Комментарий',
  `moderation` int(8) default NULL COMMENT 'Отмодерировано',
  `ip` varchar(50) default NULL COMMENT 'IP',
  `id_parent` int(11) default NULL COMMENT 'id_parent',
  `token` varchar(255) NOT NULL COMMENT 'Токен',
  PRIMARY KEY  (`id_comment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Комментарии' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_comment`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_consultation_answer`
--

CREATE TABLE IF NOT EXISTS `pr_consultation_answer` (
  `id_consultation_answer` int(8) NOT NULL COMMENT 'id',
  `id_consultation_ask` int(8) NOT NULL COMMENT 'На вопрос',
  `id_consultation_answerer` int(8) NOT NULL COMMENT 'Отвечающий',
  `answerer` varchar(255) default NULL COMMENT 'Отвечающий (ручной ввод)',
  `answer_date` int(10) unsigned default NULL COMMENT 'Дата ответа',
  `answer` text NOT NULL COMMENT 'Ответ',
  `ip` varchar(255) default NULL COMMENT 'IP отвечающего',
  PRIMARY KEY  (`id_consultation_answer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ответ';

--
-- Дамп данных таблицы `pr_consultation_answer`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_consultation_answerer`
--

CREATE TABLE IF NOT EXISTS `pr_consultation_answerer` (
  `id_consultation_answerer` int(8) NOT NULL COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT 'ФИО отвечающего',
  `email` varchar(255) default NULL COMMENT 'e-mail',
  `photo` int(8) default NULL COMMENT 'Фото',
  `caption_before` varchar(255) default NULL COMMENT 'Подпись перед ФИО',
  `caption_after` varchar(255) default NULL COMMENT 'Подпись после ФИО',
  `short_info` text COMMENT 'Краткое описание',
  `full_info` text COMMENT 'Полное описание',
  PRIMARY KEY  (`id_consultation_answerer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Отвечающий';

--
-- Дамп данных таблицы `pr_consultation_answerer`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_consultation_answerer_specialization`
--

CREATE TABLE IF NOT EXISTS `pr_consultation_answerer_specialization` (
  `id_consultation_answerer` int(8) NOT NULL,
  `id_consultation_specialization` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pr_consultation_answerer_specialization`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_consultation_ask`
--

CREATE TABLE IF NOT EXISTS `pr_consultation_ask` (
  `id_consultation_ask` int(8) NOT NULL COMMENT 'id',
  `user_fio` varchar(255) NOT NULL COMMENT 'ФИО спрашивающего',
  `email` varchar(255) default NULL COMMENT 'E-mail спрашивающего',
  `ask_date` int(10) unsigned default NULL COMMENT 'Дата вопроса',
  `ask` text NOT NULL COMMENT 'Вопрос',
  `ip` varchar(255) default NULL COMMENT 'IP спрашивающего',
  `is_visible` tinyint(1) default NULL COMMENT 'Видимость',
  `attachment` int(8) default NULL COMMENT 'Приложение',
  PRIMARY KEY  (`id_consultation_ask`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Вопрос';

--
-- Дамп данных таблицы `pr_consultation_ask`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_consultation_ask_specialization`
--

CREATE TABLE IF NOT EXISTS `pr_consultation_ask_specialization` (
  `id_consultation_ask` int(8) NOT NULL,
  `id_consultation_specialization` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pr_consultation_ask_specialization`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_consultation_specialization`
--

CREATE TABLE IF NOT EXISTS `pr_consultation_specialization` (
  `id_consultation_specialization` int(8) NOT NULL COMMENT 'id',
  `specialization` varchar(255) NOT NULL COMMENT 'Специализация',
  `description` text COMMENT 'Описание',
  PRIMARY KEY  (`id_consultation_specialization`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Специализация отвечающего';

--
-- Дамп данных таблицы `pr_consultation_specialization`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_feedback`
--

CREATE TABLE IF NOT EXISTS `pr_feedback` (
  `id_feedback` int(8) NOT NULL auto_increment COMMENT 'id',
  `fio` varchar(255) NOT NULL COMMENT 'ФИО',
  `phone` varchar(255) default NULL COMMENT 'Телефон',
  `mail` varchar(255) default NULL COMMENT 'e-mail',
  `message` longtext NOT NULL COMMENT 'Сообщение',
  `date` int(10) NOT NULL COMMENT 'Дата сообщения',
  `ip` varchar(255) NOT NULL COMMENT 'ip',
  PRIMARY KEY  (`id_feedback`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Обратная связь' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_feedback`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_link_offer_product`
--

CREATE TABLE IF NOT EXISTS `pr_link_offer_product` (
  `id_offer` int(8) NOT NULL,
  `id_product` int(8) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY  (`id_offer`,`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pr_link_offer_product`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_news`
--

CREATE TABLE IF NOT EXISTS `pr_news` (
  `id_news` int(8) NOT NULL auto_increment COMMENT 'ID',
  `title` varchar(255) NOT NULL COMMENT 'Заголовок',
  `date` int(10) unsigned NOT NULL COMMENT 'Дата',
  `id_news_category` int(8) default NULL COMMENT 'Категория',
  `short` text COMMENT 'Краткое содержание',
  `content` text NOT NULL COMMENT 'Содержание',
  `photo` int(8) default NULL COMMENT 'Картинка',
  `is_visible` tinyint(1) default '1' COMMENT 'Видимость',
  PRIMARY KEY  (`id_news`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Новости' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_news`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_news_category`
--

CREATE TABLE IF NOT EXISTS `pr_news_category` (
  `id_news_category` int(8) NOT NULL auto_increment COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `seq` int(8) NOT NULL default '1' COMMENT 'п/п',
  `is_visible` tinyint(1) default '1' COMMENT 'Видимость',
  PRIMARY KEY  (`id_news_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Категории новостей' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_news_category`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_offer`
--

CREATE TABLE IF NOT EXISTS `pr_offer` (
  `id_offer` int(8) NOT NULL auto_increment COMMENT 'id',
  `fio` varchar(255) NOT NULL COMMENT 'ФИО',
  `phone` varchar(255) default NULL COMMENT 'Телефон',
  `mail` varchar(255) NOT NULL COMMENT 'e-mail',
  `comment` longtext COMMENT 'Пожелания',
  `offer_text` longtext NOT NULL COMMENT 'Заказ',
  `create_date` int(10) NOT NULL COMMENT 'Дата заказа',
  `is_process` tinyint(1) default NULL COMMENT 'Обработано',
  `ip` varchar(255) NOT NULL COMMENT 'ip',
  `is_send` tinyint(1) default NULL COMMENT 'Отправлено ли уведомление',
  `status` int(8) NOT NULL COMMENT 'Статус',
  PRIMARY KEY  (`id_offer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Заказы пользователей' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_offer`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_photogallery`
--

CREATE TABLE IF NOT EXISTS `pr_photogallery` (
  `id_photogallery` int(8) NOT NULL auto_increment COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `text_in_gallery` text COMMENT 'Текст в галерее',
  `sequence` int(8) default NULL COMMENT 'п/п',
  `id_parent` int(8) default NULL COMMENT 'Родительский раздел',
  PRIMARY KEY  (`id_photogallery`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Фотогалереи' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_photogallery`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_photogallery_photo`
--

CREATE TABLE IF NOT EXISTS `pr_photogallery_photo` (
  `id_photogallery_photo` int(8) NOT NULL auto_increment COMMENT 'ID',
  `name` varchar(255) default NULL COMMENT 'Название',
  `id_photogallery_object` int(8) NOT NULL COMMENT 'Объект',
  `id_photogallery_instance` int(8) NOT NULL COMMENT 'Экземпляр-фотогалерея',
  `file` int(8) NOT NULL COMMENT 'Файл',
  `sequence` int(8) default NULL COMMENT 'п/п',
  PRIMARY KEY  (`id_photogallery_photo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Фотографии' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_photogallery_photo`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_product`
--

CREATE TABLE IF NOT EXISTS `pr_product` (
  `id_product` int(8) NOT NULL auto_increment COMMENT 'id',
  `id_product_category` int(8) NOT NULL COMMENT 'Каталог продукции',
  `code` varchar(255) default NULL COMMENT 'Артикул',
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `trade_price` decimal(8,2) NOT NULL COMMENT 'Оптовая цена',
  `sm_trade_price` decimal(8,2) NOT NULL COMMENT 'Мал. оптовая цена',
  `retail_price` decimal(8,2) NOT NULL COMMENT 'Розничная цена',
  `unit` varchar(255) default NULL COMMENT 'Единица измерения',
  `quanList` varchar(255) default NULL,
  `remain` varchar(255) default NULL COMMENT 'Остаток',
  `description` longtext COMMENT 'Описание товара',
  `deleted` tinyint(1) NOT NULL COMMENT 'Удален',
  `image` int(8) default NULL COMMENT 'Изображение',
  `properties` longtext COMMENT 'Характеристики',
  `additional_desc` longtext COMMENT 'Монтаж',
  `visible` tinyint(1) default '1' COMMENT 'Видимость',
  `id_brand` int(8) default NULL COMMENT 'Брэнд',
  `video` longtext COMMENT 'Видео',
  PRIMARY KEY  (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Продукция' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_product`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_product_brand`
--

CREATE TABLE IF NOT EXISTS `pr_product_brand` (
  `id_brand` int(8) NOT NULL auto_increment COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `id_parent` int(8) default NULL COMMENT 'Родительский брэнд',
  `image` int(8) default NULL COMMENT 'Логотип брэнда',
  `sequence` int(8) default NULL COMMENT 'п/п',
  PRIMARY KEY  (`id_brand`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Брэнды' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_product_brand`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_product_category`
--

CREATE TABLE IF NOT EXISTS `pr_product_category` (
  `id_product_category` int(8) NOT NULL auto_increment COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `id_parent` int(8) default NULL COMMENT 'Родитель',
  `image` int(8) default NULL COMMENT 'Изображение',
  `price_markup` int(8) NOT NULL default '0' COMMENT 'Наценка',
  `sequence` int(8) default NULL COMMENT 'п/п',
  `visible` tinyint(1) default '1' COMMENT 'Видимость',
  PRIMARY KEY  (`id_product_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Категории продукции' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_product_category`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_question`
--

CREATE TABLE IF NOT EXISTS `pr_question` (
  `id_question` int(8) NOT NULL auto_increment COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT 'Спрашивающий',
  `email` varchar(255) default NULL COMMENT 'E-mail',
  `ask_date` int(10) NOT NULL COMMENT 'Дата',
  `question` longtext NOT NULL COMMENT 'Вопрос',
  `answer` text COMMENT 'Ответ',
  `visible` tinyint(1) default NULL COMMENT 'Видимость',
  `ip` varchar(100) NOT NULL,
  PRIMARY KEY  (`id_question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Вопрос-ответ' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_question`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_quiz`
--

CREATE TABLE IF NOT EXISTS `pr_quiz` (
  `id_quiz` int(8) NOT NULL auto_increment COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT 'name',
  `description` text COMMENT 'description',
  `active` tinyint(1) NOT NULL default '1' COMMENT 'active',
  PRIMARY KEY  (`id_quiz`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Викторины' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_quiz`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_quiz_answer`
--

CREATE TABLE IF NOT EXISTS `pr_quiz_answer` (
  `id_quiz_answer` int(8) NOT NULL auto_increment COMMENT 'id',
  `id_quiz_question` int(8) NOT NULL COMMENT 'Вопрос',
  `answer` varchar(255) NOT NULL COMMENT 'Текст ответа',
  `is_right` tinyint(1) default NULL COMMENT 'Правильный ли ответ',
  `sequence` int(8) NOT NULL default '1' COMMENT 'п/п',
  PRIMARY KEY  (`id_quiz_answer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Варианты ответов' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_quiz_answer`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_quiz_answer_user`
--

CREATE TABLE IF NOT EXISTS `pr_quiz_answer_user` (
  `id_quiz_answer_user` int(8) NOT NULL auto_increment COMMENT 'id',
  `id_quiz` int(8) NOT NULL COMMENT 'Викторина',
  `name` varchar(255) NOT NULL COMMENT 'ФИО',
  `mail` varchar(255) NOT NULL COMMENT 'mail',
  `library_card` varchar(255) default NULL COMMENT 'Читательский билет',
  `contact` varchar(255) default NULL COMMENT 'Контактная информация',
  `answer` text NOT NULL COMMENT 'Ответ',
  `create_date` int(10) unsigned NOT NULL COMMENT 'Дата',
  `ip` varchar(255) NOT NULL COMMENT 'ip',
  PRIMARY KEY  (`id_quiz_answer_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ответ пользователя' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_quiz_answer_user`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_quiz_question`
--

CREATE TABLE IF NOT EXISTS `pr_quiz_question` (
  `id_quiz_question` int(8) NOT NULL auto_increment COMMENT 'id',
  `id_quiz` int(8) NOT NULL COMMENT 'Викторина',
  `question` text NOT NULL COMMENT 'Текст вопроса',
  `type` int(8) NOT NULL default '1' COMMENT 'Тип ответов',
  `sequence` int(8) NOT NULL default '1' COMMENT 'п/п',
  PRIMARY KEY  (`id_quiz_question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Вопросы викторины' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_quiz_question`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_remain_status`
--

CREATE TABLE IF NOT EXISTS `pr_remain_status` (
  `id_remain_status` int(8) NOT NULL auto_increment COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT 'Название',
  `min_value` int(8) NOT NULL COMMENT 'Мин. значение по-умолчанию',
  `max_value` int(8) NOT NULL COMMENT 'Макс. значение по-умолчанию',
  `icon` varchar(255) default NULL COMMENT 'Иконка',
  PRIMARY KEY  (`id_remain_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Статусы остатка продукции' AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `pr_remain_status`
--

INSERT INTO `pr_remain_status` (`id_remain_status`, `name`, `min_value`, `max_value`, `icon`) VALUES
(1, 'под заказ', -999999999, 0, NULL),
(2, 'последняя штука', 0, 1, 'icon-red'),
(3, 'мало', 1, 5, 'icon-yellow'),
(4, 'средне', 5, 10, NULL),
(5, 'много', 10, 999999999, 'icon-green');

-- --------------------------------------------------------

--
-- Структура таблицы `pr_vitrine`
--

CREATE TABLE IF NOT EXISTS `pr_vitrine` (
  `id_vitrine` int(8) NOT NULL auto_increment COMMENT 'id',
  `link` varchar(255) default NULL COMMENT 'Ссылка на переход',
  `title` varchar(255) default NULL COMMENT 'Заголовок',
  `text` longtext COMMENT 'Дополнительный текст',
  `image` int(8) default NULL COMMENT 'Фото',
  `sequence` int(8) default NULL COMMENT 'п/п',
  PRIMARY KEY  (`id_vitrine`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Витрина' AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `pr_vitrine`
--

INSERT INTO `pr_vitrine` (`id_vitrine`, `link`, `title`, `text`, `image`, `sequence`) VALUES
(1, '/catalog/', 'Товары', '<h1>Лучшие товары в регионе!</h1>\r\n<p>Наши услуги настолько качественны, а товары дёшевы, что мы не могли не поделиться этим со всем миром и для этого создаём замечательный сайт.</p>', NULL, 1),
(2, '/news/', 'Услуги', '<h1>Лучшие услуги в регионе!</h1>\r\n<p>Наши услуги настолько качественны, а товары дёшевы, что мы не могли не поделиться этим со всем миром и для этого создаём замечательный сайт.</p>', NULL, 2),
(3, '/feedback/', 'Компания', '<h1>Лучшая компания в регионе!</h1>\r\n<p>Наши услуги настолько качественны, а товары дёшевы, что мы не могли не поделиться этим со всем миром и для этого создаём замечательный сайт.</p>', NULL, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `pr_voting`
--

CREATE TABLE IF NOT EXISTS `pr_voting` (
  `id_voting` int(8) NOT NULL auto_increment COMMENT 'ID',
  `name` varchar(60) NOT NULL COMMENT 'Название голосования',
  `create_date` int(10) NOT NULL default '0' COMMENT 'Дата создания голосования',
  `is_active` int(1) NOT NULL default '1' COMMENT 'Активное',
  `is_checkbox` int(1) NOT NULL default '0' COMMENT 'Множество ответов',
  `in_module` int(1) NOT NULL default '1' COMMENT 'Показать в модуле',
  PRIMARY KEY  (`id_voting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Голосование' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `pr_voting`
--


-- --------------------------------------------------------

--
-- Структура таблицы `pr_voting_answer`
--

CREATE TABLE IF NOT EXISTS `pr_voting_answer` (
  `id_voting_answer` int(8) NOT NULL auto_increment COMMENT 'id',
  `id_voting` int(8) NOT NULL default '0' COMMENT 'Голосование',
  `name` varchar(60) NOT NULL COMMENT 'Вариант ответа',
  `count` int(8) NOT NULL default '0' COMMENT 'Количество голосов',
  PRIMARY KEY  (`id_voting_answer`,`id_voting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ответы на голосование' AUTO_INCREMENT=1 ;

