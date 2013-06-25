/**
 * @author Тимофеев Р.О.
 * @version 0.0.1
 */

/* Clear text by alfavit */
function clearByAlfavit(txt, alfavit){
  if (txt && alfavit){
    txt = txt.toString();
    txtLength = txt.length;
    result = "";
    for (var i = 0; i < txtLength; i++){
      symbol = txt.charAt(i);
      if ( alfavit.indexOf(symbol) != -1){
        result += symbol;
      }
    }
    return result;
  }
  return null;
}

function clearInt(txt){
  return clearByAlfavit(txt, "0123456789");
}

Number.prototype.isInt = function() {
  return (Math.round(this) == this);
}
Number.prototype.roundTo = function(n) {
  var x = 0;
  if (typeof(n) == 'number') if (n.isInt()) if (n >= -6 && n <= 6) x = n;
  x = Math.pow(10,x);
  return Math.round(this*x)/x;
}
Math.roundTo = function(i,n) {
  return (typeof(i) == 'number') ? i.roundTo(n) : false;
}

/*
toNormal(value) - приводит число в нормальный вид (довольно часто арифметические операции в JavaScript
возвращают число типа 1.9999999999999998, данная функция его округляет)
**/

function toNormal(value) {
  if (arguments.length == 1 && value != null) {
    value = value.toString();
    value = parseFloat(value.replace(/\,/, "."));
    if (!isNaN(value) && value !== null) {
      value = value.roundTo(3);
    }
  }
  return (!isNaN(value)) ? value : 0;
}
/* Приводит число к денежному формату 0.00 */
function toMoney(value) {
  value = toNormal(value);
  value = value.roundTo(2);
  return value.toFixed(2);
}

/* Делаем деление сумм на разряды */
function divideMoney(money){
  if (money.length < 6) return money;
  else {
    var result = "";
    var leftMoney = money.slice(0, (money.length-6));
    var rightMoney = money.slice(-6);
    var leftMoneyCount = leftMoney.length;
    var k = 0;
    for (var i = leftMoneyCount-1; i >= 0; i--){
      if (((k % 3) == 0) && (k != 0)) result = '&nbsp;'+result;
      k++;
if ($.browser.msie) {
    result = leftMoney.substring(i, i+1)+result;
  } else {
      result = leftMoney[i]+result;
}
    }
    result += "&nbsp;"+rightMoney;
    return result;
  }
}


/**
 * Класс продукта, для сохранения в куках корзины
 * @param id
 * @param count
 * @returns {Product}
 */
function Product(id, count) {
  this.id = id;
  this.count = count;
}
/**
 * Класс корзины
 */
DaCart = function() {};
DaCart._inited = false;
DaCart._options = {
  'onChange': function(){},
  'cookieName': 'daCart'
};
DaCart.init = function(options) {
  if (DaCart._inited == true) {
    return;
  }
  var scriptIncluding = false;
  while (!JSON) { //Если в браузере не реализован объект JSON, то подключаем его CDN
    if (!scriptIncluding) {
      document.write('<script src="http://yandex.st/json2/2011-10-19/json2.min.js" type="text/javascript"></script>');
      scriptIncluding = true;
    }
  }
  DaCart._options = $.extend(DaCart._options, options);
  DaCart.restoreFromCookie();
  DaCart._inited = true;
}
DaCart.products = [];

DaCart.addProduct = function(product) {
  if (!(product instanceof Product)) {
    throw new Error("product должен быть наследником Product");
  }
  var inCart = false;
  var addedProduct = null;
  for (var i in DaCart.products) {
    if (DaCart.products[i].id == product.id) {
      DaCart.products[i].count += product.count;
      addedProduct = DaCart.products[i];
      inCart = true;
      break;
    }
  }
  if (!inCart) {
    addedProduct = product;
    DaCart.products.push(product);
  }
  DaCart.saveToCookie();
  DaCart._options.onChange(addedProduct, inCart);
  return addedProduct.count;
}

