/*
 * This is a part of TLSFullWidthMap OpenCart Plugin
 * 
 */
var TLSFullWidthMap = {
    // CONFIGURE START
			
    src: 'https://goo.gl/maps/QCLYLfVn3mn',
    height: '300',
    // CONFIGURE END
    show: function() {
        var $container = jQuery('#tlsfullwidthmap');
        var html = '<iframe src="' + TLSFullWidthMap.src + '" width="' + ($container.width()) + '" height="' + TLSFullWidthMap.height + '" style="border:0;"></iframe>';
        jQuery('#tlsfullwidthmap').html(html);
        jQuery(function() {
            if (!('ontouchstart' in window)) {
                jQuery(window).on('resize', TLSFullWidthMap.show);
            }
        });
    }
}
document.write('<div id="tlsfullwidthmap" style="width:100%;"></div>');
jQuery(function () {
    TLSFullWidthMap.show();
});
