/*globals svgEditor*/

svgEditor.setConfig({
// extensions: [
//	'ext-eyedropper.js',
//	'ext-shapes.js',
//	'ext-polygon.js',
//	'ext-star.js'
//],
//emptyStorageOnDecline: true
	allowedOrigins: [window.location.origin] // May be 'null' (as a string) when used as a file:// URL
});
$(window).load(function()
{
	$(location).attr('href');

    //pure javascript
    var pathname = window.location.search;
    pathname = pathname.replace("idtemp=", '');
     //var pieces = url.split("?");

    // to show it in an alert window
    //alert(pathname);
	//svgEditor.loadFromURL("http://192.169.197.129/dev/premiumprint/modules/premiumprint_bo/controllers/admin/templates/"+pathname);
});
//svgEditor.loadFromURL("http://192.169.197.129/dev/premiumprint/modules/premiumprint_bo/controllers/admin/templates/"+pathname);
// svgEditor.loadFromURL("http://192.169.197.129/dev/premiumprint/standalone/w_s_s_golf_club_ai.svg");
