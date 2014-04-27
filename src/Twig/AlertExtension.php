<?php

namespace Byscripts\Bundle\AlertBundle\Twig;

use Symfony\Component\HttpFoundation\Session\Session;

class AlertExtension extends \Twig_Extension
{
    /**
     * @var string
     */
    private $template;
    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;
    /**
     * @var array
     */
    private $parameters;

    function __construct(Session $session, $template, array $parameters)
    {
        $this->template = $template;
        $this->session = $session;
        $this->parameters = $parameters;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'bys_alert',
                array($this, 'alertFunction'),
                array(
                    'is_safe' => array('html'),
                    'needs_environment' => true
                )
            )
        );
    }

    public function alertFunction(\Twig_Environment $environment)
    {
//        $flashes = $this->session->getFlashBag()->all();
//
//        $context = array('flashes' => array());
//
//        foreach($flashes as $type => $messages) {
//            $currentViewArgument = array('messages' => $messages);
//            foreach ($this->parameters as $name => $types) {
//                if (!empty($types[$type])) {
//                    $currentViewArgument[$name] = $types[$type];
//                }
//            }
//            $context['flashes'][] = $currentViewArgument;
//        }
//        return $environment->render($this->template, $context);
        return $environment->render($this->template, array(
                'flash_parameters' => $this->parameters
            ));
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'bys_alert_extension';
    }
}
