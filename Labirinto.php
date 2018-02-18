<?php

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html" charset="utf-8" />
        <title> </title>
        
    </head>
    <body>
        <!-- 
        <table border="1" cellspacing="0" cellpadding="30" align="center" style="margin-top:100px;">
            <tr><td>X </td> <td>X </td> <td>X </td> <td>X </td> <td>X </td> </tr>
            <tr><td>X </td> <td>X </td> <td>X </td> <td>X </td> <td>X </td> </tr>
            <tr><td>X </td> <td>X </td> <td>X </td> <td>X </td> <td>X </td> </tr>
            <tr><td>X </td> <td>X </td> <td>X </td> <td>X </td> <td>X </td> </tr>
            <tr><td>X </td> <td>X </td> <td>X </td> <td>X </td> <td>X </td> </tr>
        </table>
        -->
        
        
        <!--Indice do labirinto -->
        <table border="1" bordercolor="blue" cellspacing="0" cellpadding="5" align="center" style="margin-top:20px; margin-bottom:10px;">
            <tr><td style="background-color:gray; width:25px"></td><td> ← Limite</td>
                <td style="background-color:black; width:25px"></td><td> ← Muro</td>
                <td style="background-color:red; width:25px"></td><td> ← Saída</td>
            </tr>
        </table>
        
        <form method="POST" align="center">
            
            <!-- CAIXAS PARA USUARIO DIGITAR O TAMANHO DO LABIRINTO
            <label for="cLinha">Linhas: </label><input type="number" name="tLinha" id="cLinha" min="5" max="15">
            <label for="cColuna">Colunas: </label><input type="number" name="tColuna" id="cColuna" min="5" max="15">
            --> 
            
            <input type="submit" value="GERAR LABIRINTO"> 
        </form>
        
        
        
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                
                /*pega o valor inserido pelo usuario -- por praticidade vou retirar e adicionar valores aleatorios
                $qtdLinha = $_POST["tLinha"];
                $qtdColuna = $_POST["tColuna"];
                */
                $qtdLinha = rand(15,25);
                $qtdColuna = rand(30,70);
                
                /* Declara array multidimensional com 0
                for ($l=0; $l<$qtdLinha; $l++){
                    $lab[$l] = array();
                    for ($c=0; $c<$qtdColuna; $c++){
                        $lab[$l][$c] = 0;                
                    }
                }
                */
                
                
                
                // 0 é livre, 1 é parede
                for ($l=0; $l<$qtdLinha; $l++){
                    $lab[$l] = array();
                    for ($c=0; $c<$qtdColuna; $c++){
                        if ($l == 0 || $l == $qtdLinha-1 || $c == 0 || $c == $qtdColuna-1){
                            $lab[$l][$c] = 4;
                        }else{
                            
                            //verificar se existem dois vizinhos brancos em volta
                            $paredeVizinha= 0;
                            
                            for ($vetX = $l-1; $vetX <= $l+1; $vetX++){
                                for ($vetY = $c-1; $vetY <= $c+1; $vetY++){
                                    //verifica se existe a posicao do array
                                    if(isset($lab[$vetX][$vetY])){
                                        // verifica se é caminho ----- como verificar se estou olhando diagonal?
                                        if($lab[$vetX][$vetY] == 1){
                                            $paredeVizinha++;                                            
                                        }
                                    }   
                                }
                            }
                            
                            if ($paredeVizinha > 1){
                                $lab[$l][$c] = 0;
                            }else{
                                $lab[$l][$c] = rand(0,1);
                            }
                            
                            //
                        
                            //$lab[$l][$c] = rand(0,1);    
                        }
                    }
                }
                // ---
                
                /* define entrada e saida */
                $entrada = rand(1,$qtdLinha-2);
                $saida = rand(1,$qtdLinha-2);
                
                $lab[$entrada][0] = 2;
                $lab[$saida][$qtdColuna-1] = 3;
                // ---
                
                // retira parede da frente da entrada/saida
                $lab[$entrada][1] = 0;
                $lab[$saida][$qtdColuna-2] = 0;
                //
                
                
                echo '<table border="0" cellspacing="0" cellpadding="8" align="center" style="margin-top:20px;"   >';
                for ($l=0; $l<$qtdLinha; $l++){
                    echo '<tr>';
                    for ($c=0; $c<$qtdColuna; $c++){
                        if ($lab[$l][$c] == 0){
                            echo '<td></td>';
                        }elseif ($lab[$l][$c] == 1){
                            echo '<td style="background-color:black"></td>';
                        }elseif ($lab[$l][$c] == 2){
                            echo '<td style="background-color:white"></td>';
                        }elseif ($lab[$l][$c] == 3){
                            echo '<td style="background-color:red"></td>';
                        }else{
                            echo '<td style="background-color:gray"></td>';
                        }
                    }
                    echo '</tr>';
                }
                echo "</table>";
                
                
                /* tabela a partir dos dados do usuario 
                echo '<table border="1" cellspacing="0" cellpadding="30" align="center" style="margin-top:100px;"   >';
                for ($x = 1; $x <= $qtdLinha; $x++){
                    echo '<tr>';
                    for ($y = 1; $y <= $qtdColuna; $y++){
                        echo '<td> X </td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
                */
                
                //echo var_dump($lab);
            }
                
        ?>
        
    
    </body>
    
</html>