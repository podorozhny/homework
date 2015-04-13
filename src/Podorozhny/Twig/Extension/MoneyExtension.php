<?php

namespace Podorozhny\Twig\Extension;

class MoneyExtension
	extends \Twig_Extension
{
	public function getFilters()
	{
		return [
			'moneyFilter' => new \Twig_SimpleFilter(
				'money_*', [$this, 'moneyFilter'], ['is_safe' => ['html']]
			),
		];
	}

	public function moneyFilter($currency, $value, $decimals = 0)
	{
		$currencySigns = [
			'rub' => ' <i class="fa fa-rub"></i>',
			'usd' => '<i class="fa fa-usd"></i>',
			'eur' => '<i class="fa fa-eur"></i>',
			'gbp' => '<i class="fa fa-gbp"></i>',
			'btc' => '<i class="fa fa-btc"></i>',
		];

		if (!isset($currencySigns[$currency])) {
			return '';
		}

		$isNegative = $value < 0;
		$money      = number_format(
			abs($value),
			$decimals,
			'.',
			$currency == 'rub' ? ' ' : ''
		);
		if ($currency == 'rub' && isset($currencySigns[$currency])) {
			$money .= $currencySigns[$currency];
		} else {
			$money = $currencySigns[$currency] . $money;
		}
		if ($isNegative) {
			$money = '&minus;' . $money;
		}

		return $money;
	}

	public function getName()
	{
		return 'money_extension';
	}
}