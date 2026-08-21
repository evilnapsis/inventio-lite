<?php
namespace App\Service;

class HomeService {
	public function getDashboardData(): array {
		$products = \ProductData::getAll();

		$sells30 = \SellData::getSellsLast30Days();
		$sellsByDate = [];
		foreach ($sells30 as $sell) {
			$sellsByDate[$sell->date] = $sell->total;
		}

		$labels = [];
		$data = [];
		for ($i = 29; $i >= 0; $i--) {
			$date = date('Y-m-d', strtotime("-$i days"));
			$labels[] = date('d/m', strtotime($date));
			$data[] = isset($sellsByDate[$date]) ? (float)$sellsByDate[$date] : 0;
		}

		$recentSells = array_slice(\SellData::getSells(), 0, 5);

		$allProducts = $products;
		usort($allProducts, function($a, $b) { return $b->id - $a->id; });
		$recentProducts = array_slice($allProducts, 0, 5);

		return [
			'total_products' => count($products),
			'total_clients' => count(\PersonData::getClients()),
			'total_providers' => count(\PersonData::getProviders()),
			'total_categories' => count(\CategoryData::getAll()),
			'chart_labels' => $labels,
			'chart_data' => $data,
			'recent_sells' => $recentSells,
			'recent_products' => $recentProducts,
		];
	}
}
