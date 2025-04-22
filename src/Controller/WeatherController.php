<?php
namespace App\Controller;

use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather', name: 'weatherpage')]
    public function index(WeatherService $weatherService): Response
    {
        $weather = $weatherService->getCurrentWeather('Paris,fr');
        return $this->render('weather/index.html.twig', [
            'weather' => $weather,
        ]);
    }
}
