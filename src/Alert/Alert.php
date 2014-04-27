<?php

namespace Byscripts\Bundle\AlertBundle\Alert;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class Alert
 *
 * @package Byscripts\Bundle\AlertBundle\Alert
 */
class Alert
{
    /**
     * @var Session
     */
    protected $session;

    function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param string       $type
     * @param string       $message
     * @param array|string $args
     *
     * @return
     */
    public function addMessage($type, $message, array $args = array())
    {
        return $this
            ->session
            ->getFlashBag()
            ->add(
                $type,
                vsprintf(
                    $message,
                    array_map('htmlentities', $args)
                )
            );
    }

    public function __call($method, $arguments)
    {
        $this->addMessage($method, array_shift($arguments), $arguments);
    }
}
