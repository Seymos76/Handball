jssor_1_slider_init = function() {

    let jssor_1_SlideoTransitions = [
        [{b:-1,d:1,o:-0.7}],
        [{b:900,d:2000,x:-379,e:{x:7}}],
        [{b:900,d:2000,x:-379,e:{x:7}}],
        [{b:-1,d:1,o:-1,sX:2,sY:2},{b:0,d:900,x:-171,y:-341,o:1,sX:-2,sY:-2,e:{x:3,y:3,sX:3,sY:3}},{b:900,d:1600,x:-283,o:-1,e:{x:16}}]
    ];

    let jssor_1_options = {
        $AutoPlay: 1,
        $SlideDuration: 800,
        $SlideEasing: $Jease$.$OutQuint,
        $CaptionSliderOptions: {
            $Class: $JssorCaptionSlideo$,
            $Transitions: jssor_1_SlideoTransitions
        },
        $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$
        },
        $BulletNavigatorOptions: {
            $Class: $JssorBulletNavigator$
        }
    };

    let jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

    /*#region responsive code begin*/

    let MAX_WIDTH = 3000;
    let MAX_HEIGHT = 1200;

    function ScaleSlider() {
        let containerElement = jssor_1_slider.$Elmt.parentNode;
        let containerWidth = containerElement.clientWidth;
        let containerHeight = containerElement.clientHeight;

        if (containerHeight) {
            let expectedHeight = Math.min(MAX_HEIGHT || containerHeight, containerHeight);
            jssor_1_slider.$ScaleHeight(expectedHeight);
        } else {
            window.setTimeout(ScaleSlider, 30);
        }

        if (containerWidth) {
            let expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);
            jssor_1_slider.$ScaleWidth(expectedWidth);
        }
        else {
            window.setTimeout(ScaleSlider, 30);
        }
    }

    ScaleSlider();

    $Jssor$.$AddEvent(window, "load", ScaleSlider);
    $Jssor$.$AddEvent(window, "resize", ScaleSlider);
    $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
    /*#endregion responsive code end*/
}();