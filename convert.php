<?php

class convert
{
	private $buttons = [];

	public function __construct()
	{
		$this->buttons = [
			'C' => [
				'sps' => 'circle',
				'xbox' => 'B',
				'switch' => 'A',
				'std' => '4',
				'pc' => 'L',
			],
			'X' => [
				'sps' => 'cross',
				'xbox' => 'A',
				'switch' => 'B',
				'std' => '3',
				'pc' => 'K',
			],
			'S' => [
				'sps' => 'square',
				'xbox' => 'X',
				'switch' => 'Y',
				'std' => '1',
				'pc' => 'J',
			],
			'T' => [
				'sps' => 'triangle',
				'xbox' => 'Y',
				'switch' => 'X',
				'std' => '2',
				'pc' => 'I',
			],
			'U' => [
				'sps' => 'up',
				'xbox' => 'up',
				'switch' => 'up',
				'std' => 'up',
				'pc' => 'W',
			],
			'5' => [
				'sps' => 'up+forward',
				'xbox' => 'up+forward',
				'switch' => 'up+forward',
				'std' => 'U+F',
				'pc' => 'W+D',
			],
			'R' => [
				'sps' => 'forward',
				'xbox' => 'forward',
				'switch' => 'forward',
				'std' => 'F',
				'pc' => 'D',
			],
			'6' => [
				'sps' => 'down+forward',
				'xbox' => 'down+forward',
				'switch' => 'down+forward',
				'std' => 'D+F',
				'pc' => 'S+D',
			],
			'D' => [
				'sps' => 'down',
				'xbox' => 'down',
				'switch' => 'down',
				'std' => 'down',
				'pc' => 'S',
			],
			'7' => [
				'sps' => 'down+back',
				'xbox' => 'down+back',
				'switch' => 'down+back',
				'std' => 'D+B',
				'pc' => 'S+A',
			],
			'L' => [
				'sps' => 'back',
				'xbox' => 'back',
				'switch' => 'back',
				'std' => 'back',
				'pc' => 'A',
			],
			'8' => [
				'sps' => 'up+back',
				'xbox' => 'up+back',
				'switch' => 'up+back',
				'std' => 'up+back',
				'pc' => 'W+A',
			],
			'[' => [
				'sps' => 'L1',
				'xbox' => 'LB',
				'switch' => 'L',
				'std' => 'THROW',
				'pc' => 'SPACE',
			],
			'{' => [
				'sps' => 'L2',
				'xbox' => 'LT',
				'switch' => 'ZL',
				'std' => 'STANCE',
				'pc' => 'U',
			],
			']' => [
				'sps' => 'R1',
				'xbox' => 'RB',
				'switch' => 'R',
				'std' => 'AMP',
				'pc' => ';',
			],
			'}' => [
				'sps' => 'R2',
				'xbox' => 'RT',
				'switch' => 'ZR',
				'std' => 'BLOCK',
				'pc' => 'O',
			],
			',' => [
				'sps' => ',',
				'xbox' => ',',
				'switch' => ',',
				'std' => ',',
				'pc' => ',',
			],
			'+' => [
				'sps' => '+',
				'xbox' => '+',
				'switch' => '+',
				'std' => '+',
				'pc' => '+',
			],
			'|' => [
				'sps' => 'or',
				'xbox' => 'or',
				'switch' => 'or',
				'std' => 'or',
				'pc' => 'or',
			],
			'.' => [
				'sps' => '',
				'xbox' => '',
				'switch' => '',
				'std' => '',
				'pc' => '',
			],
		];
	}

	private function getJsonFiles()
	{
		return glob('json/*.json');
	}

	private function createHtml($data)
	{
		$html = '';
		$group = '';
		$subGroup = '';
		$html .= $data->characterName . "\r\n";
		$html .= '========================================' . "\r\n";

		foreach ($data->moves as $k => $move) {
			foreach ($move as $k => $data) {
				if ($k == 'group' && $data != $group) {
					$group = $data;
					$html .= "\r\n";
					$html .= "\r\n";
					$html .= $group . "\r\n";
					$html .= '========================================' . "\r\n";
				}
				if ($k == 'subGroup' && $data != $subGroup && $data != '') {
					$subGroup = $data;
					$html .= "\r\n";
					$html .= '=== ' . $subGroup . "\r\n";
					$html .= '========================================' . "\r\n";
				}
				if ($k == 'name') {
					$html .= '' . $data . ': ';
				}
				if ($k == 'move') {
					$html .= $data . "\r\n";
				}
			}
		}

		return $html;
	}

	private function createText($data, $platform = 'sps')
	{
		$text = '';
		$group = '';
		$subGroup = '';
		$text .= $data->characterName . "\r\n";
		$text .= '========================================' . "\r\n";

		foreach ($data->moves as $k => $move) {
			foreach ($move as $k => $data0) {
				if ($k == 'group' && $data0 != $group) {
					$group = $data0;
					$text .= "\r\n";
					$text .= "\r\n";
					$text .= $group . "\r\n";
					$text .= '========================================' . "\r\n";
				}
				if ($k == 'subGroup' && $data0 != $subGroup && $data0 != '') {
					$subGroup = $data0;
					$text .= "\r\n";
					$text .= '=== ' . $subGroup . "\r\n";
					$text .= '========================================' . "\r\n";
				}
				if ($k == 'name') {
					$text .= '' . $data0 . ': ';
				}
				if ($k == 'move') {
					$split = str_split($data0);
					$move = '';
					foreach ($split as $v) {
						$v = trim($v);
						if (empty($v)) {
							continue;
						}
						$move .= $this->buttons[$v][$platform] . ' ';
					}
					$move = trim($move);
					$move = str_replace(' , ', ', ', $move);
					$text .= $move . "\r\n";
				}

				if ($k == 'title') {
					$text .= $data0 . "\r\n";
				}
			}
			$text .= "\r\n";
		}

		return $text;
	}

	public function main()
	{
		$jsonFiles = $this->getJsonFiles();

		foreach ($jsonFiles as $jsonFile) {
			$pathInfo = pathinfo($jsonFile);

			$person = $pathInfo['filename'];

			$json = file_get_contents($jsonFile);
			$data = json_decode($json);

			$text = $this->createText($data, 'pc');
			file_put_contents('text/' . $person . '.txt', $text);

			$html = $this->createHtml($data);
			//file_put_contents('docs/' . $person . '.html', $html);
		}
	}
}

$object = new convert();
$object->main();
