<?php
session_start();
include_once 'painel/conf/classLoader.php';
include_once 'config/connection.php';

$menuClass = array("active","","");
$title = "Meu Carrinho";
$produtoController = new ProdutoFrontController();

include("inc/header_site.php");
?>
<script type="text/javascript">
jQuery(function($){
   $("#cepCliente").mask("99999-999");
});
</script>
	<div class="row login carrinho">
    	<div class="span12 titPagina">
        	<span class="titulo">LISTA DE COMPRAS</span><span class="subtitulo" style="margin-left:385px;">Quantidade</span><span class="subtitulo" style="margin-left:120px;">Valor</span>
        </div>
        <div class="span12">
        	<form name="carrinhoForm" method="post" action="resumoPedido.php">
                <table class="table table-striped table-bordered" style="width:900px; margin-left:30px;">
                    <?php
                    if ($_SESSION['InstagiftTipoLogin'] == 'Insta'){
                        $username = ($_SESSION['InstagiftDadosInsta']['data']['username']);
                        $origem = '1';
                    }else {
                        $username = ($_SESSION['InstagiftDadosUserFb']['username']);
                        $origem = '2';
                    }
                    $status = '1';
                    $chartAction = new ChartController();
                    $chartProdutcts = $chartAction->listActionChart($username, $origem, $status);
                    
                    foreach($chartProdutcts as $k => $v){
                            $chart = new Chart();
                            $objFixed = $chart->fetchEntity($v);
    
                            $prdList = $produtoController->listAction($objFixed->getPrdId(), false);
                            foreach ($prdList as $kProd => $vProd){
                                    $foto = $vProd->getFoto(true);
    
                                    $nomeProd = $vProd->getNome();
                            }
                            $nomeModelo = $objFixed->getNome();
                            $quantidade = $objFixed->getQuantidade();
                            $valor = $objFixed->getValor();
                            $valor = str_replace('.', ',', $valor);
    
                            echo "<tr style='height:83px;'>
                                    <td style='width:110px; padding:0;'><img src='images/uploads/produtos/produto/".$foto."' width='110' height='83' class='imgCarrinho'/></td>
                                    <td style='width:400px;'>
                                    <div class='infosProd'>
                                    <span class='nomeProd'>".$nomeProd."</span><br><span class='nomeModelo'>".$nomeModelo.
                                    "</span>
                                    </div>
                                    <div class='remProd'>
                                        <a href='excluirProdutoCarrinho.php?id=".$objFixed->getId()."' style='border:none;'><img src='images/site/btn-remover.png' alt='Remover' /></a>
                                    </div>
                                    </td>
                                    <td style='text-align:center; padding-top:28px; width:180px;'>
                                        <div class='input-append'>
                                            <input readonly='readonly' style='width:30px' id='quantidade_".$objFixed->getId()."' type='text' value='".$quantidade."' class='inputQtde' />
                                            <input class='btn' type='button' value='+' onclick=alteraQtde('" .$objFixed->getId()."','add') />
                                            <input class='btn' type='button' value = '-' onclick=alteraQtde('" .$objFixed->getId()."','rm') />
                                        </div>
                                    </td>
                                    <td style='text-align:center;'><div class='valorProd'><span id='valor_".$objFixed->getId()."'>R$ ".$valor."</span></div></td>
                                    </tr>";
                    }
            ?>
                    <tr style="height:83px;">
                        <td colspan="2" style="text-align:right; padding-right:15px; padding-top:30px;"><span class="descCep">Calcule o valor da entrega preenchendo seu CEP</span></td>
                        <td style="padding-top:20px;"><input id="cepCliente" name="cepCliente" type="text" class="inputCep" /><img src="images/site/btn-calculo-cep.png" alt="Calcular" onclick="calcularCep();" class="btnCalculaCep" /></td>
                        <td style="text-align:center;">
                        	<div id="loadingCep"></div>
                        	<div class="valorProd" id="opcoesFrete" style="display:none;">
                                	<label class="radio">
                                    <input type="radio" name="optFrete" id="optFretePac" value="pac">
                                    <span id="valorCepPac">Pac</span>
                                    </label>
                                    
                                    <label class="radio">
                                    <input type="radio" name="optFrete" id="optFreteSedex" value="sedex">
                                    <span id="valorCepSedex">Sedex</span>
									</label>
                            </div>
                       	</td>
                    </tr>
                    <tr style="height:83px;">
                        <td colspan="2" style="text-align:right; padding-right:15px; padding-top:30px;"><span class="descCep">Se possuir um cupom de desconto digite o código aqui</span></td>
                        <td style="padding-top:20px;"><input id="codigoCupom" name="codigoCupom" type="text" class="inputCep" /><img src="images/site/btn-calculo-cep.png" alt="Calcular" onclick="verificarCupom();" class="btnCalculaCep" /></td>
                        <td style="text-align:center;">
                        	<div id="loadingCupom"></div>
                        	<div class="valorProd" id="resultadoCupom"></div>
                       	</td>
                    </tr>
                </table>
            <div class="botoesNav span12">
            	<a href="produtos.php" class="btnEsq" alt="Comprar mais">Comprar mais</a>
                <a onclick="validaCarrinho();" class="btnDir" alt="Resumo do Pedido">Resumo do Pedido</a>
            </div>
            </form>
        </div>
    </div>
<?php
include("inc/footer_site.php");
?>