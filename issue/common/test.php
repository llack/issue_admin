<!DOCTYPE html>
<?
function myfunction(&$value,$key) {
	if($key == "end_date" ) { 
		echo date("Y-m-d",strtotime($value) + 86400 );
	}
}
$a=array("end_date"=>"2018-05-14","b"=>"green","c"=>"blue");
array_walk($a,"myfunction");
print_r($a);

?>
<html>
    <head>
    <meta charset="UTF-8">
    <script src="/js/jquery-3.2.1.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/huebee@1/dist/huebee.min.css">
    <script src="https://unpkg.com/huebee@1/dist/huebee.pkgd.min.js"></script>
       <title>테스트 페이지</title>
    </head>
    <body>
    <button class="color-button1">색상 선택</button>
    <input id="test1">
      <button class="color-button2">색상 선택</button>
      <input id="test2">
    </body>
<script>
$(document).ready(function(){
	colorPicker(".color-button1","test1");
	colorPicker(".color-button2","test2");
});
function colorPicker(button,inputId) {
	var hueb = new Huebee( button, {
		  notation: 'hex',
		  saturations: 2,
		  setText : false
		});
	hueb.setColor("#FFFFAA");
	hueb.on( 'change', function( color, hue, sat, lum ) {
		$("#"+inputId).val(color);
	});
}
</script>
</html>