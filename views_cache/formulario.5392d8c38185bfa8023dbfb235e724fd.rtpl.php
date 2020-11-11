<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" content="width=device-width, initial-scale=1.0" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="./res/style/style.css" />
    <link
      href="ContatoEstilo.css"
      rel="stylesheet"
      type="text/css"
      media="print"
    />
    <link
      rel="stylesheet"
      href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"
    />
    <link rel="stylesheet" href="../res/style/style.css" />

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>

  <body>
    <form action="/submit-summons" method="post" autocomplete="off">
      <h1 align="center">Dados Processuais</h1>
      <br />
      <div class="parent">
        <div class="conteudo">
          <label for="conteúdo">Nota de expediente:</label>
          <br /><br />
          <textarea
            id="conteudo"
            name="conteudo"
            rows="45"
            cols="50"
            align="center"
          >
            <?php echo htmlspecialchars( $summons["conteudo"], ENT_COMPAT, 'UTF-8', FALSE ); ?>
          </textarea>
        </div>

        <div class="dados">
          <label for="estrutura">Estrutura:</label>
          <select name="estrutura" id="estrutura">
            <?php $counter1=-1;  if( isset($estrutura_jud) && ( is_array($estrutura_jud) || $estrutura_jud instanceof Traversable ) && sizeof($estrutura_jud) ) foreach( $estrutura_jud as $key1 => $value1 ){ $counter1++; ?>
            <option value="<?php echo htmlspecialchars( $value1["est_id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["est_descricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
            <?php } ?>
          </select>
          <br /><br />
          <label for="n_processo">Número do processo:</label>
          <input type="text" id="n_processo" name="n_processo" />
          <br /><br />
          <label for="natureza">Natureza:</label>
          <select name="natureza" id="natureza">
            <?php $counter1=-1;  if( isset($natureza) && ( is_array($natureza) || $natureza instanceof Traversable ) && sizeof($natureza) ) foreach( $natureza as $key1 => $value1 ){ $counter1++; ?>
            <option value="<?php echo htmlspecialchars( $value1["nat_id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["nat_descricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
            <?php } ?>
          </select>
          <br /><br />
          <label name="vara">Vara:</label>
          <input type="text" id="vara" name="vara" maxlength="2" size="3" />
          <br /><br />
          <label for="vara">Estado:</label>
          <select name="estado" id="estado" onchange="buscaCidades(this.value)">
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
          <br /><br />
          <label for="vara">Comarca:</label>
          <select id="cidade" name="cidade"></select>
          <br /><br />
          <label for="juiz">Juiz:</label>
          <input type="text" id="juiz" name="juiz" maxlength="30" size="30" />
          <br /><br />
          <div class="input_fields_wrapA">
            <button class="add_field_buttonA">Adicionar autor</button>
            <br /><br />
            <label for="autor">Autor:</label
            ><input type="text" name="autor[]" /><br /><br />
          </div>

          <div class="input_fields_wrapB">
            <button class="add_field_buttonB">
              Adicionar novo advogado do autor
            </button>
            <br /><br />
            <div>
              <label for="advautor">Advogado:</label
              ><input type="text" name="advautor[]" /><br /><br />
              <label for="oabadvautor">OAB:</label>
              <input type="text" name="oabadvautor[]" /><br /><br />
            </div>
          </div>

          <div class="input_fields_wrapC">
            <button class="add_field_buttonC">Adicionar réu</button>
            <br /><br />
            <label for="reu">Réu:</label
            ><input type="text" name="reu[]" /><br /><br />
          </div>

          <div class="input_fields_wrapD">
            <button class="add_field_buttonD">
              Adicionar novo advogado do réu
            </button>
            <br /><br />
            <div>
              <label for="advreu">Advogado:</label
              ><input type="text" name="advreu[]" /><br /><br />
              <label for="oabadvreu">OAB:</label>
              <input type="text" name="oabadvreu[]" /><br /><br />
            </div>
          </div>

          <label for="recurso">Tipo de decisão:</label>
          <select name="recurso" id="recurso">
            <?php $counter1=-1;  if( isset($decisao_tipo) && ( is_array($decisao_tipo) || $decisao_tipo instanceof Traversable ) && sizeof($decisao_tipo) ) foreach( $decisao_tipo as $key1 => $value1 ){ $counter1++; ?>
            <option value="<?php echo htmlspecialchars( $value1["dec_id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["dec_descricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
            <?php } ?>
          </select>
          <br /><br />
          <label for="tipo_peca">Peça a produzir:</label>
          <select name="tipo_peca" id="tipo_peca">
            <?php $counter1=-1;  if( isset($peca_produzir) && ( is_array($peca_produzir) || $peca_produzir instanceof Traversable ) && sizeof($peca_produzir) ) foreach( $peca_produzir as $key1 => $value1 ){ $counter1++; ?>
            <option value="<?php echo htmlspecialchars( $value1["pec_id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["pec_descricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
            <?php } ?>
          </select>
          <br /><br />
          <label for="inicio_prazo">Início do Prazo:</label>
          <input
            type="date"
            id="datepicker"
            name="inicio"
            size="8"
            maxlength="10"
          />
          <br /><br />
          <label for="dias_prazo">Prazo:</label>
          <input
            type="text"
            id="dias_prazo"
            name="dias_prazo"
            size="2"
            maxlength="2"
          />
          <input type="radio" id="corridos" name="dias" value="corridos" />
          Dias corridos
          <input type="radio" id="uteis" name="dias" value="uteis" />
          Dias úteis
          <br /><br />
          <label for="prazo_final">Fim do prazo:</label>
          <input
            type="date"
            id="datepicker"
            name="fim"
            size="8"
            maxlength="10"
          />
          <br /><br />
          <label for="custas">Há custas?</label>
          <input
            type="radio"
            onclick="show1();"
            name="yesno"
            id="yesCheck"
            value="sim"
          />Sim
          <input
            type="radio"
            onclick="show2();"
            name="yesno"
            id="noCheck"
            value="nao"
          />Não <br /><br />
          <div class="hide" id="div1">
            <label for="custas" class>Valor a pagar:</label>
            <input type="text" id="custas" name="custas" />
          </div>
          <div class="hide" id="div2"></div>
        </div>
      </div>
      <div class="btn" align="center">
        <br /><input type="reset" name="b1" value="Limpar" />
        <input type="submit" name="b2" value="Enviar" />
      </div>
    </form>
    <script src="../res/script/script2.js"></script>
  </body>
</html>
