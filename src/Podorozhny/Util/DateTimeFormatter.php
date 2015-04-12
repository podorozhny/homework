<?php

namespace Podorozhny\Util;

class DateTimeFormatter
{
	public function formatDate(\DateTime $dateTime)
	{
		$currentDate = (new \DateTime('today'));

		$date = new \DateTime($dateTime->format('Y-m-d'));

		$interval = $currentDate->diff($date);

		$days = $interval->invert ? -$interval->days : $interval->days;

		$dayNames = [
//			-2 => 'позавчера',
			-1 => 'вчера',
			0  => 'сегодня',
			1  => 'завтра',
//			2  => 'послезавтра',
		];

		if (isset($dayNames[$days])) {
			$date = $dayNames[$days];
		} else {
			$months = array(
				1  => 'января',
				2  => 'февраля',
				3  => 'марта',
				4  => 'апреля',
				5  => 'мая',
				6  => 'июня',
				7  => 'июля',
				8  => 'августа',
				9  => 'сентября',
				10 => 'октября',
				11 => 'ноября',
				12 => 'декабря'
			);

			$date = sprintf(
				'%s %s',
				$dateTime->format('j'),
				/**
				 * @todo
				 */
				$months[(int) $dateTime->format('n')]
			);

			if ($dateTime->format('Y') != (new \DateTime())->format('Y')) {
				$date .= sprintf(
					' %s',
					$dateTime->format('Y')
				);
			}
		}

		return $date;
	}

	public function formatTime(\DateTime $dateTime)
	{
		$time = $dateTime->format('G:i');

		return $time;
	}

	public function formatDateTime(\DateTime $dateTime)
	{
		return sprintf(
			'%s в %s',
			$this->formatDate($dateTime),
			$this->formatTime($dateTime)
		);
	}
}