<?php
namespace Reweb\Job\Backend;

use Conta;

class CaixaEletronico
{
    /**
    *   Repositório para conta do usuário.
    *
    *   @var Conta
    */
    private $conta;

    /**
    *   Respositório para conta de destino de transferência.
    *
    *   @var Conta
    */
    // TODO: Criar algum tipo de middleware para este tipo de transação,
    //       intanciar a classe inteira de outro usuário é inseguro.
    private $contaDestino;

    public function __construct($id) {
        $this->conta = new Conta($id);
    }

    public function deposito($val) {
        try {
            if ($val > 0) {
                $c = $this->conta;

                echo "====================================================\n";
                echo "Conta: $c->getId()\n";
                echo "Tipo: $c->getTipo()\n";
                echo "Saldo antes da transação: B$ $c->getSaldo()\n";

                $c->deposito($val);

                echo "====================================================\n";
                echo "Valor depositado: B$ $val\n";
                echo "Saldo após transação: B$ $c->getSaldo()\n";
                echo "\n";
                echo "Obrigado por nos confiar com suas finanças! :)\n";
            } else {
                echo "Valor inválido para depósito.";
            }

        } catch(Exception $e) {
            echo "====================================================\n";
            echo "Ocorreu um erro ao realizar seu depósito. :( \n"
            echo "Entre em contato com nosso suporte e passe a seguinte\n";
            echo "informação: \n";
            echo $e;
            echo "=====================================================\n";
        }
    }

    public function saque($val) {
        try {
            $c = $this->conta;

            // TODO: criar mensagens de erro individuais para cada caso.
            if ( $val > 0 && $val !> $c->getSaldo() && $val !> $c->getLimiteSaque() ) {

                echo "====================================================\n";
                echo "Conta: $c->getId()\n";
                echo "Tipo: $c->getTipo()\n";
                echo "Saldo antes da transação: B$ $c->getSaldo()\n";

                $c->saque($val);

                echo "====================================================\n";
                echo "Valor do saque: B$ $val\n";
                echo "Taxa de saque: B$ $c->getTaxaSaque()\n";
                echo "Saldo após transação: B$ $c->getSaldo()\n";
                echo "\n";
                echo "Obrigado por nos confiar com suas finanças! :)\n";

            } else {
                echo "Valor inválido para saque.\n";
            }
        } catch ( Exception $e ) {
            echo "====================================================\n";
            echo "Ocorreu um erro ao realizar seu saque. :( \n"
            echo "Entre em contato com nosso suporte e passe a seguinte\n";
            echo "informação: \n";
            echo $e;
            echo "=====================================================\n";
        }
    }

    public function transferencia($id, $val) {
        try {
            $c = $this->conta;

            $this->contaDestino = new Conta($id);
            $cd = $this->contaDestino;

            if ( $val > 0 && $val !> $c->getSaldo() ) {

                echo "====================================================\n";
                echo "Conta: $c->getId()\n";
                echo "Tipo: $c->getTipo()\n";
                echo "Saldo antes da transação: B$ $c->getSaldo()\n";
                echo "\n";
                echo "Conta de Destino: $cd->getId()\n";
                echo "Tipo: $cd->getTipo()\n";

                $c->transferencia($val);
                $cd->deposito($val);

                echo "====================================================\n";
                echo "Valor da transferência: B$ $val\n";
                echo "Saldo após transação: B$ $c->getSaldo()\n";
                echo "\n";
                echo "Obrigado por nos confiar com suas finanças! :)\n";

            } else {
                echo "Valor inválido para transferência.\n";
            }
        } catch (Exception $e) {
            echo $e;
        }

    }
}
