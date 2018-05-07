<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <script src="/js/jquery-3.2.1.js"></script>
        <title>테스트 페이지</title>
    </head>
<style>
#cs_modify {
    visibility: hidden;
    min-width: 250px;
    margin-left: -125px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 2px;
    padding: 16px;
    position: fixed;
    z-index: 1;
    left: 50%;
    top: 30px;
    font-size: 17px;
}
#cs_modify.show {
    visibility: visible;
    -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
    animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
    from {top: 0; opacity: 0;} 
    to {top: 30px; opacity: 1;}
}

@keyframes fadein {
    from {top: 0; opacity: 0;} 
    to {top: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
    from {top: 0; opacity: 0;} 
    to {top: 30px; opacity: 1;}
}

@keyframes fadeout {
    from {top: 0; opacity: 0;} 
    to {top: 30px; opacity: 1;}
}
</style>
    <body>
    <div id="cs_modify"></div>
    <button onclick="test()">버튼이다.</button>
     </body>
     <script>
     function test() {
		snackbar("cs_modify","#54c8ff","테스트");
     }
     function snackbar(id,color,text) {
         	var x = $("#" + id + "");
	    	x.html(text);
	 		x.css("background-color",color);
			x.addClass("show");
    	    setTimeout(function(){ x.removeClass("show"); }, 500);
    }
     </script>
</html>