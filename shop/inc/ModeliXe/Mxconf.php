<?php
//Configuration g�n�rale de ModeliXe
define('MX_FLAGS_TYPE'        , 'xml'     );  //Pr�cise le mode d'�criture des templates par d�faut (xml ou pear).
define('MX_OUTPUT_TYPE'       , 'xhtml'   );  //Pr�cise le type de balisage en sortie.
define('MX_TEMPLATE_PATH'     , ROOT.'tpl/' );  //Pr�cise le r�pertoire de template par d�faut.
define('MX_DEFAULT_PARAMETER' , ''        );  //Pr�cise un fichier de param�tres par d�faut.
define('MX_CACHE_PATH'        , ROOT.'tpl/cache');  //Pr�cise le r�pertoire du cache.
define('MX_CACHE_DELAY'       , 0         );  //D�finit le d�lai de renouvellement du cache en secondes.
define('MX_SIGNATURE'         , 'off'     );  //Laisse la signature de ModeliXe dans la page HTML g�n�r�e (on ou off).
define('MX_COMPRESS'          , 'off'     );  //Mets en oeuvre la compression des pages si le navigateur le supporte (on ou off).
define('MX_REWRITEURL'        , 'off'     );  //Uitilise le mode_rewrite pour cr�er les urls (on ou  off).
define('MX_PERFORMANCE_TRACER', 'on'      );  //Pr�cise si on d�sire mettre en oeuvre le chronom�trage des performances (on ou off).

//Configuration de la gestion des erreurs
define('ERROR_MANAGER_SYSTEM' , 'on'      );  //Les erreurs sont remont�es pour on, ignor�es pour off.
define('ERROR_MANAGER_LEVEL'  , '2'       );  //Pr�cise le niveau d'erreur tol�r�, plus il est bas, moins les erreurs sont tol�r�es.
define('ERROR_MANAGER_ESCAPE' , ''        );  //Permet de sp�cifier une url locale de remplacement en cas de remont�e d'erreurs.
define('ERROR_MANAGER_LOG'    , ''        );  //Permet de d�finir un fichier de log.
define('ERROR_MANAGER_ALARME' , 'an.email@adress.com');   //Permet de d�finir une s�rie d'adresse email � laquelle sera envoy� un mail d'alerte.
?>