DaCart.updateProduct = function(product) {
  if (!(product instanceof Product)) {
    throw new Error("product должен быть наследником Product");
  }
  var inCart = false;
  var addedProduct = null;
  for (var i in DaCart.products) {
    if (DaCart.products[i].id == product.id) {
      DaCart.products[i].count = product.count;
      addedProduct = DaCart.products[i];
      inCart = true;
      break;
    }
  }
  if (!inCart) {
    addedProduct = product;
    DaCart.products.push(product);
  }
  DaCart.saveToCookie();
  DaCart._options.onChange(addedProduct, inCart);
  return addedProduct.count;
};

DaCart.removeProduct = function(id) {
  var removedProduct = null;
  var productsAfterRemoving = [];
  for (var i in DaCart.products) {
    if (DaCart.products[i].id != id) {
      productsAfterRemoving.push(DaCart.products[i]);
    } else {
      removedProduct = DaCart.products[i];
    }
  }
  DaCart.products = productsAfterRemoving;
  DaCart.saveToCookie();
  DaCart._options.onChange(removedProduct, true);
};

DaCart.saveToCookie = function() {
  $.cookie(DaCart._options.cookieName, JSON.stringify(DaCart.products), {path:'/'});
};

DaCart.restoreFromCookie = function() {
  if ($.cookie(DaCart._options.cookieName) != null) {
    DaCart.products = JSON.parse($.cookie(DaCart._options.cookieName));
  }
};


(function($){
  $.fn.daCartProduct = function(options) {
    var options = $.extend({
      'buttonAdd': '.buy',
      'buttonDecrease': '.btDecrease',
      'buttonIncrease': '.btIncrease',
      'inputCount': '.kolvo input',
      'animationDest': '.b-cart .itogo',
      'onItemChange': function(){}
    }, options);
    
    DaCart.init();

    //Функция по-умолчанию, формирующая экземпляр Product, для помещения в корзину
    var _formProduct = function($item) {
      var $btn = $item.find(options.buttonAdd);
      if ($btn.length == 0) {
        throw new Error('Не найден элемент с классом '.options.buttonAdd);
      }
      var id = $btn.data('id');
      if (id == null) {
        throw new Error('Не найден id продукции');
      }
      var cnt = $item.find(options.inputCount).val();
      if (cnt == null) {
        cnt = 1;
      }
      return new Product(id, cnt);
    };

    //Если пользователь указал свою функцию формирующую экземпляр Product 
    if (options.formProduct) {
      _formProduct = options.formProduct;
    }

    var updateAndChange = function($item) {
      var product = _formProduct($item);
      var countInCart = DaCart.updateProduct(product);
      options.onItemChange({item: $item, countInCart: countInCart});
    };
    
    //анимация помещения товара в корзину
    var _animate = function($item) {
      var productX      = $item.offset().left;
      var productY      = $item.offset().top;
      var productWidth  = $item.width();
      var productHeight = $item.height();

      var destination = $(options.animationDest);
      var basketX       = destination.offset().left;
      var basketY       = destination.offset().top;

      var gotoX         = basketX - productX;
      var gotoY         = basketY - productY;

      var newWidth      = $item.width() / 20;
      var newHeight     = $item.height() / 10;

      $('<div style="background:#eee; position:absolute; top:'+productY+'px; left:'+productX+'px; width:'+productWidth+'px; height:'+productHeight+'px"></div>').prependTo("body")
        .animate({opacity: 0.8}, 100)
        .animate({opacity: 0.1, marginLeft: gotoX, marginTop: gotoY, width: newWidth, height: newHeight}, 1200, function (){ $(this).remove(); }); 
    };
    
    //Тут перебор элементов на которых вызван daCartProduct
    return this.each(function() {
      var $item = $(this);
      //Кнопка "Добавить товар в корзину"
      $item.find(options.buttonAdd).on('click', function() {
        var product = _formProduct($item);
        var countInCart = DaCart.addProduct(product);
        _animate($item);
        options.onItemChange({item: $item, countInCart: countInCart});
        return false;
      });
      //Кнопка "Уменьшить количество товара в корзине"
      $item.find(options.buttonDecrease).on('click', function() {
        updateAndChange($item);
        return false;
      });
      //Кнопка "Увеличить количество товара в корзине"
      $item.find(options.buttonIncrease).on('click', function() {
        updateAndChange($item);
        return false;
      });
      //События на инпуте с количеством товара
      $item.find(options.inputCount).on('change, keydown, keyup', function(){
        var $this = $(this);
        $this.val(clearInt($this.val()));
        updateAndChange($item);
      });
    });
  };
})(jQuery);



