<div class="ui center aligned">
<p>Copy Now! ↓ Click ↓ </p>
<input type="text" id="copyColor" placeholder="Your color..." readonly onclick="fn_copy(this.id)"  style="width:300px;"/><br/>
<input name="color2" type="hidden" id="color_value" value="">
<button class="jscolor {valueElement: 'color_value'}" id="colorBtn" style="width:300px;height:200px">Pick a color</button> 
</div>
</div>
</body>
<script src="/js/jscolor.js"></script>
<script>
$(document).ready(function(){
	$("#color_value").change(function(){
		var color = $("#color_value").val();
		$("#copyColor").val("#"+color);
	});
});
function fn_copy(id) {
	var copyText = document.getElementById(id);
	  copyText.select();
	  document.execCommand("Copy");
} 
</script>    
<style>
body {
	padding : 1em;
}
#copyColor {
	border:none;
	height:20px;
	cursor:pointer;
	font-size: 30px;
	height : 30px;
	color : grey;
}
</style>            