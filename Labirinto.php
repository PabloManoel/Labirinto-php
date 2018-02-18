<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html" charset="utf-8" />
        <title> </title>
        
    </head>
    <body style="background-color:#F0F8FF">
      
        <!--Indice do labirinto -->
        <table border="1" bordercolor="blue" cellspacing="0" cellpadding="5" align="center" style="margin-top:20px; margin-bottom:10px;">
            <tr><td style="background-color:#5F9EA0; width:25px"></td><td> ← Trajeto</td>
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
        
        
        <!-- -------------------------------- PHP ------------------------------------ -->
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                
                /*pega o valor inserido pelo usuario -- por praticidade vou retirar e adicionar valores aleatorios
                $qtdLinha = $_POST["tLinha"];
                $qtdColuna = $_POST["tColuna"];
                */
                $qtdLinha = rand(6,10);
                $qtdColuna = rand(10,15);
                

                // DEFINE CAMINHO, PAREDE E LIMITE
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
                
                $lab[$entrada][0] =0; // ERA 2
                $lab[$saida][$qtdColuna-1] = 3;
                // ---
                
                // retira parede da frente da entrada/saida
                $lab[$entrada][1] = 0;
                $lab[$saida][$qtdColuna-2] = 0;
                // ---
                
                //exibelab($lab, $qtdLinha, $qtdColuna);
                
                caminho ($lab, $qtdLinha, $qtdColuna, $entrada, $saida);
                
                
            } //TERMINA FUNCAO POST
        
        // --------------------------------- FUNCOES --------------------------------- //
        
        // EXIBE LAB
        function exibeLab($lab, $qtdLinha, $qtdColuna){
            echo '<table border="0" cellspacing="1" cellpadding="20" align="center" style="margin-top:20px;"   >';
            for ($l=0; $l<$qtdLinha; $l++){
                echo '<tr>';
                for ($c=0; $c<$qtdColuna; $c++){
                    if ($lab[$l][$c] == 0){
                        echo '<td style="background-color:white"></td>';
                    }elseif ($lab[$l][$c] == 1){
                        echo '<td style="background-color:black"></td>';
                    }elseif ($lab[$l][$c] == 3){
                        echo '<td style="background-color:red"></td>';
                    }elseif ($lab[$l][$c] == 4){
                        echo '<td style="background-color:black"></td>';
                    }elseif ($lab[$l][$c] == 5){
                        echo '<td style="background-color:#5F9EA0;"></td>';
                    }
                }
                echo '</tr>';
            }
            echo "</table>";
        }
        
        
        
        function caminho($lab, $qtdL, $qtdC, $entrada, $saida){
            analisaCaminho($lab, $qtdL, $qtdC, $entrada, 0, $saida, $qtdC-1, $entrada, 0);
        }
        
        // 0-Caminho | 1-muro | 2-? | 3-saida | 4-muro | 5-Percorrido
        function analisaCaminho($lab, $qtdL, $qtdC, $pLI, $pCI, $pLF, $pCF, $pLA, $pCA){     
            if ($pLA == $pLF && $pCA == $pCF){
                exibelab($lab, $qtdL, $qtdC);
            }else{
                $lab[$pLA][$pCA] = 5;

                    //define vizinhança
                    for($c = -1; $c <= +1; $c++){
                        for($l = -1; $l <= +1; $l++){
                            $liA = $pLA+ $c; // linha atual
                            $coA = $pCA+ $l; // coluna atual
                            
                            //verifica se está dentro dos limites
                            if ( ($liA > 0 && $liA <=$qtdL-1) && ($coA > 0 && $coA <= $qtdC-1)  ){                   
                                // verifica se EXISTE, e se é caminho ou saida
                                if (isset($lab[$liA][$coA]) && ( $lab[$liA][$coA] == 0 || $lab[$liA][$coA] == 3 )){     
                                    // exclui diagonais
                                    if ($c * $l == 0){
                                        //exclui limites
                                        if ($lab[$liA][$coA] != 4){   
                                            analisaCaminho($lab, $qtdL, $qtdC, $pLI, $pCI, $pLF, $pCF, $liA,$coA);
                                        }
                                    }
                                }
                            } // fim limites
                            
                        }
                    }
                    // e se eu resetar o caminho aqui?   
            }
        }
       
        ?>
        
    
    </body>
    
</html>