<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    图片必须使用jpg格式，商标名最好是英文<br /><br />
    <form action="logo" method="POST" enctype="multipart/form-data">
        <input type="file" name="logo">
        <br />
        商标名
        <input type="text" name="brand">
        <input type="submit">
    </form>
    <br />
    已有的图片文件<br /><br />
    <?php
        $dir = opendir('../resources/logos');
        $arr = [];
        while($jpg = readdir($dir))
        {
            if($jpg != '.' && $jpg != '..')
                $arr[] = $jpg;
        }
        closedir($dir);
        foreach($arr as $i)
            echo "$i<br /><img width='50px' src='../resources/logos/$i' /><br />";
    ?>
</body>
</html>