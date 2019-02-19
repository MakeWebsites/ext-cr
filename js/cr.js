$(function(){
//Change of styles
$("h2").css("color", "#314593");
$(".btn-primary, .badge-success, .btn-success").css({"color": "cyan", "background-color": "#314593"});
$(".badge").css("line-height","2");
$(".imheader").animate({ "width" : "+=15" });
//$("img:not(.imgs)").width("95%");
//$(".site-header").css({"position" : "sticky", "top" : "0"});


init(); //Functions at init
});

function init() {
submf ();
framh (); 
imgh (); 
}

    //Forms
function submf () {
//Submits the form inmediately after change
$('.csubm').change(function(){
            $('#forms').submit();
            });
        }    

function framh() {
//Changes framed-box when hover
$(".framed-box").hover(
    function () {
    //$(this).animate ({ "font-size" : "110%" }, "fast" ); 
        $(this).css ("font-size",  "110%"); }, 
    function () {
       $(this).css ("font-size",  "105%"); } ); 
}

function imgh() {
    $("img:not(.imgs)").hover(
    function () { //Decreases image opacity when hover
       $(this).animate({ opacity: 0.7 }, "fast"); }, 
    function () {
       $(this).animate({ opacity: 1.0 }, "fast"); } );
    }