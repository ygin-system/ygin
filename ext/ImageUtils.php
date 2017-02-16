<?php
/**
 * ImageUtils Class 17.01.2007 - 25.03.07
 * v 1.4 от 16 августа 2007 г.
 *
 * Класс позволяет открывать изображения, изменять их размеры, сохранять в файл
 * и выводить в браузер, создавать новые картинки, добавлять к ним текст,
 * рамку, фон, другие картинки
 * Фон можно создать несколько видов
 *
 * ПРИМЕР использование см. в конце файла
 */
/* Список функций класса

open(file)
show()
save(newfile)
resize(w,h)
scale(wscale,hscale)
fitto(maxside)

create(w,h,type)

add_border($thick = 1, $color = '000000')
add_fixed_text()
add_ttf_text($text,$fontfile,$x,$y,$fontsize,$color,$angel)
add_text_align($text, $fontfile, $align, $valign, $margin = 3, $fontsize = '24', $color = '000000', $angel = 0, $option = 1)

add_image ($file, $x, $y)
image_align ($file1, $file2, $pos1, $pos2, $margin = 0, $offset = 0)
dynamic_bg()

error($info = '')
info($file, $info = false)
to_ord($string)
reg2hex($color)
create_color($hex)

setFontFile($a)
setTextColors($colors)
setFontSizeRange($array)
setAngelRange($array)
setYOffsetRange($array)
set_bg_color($hex)
set_line_color($hex)
set_text_color($hex)
set_thickness($thick = 1)
*/

class ImageUtils
{
    var $im;
    var $type, $info, $width, $height;
    var $bg_color, $text_color, $line_color;

    var $fontFile, $textColors;
    var $textFSize1, $textFSize2;
    var $textAngel1, $textAngel2;
    var $textYOffset1, $textYOffset2;

    // зададим начальные параметры
    function ImageUtils($colors = array('000000'), $fSize = array(18), $angel = array(0), $yoffset = array(0))
    {
        $this->setFontSizeRange($fSize);
        $this->setAngelRange($angel);
        $this->setTextColors($colors);
        $this->setYOffsetRange($yoffset);
    }

    /************************************************************************/
    // загружает изображение из файла
    function open($file)
    {
        $a = $this->info($file);
        if (!$a || !is_array($a) || !array_key_exists('type', $a)) return false;

        $this->type = $a['type'];
        if ($this->type == 'jpg') {
            $this->im = imagecreatefromjpeg($file);
        } else if ($this->type == 'gif') {
            $this->im = imagecreatefromgif($file);
        } else if ($this->type == 'png') {
            $this->im = imagecreatefrompng($file);
        }
        if ($this->im == false) {
            return false;
        }
        $this->width = imagesx($this->im);
        $this->height = imagesy($this->im);
        return true;
    }

    // выводит изображение в браузер или сохраняет
    function show($new_file = '', $quality = 100)
    {
        if ($new_file == '') {
            header("Content-type: image/" . $this->type);
            $new_file = '';
        }
        if ($this->type == 'jpg') {
            @imagejpeg($this->im, $new_file, $quality);
        } else if ($this->type == 'png') {
            $new_file == '' ? imagepng($this->im) : imagepng($this->im, $new_file);
        } else if ($this->type == 'gif') {
            $new_file == '' ? imagegif($this->im) : imagegif($this->im, $new_file);
        }
        imagedestroy($this->im);
    }

    // сохраняет изображение в файл (если имя пусто - имя по умолчанию, если расширения нет - вводится тип)
    function save($new_file = '', $quality = 100)
    {
        $default_name = trim(strchr(microtime(), ' ')) . '.' . $this->type;
        $new_file == '' ? $new_file = $default_name : false;
        !strchr($new_file, '.') ? $new_file = $new_file . "." . $this->type : false;
        $this->show($new_file, $quality);
    }

    /************************************************************************/
    // альфа каналы
    function addAlphaChannel($width, $height, $im = null)
    {
        if ($im == null) $im = $this->im;
        if ($this->type == "gif" || $this->type == "png") {
            imagealphablending($im, false);
            imagesavealpha($im, true);
            $transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
            imagefilledrectangle($im, 0, 0, $width, $height, $transparent);
        }
    }

