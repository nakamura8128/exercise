<?php
//標準入力から値を受けとる
while (true) {
    $line = trim(fgets(STDIN));
    $tmp[] = $line;
    if ($line === '') {
        break;
    }
}

foreach ($tmp as $key => $value) {
    $array[] = explode(" ", $value);
}

$totalTurn = (int) $array[0][0];
$totalFingers = (int) $array[0][1];
$string = (string) $array[1][0];
$enemyOutput = str_split($string);

//相手のぐーちょきぱーの数を数える
$enemyGooCount = 0;
$enemyChokiCount = 0;
$enemyPaaCount = 0;

for ($i = 0; $i < $totalTurn; $i++) {
    switch ($enemyOutput[$i]) {
        case 'G':
            $enemyGooCount++;
            break;
        case 'C':
            $enemyChokiCount++;
            break;
        case 'P':
            $enemyPaaCount++;
            break;
        default:
            echo 'unexpected string was input';
    }
}

//自分のぐーちょきぱーの出せる回数のパターンを出す

/** @var array $possinlePatterns = [[gooCount, chokiCount, perCount],...] */
$possiblePatterns = [];

for ($paaCount = 0; $paaCount <= $totalTurn; $paaCount++) {

    //指の数が明らかに大きくなる場合はスキップ
    if ($paaCount * 5 > $totalFingers) {
        break;
    }

    for ($chokiCount = 0; $chokiCount <= $totalTurn - $paaCount; $chokiCount++) {

        //指の数が明らかに大きくなる場合はスキップ
        if ($paaCount * 5 + $chokiCount * 2 > $totalFingers) {
            break;
        }

        $usedFingers = (int) ($paaCount * 5 + $chokiCount * 2);

        //この場合のみ題意を満たす出し方が出来る
        if ($usedFingers === $totalFingers) {
            $gooCount = $totalTurn - ($paaCount + $chokiCount);
            $possiblePatterns[] = [
                'goo' => $gooCount,
                'choki' => $chokiCount,
                'paa' => $paaCount
            ];
        }
    }
}

//どのパターンが最も勝利数が多いかを計算する
$maximumWinCount = 0;
foreach ($possiblePatterns as $possiblePattern) {
    $winCount = min($possiblePattern['goo'], $enemyChokiCount)
        + min($possiblePattern['choki'], $enemyPaaCount)
        + min($possiblePattern['paa'], $enemyGooCount);
    $maximumWinCount = max($maximumWinCount, $winCount);
}
echo $maximumWinCount;
echo "\n";
