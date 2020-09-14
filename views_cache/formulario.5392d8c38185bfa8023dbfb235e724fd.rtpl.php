<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" content="width=device-width, initial-scale=1.0"/>
  <link href="ContatoEstilo.css" rel="stylesheet" type="text/css" media="print"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet"   href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  

<style>
form {
  margin: auto;
  width: 600px;
  min-height: 100%;
  font-family: arial, sans-serif;
  font-weight: normal;
  font-size: 9pt;
}

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

input {
	font-family: arial, sans-serif;
}
</style>

</head>
<body>

<h2 align="center">Dados Processuais</h2>
<form action="/action_page.php">
<div>
<table>
  <tr>
    <td><label for="estrutura">Estrutura processual:</label></td>
    <td><select name="estrutura" id="estrutura">
  <option value="federal">Selecione</option>
  <option value="federal">Federal</option>
  <option value="estadual">Estadual</option>
</select></td>
  </tr>
   <tr>
    <td><label for="n_processo">Processo número:</label></td>
    <td><input type="text" id="n_processo" name="n_processo"></td>
  </tr>
   <tr>
    <td><label for="natureza">Natureza:</label></td>
    <td><select name="natureza" id="natureza">
	<option value="federal">Selecione</option>
  <option value="administrativa">Administrativa</option>
  <option value="civil">Civil</option>
  <option value="penal">Penal</option>
  <option value="trabalhista">Trabalhista</option>
</select></td>
  </tr>
  <tr>
    <td><label name=for="vara">Vara:</label></td>
    <td><input type="text" id="vara" name="vara"></td>
  </tr>
  <tr>
    <td><label for="vara">Comarca:</label></td>
    <td><input type="text" id="comarca" name="comarca"></td>
  </tr>
  <tr>
    <td><label for="juiz">Juiz:</label></td>
    <td><input type="text" id="juiz" name="juiz"></td>
  </tr>
  <tr>
    <td><label for="autor">Autor1:</label></td>
    <td><input type="text" id="autor1" name="autor1"></td>
  </tr>
  <tr>
    <td><label for="autor">Autor2:</label></td>
    <td><input type="text" id="autor2" name="autor2"></td>
  </tr>
  <tr>
    <td><label for="autor">Autor3:</label></td>
    <td><input type="text" id="autor3" name="autor3"></td>
  </tr>
  <tr>
    <td><label for="advogado1">Advogado1:</label></td>
    <td><input type="text" id="advogado1" name="advogado1"></td>
  </tr>
  <tr>
    <td><label for="autor">OAB1:</label></td>
    <td><input type="text" id="oab1" name="oab1"></td>
  </tr>
  <tr>
    <td><label for="advogado2">Advogado2:</label></td>
    <td><input type="text" id="advogado2" name="advogado2"></td>
  </tr>
  <tr>
    <td><label for="autor">OAB2:</label></td>
    <td><input type="text" id="oab2" name="oab2"></td>
  </tr>
  <tr>
    <td><label for="advogado3">Advogado3:</label></td>
    <td><input type="text" id="advogado3" name="advogado3"></td>
  </tr>
  <tr>
    <td><label for="autor">OAB3:</label></td>
    <td><input type="text" id="oab3" name="oab3"></td>
  </tr>
  <tr>
    <td><label for="reu">Réu1:</label></td>
    <td><input type="text" id="reu1" name="reu1"></td>
  </tr>
  <tr>
    <td><label for="reu">Réu2:</label></td>
    <td><input type="text" id="reu2" name="reu2"></td>
  </tr>
  <tr>
    <td><label for="reu">Réu3:</label></td>
    <td><input type="text" id="reu3" name="reu3"></td>
  </tr>
  <tr>
    <td><label for="advogado3">Advogado4:</label></td>
    <td><input type="text" id="advogado4" name="advogado4"></td>
  </tr>
  <tr>
    <td><label for="autor">OAB4:</label></td>
    <td><input type="text" id="oab4" name="oab4"></td>
  </tr>
  <tr>
    <td><label for="advogado3">Advogado5:</label></td>
    <td><input type="text" id="advogado5" name="advogado5"></td>
  </tr>
  <tr>
    <td><label for="autor">OAB5:</label></td>
    <td><input type="text" id="oab5" name="oab5"></td>
  </tr>
  <tr>
    <td><label for="advogado3">Advogado6:</label></td>
    <td><input type="text" id="advogado6" name="advogado6"></td>
  </tr>
  <tr>
    <td><label for="autor">OAB6:</label></td>
    <td><input type="text" id="oab6" name="oab6"></td>
  </tr>
  <tr>
    <td><label for="conteúdo">Conteúdo:</label></td>
    <td><input type="text" multiline rows="30" id="conteudo" name="conteudo"></td>
  </tr>
  <tr>
    <td><label for="recurso">Recurso:</label></td>
    <td><select name="recurso" id="recurso">
	<option value="federal">Selecione</option>
  <option value="instrumento">Agravo de Instrumento</option>
  <option value="interno">Agravo Interno</option>
  <option value="infringentes">Agravo em Recurso Especial</option>
  <option value="infringentes">Agravo em Recurso Extraordinário</option>
  <option value="regimental">Agravo Regimental</option>
  <option value="apelacao">Apelação</option>
  <option value="carta">Carta Testemunhável</option>
  <option value="declaratorios">Embargos declaratórios</option>
  <option value="divergencia">Embargos de divergência</option>
  <option value="infringentes">Embargos infringentes</option>
  <option value="corpus">Habeas Corpus</option>
  <option value="data">Habeas Data</option>
  <option value="seguranca">Mandado de Segurança</option>
  <option value="manifestacao">Manifestação</option>
  <option value="rec_adm">Recurso administrativo</option>
  <option value="estrito">Recurso em Sentido Estrito</option>
  <option value="rec_especial">Recurso Especial</option>
  <option value="extraordinario">Recurso Extraordinário</option>
  <option value="ordinario">Recurso Ordinário</option>
  <option value="revisao">Revisão Criminal</option>
  <option value="revista">Recurso de Revista</option>
</select></td>
  </tr>
  <tr>
    <td><label for="inicio_prazo">Início do Prazo:</label></td>
    <td><input type="date" id="datepicker" name="início" size="8" maxlength="10"></td>
  </tr>
  <tr>
    <td><label for="dias_prazo">Prazo:</label></td>
    <td><input type="text" id="dias_prazo" name="dias_prazo" size="2" maxlength="2"></td>
  </tr>
  <tr>
    <td><label for="prazo_final">Data final do prazo:</label></td>
    <td><input type="text" id="prazo_final" name="prazo_final" size="7" maxlength="10"></td>
  </tr>
  
  
</table>
</div>
<br>
<div align="center">
<input type="reset"  name="b2" value="Limpar">
<input type="submit" name="b1" value="Enviar">
</div>
</form>
</body>
</html>