    // изменяет размер изображения
    function resize($width, $height)
    {
        $old = $this->im;
        $this->im = imagecreatetruecolor($width, $height);
        $this->addAlphaChannel($width, $height);
        imagecopyresampled($this->im, $old, 0, 0, 0, 0, $width, $height, imagesx($old), imagesy($old));
    }

    // масштабирует изображение по ширине/высоте
    function scale($scale_width, $scale_height)
    {
        $old = $this->im;
        $width = round(imagesx($old) * $scale_width);
        $height = round(imagesy($old) * $scale_height);
        $this->im = imagecreatetruecolor($width, $height);
        $this->addAlphaChannel($width, $height);
        imagecopyresampled($this->im, $old, 0, 0, 0, 0, $width, $height, imagesx($old), imagesy($old));
    }

    // изменяет размер изображения по максимальной стороне
    function fitto($max_side)
    {
        $w = $this->width;
        $h = $this->height;
        if ($w > $h) {
            $h = round(round($max_side / $w, 3) * $h);
            $w = $max_side;
        } else {
            $w = round(round($max_side / $h, 3) * $w);
            $h = $max_side;
        }
        $this->resize($w, $h);
    }
    // обрезка картинки точно в прямоуголник $w*$h без искажения размеров
    // $cropType = center|left|right Тип обрезки
    function crop($w, $h, $crop = false, $cropType = null)
    {
        $srcW = $this->width;
        $srcH = $this->height;
        $ks = $srcW / $srcH; // растянутость по ширине
        $kd = $w / $h;
        $ofX = $ofXr = 0;
        $ofY = $ofYr = 0;
        if ($kd > $ks) {
            $a = $srcW / $kd;
            $ofY = round(($srcH - $a) / 2);
            $ofYr = round($srcH - $a);
            $srcH = $a;
            if ($cropType == 'top') {
                $cropType = 'left';
            }
        } else {
            $a = $srcH * $kd;
            $ofX = round(($srcW - $a) / 2);
            $ofXr = round($srcW - $a);
            $srcW = $a;
        }
        if ($cropType == 'height') {
            $k = $w / $this->width;
            $hd = round($this->height * $k);
            if ($hd < $h) {
                $this->resize($w, $hd);
                return;
            }
            $cropType = 'left';
        }
        $imd = imagecreatetruecolor($w, $h);
        $this->addAlphaChannel($w, $h, $imd);
        if ($cropType == 'right') {
            imagecopyresampled($imd, $this->im, 0, 0, $ofXr, $ofYr, $w, $h, $srcW, $srcH);
        } else if ($cropType == 'left') {
            imagecopyresampled($imd, $this->im, 0, 0, 0, 0, $w, $h, $srcW, $srcH);
        } else {
            imagecopyresampled($imd, $this->im, 0, 0, $ofX, $ofY, $w, $h, $srcW, $srcH);
        }
        $this->im = $imd;
    }

    /************************************************************************/
    // создаёт пустую картинку
    function create($width, $height, $bg = 'FFFFFF', $type = 'png')
    {
        $this->im = imagecreate($width, $height);
        $this->width = $width;
        $this->height = $height;
        $this->type = $type;
        $this->create_color($bg);
    }

    // рисует рамку
    function add_border($thick = 1, $color = '000000')
    {
        $w = $this->width;
        $h = $this->height;
        $border_color = $this->create_color($color);
        imagefilledrectangle($this->im, 0, 0, $w, $thick - 1, $border_color);  // up
        imagefilledrectangle($this->im, 0, $h - $thick, $w, $h + $thick, $border_color);  // down
        imagefilledrectangle($this->im, 0, 0, $thick - 1, $h, $border_color);  // left
        imagefilledrectangle($this->im, $w - $thick, 0, $w, $h, $border_color);  // right
    }

    // добавляет многострочный текст фиксированным шрифтом
    function add_fixed_text($text, $color = '000000', $font = 1, $x = 10, $y = 10)
    {
        $this->set_text_color($color);
        $text = str_replace("\r", "\n", $text);
        $a = explode("\n", $text);
        foreach ($a as $k => $v) {
            if (trim($v) == '') {
                continue;
            }
            imagestring($this->im, $font, $x, $y, $v, $this->text_color);
            $y += $font + 10;
        }
    }

