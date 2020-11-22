<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>IADireito</title>
  </head>
  <body>
    <form action="/login" method="post">
      <label for="username">Usuário: </label>
      <input type="text" name="username" placeholder="Usuário" />
      <label for="password">Senha: </label>
      <input type="password" name="password" placeholder="Senha" />
      <br />
      <br />
      <input type="reset" value="Limpar" />
      <input type="submit" value="Entrar" />
    </form>
  </body>
</html>
