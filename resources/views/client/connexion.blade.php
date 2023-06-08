<html>
 <head>
 <meta charset="utf-8">

 <link rel="stylesheet" href="frontend/css/connexion.css" media="screen" type="text/css" />
 </head>
 <body>
 <div id="container">
 
 
 <form action="{{url('/creer_compte')}}" method="POST" class="login100-form validate-form">
    {{csrf_field()}}
 <h1>Connexion</h1>

 @if(Session::has('status'))
	<div>
		{{Session::get('status')}}
	</div>
@endif
 


 <label><b>Email</b></label>
 <input type="text" placeholder="Entrer votre email" name="email" required>

 <label><b>Mot de passe</b></label>
 <input type="password" placeholder="Entrer le mot de passe" name="password" required>


 <input type="submit" id='submit' value='connexion' >
 
 </form>
 </div>
 </body>
</html>