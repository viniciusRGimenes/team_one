<!DOCTYPE html>

<head>
    <meta charset="utf-8">
   
    <title>Team One</title>
    <style>
        table,td,th {
            border: 1px solid black;
            border-collapse: collapse;
        }
        td,th {
            padding: 10px;
        }
        th {
            text-align: left;
            background-color: black;
            color: white;
        }
        tr:nth-child(even) {
            background-color: whitesmoke;
        }
        tr:nth-child(odd) {
            background-colorgit: white;
        }
    </style>
</head>
<body>
    <h1>Team One</h1>

    <p>Gerenciador de Usuários</p>
    
    <form action="index.php" method="post">

        <input name="nome_completo" type="text" value="" required autofocus placeholder="Nome Completo"/><br><br>

        <input name="nome_acesso" type="text" value="" required placeholder="Nome de Acesso"/><br><br>

        <input name="senha" type="password" value="" required placeholder="Senha"/><br><br>

        <input name="botao_adicionar" type="submit" value="Adicionar"><br><br>
    </form>

    <?php

        $servidor = "team_one_db_1";
        $usuario = "root";
        $senha = "phprs";
        $table = "usuarios";

        $connection = new mysqli($servidor, $usuario, $senha, $table);

        if($connection->connect_error){
            die("Falha de conexão: " . $connection->connect_error);
        }


        # Tratar dados enviados via GET para excluir registro.
        if($_GET["id"]!=""){
            $sql = "DELETE FROM usuarios WHERE id = ".$_GET["id"];
            if($connection->query($sql)===TRUE){
                echo "Registro excluído com sucesso!";
            }else{
                echo "Ocorreu um erro:".$sql."<br/>".$connection->error;
            }
        }
    
        # Tratar dados enviados via POST para excluir registro.

        # Tratar dados enviados para a página. data send to index
        if($_POST["nome_completo"]!= ""){
            $sql = "INSERT INTO usuarios (nome_completo, nome_acesso, senha, status) VALUES ('".utf8_encode($_POST["nome_completo"])."', '".utf8_encode($_POST["nome_acesso"])."','".utf8_encode($_POST["senha"])."', 0)";         
            if($connection->query($sql)===TRUE){
                echo "Usuario adicionado!";
            }else{
                echo "Ocorreu um erro:".$sql."<br/>".$connection->error;
            }
        }


        # Recover all register of tickets table.
        $sql = "SELECT * FROM usuarios";
        $result = $connection->query($sql);
    ?>

        <?php
            if($result->num_rows > 0){
                ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nome Completo</th>
                        <th>Nome de Acesso</th>
                        <th>Senha</th>
                        <th>Status</th>
                        <th>&nbsp;</th>
                    </tr>
                <?php
                    while($row = $result->fetch_assoc()){
                        echo"<tr>";
                        echo"<td>". $row["id"]."</td>";
                        echo"<td>". utf8_decode($row["nome_completo"])."</td>";
                        echo"<td>". utf8_decode($row["nome_acesso"])."</td>";
                        echo"<td>". $row["senha"]."</td>";
                        echo"<td>";
                        if($row["status"]==0){
                            echo "Inativo";
                        }else{
                            echo"Ativo";
                        }
                        ?>
                        <td>
                        <a href="index.php?id=<?=$row["id"]?>">APAGAR</a>
                        </td>
                        <?php
                        echo"</td>";
                        echo"</tr>";
                    }
                ?> 
                </table>
                <?php
                    }else{
                        echo "Empty register.";
                    }

                    $connection->close();

                ?>
  
</body>
</html>
