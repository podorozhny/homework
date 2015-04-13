<?php

namespace Podorozhny\Twig\Extension;

class SizeExtension
    extends \Twig_Extension
{
    public function getFilters()
    {
        return [
			'sizeFilter' => new \Twig_SimpleFilter(
				'size', [$this, 'sizeFilter'], ['is_safe' => ['html']]
			),
        ];
    }

    public function sizeFilter($size)
    {
		if ($size < 1000) {
			return $size . ' мм';
		}

		$size = number_format($size / 1000, 3, '.', ' ');

		while (mb_substr($size, -1) == '0') {
			$size = mb_substr($size, 0, -1);
		}

		if (mb_substr($size, -1) == '.') {
			$size = mb_substr($size, 0, -1);
		}

		return $size . ' м';
    }

    public function getName()
    {
        return 'size_extension';
    }
}