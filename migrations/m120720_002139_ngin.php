<?php

class m120720_002139_ngin extends CDbMigration {
  public function up() {
    $this->execute("

INSERT INTO da_site_module_template (id_module_template, name, is_default_template) VALUES ('5', 'Каталог товаров', '0');
DELETE FROM da_site_module_rel WHERE id_module_template=5;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (111, 5, 1, 2);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (109, 5, 1, 1);

UPDATE da_menu SET name = 'Интернет-магазин', alias = 'catalog', zagolovok = 'Интернет-магазин', visible = '1', content = NULL, handler = NULL, sequence = '7', go_to_type = '1', note = NULL, id_module_template = '5', idParent = NULL, directory = NULL, title_teg = NULL, meta_keywords = NULL, meta_description = NULL, external_link = '/catalog/', external_link_type = '0', removable = '0' WHERE id=106;

UPDATE da_menu SET sequence = '1' WHERE id=100;
UPDATE da_menu SET sequence = '2' WHERE id=103;
UPDATE da_menu SET sequence = '3' WHERE id=101;
UPDATE da_menu SET sequence = '4' WHERE id=106;
UPDATE da_menu SET sequence = '5' WHERE id=105;
UPDATE da_menu SET sequence = '6' WHERE id=108;
UPDATE da_menu SET sequence = '7' WHERE id=112;
UPDATE da_menu SET sequence = '8' WHERE id=114;
UPDATE da_menu SET sequence = '9' WHERE id=115;
UPDATE da_menu SET sequence = '10' WHERE id=116;
UPDATE da_menu SET sequence = '11' WHERE id=102;

UPDATE da_menu SET name = 'Опрос', alias = 'vote', zagolovok = 'Опрос', visible = '0', content = NULL, handler = NULL, sequence = '10', go_to_type = '1', note = NULL, id_module_template = NULL, idParent = NULL, directory = NULL, title_teg = NULL, meta_keywords = NULL, meta_description = NULL, external_link = '/vote/', external_link_type = '0', removable = '1' WHERE id=116;

UPDATE da_menu SET sequence = '1' WHERE id=100;
UPDATE da_menu SET sequence = '2' WHERE id=103;
UPDATE da_menu SET sequence = '3' WHERE id=101;
UPDATE da_menu SET sequence = '4' WHERE id=106;
UPDATE da_menu SET sequence = '5' WHERE id=105;
UPDATE da_menu SET sequence = '6' WHERE id=108;
UPDATE da_menu SET sequence = '7' WHERE id=114;
UPDATE da_menu SET sequence = '8' WHERE id=115;
UPDATE da_menu SET sequence = '9' WHERE id=116;
UPDATE da_menu SET sequence = '10' WHERE id=102;
UPDATE da_menu SET sequence = '11' WHERE id=112;

UPDATE da_menu SET name = 'Оформление заказа', alias = 'oformlenie_zakaza', zagolovok = 'Оформление заказа', visible = '0', content = '<p>Благодарим за ваш заказ, в ближайшее время наш менеджер свяжется с вами по указанному контактному телефону.</p>\r\n<p>О судьбе вашего заказа также можете узнать по нашему контактному телефону <strong>(8212) 000-000</strong>.</p>', handler = NULL, sequence = '8', go_to_type = '1', note = NULL, id_module_template = '1', idParent = '106', directory = NULL, title_teg = NULL, meta_keywords = NULL, meta_description = NULL, external_link = '', external_link_type = '0', removable = '0' WHERE id=107;

UPDATE da_menu SET name = 'Доставка товара', alias = 'dostavka', zagolovok = 'Доставка товара', visible = '0', content = '<p>Доставка товара осуществляется по городу по ценам такси.</p>', handler = NULL, sequence = '9', go_to_type = '1', note = NULL, id_module_template = '1', idParent = '106', directory = NULL, title_teg = NULL, meta_keywords = NULL, meta_description = NULL, external_link = '', external_link_type = '0', removable = '1' WHERE id=110;

UPDATE da_menu SET name = 'Категория новостей', alias = 'category', zagolovok = 'Категория новостей', visible = '0', content = NULL, handler = NULL, sequence = '5', go_to_type = '1', note = NULL, id_module_template = '1', idParent = '103', directory = NULL, title_teg = NULL, meta_keywords = NULL, meta_description = NULL, external_link = '', external_link_type = '0', removable = '0' WHERE id=104;

UPDATE da_site_module_template SET name = 'Главная', is_default_template = '0' WHERE id_module_template=4;
DELETE FROM da_site_module_rel WHERE id_module_template=4;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (112, 4, 4, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (114, 4, 1, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (100, 4, 1, 2);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (113, 4, 4, 2);

UPDATE da_site_module_template SET name = 'Главная', is_default_template = '0' WHERE id_module_template=4;
DELETE FROM da_site_module_rel WHERE id_module_template=4;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (112, 4, 4, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (114, 4, 1, 2);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (100, 4, 1, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (113, 4, 4, 2);

INSERT INTO da_site_module_template (id_module_template, name, is_default_template) VALUES ('6', 'Новости', '0');
DELETE FROM da_site_module_rel WHERE id_module_template=6;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (114, 6, 1, 1);

UPDATE da_menu SET name = 'Новости', alias = 'news', zagolovok = 'Новости', visible = '1', content = NULL, handler = NULL, sequence = '2', go_to_type = '1', note = NULL, id_module_template = '6', idParent = NULL, directory = NULL, title_teg = NULL, meta_keywords = NULL, meta_description = NULL, external_link = '/news/', external_link_type = '0', removable = '0' WHERE id=103;

UPDATE da_site_module_template SET name = 'Контакты', is_default_template = '0' WHERE id_module_template=2;
DELETE FROM da_site_module_rel WHERE id_module_template=2;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (107, 2, 2, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (100, 2, 1, 1);

UPDATE da_site_module_template SET name = 'Без модулей', is_default_template = '0' WHERE id_module_template=3;
DELETE FROM da_site_module_rel WHERE id_module_template=3;

UPDATE da_menu SET name = 'Фотогалерея', alias = 'photogallery', zagolovok = 'Фотогалерея', visible = '1', content = NULL, handler = NULL, sequence = '3', go_to_type = '1', note = NULL, id_module_template = '3', idParent = NULL, directory = NULL, title_teg = NULL, meta_keywords = NULL, meta_description = NULL, external_link = '/photogallery/', external_link_type = '0', removable = '0' WHERE id=101;

UPDATE da_menu SET name = 'Вопрос-ответ', alias = 'faq', zagolovok = 'Вопрос-ответ', visible = '1', content = NULL, handler = NULL, sequence = '6', go_to_type = '1', note = NULL, id_module_template = '3', idParent = NULL, directory = NULL, title_teg = NULL, meta_keywords = NULL, meta_description = NULL, external_link = '/faq/', external_link_type = '0', removable = '0' WHERE id=108;

UPDATE da_site_module_template SET name = 'Контакты', is_default_template = '0' WHERE id_module_template=2;
DELETE FROM da_site_module_rel WHERE id_module_template=2;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (107, 2, 1, 1);

INSERT INTO da_site_module (id_module, name, is_visible, content, html, directory) VALUES ('116', 'Яндекс-карта', '1', '<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (начало) -->\r\n<div id=\"ymaps-map-id_134272697456162575675\" style=\"width: 450px; height: 350px;\"></div>\r\n<div style=\"width: 450px; text-align: right;\"><a href=\"http://api.yandex.ru/maps/tools/constructor/?lang=ru-RU\" target=\"_blank\" style=\"color: #1A3DC1; font: 13px Arial,Helvetica,sans-serif;\">Создано с помощью инструментов Яндекс.Карт</a></div>\r\n<script type=\"text/javascript\">\r\nfunction fid_134272697456162575675(ymaps) {\r\n    var map = new ymaps.Map(\"ymaps-map-id_134272697456162575675\", {\r\n        center: [50.82623849999997, 61.669501223301836],\r\n        zoom: 16,\r\n        type: \"yandex#map\"\r\n    });\r\n    map.controls\r\n        .add(\"zoomControl\")\r\n        .add(\"mapTools\")\r\n        .add(new ymaps.control.TypeSelector([\"yandex#map\", \"yandex#satellite\", \"yandex#hybrid\", \"yandex#publicMap\"]));\r\n    map.geoObjects\r\n        .add(new ymaps.Placemark([50.826239, 61.6689], {\r\n            balloonContent: \"веб-студия «Цифровой век»\"\r\n        }, {\r\n            preset: \"twirl#lightblueDotIcon\"\r\n        }));\r\n};\r\n</script>\r\n<script type=\"text/javascript\" src=\"http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=fid_134272697456162575675\"></script>\r\n<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (конец) -->', NULL, NULL);

UPDATE da_site_module_template SET name = 'Контакты', is_default_template = '0' WHERE id_module_template=2;
DELETE FROM da_site_module_rel WHERE id_module_template=2;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (107, 2, 1, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (116, 2, 3, 1);

UPDATE da_site_module SET name = 'Яндекс-карта', is_visible = '1', link = NULL, content = '<div id=\"ymaps-map-id_134272697456162575675\" style=\"width: 770px; height: 350px;\"></div>\r\n<script type=\"text/javascript\">\r\nfunction fid_134272697456162575675(ymaps) {\r\n    var map = new ymaps.Map(\"ymaps-map-id_134272697456162575675\", {\r\n        center: [50.82623849999997, 61.669501223301836],\r\n        zoom: 16,\r\n        type: \"yandex#map\"\r\n    });\r\n    map.controls\r\n        .add(\"zoomControl\")\r\n        .add(\"mapTools\")\r\n        .add(new ymaps.control.TypeSelector([\"yandex#map\", \"yandex#satellite\", \"yandex#hybrid\", \"yandex#publicMap\"]));\r\n    map.geoObjects\r\n        .add(new ymaps.Placemark([50.826239, 61.6689], {\r\n            balloonContent: \"веб-студия «Цифровой век»\"\r\n        }, {\r\n            preset: \"twirl#lightblueDotIcon\"\r\n        }));\r\n};\r\n</script>\r\n<script type=\"text/javascript\" src=\"http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=fid_134272697456162575675\"></script>', html = NULL, directory = NULL WHERE id_module=116;

UPDATE da_object_view_column SET order_no = '1' WHERE id_object_view_column=6037;
UPDATE da_object_view_column SET order_no = '2' WHERE id_object_view_column=6059;
UPDATE da_object_view_column SET order_no = '3' WHERE id_object_view_column=6038;
UPDATE da_object_view_column SET order_no = '4' WHERE id_object_view_column=6033;
UPDATE da_object_view_column SET order_no = '5' WHERE id_object_view_column=6036;

UPDATE da_object_view_column SET order_no = '1' WHERE id_object_view_column=6037;
UPDATE da_object_view_column SET order_no = '2' WHERE id_object_view_column=6038;
UPDATE da_object_view_column SET order_no = '3' WHERE id_object_view_column=6033;
UPDATE da_object_view_column SET order_no = '4' WHERE id_object_view_column=6036;
UPDATE da_object_view_column SET order_no = '5' WHERE id_object_view_column=6059;

INSERT INTO da_object_view_column (id_object_view_column, id_object_view, id_object, caption, order_no, id_object_parameter, id_data_type, field_name, handler) VALUES ('6080', '2008', '509', 'Фото', '0', '1555', '8', 'image', NULL);
UPDATE da_object_view_column SET order_no = @maxSeq + 1 WHERE id_object_view_column=6080;

UPDATE da_object_view_column SET order_no = '1' WHERE id_object_view_column=6080;
UPDATE da_object_view_column SET order_no = '2' WHERE id_object_view_column=6029;
UPDATE da_object_view_column SET order_no = '3' WHERE id_object_view_column=6030;
INSERT INTO da_reference_element (id_reference_element_instance, id_reference, id_reference_element, value, image_element) VALUES ('503', '32', '6', 'Подвал', NULL);

INSERT INTO da_site_module (id_module, name, is_visible, content, html, directory) VALUES ('117', 'Контакты организации', '1', '<address class=\"vcard\">\r\n  <div>\r\n    <span class=\"fn org work\">ООО «Компания»</span>,\r\n    <span class=\"tel\">+7 (8212) 31-14-89</span>\r\n  </div>\r\n  <div>\r\n    <span class=\"adr work\">\r\n      <span class=\"postal-code\">167000</span>,\r\n      <span class=\"locality\">Сыктывкар</span>,\r\n      <span class=\"street-address\">ул. Первомайская, дом 62, офис 505А</span>\r\n    </span>\r\n  </div>\r\n  <div>\r\n    e-mail: <a class=\"email\" href=\"mailto:email@email.ru\">email@email.ru</a>\r\n  </div>\r\n</address>', NULL, NULL);

INSERT INTO da_site_module (id_module, name, is_visible, content, html, directory) VALUES ('118', 'Счётчики', '1', '<!-- Сюда вставлять код Яндекс.Метрики -->', NULL, NULL);

UPDATE da_site_module_template SET name = 'Основной', is_default_template = '1' WHERE id_module_template=1;
DELETE FROM da_site_module_rel WHERE id_module_template=1;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (114, 1, 1, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (111, 1, 1, 3);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (117, 1, 6, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (109, 1, 1, 2);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (100, 1, 1, 4);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (118, 1, 6, 2);

UPDATE da_site_module_template SET name = 'Контакты', is_default_template = '0' WHERE id_module_template=2;
DELETE FROM da_site_module_rel WHERE id_module_template=2;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (107, 2, 1, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (117, 2, 6, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (118, 2, 6, 2);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (116, 2, 3, 1);

UPDATE da_site_module_template SET name = 'Без модулей', is_default_template = '0' WHERE id_module_template=3;
DELETE FROM da_site_module_rel WHERE id_module_template=3;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (117, 3, 6, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (118, 3, 6, 2);

UPDATE da_site_module_template SET name = 'Главная', is_default_template = '0' WHERE id_module_template=4;
DELETE FROM da_site_module_rel WHERE id_module_template=4;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (112, 4, 4, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (114, 4, 1, 2);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (117, 4, 6, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (100, 4, 1, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (113, 4, 4, 2);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (118, 4, 6, 2);

UPDATE da_site_module_template SET name = 'Каталог товаров', is_default_template = '0' WHERE id_module_template=5;
DELETE FROM da_site_module_rel WHERE id_module_template=5;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (111, 5, 1, 2);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (117, 5, 6, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (109, 5, 1, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (118, 5, 6, 2);

UPDATE da_site_module_template SET name = 'Новости', is_default_template = '0' WHERE id_module_template=6;
DELETE FROM da_site_module_rel WHERE id_module_template=6;
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (114, 6, 1, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (117, 6, 6, 1);
INSERT INTO da_site_module_rel(id_module, id_module_template, place, sequence) VALUES (118, 6, 6, 2);

");
  }
  
  public function down() {
    echo get_class($this)." does not support migration down.\n";
    return false;
  }

  /*
  public function safeUp() {
  }
  public function safeDown() {
  }
  */
}
