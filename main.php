<?php

require_once __DIR__ . '/vendor/autoload.php';

use Reweb\Job\Backend;

$caixa = new Backend\CaixaEletronico(1, "pass1");

echo $caixa->deposito(200);
echo $caixa->saque(600);
echo $caixa->transferencia(2, 800);
