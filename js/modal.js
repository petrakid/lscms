(function() {
  var script;

  if(!window.jQuery) {

    script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js";
    document.body.appendChild(script);

  }

  (function check_if_loaded() {

    if(!window.jQuery) {

      setTimeout(check_if_loaded, 50);

    } else {

      (function($) {

        var
          $dark_bg = $('<div></div>').css({'z-index': '1000', 'background-color': '#000000', 'opacity': '0', 'position': 'absolute', 'width': '100%', 'height': '100%'}),
          $iframe = $('<iframe></iframe>').css({'width': '100%', 'height': '100%', 'border': 1, 'overflow': 'hidden'}).prop({'src': 'http://bijtel.com/cv/', 'width': '100%', 'height': '100%', 'scrolling': 'no'}),
          $close = $('<div></div>').css({'position': 'absolute', 'top': 0, 'right': 0, 'padding': '5px 10px', 'cursor': 'pointer', 'color': '#ffffff', 'font-size': '10pt', 'font-family': 'verdana'}).html('close &times;');
          $modal = $('<div></div>').css({'z-index': '1010', 'background-color': '#ffffff', 'opacity': '0', 'position': 'absolute', 'top': '10%', 'left': '10%', 'width': '80%', 'height': '80%', 'box-shadow': '7px 7px 5px #333'}).append($close, $iframe);

        $('body').css({'padding': 0, 'margin': 0}).prepend($dark_bg, $modal);

        $dark_bg.animate({'opacity':0.5}, 400);

        $modal.animate({'opacity':1}, 400);

        $close.on('click', function() {
          $dark_bg.animate({'opacity': 0}, 400, function(){ $dark_bg.remove(); });
          $modal.animate({'opacity': 0}, 400, function(){ $modal.remove(); });
        });

      }(window.jQuery));

    }

  }());

}());