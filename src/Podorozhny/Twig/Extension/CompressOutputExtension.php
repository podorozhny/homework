<?php

namespace Podorozhny\Twig\Extension;

class CompressOutputExtension
    extends \Twig_Extension
{
    public function getFilters()
    {
		return [
			'compressFilter' => new \Twig_SimpleFilter(
				'compress', [$this, 'compressFilter'], ['is_safe' => ['html']]
			),
		];
    }

    public function compressFilter($content)
    {
        $content = str_replace(["\n", "\r", "\t"], " ", $content);
        $content = preg_replace("/ {2,}/", " ", $content);

        return $content;
    }

    public function getName()
    {
        return 'compress_output_extension';
    }
}