    // добавялет картинку
    function add_image($file, $x, $y)
    {
        $bgFile = new ImageUtils();
        if ($bgFile->open($file)){
            $im1 = $bgFile->im;
            $size_x = imagesx($im1);
            $size_y = imagesy($im1);
            imagecopy($this->im, $im1, $x, $y, 0, 0, $size_x, $size_y);
            return true;
        } else {
            return false;
        }
    }


    /**
     * Определим параметры текста
     */
    function setFontFile($a)
    {
        $this->fontFile = $a;
    }

    // массив цветов текста
    function setTextColors($colors)
    {
        if (is_array($colors)) {
            $this->textColors = $colors;
        } else {
            $this->textColors = array($colors);
        }
    }

    function set_text_color($hex)
    {
        $this->text_color = $this->create_color($hex);
        $this->textColors = array($hex);
        return $this->text_color;
    }

    function setTextColor($hex)
    {
        $this->text_color = $this->create_color($hex);
        $this->textColors = array($hex);
        return $this->text_color;
    }

    // массив из двух размеров шрифта
    function setFontSizeRange($array)
    {
        if (is_array($array)) {
            $this->textFSize1 = $array[0];
            if (isset($array[1])) {
                $this->textFSize2 = $array[1];
            }
        } else {
            // експлодить через ,?
            $this->textFSize1 = $array;
        }
    }

    // диапазон углов
    function setAngelRange($array)
    {
        if (is_array($array)) {
            $this->textAngel1 = $array[0];
            if (isset($array[1])) {
                $this->textAngel2 = $array[1];
            }
        } else {
            $this->textAngel1 = $array;
        }
    }

    // диапазон смещения
    function setYOffsetRange($array)
    {
        if (is_array($array)) {
            $this->textYOffset1 = $array[0];
            if (isset($array[1])) {
                $this->textYOffset2 = $array[1];
            }
        } else {
            $this->textYOffset1 = $array;
        }
    }

    function set_bg_color($hex)
    {
        //echo 1;
        $this->bg_color = imagefilledrectangle(
            $this->im, 0, 0, imagesx($this->im), imagesy($this->im), $this->create_color($hex));
    }

    function set_line_color($hex)
    {
        $this->line_color = $this->create_color($hex);
    }

    function set_thickness($thick = 1)
    {
        imagesetthickness($this->im, $thick);
    }

    function checkSettings()
    {
        if (empty($this->fontFile)) {
            $this->error("fontFile not set. \r\nuse setFontFile() function");
        }
    }
    /**
     * ФУНКЦИИ ДЛЯ РАБОТЫ С TTF ТЕКСТОМ
     * параметры файла шрифта и цвета текста задаются специальными функциями!
     * если они не заданы, берутся значения по умолчнию
     *
     * Внимание! Если в тексте русские буквы, с ними нельзя применять случайный размер, цвет и т.д.!!!
     */

    /**
     * Добавляет текст шрифтом TTF в точку ($x, $y)
     */
    function add_ttf_text($text, $x = 10, $y = 10)
    {
        $text = $this->to_ord($text);

        // цвет один по умолчанию, первый
        $color = $this->textColors[0];

        foreach ($this->textColors as $k => $v) {
            if (strlen($v) == 6) {
                $this->textColors[$k] = $this->create_color($v);
            }
        }

        // если задан хотя бы один диапазон, то текст выводим в цикле
        if (!empty($this->textFSize2) || !empty($this->textAngel2) || !empty($this->textYOffset2) || count($this->textColors) > 1) {
            for ($i = 0; $i < strlen($text); $i++) {
                $y2 = $y;

                // случайный размер
                $fontsize = $this->textFSize1;
                if (!empty($this->textFSize2)) {
                    $fontsize = rand($this->textFSize1, $this->textFSize2);
                }

                // случайный угол
                $angel = $this->textAngel1;
                if (!empty($this->textAngel2)) {
                    $angel = rand($this->textAngel1 + 360, $this->textAngel2 + 360);
                }

                // смещение по Y
                if (!empty($this->textYOffset1)) {

                    if (!empty($this->textYOffset2)) {
                        $y2 = $y2 + rand($this->textYOffset1, $this->textYOffset2);
                    } else {
                        $y2 = $y2 + rand(0, $this->textYOffset1);
                    }
                }

                // случайный цвет
                $color = $this->textColors[array_rand($this->textColors)];

                // мы должны точно определить ширину буквы!!!!
                $sz = imagettfbbox($fontsize, $angel, $this->fontFile, $text[$i]);
                $symbWidth = $sz[2] - $sz[0];
                if ($i > 0) {
                    $x = $x + $symbWidth + $symbWidth * 0.2;
                }
                //$xoffset = $x + $fontsize * $i / 1.2; // старый вариант
                //
                imagettftext($this->im, $fontsize, $angel, $x, $y2,
                    $color, $this->fontFile, $text[$i]);
            }
        } else {
            /*echo "
            im:$this->im,
            fsize:$this->textFSize1,
            angel:$this->textAngel1,
            x:$x,
            y:$y,
            color:$this->textColors[0],
            file:$this->fontFile,
            text:$text<br>";*/
            imagettftext($this->im, $this->textFSize1, $this->textAngel1, $x, $y, $this->textColors[0], $this->fontFile, $text);
        }
        return true;
    }

