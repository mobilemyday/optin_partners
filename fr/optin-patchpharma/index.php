<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
<head>
	<title>mobile my day - optin</title>
	<meta charset="utf-8">
	<link rel="stylesheet" media="screen" href="/css/optin-patchpharma.css">
	<link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="/js/libs/modernizr.js"></script>
	<link rel="apple-touch-icon" sizes="57x57" href="/icons/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/icons/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/icons/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/icons/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/icons/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/icons/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/icons/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/icons/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/icons/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/icons/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
	<link rel="manifest" href="/icons/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/icons/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
</head>
<body>
<div class="wrapper">
	<div class="header">
		<img class="logo" src="/img/logo-mobilemyday.jpg" alt="Logo MMD" />
				<img class="logo" src="/img/logo-patchpharma.jpg" alt="Logo patchpharma" />
		</div>
		<ul class="m-languages">
                    <li>
                <a href="/be-fr/interest/patchpharma" class="active">
                    FR
                </a>
            </li>
                    <li>
                <a href="/be-nl/interest/patchpharma">
                    NL
                </a>
            </li>
        	</ul>
		<div class="title-container">
	<h1>
		Formulaire
	</h1>
</div>
<?php if(isset($_GET['done']) && $_GET['done'] == 1) : ?>
	<p style="margin:20px;padding:20px;background-color: #dcffef;color: #44a47f">Optin enregistré avec succès<br /><a href="/fr/optin-patchpharma/">Nouvel optin?</a></p>
