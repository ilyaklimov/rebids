<?php

$config = [
	"Accounts" => [
		[
			"Login" => "",
			"Token" => "",
			"Campaigns" => [
				1 => [
					"Name" => "Test name",
					"PriceMax" => 300000000,
					"PricePlusPercent" => 20, // 20%
					"Strategy" => "SPECIAL"
				],
			],
		],
	],
	"Strategies" => [
		"MAX" => [

		],
		"SPECIAL" => [

		],
	],
	"PriceDefault" => 1000000
];