    /**
     * Добавляет ttf текст и выравнивает
     * $align  = L M R - выравнивание по горизонтали
     * $valign = T M D - вырванивание по вертикали
     * $margin = [NUMBER] - поле при выравнивании НЕ по центру
     * Остальный параметры идентичны add_ttf_text()
     */
    function add_text_align($text, $align, $valign, $margin = 3)
    {

        $text = "$text";
        $this->checkSettings();
        $w = $this->width;
        $h = $this->height;
        $sz = imagettfbbox($this->textFSize1, 0, $this->fontFile, $text);
        $fontwidth = ($sz[2] - $sz[0]) * 1.1;
        $fontheight = abs($sz[3] - abs($sz[5])) * 1.3;

        //pre($sz);
        //echo "$fontwidth * $fontheight";
        //exit();
        switch ($align) {
            case 'L' :
                $xoffset = $margin;
                break;
            case 'R' :
                $xoffset = $w - $fontwidth - $margin;
                break;
            case 'M' :
                $xoffset = $w / 2 - $fontwidth;
                break;
            default  :
                $xoffset = $margin;
        }
        switch ($valign) {
            case 'T' :
                $yoffset = $margin + $fontheight;
                break;
            case 'D' :
                $yoffset = $h - $margin;
                break;
            case 'M' :
                $yoffset = $h / 2 + $fontheight;
                break;
            default  :
                $yoffset = $margin + $fontheight;
        }

        $this->add_ttf_text($text, $xoffset, $yoffset);
    }

