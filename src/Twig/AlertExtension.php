<?php

namespace Byscripts\Bundle\AlertBundle\Twig;

class AlertExtension extends \Twig_Extension
{
    /**
     * @var string
     */
    private $template;

    function __construct($template)
    {
        $this->template = $template;
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
        return $environment->render($this->template);
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
