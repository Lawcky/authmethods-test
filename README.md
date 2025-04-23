Authentification Methodo TP  
========================  

Fork de l'application démo Symfony pour le projet Methodo d'application  

Étapes  
------------  
- Création et utilisation du Codespace pour tout le développement et les commits/push  
- Ajout de la connexion OAuth2 par GitHub en utilisant **league/oauth2-server-bundle**  
- GitHub passe par le MFA, les deux solutions sont donc implémentées.  
- Ajout d'une page météo avec l'API OpenWeatherMap  

3 variables d'environnement sont nécessaires pour faire fonctionner le tout : une identification d'application GitHub OAuth2 avec l'ID client et sa clé secrète, ainsi que la clé d'API OpenWeatherMap.  

Le seul moyen de connexion est l'OAuth2 par GitHub pour le panneau admin, les routes menant à la connexion par mot de passe ont été retirées.

Modifications apportées pour l'OAuth2 par GitHub :  
- config/packages/security.yaml  # Ajout des information Github Authenticator
- config/routes.yaml  # Ajout des routes de connexion vers Github
- src/Controller/SecurityController.php  # Ajout du controleur de sécurité 
- src/Entity/User.php  # Ajout du Github ID sur le profile utilisateur pour les connexions
- src/Security/GitHubAuthenticator.php  # Ajout du code de connexion à Github
- src/Security/GitHubEntryPoint.php  # Ajout de l'entrypoint pour initié la connexion
- templates/security/login.html.twig  # template pour l'affichage

Modifications apportées pour l'OpenWeatherAPI :  
- src/Controller/WeatherController.php  # controleur du Weather
- src/Service/WeatherService.php  # code pour appeler l'api
- config/services.yaml  # ajout du service
- public/weatherservice.php  
- templates/default/homepage.html.twig  # ajout de la page sur l'affichage de base
- templates/weather/index.html.twig  # template pour l'affichage météo
- translations/messages+intl-icu.en.xlf  # language anglais pour la météo
- translations/messages+intl-icu.fr.xlf  # language français pour la météo

Modifications tierces :  
- Ajout de assets/styles/bootswatch/$web-font-path pour corriger un problème lié au CSS.  
