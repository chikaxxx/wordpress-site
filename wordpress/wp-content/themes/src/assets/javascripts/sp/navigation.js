var $            = require('jquery');

$(function(){

  var Navigation = function(){
    this.body              = $('body');
    this.btn               = $('.js-navigation-btn, .js-navigation-item');
    this.btnIcon               = $('.js-navigation-btn button');
    this.contents          = $('.js-navigation-contents');
    this.contentsShowClass = 'js-navigation-show';
    this.contentsHideClass = 'js-navigation-hide';
    this.btnActiveClass    = 'is-active'; //ハンバーガーアイコンアニメーションプラグイン指定のclass
  }

  Navigation.prototype.noscroll = function(){
    event.preventDefault();
  }

  Navigation.prototype.activate = function(){
    var _this = this;

    this.btn.click(function(){
      if(_this.body.hasClass(_this.contentsShowClass)) {
        //メニューが表示されているとき
        _this.body.removeClass(_this.contentsShowClass);
        _this.body.addClass(_this.contentsHideClass);
        //フェードアウトが終わったら display:none; に戻したいため
        _this.contents.on('animationend webkitAnimationEnd', function(){
          _this.body.removeClass(_this.contentsHideClass);
        });
        _this.btnIcon.removeClass(_this.btnActiveClass);
        $(window).off('.noScroll');
      } else {
        _this.body.removeClass(_this.contentsHideClass);
        _this.body.addClass(_this.contentsShowClass);
        _this.btnIcon.addClass(_this.btnActiveClass);
        $(window).on('touchmove.noScroll', function(e) {
            e.preventDefault();
        });
      }
    });
  }


  var navigation = new Navigation();
  navigation.activate();

});
