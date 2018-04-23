<!DOCTYPE html>
    <head>
    <meta charset="UTF-8">
        <title>PHP Pagination</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
    </head>
<?
include $_SERVER["DOCUMENT_ROOT"]."/common/pagination.php";
$limit      = ($_REQUEST['limit']!="") ? $_REQUEST['limit'] : 10;
$page       = ($_REQUEST['page']!="") ? $_REQUEST['page'] : 1;
$links      = ($_REQUEST['links']!="") ? $_REQUEST['links'] : 10;
$query      = " select * from member ";
$paginator  = new Paginator($query);
$results = $paginator->getData($page,$limit);
?>
    <body>
        <div class="container">
                <div class="col-md-10 col-md-offset-1">
                <h1>PHP Pagination</h1>
                <table class="table table-striped table-condensed table-bordered table-rounded">
                        <thead>
                                <tr>
                                <th>이름</th>
                                <th width="20%">직책</th>
                                <th width="20%">이메일</th>
                                <th width="25%">레벨</th>
                        </tr>
                        </thead>
                        <? 
                        	for($i = 0; $i < count($results->data); $i++) {?>
                        		<tr>
                        			<td><?=$results->data[$i][user_name]?></td>
                        			<td><?=$results->data[$i][position]?></td>
                        			<td><?=$results->data[$i][user_email]?></td>
                        			<td><?=$results->data[$i][user_level]?></td>
                        		</tr>
                        	<?}
                        ?>
                        <tbody></tbody>
                </table>
                </div>
        </div>
<?php 
echo $paginator->createLinks('pagination pagination-sm'); ?> 
        </body>
</html>