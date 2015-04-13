<?php

namespace Podorozhny\Twig\Extension;

class WeightExtension
	extends \Twig_Extension
{
	public function getFilters()
	{
		return [
			'weightFilter' => new \Twig_SimpleFilter(
				'weight', [$this, 'weightFilter'], ['is_safe' => ['html']]
			),
		];
	}

	public function weightFilter($weight)
	{
		if ($weight < 1000) {
			return $weight . ' г';
		}

		$weight = number_format($weight / 1000, 3, '.', ' ');

		while (mb_substr($weight, -1) == '0') {
			$weight = mb_substr($weight, 0, -1);
		}

		if (mb_substr($weight, -1) == '.') {
			$weight = mb_substr($weight, 0, -1);
		}

		return $weight . ' кг';
	}

	public function getName()
	{
		return 'weight_extension';
	}
}