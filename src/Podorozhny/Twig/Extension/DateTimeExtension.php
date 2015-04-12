<?php

namespace Podorozhny\Twig\Extension;

use Podorozhny\Util\DateTimeFormatter;

class DateTimeExtension
	extends \Twig_Extension
{
	protected $formatter;

	public function __construct(DateTimeFormatter $formatter)
	{
		$this->formatter = $formatter;
	}

	public function getFilters()
	{
		return [
			'dateTimeFilter' => new \Twig_SimpleFilter(
				'dtDateTime', [$this, 'dateTimeFilter'], ['is_safe' => ['html']]
			),
			'dateFilter'     => new \Twig_SimpleFilter(
				'dtDate', [$this, 'dateFilter'], ['is_safe' => ['html']]
			),
			'timeFilter'     => new \Twig_SimpleFilter(
				'dtTime', [$this, 'timeFilter'], ['is_safe' => ['html']]
			),
		];
	}

	public function getName()
	{
		return 'datetime_extension';
	}

	public function dateTimeFilter(\DateTime $dateTime)
	{
		return $this->formatter->formatDateTime($dateTime);
	}

	public function dateFilter(\DateTime $dateTime)
	{
		return $this->formatter->formatDate($dateTime);
	}

	public function timeFilter(\DateTime $dateTime)
	{
		return $this->formatter->formatTime($dateTime);
	}
}