<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" content="width=device-width, initial-scale=1.0"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet"   href="../res/style/style.css">
</head>
<body>

  <form action="/submit-summons" method="post" autocomplete="off">
    <div class="parent">
      <h1 align="center">Dados Processuais</h1>
      <div>
        <table width="100%" id="dados">
          <tr>
            <td><label for="estrutura">Estrutura processual:</label></td>
            <td><select name="estrutura" id="estrutura">
                <option value="branco"> </option>
                <option value="federal">Federal</option>
                <option value="estadual">Estadual</option>
              </select></td>
          </tr>
          <tr>
            <td><label for="n_processo">Número CNJ:</label></td>
            <td><input type="text" id="n_cnj" name="n_cnj" size="20" maxlength="20"></td>
          </tr>
          <tr>
            <td><label for="n_processo">Processo número:</label></td>
            <td><input type="text" id="n_processo" name="n_processo"></td>
          </tr>
          <tr>
            <td><label for="natureza">Natureza:</label></td>
            <td><select name="natureza" id="natureza">
              <?php $counter1=-1;  if( isset($natureza) && ( is_array($natureza) || $natureza instanceof Traversable ) && sizeof($natureza) ) foreach( $natureza as $key1 => $value1 ){ $counter1++; ?>
                <option value="<?php echo htmlspecialchars( $value1["nat_value"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["nat_desc"], ENT_COMPAT, 'UTF-8', FALSE ); ?> </option>
              <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><label name="vara">Vara:</label></td>
            <td><input type="text" id="vara" name="vara"></td>
          </tr>
          <tr>
            <td><label for="vara">Estado:</label></td>
            <td><select name="estado" id="estado" onchange="buscaCidades(this.value)">
                <option value="branco"></option>
                <option value="AC">AC</option>
                <option value="AL">AL</option>
                <option value="AP">AP</option>
                <option value="AM">AM</option>
                <option value="BA">BA</option>
                <option value="CE">CE</option>
                <option value="DF">DF</option>
                <option value="ES">ES</option>
                <option value="GO">GO</option>
                <option value="MA">MA</option>
                <option value="MT">MT</option>
                <option value="MS">MS</option>
                <option value="MG">MG</option>
                <option value="PA">PA</option>
                <option value="PB">PB</option>
                <option value="PR">PR</option>
                <option value="PE">PE</option>
                <option value="PI">PI</option>
                <option value="RJ">RJ</option>
                <option value="RN">RN</option>
                <option value="RS">RS</option>
                <option value="RO">RO</option>
                <option value="RR">RR</option>
                <option value="SC">SC</option>
                <option value="SP">SP</option>
                <option value="SE">SE</option>
                <option value="TO">TO</option>
              </select>
            </td>
          </tr>
          <tr>
            <td><label for="vara">Comarca:</label></td>
            <td><select id="cidade" name="cidade"><select></td>
          </tr>
          <tr>
            <td><label for="juiz">Juiz:</label></td>
            <td><input type="text" id="juiz" name="juiz"></td>
          </tr>
          <tr>
            <td><label for="autor">Autor:</label></td>
            <td><input type="text" id="autor" name="autor"></td>
          </tr>
          <!--aqui tr para o botão de inserir adv-->
            <tr id="advbtn">
              <td></td>
              <td>
                <input type=button id="addAdv" value="Add Advogado">
                <input type=button id="excludeAdv" value="Excluir Advogado">
              </td>
            </tr>
          <!--fim tr botoes adv-->
          <tr>
            <td><label for="estado1">Estado:</label></td>
            <td><select name="estado1" id="estado1">
                <option value="branco"></option>
                <option value="AC">AC</option>
                <option value="AL">AL</option>
                <option value="AP">AP</option>
                <option value="AM">AM</option>
                <option value="BA">BA</option>
                <option value="CE">CE</option>
                <option value="DF">DF</option>
                <option value="ES">ES</option>
                <option value="GO">GO</option>
                <option value="MA">MA</option>
                <option value="MT">MT</option>
                <option value="MS">MS</option>
                <option value="MG">MG</option>
                <option value="PA">PA</option>
                <option value="PB">PB</option>
                <option value="PR">PR</option>
                <option value="PE">PE</option>
                <option value="PI">PI</option>
                <option value="RJ">RJ</option>
                <option value="RN">RN</option>
                <option value="RS">RS</option>
                <option value="RO">RO</option>
                <option value="RR">RR</option>
                <option value="SC">SC</option>
                <option value="SP">SP</option>
                <option value="SE">SE</option>
                <option value="TO">TO</option>
              </select></td>
          </tr>
          <tr>
            <td><label for="reu">Réu:</label></td>
            <td><input type="text" id="reu1" name="reu1"></td>
          </tr>
          <tr>
            <td><label for="advogado3">Advogado:</label></td>
            <td><input type="text" id="advogado4" name="advogado4"></td>
          </tr>
          <tr>
            <td><label for="autor">OAB:</label></td>
            <td><input type="text" id="oab4" name="oab4"></td>
          </tr>
          <tr>
            <td><label for="valor">Valor da causa:</label></td>
            <td><input type="text" id="valor" name="valor"></td>
          </tr>
          <tr>
            <td><label for="recurso">Tipo de decisão:</label></td>
            <td><select name="recurso" id="recurso">
              <?php $counter1=-1;  if( isset($tipo_decisao) && ( is_array($tipo_decisao) || $tipo_decisao instanceof Traversable ) && sizeof($tipo_decisao) ) foreach( $tipo_decisao as $key1 => $value1 ){ $counter1++; ?>
                <option value="<?php echo htmlspecialchars( $value1["tp_value"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["tp_desc"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
              <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><label for="tipo_peca">Peça a produzir:</label></td>
            <td><select name="recurso" id="recurso">
              <?php $counter1=-1;  if( isset($peca_produzir) && ( is_array($peca_produzir) || $peca_produzir instanceof Traversable ) && sizeof($peca_produzir) ) foreach( $peca_produzir as $key1 => $value1 ){ $counter1++; ?>  
              <option value="<?php echo htmlspecialchars( $value1["pec_value"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["pec_desc"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
              <?php } ?>  
              </select></td>
          <tr>
            <td><label for="inicio_prazo">Início do Prazo:</label></td>
            <td><input type="date" id="datepicker" name="início" size="8" maxlength="10"></td>
          </tr>
          <tr>
            <td><label for="dias_prazo">Prazo:</label></td>
            <td><input type="text" id="dias_prazo" name="dias_prazo" size="2" maxlength="2"> <input type="radio" id="corridos" name="yesno" value="corridos">
              <label for="corridos">Dias corridos</label>
              <input type="radio" id="uteis" name="yesno" value="uteis">
              <label for="corridos">Dias úteis</label><br></td>
          </tr>
          <tr>
            <td><label for="prazo_final">Data final do prazo:</label></td>
            <td><input type="date" id="datepicker" name="início" size="8" maxlength="10"></td>
          </tr>
          <tr>
            <td><label for="custas">Há pagamento de custas?</label></td>
  
            <td><input type="radio" onclick="show1();" name="yesno" id="yesCheck" value="sim">Sim
              <input type="radio" onclick="show2();" name="yesno" id="noCheck" value="nao">Não</td>
          </tr>
  
          <tr class="hide" id="tr1">
            <td><label for="custas" class>Valor a pagar:</label></td>
            <td><input type="text" id="custas" name="custas"></td>
          </tr>
  
          <tr class="hide" id="tr2">
          </tr>
        </table>
      </div>
      <div class="conteudo">
        <label for="conteúdo">Conteúdo da nota de expediente:</label><br>
        <textarea id="conteudo" name="conteudo" rows="44" cols="30"><?php echo htmlspecialchars( $summons["pub_conteudo"], ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea>
      </div>
      <br><br>
      <div align="center">
        <input type="reset" name="b1" value="Limpar">
        <input type="submit" name="b2" value="Enviar">
      </div>
  </form>
  <script src="../res/script/script.js"></script>
</body>
</html>