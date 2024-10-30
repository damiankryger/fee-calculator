<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use PragmaGoTech\Interview\DefaultFeeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Repositories\InMemoryFeeStructureRepository;
use PragmaGoTech\Interview\Services\FeeInterpolator;

$feeStructureRepository = new InMemoryFeeStructureRepository();
$feeInterpolator = new FeeInterpolator();
$calculator = new DefaultFeeCalculator(
    $feeStructureRepository,
    $feeInterpolator
);

$term = (int) $argv[1];
$amount = (float) $argv[2];

echo sprintf('Calculated fee for term %d and amount %d is: %d.' . PHP_EOL, $term, $amount, $calculator->calculate(new LoanProposal($term, $amount)));