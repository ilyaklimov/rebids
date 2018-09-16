<?php

include __DIR__.'/libs/direct-api-5/Direct5.php';
include __DIR__.'/config.php';

$action = $argv[1];

switch ($action) {
	case 'update':

		foreach ($config["Accounts"] as $accounts) {

			$Direct = new Direct5($accounts["Token"], $accounts["Login"]);

			$compaign_ids = array_chunk(array_keys($accounts["Campaigns"]), 10);

			foreach ($compaign_ids as $compaign_ids_part) {
				$bids = $Direct->getResult('bids', 'get', [
					"SelectionCriteria" => [
						"CampaignIds" => $compaign_ids_part,
						"ServingStatuses" => ["ELIGIBLE"],
					],
					"FieldNames" => [
						"CampaignId", "AdGroupId", "KeywordId", "AuctionBids", "ContextCoverage"
					],
				]);

				$bids_new = [];

				foreach ($bids['result']['Bids'] as $arr) {

					$bid = $config["PriceDefault"];
					$auction_bids = [];
					foreach ($arr["AuctionBids"] as $value) {
						$auction_bids[$value['Position']] = $value['Bid'];
					}
					$campaign = &$accounts["Campaigns"][$arr["CampaignId"]];
					switch ($campaign["Strategy"]) {
						case 'MAX':
							if ($auction_bids['P11'] <= $campaign["PriceMax"]) {
								$bid = $auction_bids['P11'] + ($auction_bids['P11'] / 100 * $campaign["PricePlusPercent"]);
								if ($bid > $campaign["PriceMax"]) {
									$bid = $campaign["PriceMax"];
								}
							}					
							break;
						case 'SPECIAL':
							foreach (['P11', 'P12', 'P13', 'P14'] as $name) {
								if (isset($auction_bids[$name]) && $auction_bids[$name] <= $campaign["PriceMax"]) {
									$bid = $auction_bids[$name] + ($auction_bids[$name] / 100 * $campaign["PricePlusPercent"]);
									break;
								}
							}
							break;
						default:
							# code...
							break;
					}
					$bids_new[] = [
						"KeywordId" => $arr["KeywordId"],
						"Bid" => $bid
					];

				}

				$res = $Direct->getResult('bids', 'set', [
					"Bids" => $bids_new
				]);
			}
		}
		
		break;
	
	default:
		# code...
		break;
}





