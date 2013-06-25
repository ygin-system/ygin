
Процедура обновления:
1. Выкачиваем последнюю версию редактора. jQuery-version.
http://tinymce.moxiecode.com/download/download.php
+ русскую локализацию: http://tinymce.moxiecode.com/i18n/index.php?ctrl=lang&act=download&pr_id=1

2. Бэкапим assets/tiny_mce/ и удаляем всё из assets/tiny_mce/
Копируем содержимое архивов в директорию редактора

3. Удаляем из папки plugins неиспользуемые плагины. Необходимые плагины можно посмотреть в предыдущей версии.
+Копируем плагины из src

4. Удаляем из директории редактора исходники по маске "*_src.js"

5. Настраиваем плагин media - чтобы поддерживал работу с rutube.
plugins/media/js/media.js

Нужно в функцию setOptions добавить следующий блок:

        // RuTube
        if (src.match(/tracks\/\d+\.[a-z]+\?v=(.+)/)) {
          data.width = 425;
          data.height = 350;
          data.params.frameborder = '0';
          data.type = 'flash';
          src = 'http://video.rutube.ru/' + src.match(/v=(.*)/)[1];
          setVal('src', src);
          setVal('media_type', data.type);
        }


Примечания:
Блоки комментируются следующим образом:
add - блок добавлен
modify - блок изменен

6. Делаем кастомайз плагинов advimage и advlink (по аналогии с плагинами из бэкапа)



