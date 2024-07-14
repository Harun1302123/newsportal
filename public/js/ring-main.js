
(function ($) {
    var data = [
    { number: '1', ratio: 6 },
    { number: '2', ratio: 6 },
    { number: '3', ratio: 6 },
    { number: '4', ratio: 6 },
    { number: '5', ratio: 6 },
    { number: '6', ratio: 6 },
    { number: '7', ratio: 6 },
    { number: '8', ratio: 6 },
    { number: '9', ratio: 6 },
    { number: '10', ratio: 6 },
    { number: '11', ratio: 6 },
    { number: '12', ratio: 6 }];


    // Color array.
    var color = d3.scaleOrdinal().
    range(
    ['#E7223C',
    '#DEA73A',
    '#4CA246',
    '#C7202F',
    '#F03F2E',
    '#26C0E7',
    '#FBC412',
    '#A41C45',
    '#F26A2F',
    '#DF1568',
    '#F89D29',
    '#C08E2C']);



    function svg() {
      // Variable to define if element is active and rotation counter.
      var active;
      var rotate = 0;

      var width = 527,
      height = 587;

      // Ring radiuses.
      var outerRadius;
      if (window.matchMedia('(max-width: 768px)').matches) {
        outerRadius = width / 2;
      } else {
        outerRadius = (height - 100) / 2;
      }

      var innerRadius = outerRadius / 2 + 3;

      // Chart definition.
      var pie = d3.pie().
      padAngle(.05).
      value(function (d) {
        return d.ratio;
      }).sort(null)(data);

      // Chart's arc definition.
      var arc = d3.arc().
      padRadius(outerRadius).
      innerRadius(innerRadius).
      startAngle(function (d) {
        return d.startAngle + Math.PI / 2 - .2;
      }).
      endAngle(function (d) {
        return d.endAngle + Math.PI / 2 - .2;
      });

      // Chart's label arc definition.
      var labelArc = d3.arc().
      outerRadius(outerRadius - 10).
      innerRadius(innerRadius - 10).
      startAngle(function (d) {
        return d.startAngle + Math.PI / 2 - .2;
      }).
      endAngle(function (d) {
        return d.endAngle + Math.PI / 2 - .2;
      });

      var svg;
      if (window.matchMedia('(max-width: 768px)').matches) {
        // Create SVG inside the given element and main <g> element.
        svg = d3.select('#nfisRing').append('svg').
        attr('preserveAspectRatio', 'xMinYMin meet').
        attr('viewBox', "0 0 ".concat(width, " ").concat(height)).
        attr('class', 'svg-content').
        append('g').
        attr('class', 'main-g').
        attr('transform', 'translate(' + width / 2 + ',' + height / 2 + ')');
      } else {
        // Create SVG inside the given element and main <g> element.
        svg = d3.select('#nfisRing').append('svg').
        attr('width', width).
        attr('height', height).
        append('g').
        attr('class', 'main-g').
        attr('transform', 'translate(' + width / 2 + ',' + height / 2 + ')');
      }

      var mainG = d3.select('.main-g');

      // Creates <g> elements inside main <g>.
      var g = svg.selectAll('path').
      data(pie).
      enter().append('g').
      attr('id', function (d) {
        return 'sdg-' + d.data.number;
      }).
      attr('class', function (d) {
        return 'arc sector-disabled sdg-' + d.data.number;
      });

      var $sectors = $('.main-g').find('.arc');
      $sectors.each(function (el, value) {
        var id = value.getAttribute('id');
        var node = $('.view-content').find('.' + id);
        if (node.length) {
          $('g#' + id).removeClass('sector-disabled');
        }
      });

      // Creates <path> elements inside <g>'s, fills them with exact color and sets onClick event.
      g.append('path').
      each(function (d) {
        d.outerRadius = outerRadius - 20;
      }).
      attr('d', arc).
      attr('id', function (d) {
        return 'sdg-' + d.data.number;
      }).
      style('fill', function (d) {
        return color(d.data.number);
      }).
      on('click', enableElement(outerRadius + 20, 0));

      // Creates <text> elements inside <g>'s, center them and sets the label.
      g.append('text').
      attr('transform', function (d) {
        return 'translate(' + labelArc.centroid(d) + ')';
      }).
      attr('dx', '-9px').
      attr('dy', '5px').
      text(function (d) {
        return d.data.number;
      }).
      style('fill', '#fff');

      // Variable for all text elements.
      var text = g.selectAll('text');

      // Function that extends arc.
      function enableElement(outerRadius, delay) {
        return function (d) {
          if (typeof active !== 'undefined') {
            setDefault(outerRadius - 40, 150);
          }
          active = this;
          rotate = 10.5 - (d.startAngle + d.endAngle) / 2 / Math.PI * 180;
          mainG.transition().
          attr('transform', 'translate(' + width / 2 + ',' + height / 2 + ') rotate(' + rotate + ',' + 0 + ',' + 0 + ')').
          duration(1000);
          text.transition().
          attr('transform', function (dd) {
            return 'translate(' + labelArc.centroid(dd) + ') rotate(' + -rotate + ')';
          }).
          duration(1000);
          d3.select(this).transition().delay(delay).attr('class', 'active').attrTween('d', function (d) {
            var i = d3.interpolate(d.outerRadius, outerRadius);
            return function (t) {
              d.outerRadius = i(t);
              return arc(d);
            };
          });
          var id = $(this).attr('id');
          if (id !== '') {
            setData(id);
          }
        };
      }

      // Function that set default size to the arc..
      function setDefault(outerRadius, delay) {
        d3.select(active).transition().delay(delay).attr('class', '').attrTween('d', function (d) {
          var i = d3.interpolate(d.outerRadius, outerRadius);
          return function (t) {
            d.outerRadius = i(t);
            return arc(d);
          };
        });
      }

      setFromHash();
    }

    function setFromHash() {
      $.fn.d3Click = function () {
        this.each(function (i, e) {
          var evt = new MouseEvent("click");
          e.dispatchEvent(evt);
        });
      };

      var selectedNode = window.location.hash.substring(1);
      var node = $('div.sdg-' + selectedNode);
      if (selectedNode === '' || node.length === 0) {
        selectedNode = 1;
      }
      var elementToSelect = $('path#sdg-' + selectedNode);
      elementToSelect.trigger('click');
      elementToSelect.d3Click();
      setData('sdg-' + selectedNode);
    }

    function setData(id) {
      var nodeClass = '.' + id;
      var hashNumber = id.replace('sdg-', '');
      $('.sdg-node').addClass('sdg-node-hidden');
      $(nodeClass).removeClass('sdg-node-hidden');

      var title = $.trim($(nodeClass + ' .full-content.field__title').text());
      var description = $.trim($(nodeClass + ' .sdg-content-description').html());
      var image = $.trim($(nodeClass + ' .full-content.field__image').html());

      $('.sdg-ring-content-title').text(title);
      $('.sdg-ring-content-description').html(description);
      $('.center-image').html(image);
      window.location.hash = "#".concat(hashNumber);
    //   Drupal.attachBehaviors(context);
    }

    if (!$('.main-g').length) {
      var outerCircle = $('svg.outer-circle');
      var mobile = true;
      var isResizeble = true;
      $(window).on('load resize', function () {
        if (window.matchMedia('(max-width: 768px)').matches) {
          isResizeble = true;

          if (mobile) {
            if ($('#nfisRing > svg').length > 0) {
              $('#nfisRing > svg').remove();
            }
            svg();
            mobile = false;
          }

          $('.center-image').css('width', $(window).width() / 2 - 20);
          $('.center-image').css('height', $(window).width() / 2 - 20);
        } else if (isResizeble) {
          if ($('#nfisRing > svg').length > 0) {
            $('#nfisRing > svg').remove();
            $('#nfisRing').append(outerCircle);
          }
          $('.center-image').css('width', '220px');
          $('.center-image').css('height', '220px');
          svg();
          isResizeble = false;
          mobile = true;
        }
      });
    }


})(jQuery);

$('#nfisRing').on('click', 'path', function (e) {
e.preventDefault();
var $this = $(e.target);
var fill = $this.attr('style');

if (fill && fill.length > 0) {
  $('.outer-circle path').attr('style', fill);
  var p = fill.split(';');
  p.forEach(function (val) {
    var split = val.split(':');
    $('.center-image').css('backgroundColor', split[1]);
  });
}
});

$('#snapshotRing').on('click', 'path', function (e) {
e.preventDefault();
var $this = $(e.target);
var fill = $this.attr('style');

$('.background-circle').attr('style', 'box-shadow: 0 0px 28px rgba(0,0,0,0.25), 0 0px 10px rgba(0,0,0,0.22);');
if (fill && fill.length > 0) {
  $('.outer-circle path').attr('style', fill);
}
});
