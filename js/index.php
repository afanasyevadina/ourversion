<?php
require_once('../prepare.php');
if (!isset($role)) {
    header('Location:/en/login.php');
}
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
if(isset($_GET['college'])) {
        $count=$pdo->prepare('SELECT COUNT(*) FROM `students` WHERE `College`=:college');
        $count->execute(['college'=>$_GET['college']]); 
    if (isset($_GET['page'])) {
        $result=$pdo->prepare('SELECT * FROM `students` WHERE `College`=:college LIMIT :page, 100');
        $result->execute(['college'=>$_GET['college'], 'page'=>$_GET['page']*100-100]); 
    }
    else {
        $result=$pdo->prepare('SELECT * FROM `students` WHERE `College`=:college LIMIT 100');
        $result->execute(['college'=>$_GET['college']]); 
    }
}
else {
    $count=$pdo->query('SELECT COUNT(*) FROM students');
    if(!isset($_GET['search'])) {
        if (isset($_GET['page'])) { 
            $result=$pdo->prepare('SELECT * FROM `students` LIMIT :page, 100');
            $result->bindParam(':page', $page);
            $page=$_GET['page']*100-100;
            $result->execute(); 
        }
        else {
            $result=$pdo->query("SELECT * FROM students LIMIT 100");
        }
    }
else {
    $count=$pdo->prepare('SELECT COUNT(*) FROM `students` WHERE (`Surname` LIKE :surname OR `Name` LIKE :name OR `Otchestvo` LIKE :otchestvo) AND `StartYear` LIKE :startyear AND `FinishYear` LIKE :finishyear');
    $count->execute(['surname'=>'%'.$_GET['search'].'%', 
                      'name'=>'%'.$_GET['search'].'%', 
                      'otchestvo'=>'%'.$_GET['search'].'%',
                      'startyear'=>'%'.substr($_GET['yearenter'],2), 
                      'finishyear'=>'%'.substr($_GET['yearleave'],2)]); 
    if (isset($_GET['page'])) {
        $result=$pdo->prepare('SELECT * FROM `students` WHERE (`Surname` LIKE :surname OR `Name` LIKE :name OR `Otchestvo` LIKE :otchestvo)AND `StartYear` LIKE :startyear AND `FinishYear` LIKE :finishyear LIMIT :page, 100');
        $result->execute(['surname'=>'%'.$_GET['search'].'%', 
                      'name'=>'%'.$_GET['search'].'%', 
                      'otchestvo'=>'%'.$_GET['search'].'%',
                      'startyear'=>'%'.substr($_GET['yearenter'],2), 
                      'finishyear'=>'%'.substr($_GET['yearleave'],2),
                      'page'=>$_GET['page']*100-100]); 
    }
    else {
    $result=$pdo->prepare('SELECT * FROM `students` WHERE (`Surname` LIKE :surname OR `Name` LIKE :name OR `Otchestvo` LIKE :otchestvo) AND `StartYear` LIKE :startyear AND `FinishYear` LIKE :finishyear LIMIT 100');
    $result->execute(['surname'=>'%'.$_GET['search'].'%', 
                      'name'=>'%'.$_GET['search'].'%', 
                      'otchestvo'=>'%'.$_GET['search'].'%',
                      'startyear'=>'%'.substr($_GET['yearenter'],2), 
                      'finishyear'=>'%'.substr($_GET['yearleave'],2)]); 
    }
}
}
if(!$result)
header('Location:notfound.php');
$cnt=$count->fetchColumn();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" type="text/css" href="../Content/bootstrap.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css"/>
    <!--<script src="Content/script.js"></script>-->
</head>
<body>
    <?php
    require_once('header.php');
    ?>
    <div class="container">
        <div class="pagecontainer">
        <span class="pager">Page</span>
<?php

