//Editar do USUÁRIO
if (isset($_POST['enviarUpdate'])) {
    try {
        $id = $_SESSION['id_usuario'];//Pegando os dados do user logado
        $nome = mysqli_escape_string($conexao, $_POST['editarNome']);
        $email = mysqli_escape_string($conexao, $_POST['editarEmail']);
        $senha = mysqli_escape_string($conexao, $_POST['editarSenha']);
        $idade = mysqli_escape_string($conexao, $_POST['editarIdade']);
        $pais = mysqli_escape_string($conexao, $_POST['editarPais']);

        $sql = "SELECT * FROM usuario WHERE id = '$id'";
        $resultado = mysqli_query($conexao, $sql);
        if (mysqli_num_rows($resultado) > 0) {//Verificar se existe o mesmo email
            $senha = base64_encode($senha);
            $sql = "UPDATE usuario SET nome_user = '$nome', senha = '$senha', pais = '$pais', idade = '$idade' WHERE id = '$id'";

            if (mysqli_query($conexao, $sql)) {

                header('Location: ../perfil.php');
            }
        }
    } catch (Exception $e) {

    } finally {
        mysqli_close($conexao);//Fechar conexão
    }
}