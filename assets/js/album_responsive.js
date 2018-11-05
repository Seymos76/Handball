let jssor_1_options = {
    $Idle: 2000,
    $SlideEasing: $Jease$.$InOutSine,
    $DragOrientation: 3,
    $ArrowNavigatorOptions: {
        $Class: $JssorArrowNavigator$
    },
    $BulletNavigatorOptions: {
        $Class: $JssorBulletNavigator$
    }
};

let jssor_1_slider = new $JssorSlider$("jssor_album", jssor_1_options);

//make sure to clear margin of the slider container element
jssor_1_slider.$Elmt.style.margin = "";

/*#region responsive code begin*/

/*
    parameters to scale jssor slider to fill parent container

    MAX_WIDTH
        prevent slider from scaling too wide
    MAX_HEIGHT
        prevent slider from scaling too high, default value is original height
    MAX_BLEEDING
        prevent slider from bleeding outside too much, default value is 1
        0: contain mode, allow up to 0% to bleed outside, the slider will be all inside parent container
        1: cover mode, allow up to 100% to bleed outside, the slider will cover full area of parent container
        0.1: flex mode, allow up to 10% to bleed outside, this is better way to make full window slider, especially for mobile devices
*/

let MAX_WIDTH = 3000;
let MAX_HEIGHT = 3000;
let MAX_BLEEDING = 0.128;

function ScaleSlider() {
    let containerElement = jssor_1_slider.$Elmt.parentNode;
    let containerWidth = containerElement.clientWidth;

    if (containerWidth) {
        let originalWidth = jssor_1_slider.$OriginalWidth();
        let originalHeight = jssor_1_slider.$OriginalHeight();

        let containerHeight = containerElement.clientHeight || originalHeight;

        let expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);
        let expectedHeight = Math.min(MAX_HEIGHT || containerHeight, containerHeight);

        //scale the slider to expected size
        jssor_1_slider.$ScaleSize(expectedWidth, expectedHeight, MAX_BLEEDING);

        //position slider at center in vertical orientation
        jssor_1_slider.$Elmt.style.top = ((containerHeight - expectedHeight) / 2) + "px";

        //position slider at center in horizontal orientation
        jssor_1_slider.$Elmt.style.left = ((containerWidth - expectedWidth) / 2) + "px";
    }
    else {
        window.setTimeout(ScaleSlider, 30);
    }
}

function OnOrientationChange() {
    ScaleSlider();
    window.setTimeout(ScaleSlider, 800);
}

ScaleSlider();

$(window).bind("load", ScaleSlider);
$(window).bind("resize", ScaleSlider);
$(window).bind("orientationchange", OnOrientationChange);
/*#endregion responsive code end*/