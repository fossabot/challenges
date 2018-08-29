<?php

function hourglassSum($arr)
{
    $max = 0;
    foreach ($arr as $y => $row) {
        for ($x = 0, $length = count($row); $x < $length; $x++) {
            $matrixSlice = matrixSlice($arr, $x, $y, 3);
            if (null === $matrixSlice) {
                continue;
            }

            $hourGlass = getHourGlass($matrixSlice);
            $max = max($max, matrixSum($hourGlass));
        }
    }

    return $max;
}

function matrixSlice($arr, $xOffset, $yOffset, $size)
{
    $firstRow = reset($arr);
    $sideLength = count($firstRow);
    $diff = $sideLength - 1 - $size;

    if (!isset($arr[$yOffset + $diff][$xOffset])) {
        return null;
    }

    if (!isset($arr[$yOffset][$xOffset + $diff])) {
        return null;
    }

    $result = [];
    foreach ($result as $i => $iValue) {
        $result[$i] = array_slice($arr[$i + $yOffset], $xOffset, $size);
    }

    return $result;
}

function getHourGlass($squareMatrix)
{
    $firstRow = reset($squareMatrix);
    $sideLength = count($firstRow);
    $middleIndex = (int)(($sideLength - 1) / 2);

    for ($i = 1; $i < $sideLength - 1; $i++) {
        foreach ($squareMatrix[$i] as $j => $row) {
            if ($j !== $middleIndex) {
                $row[$j] = 0;
            }
        }
    }

    return $squareMatrix;
}

function matrixSum($matrix)
{
    return array_reduce(
        array_keys($matrix),
        function ($carry, $key) use ($matrix) {
            return $carry + array_sum($matrix[$key]);
        },
        0
    );
}

function printMatrix($matrix)
{
    foreach ($matrix as $row) {
        echo json_encode($row);
        echo "\n";
    }
}

function validate()
{
    return true;
}

$arr = [
    [1, 1, 1, 0, 0, 0],
    [0, 1, 0, 0, 0, 0],
    [1, 1, 1, 0, 0, 0],
    [0, 0, 2, 4, 4, 0],
    [0, 0, 0, 2, 0, 0],
    [0, 0, 1, 2, 4, 0],
];

$result = hourglassSum($arr);
printf("Result: %d\n", $result);