<?php else : ?>
	<form action="../../run.php" method="post" enctype="application/x-www-form-urlencoded">
		<section>
	
			
			<fieldset class="inputstyle">
				<label for="apb-input">N° APB</label>
				<input name="optin[code]" type="text" placeholder="" class="" id="code-input" value="" required="">
			</fieldset>
			<fieldset class="inputstyle">
				<div class="row">
					<div class="col-md-2 select-container">
						<select name="optin[sex]" type="select" class="" id="sex-select" required="" autocomplete="off"><option value="" selected="selected">Civilité</option>
	<option value="m">Mr.</option>
	<option value="f">Mrs.</option></select>
					</div>
					<div class="col-md-5 inputstyle">
						<label for="lastname-input">Nom du responsable</label>
						<input name="optin[lastname]" type="text" placeholder="" class="" id="lastname-input" value="" required="">
					</div>
					<div class="col-md-5 inputstyle">
						<label for="firstname-input">Prénom</label>
						<input name="optin[firstname]" type="text" placeholder="" class="" id="firstname-input" value="" required="">
					</div>
				</div>
			</fieldset>
			<fieldset class="inputstyle">
				<label for="email-input">Addresse e-mail de la pharmacie</label>
				<input name="optin[email]" type="text" placeholder="" class="" id="test" value="" required="">
			</fieldset>
			<fieldset class="inputstyle">
				<label for="pos-name-input">Nom de la pharmacie</label>
				<input name="optin[pointOfSaleName]" type="text" placeholder="" class="" id="pos-name-input" value="" required="">
			</fieldset>
			<fieldset class="">
				<div class="row">
					<div class="col-md-8 inputstyle">
						<label for="street-input">Rue</label>
						<input name="optin[street]" type="text" placeholder="" class="" id="street-input" value="" required="">
					</div>
					<div class="col-md-2 inputstyle">
						<label for="number-input">Numéro</label>
						<input name="optin[number]" type="text" placeholder="" class="" id="number-input" value="" required="">
					</div>
					<div class="col-md-2 inputstyle">
						<label for="box-input">Boite</label>
						<input name="optin[box]" type="text" placeholder="" class="" id="box-input" value="">
					</div>
				</div>
			</fieldset>
			<fieldset class="inputstyle">
				<div class="row">
					<div class="col-md-8 inputstyle">
						<label for="city-input">Ville</label>
						<input name="optin[city]" type="text" placeholder="" class="" id="city-input" value="" required="">
					</div>
					<div class="col-md-4 inputstyle">
						<label for="zip-input">Code postal</label>
						<input name="optin[zip]" type="text" placeholder="" class="" id="zip-input" value="" required="">
						<input name="optin[country]" type="hidden" placeholder="" class="" id="country-input" value="BE" required="">
						<input name="optin[language]" type="hidden" placeholder="" class="" id="country-input" value="fr" required="">
					</div>
				</div>
			</fieldset>
			<fieldset class="inputstyle select-container">
				<select name="optin[idSoftware]" type="select" class="software-select" id="software-select" required="" autocomplete="off"><option value="" selected="selected">Sélectionnez le logiciel de gestion</option>
	<option value="2">Corilus - Greenock</option>
	<option value="1">Corilus - Offigest</option>
	<option value="13">Familia</option>
	<option value="9">Farmad</option>
	<option value="7">iPharma</option>
	<option value="12">Multipharma Unix</option>
	<option value="6">NextPharm</option>
	<option value="11">NextPharm - NextPharm LU</option>
	<option value="8">Officinall</option>
	<option value="10">Pharmony - Pharmony One</option>
	<option value="5">Sabco - New</option>
	<option value="4">Sabco - Optimum</option>
	<option value="3">Sabco - Ultimate</option>
	<option value="other">Autre</option></select>
			</fieldset>
			<fieldset class="inputstyle hidden">
				<label for="software-other-input">Précisez le logiciel de gestion</label>
				<input name="optin[otherSoftware]" type="text" placeholder="" class="" id="software-other-input" value="">
			</fieldset>
			<fieldset>
				<input name="optin[software_has_change]" type="hidden" value="0"><input name="optin[software_has_change]" type="checkbox" class="" id="software-has-change-checkbox" value="1"><label  for="software-has-change-checkbox">Avez-vous changé de soft ces deux dernières années?</label>
			</fieldset>
			<fieldset class="inputstyle hidden select-container">
				<select name="optin[old_idSoftware]" type="select" class="software-select" id="old-software-select" autocomplete="off"><option value="" selected="selected">Sélectionnez le logiciel de gestion</option>
	<option value="2">Corilus - Greenock</option>
	<option value="1">Corilus - Offigest</option>
	<option value="13">Familia</option>
	<option value="9">Farmad</option>
	<option value="7">iPharma</option>
	<option value="12">Multipharma Unix</option>
	<option value="6">NextPharm</option>
	<option value="11">NextPharm - NextPharm LU</option>
	<option value="8">Officinall</option>
	<option value="10">Pharmony - Pharmony One</option>
	<option value="5">Sabco - New</option>
	<option value="4">Sabco - Optimum</option>
	<option value="3">Sabco - Ultimate</option>
	<option value="other">Autre</option></select>
			</fieldset>
			<fieldset class="inputstyle hidden">
				<label for="old-software-other-input">Précisez le logiciel de gestion</label>
				<input name="optin[old_otherSoftware]" type="text" placeholder="" class="" id="old-software-other-input" value="">
			</fieldset>
			<fieldset class="">
				<input name="optin[optin_mmd]" type="hidden" value="0"><input name="optin[optin_mmd]" type="checkbox" class="" id="optin-mmd-checkbox" value="1"><label  for="optin-mmd-checkbox">Optin MMD</label>
								<input name="optin[optin_partner]" type="hidden" value="0"><input name="optin[optin_partner]" type="checkbox" class="" id="optin-mmd-partner" value="1"><label  for="optin-mmd-partner">Optin Patch Pharma</label>
						</fieldset>
			<fieldset>
				<button name="submit" class="btn" type="submit">
					Soumettre
				</button>
			</fieldset>
		</section>
	</form>
<?php endif ?>
</div>
</body>
<script src="/js/libs/jquery-1.11.2.js"></script>
<script src="/js/libs/validate.js"></script>
<script src="/js/optin-patchpharma.js"></script>
</html>