    /**
     * Создаёт фон для картинки в соответвии с типом $type
     * Типы: 1, 2, 3, 4, 5 или путь к картинке фона
     * $color - цвет, который используется для рисования линий типов 2-5
     * $plotnost и $interval используются только для создания фона случайны пикселей тип 1
     */
    function dynamic_bg($type, $color = '000000', $plotnost = 0.5, $interval = 10)
    {
        if ($type == null || $type == 0) return;
        $color1 = $this->create_color($color);
        $color2 = $this->create_color('AAAAAA');
        $w = $this->width;
        $h = $this->height;

        switch ($type) {
            // из файла
            case file_exists($type) :
                $file = $type;
                $bgFile = new ImageUtils();
                if ( $bgFile->open($type)){
                    $im1 = $bgFile->im;
                    $size_x = imagesx($im1);
                    $size_y = imagesy($im1);
                    $rows = floor($h / $size_y);
                    $steps = floor($w / $size_x);
                    for ($i = 0; $i < $h; $i += $size_y) {
                        for ($j = 0; $j < $w; $j += $size_x) {
                            imagecopy($this->im, $im1, $j, $i, 0, 0, $size_x, $size_y);
                        }
                    }
                }
                break;
            // случайные пиксели
            case 1 :
                $plotnost > 1 || $plotnost <= 0 ? $plotnost = 0.5 : false;
                $randsteps = range(0, $w);
                for ($i = 0; $i < $h; $i++) {
                    $randsteps_mix = array_rand_values($randsteps, round(sizeof($randsteps) * $plotnost));
                    foreach ($randsteps_mix as $v) {
                        imagesetpixel($this->im, $v, $i, $color1);
                    }
                }
                break;
            // клетки
            case 2 :
                for ($i = 0; $i < $h; $i += $interval) {
                    imageline($this->im, 0, $i, $w, $i, $color1);
                }
                for ($i = 0; $i < $w; $i += $interval) {
                    imageline($this->im, $i, 0, $i, $h, $color1);
                }
                break;
            // сетка
            case 3 :
                $k = $w / $h;
                for ($i = 0; $i < $h; $i += $interval) {
                    imageline($this->im, 0, $i, $w, $i, $color1);
                    imageline($this->im, $i * $k, 0, $i * $k, $h, $color2);
                    //imageline($this->im, 0, $i, $w, $w - $i, $color1);
                }
                break;
            // ещё что-то
            case 4 :
                for ($i = 0; $i < $h; $i += $interval) {
                    imageline($this->im, 0, $i, $w, $h - $i, $color1);
                }
                for ($i = 0; $i <= $h; $i += $interval) {
                    imageline($this->im, $i, 0, $w - $i, $h, $color1);
                }
                break;
            // диагонали
            case 5 :
                for ($i = 0; $i < $h; $i += $interval) {
                    imageline($this->im, 0, $i, $w, $h + $i, $color1);
                }
                for ($i = 0; $i < $h; $i += $interval) {
                    imageline($this->im, $i, 0, $w + $i, $h, $color1);
                }
                break;

            // огород арбузов
            case 6 :
                $radius = 10;
                for ($i = $radius; $i < $h; $i += $interval) {
                    for ($j = $radius; $j < $w; $j += $interval) {
                        imageellipse($this->im, $j, $i, $radius, $radius, $color1);
                    }
                }
                break;

            // рандом кружки
            case 20 :
            case 21 :
            case 22 :
            case 23 :
            case 24 :
            case 25 :
            case 26 :
            case 27 :
            case 28 :
            case 29 :
                for ($i = 0; $i < $h; $i += $interval) {
                    switch ($type) {
                        case 20:
                            imageellipse($this->im, rand(0, $w), rand(0, $h), rand(0, $w), rand(0, $h), $color1);
                            break;
                        case 21:
                            imageellipse($this->im, $w / 2 - ($i - round($i / 100) * 100), $i, 10, 10, $color1);
                            break;
                        case 28:
                            imageellipse($this->im, rand($w / 2 - 10, $w / 2 + 10), $i, 10, 10, $color1);
                            break;
                        case 29:
                            imageellipse($this->im, rand(0, $w), rand(0, $h), rand(0, $i), rand(0, $i), $color1);
                            break;
                    }
                }
                break;

            // рандом полоски
            case 7 :
                for ($i = 0; $i < $h; $i += $interval) {
                    imageline($this->im, rand(0, $w), rand(0, $h), rand(0, $w), rand(0, $h), $color1);
                    //imageline($this->im,   0, $i,      rand(0, $i), rand(0, $i),    $color1);
                }
                break;

            // квадратики из центра
            case 8 :
                $k = $w / $h;
                for ($i = 0; $i < $h; $i += $interval) {
                    $sizeW = 10 * $k + $i;
                    $sizeH = 10 + $i;
                    $x1 = $w / 2 - $sizeW / 2;
                    $y1 = $h / 2 - $sizeH / 2;
                    $x2 = $w / 2 + $sizeW / 2;
                    $y2 = $h / 2 + $sizeH / 2;
                    imagerectangle($this->im, $x1, $y1, $x2, $y2, $color1);
                }
                break;
            // паутина
            case 9 :
                for ($i = -$h; $i < $h; $i += $interval) {
                    imageline($this->im, 0, $i, $w - $i, $h + $i, $color1);
                }
                for ($i = -$h; $i < $h; $i += $interval) {
                    imageline($this->im, 0, $i, $h - $i, $w + $i, $color1);
                }
                break;
        }
    }