/**
 * Класс продукции для добавления в виджет корзины
 * @param id
 * @param count
 * @param name
 * @param price
 * @returns {CartWidgetProduct}
 */
function CartWidgetProduct(id, count, name, price) {
  this.id = id;
  this.count = count;
  this.name = name;
  this.price = price;
}
/**
 * Виджет корзины
 */
(function($){
  $.widget('da.Cart', {
    options: {
      'empty': '.hdr', //элемент с сообщением о пустой корзине
      'item': '.item', //элемент одиночного товара
      'itemButtonDelete': '.close', //кнока "удалить товар из корзины"
      'itemName': '.name', //контейнер с названием товара
      'itemCount': '.kolvo input', //инпут с количеством товара
      'itemPriceValue': '.price .val', //контейнер с ценной товара
      'itemAttrId': 'data-id', //атрибут, содержащий id одиночного товара
      'itemAttrPrice': 'data-price', //атрибут, содержащий цену одиночного товара
      'itemAttrCount': 'data-kolvo', //атрибут, содержащий количество выбранного товара
      'offerLink': '#', //ссылка на форму заказа
      'buttonOffer': '.btns .offer', //кнопка заказать
      'buttonClearCart': '.btns .clear', //кнопка очистить корзину
      'productList': '.tovarList', //контейнер списка товаров
      'total': '.itogo span', //контейнер с итоговой суммой
      'noPrice': '', //классы элементов, которые необходимо скрывать, если не нужно отображать цену товаров.
                    //если пусто, то цена отображается
      'visibleCount': 20, //Количество отображаемых товаров в корзине, остальные будут скрываться 
      'itemInvisible': 'itemInvisible', //класс для невидимого итема
      'totalItemsCount': '.totalItems', //контейнер с общим количеством товара в корзине
      'totalItemsCountValue': '.totalItems span', //контейнер со значением общего количества товара в корзине
      //шаблон одиночного товара
      'itemTemplate': '<li data-price-result="" data-kolvo="" data-price="" data-id="" class="item">' +
                        '<a title="Удалить" href="#" class="close">×</a>' +
                        '<div class="name"></div>' +
                        '<div class="kolvo">' +
                          '<input maxlength="4" value="0"> шт.' +
                        '</div>' +
                        '<div class="price">' +
                          '<span class="val">0</span> <img title="руб." alt="руб." src="/project/plugin/internet_magazin/gfx/rub18.png">' +
                        '</div>' +
                      '</li>',
      //шаблон корзины             
      'cartTemplate': '<h3 class="title">Корзина</h3>'+
                      '<div class="hdr">' +
                        '<div class="alert alert-info"><i class="icon-info-sign icon-white"></i> Ваша корзина пуста</div>' +
                      '</div>' +
                      '<ul class="tovarList"></ul>'+
                      '<div class="itogo alert"><table cellpadding="0" cellspacing="0" style="width:100%"><tr><th style="width:60%">Итог</th><td style="text-align:right"> <span>0</span> </td><td>&nbsp;руб.</td></tr></table></div>' +
                      '<div class="btns">' +
                        '<a class="btn btn-large btn-success offer" href="#"><i class="icon-shopping-cart icon-white"></i> Оформить заказ</a>' +
                        '<button class="btn clear"><i class="icon-trash"></i> Очистить</button>' +
                      '</div>'
    },
    
    _bindEvents: function() {
      var that = this;
      //Кнопка "удалить" товар из корзины
      this.element.find(this.options.productList).on('click', this.options.itemButtonDelete, function(event) {
        var $this = $(event.target);
        var $item = $this.closest(that.options.item);
        that.removeProduct($item, true);
        return false;
      });
      //Инпут с количеством товара
      this.element.find(this.options.productList).on('change, keydown, keyup', this.itemPriceValue, function(event) {
        var $this = $(event.target);
        $this.val(clearInt($this.val()));
        var $item = $this.closest(that.options.item);
        
        that.updateProduct(new CartWidgetProduct(
          $item.attr(that.options.itemAttrId),
          $item.find(that.options.itemCount).val()*1,
          $item.find(that.options.itemName).html(),
          $item.attr(that.options.itemAttrPrice)
        ));
      });
      //кнопка "очистить корзину"
      this.element.find(this.options.buttonClearCart).on('click', function() {
        $(that.options.item).each(function() {
          that.removeProduct($(this), false);
        });
        that._renderCart();
      });
    },
    //рендерит саму корзину
    _renderCart: function() {
      var $cartBody = this.element.children();
      if ($cartBody.length == 0) {
        $cartBody = $(this.options.cartTemplate);
        $cartBody.find(this.options.buttonOffer).attr('href', this.options.offerLink);
        this._checkEmptyCart($cartBody);
        this.element.html($cartBody);
      } else {
        this._checkEmptyCart($cartBody);
      }
      if (this.options.noPrice == '') {
        this._renderSum();
      }
      this._checkItemsVisibleCount();
    },
    
    //Прячем итемы, если корзина переполнена
    _checkItemsVisibleCount: function() {
      var $items = this.element.find(this.options.item);
      var that = this;
      $items.each(function(index){
        if (index < that.options.visibleCount) {
          $(this).removeClass(that.options.itemInvisible);
        } else {
          $(this).addClass(that.options.itemInvisible);
        }
      });
      var $totalItemsCountCont = this.element.find(this.options.totalItemsCount);
      var $totalItemsCountVal = this.element.find(this.options.totalItemsCountValue);
      if ($items.length > this.options.visibleCount) {
        $totalItemsCountVal.html($items.length);
        $totalItemsCountCont.show();
      } else {
        $totalItemsCountCont.hide();
      }
    },
    
    //высчитывает и рендерит сумму (а также итоговую сумму) каждого товара в виджете
    _renderSum: function() {
      var totalSum = 0;
      var that = this;
      this.element.find(this.options.item).each(function(){
        var $item = $(this);
        var price     = $item.attr(that.options.itemAttrPrice)*100;
        var strPrice  = toMoney(String($item.attr(that.options.itemAttrCount) * price / 100));
        var formatedPrice = divideMoney(strPrice);
        $item.find(that.options.itemPriceValue).html(formatedPrice).attr('title', strPrice);
        totalSum += strPrice*1;
      });
      var strTotalSum = divideMoney(toMoney(totalSum.toString()));
      this.element.find(this.options.total).html(strTotalSum).attr('title', toMoney(totalSum.toString()));
    },
    //проверяет корзину на пустоту
    _checkEmptyCart: function($cartBody) {
      if ($cartBody.find(this.options.item).length == 0) {
        $cartBody.filter(this.options.empty).show();
        $cartBody.filter(this.options.empty).nextAll().not(this.options.noPrice).slideUp();
      } else {
        $cartBody.filter(this.options.empty).hide();
        $cartBody.filter(this.options.empty).nextAll().not(this.options.noPrice).slideDown();
      }
    },
    //вызывается при создании виджета
    _create: function() {
      this._renderCart();
      this._bindEvents();
    },
    //добавляет либо обновляет информацию о выбраном товаре
    updateProduct: function(product) {
      if (!(product instanceof CartWidgetProduct)) {
        throw new Error('product должен быть наследником CartWidgetProduct');
      }
      var $item = this.findItemById(product.id);
      if ($item.length == 0) {
        $item = $(this.options.itemTemplate);
        this.fillItem($item, product);
        this.element.find(this.options.productList).append($item);
      } else {
        this.fillItem($item, product);
      }
      this._trigger('onUpdateProduct', null, {item: $item, product: product});
      this._renderCart();
    },
    //удаляет товар из виджета
    removeProduct: function($item, render) {
      this._trigger('onRemoveProduct', null, {item: $item});
      $item.remove();
      if (render) {
        this._renderCart();
      }
    },
    
    findItemById: function(id) {
      return this.element.find(this.options.item + '[' + this.options.itemAttrId + '="' + id + '"]');
    },
    
    //Заполняет $item(обычно это li) значениями
    fillItem: function($item, product) {
      var eventData = {item: $item, product: product, filled: false};
      this._trigger('onFillItem', null, eventData);
      //если итем не был заполнен в обработчике события, то заполняем вручную
      if (eventData.filled) return;
      
      $item.attr(this.options.itemAttrId, product.id);
      $item.attr(this.options.itemAttrPrice, product.price);
      $item.attr(this.options.itemAttrCount, product.count);
      $item.find(this.options.itemName).html(product.name);
      $item.find(this.options.itemCount).val(product.count);
    }
    
  });
})(jQuery);

