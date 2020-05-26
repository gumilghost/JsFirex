<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Repository\LanguageRepository;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class LanguageSubscriber implements EventSubscriberInterface
{
    private Environment $twig;
    private LanguageRepository $languageRepository;

    public function __construct(Environment $twig, LanguageRepository $languageRepository)
    {
        $this->twig = $twig;
        $this->languageRepository = $languageRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event)
    {
        $this->twig->addGlobal('languages', $this->languageRepository->getLanguagesAsArray());
    }
}
