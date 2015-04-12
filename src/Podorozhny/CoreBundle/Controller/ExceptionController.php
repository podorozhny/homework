<?php

namespace Podorozhny\CoreBundle\Controller;

use Symfony\Bundle\TwigBundle\Controller\ExceptionController as BaseExceptionController;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\HttpFoundation\Request;

class ExceptionController
    extends BaseExceptionController
{
    protected function findTemplate(Request $request, $format, $code, $debug)
    {
        if (!$debug) {
            $template = new TemplateReference(
                'CoreBundle', 'Exception', 'error' . $code, $format, 'twig'
            );
            if ($this->templateExists($template)) {
                return $template;
            }
        }

        return parent::findTemplate($request, $format, $code, $debug);
    }
}