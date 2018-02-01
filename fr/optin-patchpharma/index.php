<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
    <head>
        <title>mobile my day - formulaire optin</title>
        <meta charset="utf-8">
        <link rel="stylesheet" media="screen" href="/css/optin-patchpharma.css">
        <link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="/js/libs/modernizr.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <div class="header">
             <img class="logo" src="/img/logo-mobilemyday.jpg" alt="Logo MMD" />
             <img class="logo" src="/img/logo-patchpharma.jpg" alt="Logo Patch Pharma" />
             </div>
            <ul class="m-languages">
                <li><a href="/fr/optin-patchpharma" class="active">FR</a></li>
                <li><a href="/en/optin-patchpharma">EN</a></li>
                <li><a href="/nl/optin-patchpharma">NL</a></li>
            </ul>
            <div class="title-container">
                <h1>Formulaire</h1>
            </div>
            <?php if(isset($_GET['done']) && $_GET['done'] == 1) : ?>
            	<p style="margin:20px;padding:20px;background-color: #dcffef;color: #44a47f">Optin enregistré avec succès</p>
            <?php endif ?>
            <form method="post" action="/run.php">
                <section>
                    <fieldset class="inputstyle">
                        <label for="code">N°APB</label>
                        <input name="form[code]" id="code" type="text" required>
                    </fieldset>
                    <fieldset class="inputstyle">
                        <label for="name">Nom du responsable</label>
                        <input name="form[responsible_name]" id="name" type="text" required>
                    </fieldset>
                    <fieldset class="inputstyle">
                        <label for="email">Adresse e-mail de la pharmacie</label>
                        <input name="form[email]" id="email" type="email" required>
                    </fieldset>
                    <fieldset class="select-container">
                        <select name="form[software]" id="software" required>
                           	<option value="">Sélectionnez le logiciel de gestion</option>
                            <option value="corilus-offigest">Corilus - Offigest</option>
                            <option value="corilus-greenock">Corilus - Greenock</option>
                            <option value="sabco-greenock">Sabco - Ultimate</option>
                            <option value="sabco-optimum">Sabco - Optimum</option>
                            <option value="sabco-new">Sabco - New</option>
                            <option value="nextpharm">NextPharm</option>
                            <option value="ipharma">Ipharma</option>
                            <option value="officinall">Officinall</option>
                            <option value="farmad">Farmad</option>
                            <option value="other">Autre</option>
                        </select>
                    </fieldset>
                    <fieldset class="inputstyle hidden">
                        <label for="software">Précisez le logiciel de gestion</label>
                        <input name="form[other_software]" id="software" type="text" required>
                    </fieldset>
                    <fieldset>
                        <input type="checkbox" id="optin-mmd" name="form[optin_mmd]" value="1">
                        <label for="optin-mmd">Opt-in MMD</label>
                        <input type="checkbox" id="optin-pp" name="form[optin_patchpharma]" value="1">
                        <label for="optin-pp">Opt-in Patch Pharma</label>
                    </fieldset>
                    <fieldset>
                        <button name="submit" class="btn" type="submit">SOUMETTRE</button>
                    </fieldset>  
                </section>
                <input type="hidden" name="form[language]" value="fr">
            </form>
        </div>
    </body>
    <script src="/js/libs/jquery-1.11.2.js"></script>
    <script src="/js/libs/validate.js"></script>
    <script src="/js/optin-patchpharma.js"></script>
</html>
   