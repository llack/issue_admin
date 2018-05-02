<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
        <title>테스트 페이지</title>
    </head>
<? 
$param = "{\"cs_name\":\"test1\",\"cs_code\":\"DDT\"}";

print_r();
$test =json_decode($param,true);
echo json_encode($test);
?>
    <body>
     </body>
</html>