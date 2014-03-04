<?php

namespace Perso\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyController extends Controller
{

    private $Em;

    protected function setFlashMessage($message, $type = 'info')
    {
        $this->get('session')->getFlashBag()->add(
                $type, $message
        );
    }

    /**
     * Récupération de l'entity manager
     * @return type
     */
    protected function getEm()
    {
        if (null === $this->Em) {
            $this->Em = $this->getDoctrine()->getManager();
        }
        return $this->Em;
    }

    /**
     * Récupération d'un repo
     */
    protected function getRepo($repositoryName)
    {
        return $this->getEm()->getRepository($repositoryName);
    }

}
