<?php
    session_start();// início da sessão
        if(!isset($_SESSION['username'])){// se não existir a sessão
            header('location: guest/index.php');// redireciona para a página de login
        }elseif(isset($_SESSION['username'])=="admin"){// se existir a sessão e o valor for igual a admin
            header('location: admin/index.php');// redireciona para a página de admin
        }else{// se não for admin
            header('location: user/index.php');// redireciona para a página de usuário
        }
?>