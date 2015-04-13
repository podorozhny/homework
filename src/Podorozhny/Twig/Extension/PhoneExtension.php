<?php

namespace Podorozhny\Twig\Extension;

class PhoneExtension
	extends \Twig_Extension
{
	public function getFilters()
	{
		return [
			'phoneFilter' => new \Twig_SimpleFilter(
				'phone', [$this, 'phoneFilter'], ['is_safe' => ['html']]
			),
		];
	}

	public function phoneFilter($phone)
	{
		switch (mb_strlen($phone)) {
			case 7:
				$phone = sprintf(
					'+7 (495) %s-%s-%s',
					mb_substr($phone, 0, 3),
					mb_substr($phone, 3, 2),
					mb_substr($phone, 5, 2)
				);
				break;
			case 10:
				$phone = sprintf(
					'+7 (%s) %s-%s-%s',
					mb_substr($phone, 0, 3),
					mb_substr($phone, 3, 3),
					mb_substr($phone, 6, 2),
					mb_substr($phone, 8, 2)
				);
				break;
			case 11:
				$phone = sprintf(
					'+%s (%s) %s-%s-%s',
					mb_substr($phone, 0, 1),
					mb_substr($phone, 1, 3),
					mb_substr($phone, 4, 3),
					mb_substr($phone, 7, 2),
					mb_substr($phone, 9, 2)
				);
		}

		return $phone;
	}

	public function getName()
	{
		return 'phone_extension';
	}
}