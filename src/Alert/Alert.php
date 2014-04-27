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
    /**
     * @var array
     */
    private $classes;

    function __construct(Session $session, array $classes)
    {
        $this->session = $session;
        $this->classes = $classes;
    }

    /**
     * @param string $type
     * @param string $message
     * @param array|string $args
     * @param null|string $_
     */
    public function addMessage($type, $message, $args = null, $_ = null)
    {
        if (array_key_exists($type, $this->classes)) {
            $type = $this->classes[$type];
        }
        if (null === $args) {
            return $this->session->getFlashBag()->add($type, $message);
        } elseif (!is_array($args)) {
            $args = array_slice(func_get_args(), 2);
        }

        $args = array_map(
            function ($value) {
                return htmlentities($value);
            },
            $args
        );

        return $this->session->getFlashBag()->add($type, vsprintf($message, $args));
    }

    public function __call($method, $arguments)
    {
        $this->addMessage($method, array_shift($arguments), $arguments);
    }
}
