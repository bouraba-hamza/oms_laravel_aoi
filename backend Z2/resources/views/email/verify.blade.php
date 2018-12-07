<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
Hi  Bienvenue chez Opentech{{ $name }}, <br>

    voici votre email :{{$email}}  <br>

    voici votre mot de passe :{{$password}}


<br>
Merci pour l'enregistrement <br>
Cliquez sur le lien ci-dessous ou copiez-le dans la barre d'adresse de votre navigateur pour confirmer votre adresse email:
<br>

<a href="{{ url('user/verify', $verification_code)}}">Confirm my email address </a>

<br/>
</div>

</body>
</html>