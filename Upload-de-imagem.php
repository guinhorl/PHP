//upload da imagem perfil
if (isset($_POST['enviarFoto'])) {
    try {
        $formatos = array("png", "jpeg", "jpg");
        $extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
        if (in_array($extensao, $formatos)) {
            $pasta = "../imagensPerfil/";
            $temporario = $_FILES['arquivo']['tmp_name'];
            $novoNome = uniqid() . ".$extensao";
            if (move_uploaded_file($temporario, $pasta . $novoNome)) {
                $id = $_SESSION['id_usuario'];//Pegando os dados do user logado
                $sql = "SELECT * FROM usuario WHERE id = '$id'";
                $resultado = mysqli_query($conexao, $sql);
                if (mysqli_num_rows($resultado) > 0) {//Verificar se existe o mesmo email
                    //$sql ="UPDATE usuario SET nome_user = '', email = '', senha = '', cod_video = '', foto_perfil = '', pais = '', idade = '' WHERE id = '$id'";
                    $sql = "UPDATE usuario SET foto_perfil = '$novoNome' WHERE id = '$id'";
                    if (mysqli_query($conexao, $sql)) {
                        $_SESSION['mensagem'] = "<div class='alert alert-success '> Foto alterada com sucesso! </div>";
                        header('Location: ../perfil.php');
                    }
                }
                $_SESSION['mensagem'] = "<div class='alert alert-danger m-2'> ERRO AO CARREGAR!! </div>";
                header('Location: ../perfil.php');
            } else {
                $_SESSION['mensagem'] = "<div class='alert alert-danger m-2'> ERRO AO CARREGAR!! </div>";
                header('Location: ../perfil.php');
            }
        } else {
            $_SESSION['mensagem'] = "<div class='alert alert-danger m-2'> Formato não permitido tente <strong>PNG, JPEG, JPG !</strong> </div>";
            header('Location: ../perfil.php');
        }
    } catch (Exception $e) {
        $_SESSION['mensagemFoto'] = $e;
    } finally {
        mysqli_close($conexao);//Fechar conexão
    }
}