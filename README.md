Authentification Metho TP  
========================  

Fork de l'application démo Symfony pour le projet Methodo d'application  

Étapes  
------------  
- Création et utilisation du Codespace pour tout le développement et les commits/push  
- Ajout de la connexion OAuth2 par GitHub en utilisant **league/oauth2-server-bundle**  
- GitHub passe par le MFA, les deux solutions sont donc implémentées.  
- Ajout d'une page météo avec l'API OpenWeatherMap  

3 variables d'environnement sont nécessaires pour faire fonctionner le tout : une identification d'application GitHub OAuth2 avec l'ID client et sa clé secrète, ainsi que la clé d'API OpenWeatherMap.  

Modifications apportées pour l'OAuth2 par GitHub :  
- config/packages/security.yaml  
- config/routes.yaml  
- src/Controller/SecurityController.php  
- src/Entity/User.php  
- src/Security/GitHubAuthenticator.php  
- src/Security/GitHubEntryPoint.php  
- templates/security/login.html.twig  

Modifications apportées pour l'OpenWeatherAPI :  
- src/Controller/WeatherController.php  
- src/Service/WeatherService.php  
- config/services.yaml  
- public/weatherservice.php  
- templates/default/homepage.html.twig  
- templates/weather/index.html.twig  
- translations/messages+intl-icu.en.xlf  
- translations/messages+intl-icu.fr.xlf  

Modifications tierces :  
- Ajout de assets/styles/bootswatch/$web-font-path pour corriger un problème lié au CSS.  
