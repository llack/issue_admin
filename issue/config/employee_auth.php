<?
session_start();
if($_SESSION["USER_NAME"]=="") {
	header("Location:/common/login.php");
}
if($_SESSION["USER_ID"]!="admin") {
	echo "<script>alert('권한이 없습니다.');
		history.back();
		</script>";
}
	
include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";

?>
<body>
<div class="ui container side ">
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>
<div class="ui container table purple segment">
<div class="right aligned">
	<a class="ui tag label">menu</a>
	<a class="ui red tag label">사원관리</a>
	<a class="ui teal tag label">사원 권한관리</a>
</div>
<h2 class="ui header" style="margin-top: 0px">

<i class="circular purple users icon icon"></i>
<div class="content">사원 권한관리</div>
</h2>
<!-- table start -->
<table class="ui celled table" style="border:1px solid rgba(34,36,38,.15)">
  <thead>
    <tr><th>Header</th>
    <th>Header</th>
    <th>Header</th>
  </tr></thead>
  <tbody>
    <tr>
      <td>
        <div class="ui ribbon label">First</div>
      </td>
      <td>Cell</td>
      <td>Cell</td>
    </tr>
    <tr>
      <td>Cell</td>
      <td>Cell</td>
      <td>Cell</td>
    </tr>
    <tr>
      <td>Cell</td>
      <td>Cell</td>
      <td>Cell</td>
    </tr>
  </tbody>
  <tfoot>
    <tr><th colspan="3">
      <div class="ui right floated pagination menu">
        <a class="icon item">
          <i class="left chevron icon"></i>
        </a>
        <a class="item">1</a>
        <a class="item">2</a>
        <a class="item">3</a>
        <a class="item">4</a>
        <a class="icon item">
          <i class="right chevron icon"></i>
        </a>
      </div>
    </th>
  </tr></tfoot>
</table>
<!-- /table container -->
</div>
</body>
</html>







