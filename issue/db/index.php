
<?
include $_SERVER["DOCUMENT_ROOT"]."/db/common/header.php";
$db = new db();
?>
<body>
<div class="dbContainer">
	<ul class="mtree transit">
		<?
		foreach ($db->getDb() as $value) {
			$tables = $db->getTables($value);
			echo "<li class='database ".$value."'>
					<a style='font-size : 15px !important;'>".$value."&nbsp;(".$tables->count.")</a>
				".$tables->tables."</li>";
		}
		?>
	</ul>
</div>
<div class="rowContainer">

	<div class="tab" id="tabList">
	  <button class="tablinks contents" onclick="tabMode('contents')">구조</button>
	  <button class="tablinks querytabs" onclick="tabMode('querytabs')">&nbsp;SQL&nbsp;</button>
	  <button class="tablinks searchtabs" onclick="tabMode('searchtabs')">검색</button>
	</div>
	<div id="contents" class="tabcontent"></div>
	<div id="querytabs" class="tabcontent">
	  <textarea spellcheck="false" id="queryText"></textarea>
	</div>
	<div id="searchtabs" class="tabcontent">
	  <h3>Tokyo</h3>
	</div>
	<div id='resizeBar'>● ● ●</div>
	<div id="mainTable"></div>
</div>

<script src='/db/js/jquery.velocity.min.js'></script> 
<script src="/db/js/mtree.js"></script> 
<script>
$(function(){
	if(getter('database') !== null) {
		initTree(".database."+getter('database'));
		initDb(getter('database'),getter('table'));
		tabMode(getter('tabMode'))
	}
	$("#queryText").keyup(function(){
		console.log(this.value.replace(/\s{2,}/gi," ").trim());
	});
});
</script>

</body>
<style>

</style>
</html>