/**
 * Инициализация плагина daCartProducts по-умолчанию
 * @param selector - селектор элементов на  которых будет вызван плагин
 */
function initDaCartProducts(selector) {
  $(selector).daCartProduct({
    onItemChange: function(eventData) {
      var $item = eventData.item; //елемент товара (из списка товаров либо из представления одиночного товара)
      //Формируем продукт виджета корзины
      var product = new CartWidgetProduct(
        $item.find(".buy").data("id"),
        eventData.countInCart,
        $item.find(".buy").data("name"),
        $item.find(".buy").data("price")
      );
      //Добавляем продукт в виджет корзины
      $(".b-cart").Cart("updateProduct", product);
    }
  });
}


/***********************************
 **********   Товар    ******
 ***********************************/
function EMarketProduct(){}
EMarketProduct.textCollapse = function(){
  var productDescription = $('.b-emarket-product .description');
  var productText        = productDescription.find('.text');
  var productSlider      = productDescription.find('.slider');
  if (productText.height() > 50){
    productSlider.show();
    productText.height(50);
    productSlider.find('.buy').click(function(){
      productSlider.fadeOut();
      productText.height('auto');
    });
  } else {
    productSlider.hide();
  }
}





/***********************************
 **********   Категории товоров    ******
 ***********************************/
function EMarketProductCategoryList(){}//Создаём объект Корзины
EMarketProductCategoryList.maxSubCategoryHeight = 100; // Высота видимых сразу подкатегорий
EMarketProductCategoryList.container = null;

EMarketProductCategoryList.init = function(){
  EMarketProductCategoryList.container = $('.b-emarket-category-list');
  EMarketProductCategoryList.subCategoryCollapse();
}

EMarketProductCategoryList.subCategoryCollapse = function(){
  EMarketProductCategoryList.container.find('.sub-item-list').each(function(){
    if ($(this).height() > EMarketProductCategoryList.maxSubCategoryHeight){
        $(this).height( EMarketProductCategoryList.maxSubCategoryHeight );
        $(this).after('<button class="expend">раскрыть полный список</button>');
    }
  });
  EMarketProductCategoryList.container.find('.expend').live('click', function(){
    $(this).prev().height('auto');
    $(this).remove();
  })
}