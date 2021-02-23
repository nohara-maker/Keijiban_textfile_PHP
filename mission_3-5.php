<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
    <?php
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $password = $_POST["password"];
    
    $delete = $_POST["delete"];
    $delete_password = $_POST["delete_password"];
    
    $edit = $_POST["edit"];
    $edit_password = $_POST["edit_password"];
    $edit_n = $_POST["edit_n"];
    
    $date = date("Y年m月d日 H:i:s");
    $filename="mission_3-5.txt";
    if (file_exists($filename)) {
    //  $num = count(file($filename))+1;
    $lines = file($filename);
    $get_line = $lines[count($lines)-1];
    $str = explode("<>",$get_line);
    $num = $str[0]+1;
    } else {
    $num = 1;
    }
    if($name && $comment && $password && !$edit_n) {
        $txt = 
        $num."<>".$name."<>".$comment."<>".$date."<>".$password."<>";
        $fp = fopen($filename,"a");
        fwrite($fp, $txt.PHP_EOL);
        fclose($fp);
    }
    
    if($delete && $delete_password){
        $lines = file($filename,FILE_IGNORE_NEW_LINES);
        foreach($lines as $line){
            $str = explode("<>",$line);
            if($str[0] == $delete && $str[4] == $delete_password){
                $fp = fopen($filename,"w");
                foreach($lines as $line){
                    $str = explode("<>",$line);
                    if($str[0] != $delete){
                    fwrite($fp,$str[0]."<>".$str[1]."<>".
                    $str[2]."<>".$str[3]."<>".$str[4]."<>".PHP_EOL);
                    }  
                }
                fclose($fp);
            }
        }
    }
    
    if($edit && $edit_password){
        $lines = file($filename,FILE_IGNORE_NEW_LINES);
        foreach($lines as $line){
            $str = explode("<>",$line);
            if($str[0] == $edit && $str[4] == $edit_password){
                $edit_n = $_POST["edit"];
                $edName = $str[1];
                $edComment = $str[2];
                break;
            }
        }
    }
    
    if($name && $comment && $edit_n){
        $lines = file($filename,FILE_IGNORE_NEW_LINES);
        $fp = fopen($filename,"w");
        foreach($lines as $line){
            $str = explode("<>",$line);
            if($str[0] == $edit_n){
                $password = $str[4];
                fwrite($fp,"$edit_n<>$name<>$comment<>$date<>$password<>".PHP_EOL);
            }else{
                fwrite($fp,$line.PHP_EOL);
            }
        }
        fclose($fp);
        $edit_n = null;
    }
    ?>
<form action="" method="post">
    名前:
    <input type="text" name="name" value="<?php echo $edName;?>">
    <br>
    コメント:
    <input type="text" name="comment" value="<?php echo $edComment;?>">
    <br>
    パスワード:
    <input type="text" name="password">
    <input type="submit" name="submit">
    <br>
    <input type="hidden" name="edit_n" value="<?php echo $edit_n;?>">
</form>
<hr>
<form action="" method="post">
    削除番号:
    <input type="text" name="delete">
    <br>
    パスワード:
    <input type="text" name="delete_password">
    <input type="submit" name="submit">
</form>
<hr>
<form action="" method="post">
    編集番号:
    <input type="text" name="edit">
    <br>
    パスワード:
    <input type="text" name="edit_password">
    <input type="submit" name="submit">
</form>
<?php
    if(file_exists($filename)){
        $lines = file($filename,FILE_IGNORE_NEW_LINES);
            foreach($lines as $line){
                $str = explode("<>",$line);
                echo $str[0]." ".$str[1]." ".
                $str[2]." ".$str[3]."<br>";
            }
    }
?>
</body>
</html>