$college=(isset($_GET['college']))?'college='.$_GET['college'].'&':'';
$search=(isset($_GET['search']))?'search='.$_GET['search'].'&yearenter='.$_GET['yearenter'].'&yearleave='.$_GET['yearleave'].'&':'';
if (isset($_GET['page'])) {
    if($cnt>1000) {
        if ($_GET['page']<=7) {
            for ($i=1; $i <=10 ; $i++) { 
                if($i==$_GET['page']) echo '<span class="pager">'.$i.'</span>';
                else echo '<a href="?'.$college.$search.'page='.$i.'" class="pager">'.$i.'</a>';
            }
            echo ' ... <a href="?'.$college.$search.'page='.strval($cnt/100).'" class="pager">'.ceil($cnt/100).'</a>';
        }
        else {
            if ($_GET['page']>=$cnt/100-7) {
                echo '<a href="?'.$college.$search.'page=1" class="pager">1</a> ... ';
                for ($i=ceil($cnt/100-10); $i <=ceil($cnt/100) ; $i++) { 
                    if($i==$_GET['page']) echo '<span class="pager">'.$i.'</span>';
                    else echo '<a href="?'.$college.$search.'page='.$i.'" class="pager">'.$i.'</a>';
                }
            }
            else {
                echo '<a href="?'.$college.$search.'page=1" class="pager">1</a> ... ';
                for ($i=$_GET['page']-5; $i <=$_GET['page']+5 ; $i++) { 
                    if($i==$_GET['page']) echo '<span class="pager">'.$i.'</span>';
                    else echo '<a href="?'.$college.$search.'page='.$i.'" class="pager">'.$i.'</a>';
                }
                echo ' ... <a href="?'.$college.$search.'page='.strval($cnt/100).'" class="pager">'.ceil($cnt/100).'</a>';
            }
        }
    }
    else {
        for ($i=1; $i <=ceil($cnt/100) ; $i++) { 
            if($i==$_GET['page']) echo '<span class="pager">'.$i.'</span>';
            else echo '<a href="?'.$college.$search.'page='.$i.'" class="pager">'.$i.'</a>';
        }
    }
}
else {
    $j=($cnt>1000)?10:ceil($cnt/100);
    for ($i=1; $i <=$j ; $i++) { 
        if($i==1) echo '<span class="pager">'.$i.'</span>';
        else echo '<a href="?'.$college.$search.'page='.$i.'" class="pager">'.$i.'</a>';
    }
    if($cnt>1000) echo ' ... <a href="?'.$college.$search.'page='.ceil($cnt/100).'" class="pager">'.ceil($cnt/100).'</a>';
}
?>
</div>
<table class="table">   
    <tr>
        <th>Surname</th>
        <th>Name</th>
        <th>Patronymic</th>
        <th>Born</th>
        <th>Gender</th>
        <th>College start date</th>
        <th>Specialization</th>
        <th>College graduation date</th>
        <th>Name of the institution</th>
    </tr>

  
    <?php
    while ($student=$result->fetch()) { ?>
        <tr>
            <td><?=$student['Surname']?></td>
            <td><?=$student['Name']?></td>
            <td><?=$student['Otchestvo']?></td>
            <td><?=$student['Born']?></td>
            <td><?=$student['Gender']?></td>
            <td><?=$student['StartYear']?></td>
            <td><?=$student['Specialization']?></td>
            <td><?=$student['FinishYear']?></td>
            <td><?=$student['College']?></td>
            <?php if(isset($role)) { ?>
            <td><a href="edit.php?id=<?=$student['Id']?>" title="Edit"><i class="fas fa-pen"></i></a></td>
            <td><a href="delete.php?id=<?=$student['Id']?>" title="Delete"><i class="far fa-trash-alt"></i></a></td>
            <td><a href="details.php?id=<?=$student['Id']?>" title="Details"><i class="fas fa-ellipsis-v"></i></a></td>
            <td><a href="../spravka.php?id=<?=$student['Id']?>" title="Get a certificate"><i class="far fa-file-alt"></i></a></td>
            </tr>
     <?php } 
 }?>

</table>
<div class="pagecontainer">
<span class="pager">Page</span>
<?php
if (isset($_GET['page'])) {
    if($cnt>1000) {
        if ($_GET['page']<=7) {
            for ($i=1; $i <=10 ; $i++) { 
                if($i==$_GET['page']) echo '<span class="pager">'.$i.'</span>';
                else echo '<a href="?'.$college.$search.'&page='.$i.'" class="pager">'.$i.'</a>';
            }
            echo ' ... <a href="?'.$college.$search.'&page='.strval($cnt/100).'" class="pager">'.ceil($cnt/100).'</a>';
        }
        else {
            if ($_GET['page']>=$cnt/100-7) {
                echo '<a href="?'.$college.$search.'&page=1" class="pager">1</a> ... ';
                for ($i=ceil($cnt/100-10); $i <=ceil($cnt/100) ; $i++) { 
                    if($i==$_GET['page']) echo '<span class="pager">'.$i.'</span>';
                    else echo '<a href="?'.$college.$search.'&page='.$i.'" class="pager">'.$i.'</a>';
                }
            }
            else {
                echo '<a href="?'.$college.$search.'&page=1" class="pager">1</a> ... ';
                for ($i=$_GET['page']-5; $i <=$_GET['page']+5 ; $i++) { 
                    if($i==$_GET['page']) echo '<span class="pager">'.$i.'</span>';
                    else echo '<a href="?'.$college.$search.'&page='.$i.'" class="pager">'.$i.'</a>';
                }
                echo ' ... <a href="?'.$college.$search.'&page='.strval($cnt/100).'" class="pager">'.ceil($cnt/100).'</a>';
            }
        }
    }
    else {
        for ($i=1; $i <=ceil($cnt/100) ; $i++) { 
            if($i==$_GET['page']) echo '<span class="pager">'.$i.'</span>';
            else echo '<a href="?'.$college.$search.'&page='.$i.'" class="pager">'.$i.'</a>';
        }
    }
}
else {
    $j=($cnt>1000)?10:ceil($cnt/100);
    for ($i=1; $i <=$j ; $i++) { 
        if($i==1) echo '<span class="pager">'.$i.'</span>';
        else echo '<a href="?'.$college.$search.'&page='.$i.'" class="pager">'.$i.'</a>';
    }
    if($cnt>1000) echo ' ... <a href="?'.$college.$search.'&page='.ceil($cnt/100).'" class="pager">'.ceil($cnt/100).'</a>';
}
?>
</div>
        <hr />
    </div> 

        <footer>
            <p>&copy; 2018 - Pavlodar business-college</p>
            <a href="contacts.php">Feedback</a>
        </footer>  
</body>
</html>