    /**
     * расчёт парметров выравнивания двух картинок по ВЫСОТЕ
     * $margin - поле сверху и снизу конечной картинки
     * $offset - смещение картинки 1
     * возвращает массив параметров, какие надо установить у картинок
     */
    function image_align($file1, $file2, $pos1, $pos2, $margin = 0, $offset = 0)
    {
        $array = array();
        $info1 = self::info($file1);
        $info2 = self::info($file2);
        if (!$info1 || !$info2) {
            return null;
        }
        $h1 = $info1['height'];
        $h2 = $info2['height'];
        //echo "$h1<br>$h2<br>";
        $h_max = ($h1 >= $h2 ? $h1 : $h2);
        $h_min = ($h1 >= $h2 ? $h2 : $h1);
        $h_delta = $h_max - $h_min;
        if ($pos1 == 'top' && $pos2 == 'top') {
            $array['y1'] = $margin + $offset;
            $array['y2'] = $margin;
            $array['h'] = $h_max + $margin * 2 + $offset;
        }
        if ($pos1 == 'top' && $pos2 == 'down') {
            $array['y1'] = $margin + $offset + $h2;
            $array['y2'] = $margin;
            $array['h'] = $h_max + $margin * 2 + $offset + $h2;
        }
        if ($pos1 == 'down' && $pos2 == 'down') {
            $array['y1'] = $margin + $offset + $h2 - $h_min;
            $array['y2'] = $margin + $h1 - $h_min;
            $array['h'] = $h_max + $margin * 2 + $offset;
        }
        if ($pos1 == 'down' && $pos2 == 'top') {
            $array['y1'] = $margin;
            $array['y2'] = $margin + $offset + $h1;
            $array['h'] = $h_max + $margin * 2 + $offset + $h1;
        }
        return $array;
    }

    /************************************************************************/
    // показывает ошибку
    function error($info = '')
    {
        $info == '' ? $info = 'Unknown error' : false;
        $this->create(500, 200);
        $this->add_fixed_text($info, '000000', 12);
        $this->show();
    }

    // инфо
    // Возвращает null в случае ошибки
    function info($file, $info = false)
    {
        if (filesize($file) > 0) {
            $a = array();
            $b = getimagesize($file, $info);
            $a['width'] = $b[0];
            $a['height'] = $b[1];
            $b[2] == '1' ? $a['type'] = 'gif' : false;
            $b[2] == '2' ? $a['type'] = 'jpg' : false;
            $b[2] == '3' ? $a['type'] = 'png' : false;
            $b[2] == '4' ? $a['type'] = 'swf' : false;
            $a['attr'] = $b[3];
            return $a;
        } else {
            return null;
        }
    }

    // преобразует русский текст в ASCII символы
    function to_ord($string)
    {
        $s = '';
        $cir = 'йцукенгшщзхъэждлорпавыфячсмитьбю';
        for ($i = 0; $i < strlen($string); $i++) {
            $n = $string[$i];
            if (stristr($cir, $n)) {
                $n = 848 + ord($n);
                $s .= "&#$n;";
            } else {
                //$n = ord($n);
                $s .= $n;
            }

        }
        return $s;
    }

    // из rgb (num, num, num) в 000000
    function reg2hex($color)
    {
        if (!empty($color) && strchr($color, 'rgb(')) {
            $a = str_replace('rgb(', '', $color);
            $a = str_replace(')', '', $a);
            $b = explode(', ', $a);
            $m1 = str_pad(dechex($b[0]), 2, '0', STR_PAD_LEFT);
            $m2 = str_pad(dechex($b[1]), 2, '0', STR_PAD_LEFT);
            $m3 = str_pad(dechex($b[2]), 2, '0', STR_PAD_LEFT);
            $color = strtoupper($m1 . $m2 . $m3);
        }
        return $color;
    }

    // создаёт цвет из hex
    function create_color($hex)
    {
        $a = array();
        $a = $this->html_color_array(strtolower($hex));
        return imagecolorallocate($this->im, $a[0], $a[1], $a[2]);
    }

    function html_color_array($s)
    {
        $a = array();
        $a[0] = hexdec('0x' . substr($s, 0, 2));
        $a[1] = hexdec('0x' . substr($s, 2, 2));
        $a[2] = hexdec('0x' . substr($s, 4, 2));
        return $a;
    }
}

/**
 * Пример использования класса для создания картинки с текстом и фоном
 *
 * $imageUtils = new ImageUtils();
 * $imageUtils->create(100, 200, 'ffffff');
 * $imageUtils->setFontFile('path/arial.ttf');
 * $imageUtils->setFontSizeRange(18, 24);
 * $imageUtils->setAngelRange(0, 10);
 * $imageUtils->setTextColors('0000ff', '003333', 'aa1111');
 * $imageUtils->dynamic_bg(5, '000000', 0.5);
 * $imageUtils->add_ttf_text('text', 10, 10);
 * $imageUtils->add_border();
 * $imageUtils->show();
 *
 * Открыть и вывести картинку:
 * $imageUtils = new ImageUtils();
 * $imageUtils->open('file.gif');
 * $imageUtils->show();
 */


?>