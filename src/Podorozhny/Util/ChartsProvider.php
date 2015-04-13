<?php

namespace Podorozhny\Util;

class ChartsProvider
	implements ChartsProviderInterface
{
	public function getData()
	{
		return [
			'clientsCount'  => $this->getClientsCountData(),
			'clientsInflow' => $this->getClientsInflowData(),
			'users'         => $this->getUsersData(),
			'transactions'  => $this->getTransactionsData(),
			'goodsWeight'   => $this->getGoodsWeightData(),
			'goodsSpace'    => $this->getGoodsSpaceData(),
		];
	}

	protected function getClientsCountData()
	{
		$data = [
			'labels'   => [
				'1 ноября',
				'1 декабря',
				'1 января',
				'1 февраля',
				'1 марта',
				'1 апреля'
			],
			'datasets' => [
				[
					'label'                => 'Количество клиентов',
					'fillColor'            => 'rgba(151,187,205,0.2)',
					'strokeColor'          => 'rgba(151,187,205,1)',
					'pointColor'           => 'rgba(151,187,205,1)',
					'pointStrokeColor'     => '#fff',
					'pointHighlightFill'   => '#fff',
					'pointHighlightStroke' => 'rgba(151,187,205,1)',
					'data'                 => [33, 62, 113, 165, 211, 277]
				]
			]
		];

		return $data;
	}

	protected function getClientsInflowData()
	{
		$data = [
			'labels'   => [
				'Октябрь',
				'Ноябрь',
				'Декабрь',
				'Январь',
				'Февраль',
				'Март',
				'Апрель'
			],
			'datasets' => [
				[
					'label'           => 'Приток клиентов',
					'fillColor'       => 'rgba(151,187,205,0.5)',
					'strokeColor'     => 'rgba(151,187,205,0.8)',
					'highlightFill'   => 'rgba(151,187,205,0.75)',
					'highlightStroke' => 'rgba(151,187,205,1)',
					'data'            => [33, 29, 51, 52, 46, 66, 18]
				]
			]
		];

		return $data;
	}

	protected function getUsersData()
	{
		$data = [
			'labels'   => [
				'1 ноября',
				'1 декабря',
				'1 января',
				'1 февраля',
				'1 марта',
				'1 апреля'
			],
			'datasets' => [
				[
					'label'                => 'Количество сотрудников',
					'fillColor'            => 'rgba(151,187,205,0.2)',
					'strokeColor'          => 'rgba(151,187,205,1)',
					'pointColor'           => 'rgba(151,187,205,1)',
					'pointStrokeColor'     => '#fff',
					'pointHighlightFill'   => '#fff',
					'pointHighlightStroke' => 'rgba(151,187,205,1)',
					'data'                 => [7, 20, 32, 48, 63, 78]
				]
			]
		];

		return $data;
	}

	protected function getTransactionsData()
	{
		$data = [
			'labels'   => [
				'Октябрь',
				'Ноябрь',
				'Декабрь',
				'Январь',
				'Февраль',
				'Март',
				'Апрель'
			],
			'datasets' => [
				[
					'label'           => 'Приходы',
					'fillColor'       => 'rgba(151,187,205,0.5)',
					'strokeColor'     => 'rgba(151,187,205,0.8)',
					'highlightFill'   => 'rgba(151,187,205,0.75)',
					'highlightStroke' => 'rgba(151,187,205,1)',
					'data'            => [
						2120500,
						5893600,
						6228600,
						3648100,
						4182400,
						4807200,
						787900,
					]
				],
				[
					'label'           => 'Расходы',
					'fillColor'       => 'rgba(220,220,220,0.5)',
					'strokeColor'     => 'rgba(220,220,220,0.8)',
					'highlightFill'   => 'rgba(220,220,220,0.75)',
					'highlightStroke' => 'rgba(220,220,220,1)',
					'data'            => [
						127900,
						858600,
						2701000,
						2271000,
						825900,
						1507600,
						354600,
					]
				]
			]
		];

		return $data;
	}

	protected function getGoodsWeightData()
	{
		$data = [
			[
				'value'     => 75,
				'color'     => '#F7464A',
				'highlight' => '#FF5A5E',
				'label'     => '0—100 г'
			],
			[
				'value'     => 318,
				'color'     => '#46BFBD',
				'highlight' => '#5AD3D1',
				'label'     => '100—500 г'
			],
			[
				'value'     => 405,
				'color'     => '#FDB45C',
				'highlight' => '#FFC870',
				'label'     => '500—1000 г'
			],
			[
				'value'     => 55,
				'color'     => '#949FB1',
				'highlight' => '#A8B3C5',
				'label'     => '1—5 кг'
			],
			[
				'value'     => 149,
				'color'     => '#4D5360',
				'highlight' => '#616774',
				'label'     => '> 5 кг'
			],
		];

		return $data;
	}

	protected function getGoodsSpaceData()
	{
		$data = [
			[
				'value'     => 18,
				'color'     => '#F7464A',
				'highlight' => '#FF5A5E',
				'label'     => '0—0.001 м³'
			],
			[
				'value'     => 131,
				'color'     => '#46BFBD',
				'highlight' => '#5AD3D1',
				'label'     => '0.001—0.01 м³'
			],
			[
				'value'     => 245,
				'color'     => '#FDB45C',
				'highlight' => '#FFC870',
				'label'     => '0.01—0.05 м³'
			],
			[
				'value'     => 165,
				'color'     => '#949FB1',
				'highlight' => '#A8B3C5',
				'label'     => '0.05—0.1 м³'
			],
			[
				'value'     => 424,
				'color'     => '#4D5360',
				'highlight' => '#616774',
				'label'     => '> 0.1 мм³'
			],
		];

		return $data;
	}
}