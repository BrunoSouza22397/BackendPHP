<?php
namespace Reweb\Job\Backend;

use Reweb\Job\Backend\Conta;

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
    private $contaDestino;

    public function __construct( int $id, string $pass ) {
        $this->conta = new Conta($id, $options = array("pass" => $pass));
    }

    /**
     * Insere $val ao saldo da conta e imprime resposta ao usuário.
     * 
     * @return string
     */
    public function deposito(float $val) {
        try {
            if ($val > 0) {
                $c = $this->conta;
                
                echo "====================================================\n";
                echo "--------------COMPROVANTE DE DEPÓSITO--------------\n";
                echo "====================================================\n";
                echo "Conta: ". $c->getId() ."\n";
                echo "Tipo: ". $c->getTipo() ."\n";
                echo "Saldo antes da transação: B$ ". $c->getSaldo() ."\n";

                $c->deposito($val);

                echo "====================================================\n";
                echo "Valor depositado: B$ $val\n";
                echo "Saldo após transação: B$ ". $c->getSaldo() ."\n";
                echo "\n";
                echo "Obrigado por nos confiar com suas finanças! :)\n";
            } else {
                echo "====================================================\n";
                echo "Valor inválido para depósito.";
            }

        } catch(Exception $e) {
            echo "====================================================\n";
            echo "Ocorreu um erro ao realizar seu depósito. :( \n";
            echo "Entre em contato com nosso suporte e passe a seguinte\n";
            echo "informação: \n";
            echo $e;
            echo "=====================================================\n";
        }
    }


    /**
     * Remove $val do saldo da conta e imprime resposta ao usuário.
     * 
     * @return string
     */
    public function saque(float $val) {
        try {
            $c = $this->conta;

            if ( $val > 0 ) {
                if ( !($val > $c->getSaldo()) ) {
                    if ( !($val > $c->getLimiteSaque()) ) {
                        echo "====================================================\n";
                        echo "---------------COMPROVANTE DE SAQUE-----------------\n";
                        echo "====================================================\n";
                        echo "Conta: ". $c->getId() ."\n";
                        echo "Tipo: ". $c->getTipo() ."\n";
                        echo "Saldo antes da transação: B$ ". $c->getSaldo() ."\n";

                        $c->saque($val);

                        echo "====================================================\n";
                        echo "Valor do saque: B$ $val\n";
                        echo "Taxa de saque: B$ ". $c->getTaxaSaque() ."\n";
                        echo "Saldo após transação: B$ ". $c->getSaldo() ."\n";
                        echo "\n";
                        echo "Obrigado por nos confiar com suas finanças! :)\n";
                    } else {
                        echo "====================================================\n";
                        echo "Valor maior que seu limite de Saque.\n";
                        echo "Seu limite de saque é de: ". $c->getLimiteSaque() ."\n";
                    }
                } else {
                    echo "====================================================\n";
                    echo "Valor maior do que o saldo disponível.\n";
                    echo "Seu saldo é: ". $c->getSaldo() ."\n";
                }
                

            } else {
                echo "====================================================\n";
                echo "Valor inválido para saque.\n";
            }
        } catch ( Exception $e ) {
            echo "====================================================\n";
            echo "Ocorreu um erro ao realizar seu saque. :( \n";
            echo "Entre em contato com nosso suporte e passe a seguinte\n";
            echo "informação: \n";
            echo $e;
            echo "=====================================================\n";
        }
    }

    /**
     * Realiza transferência entre as contas e retorna resposta ao usuário.
     * 
     * @return string
     */
    public function transferencia(int $id, float $val) {
        try {
            $c = $this->conta;

            $this->contaDestino = new Conta($id);
            $cd = $this->contaDestino;

            if ( $val > 0 ) {
                if ( !($val > $c->getSaldo()) ) {
                    
                    echo "====================================================\n";
                    echo "-------------COMPROVANTE DE TRANSFERÊNCIA-----------\n";
                    echo "====================================================\n";
                    echo "Conta: ". $c->getId() ."\n";
                    echo "Tipo: ". $c->getTipo() ."\n";
                    echo "Saldo antes da transação: B$ ". $c->getSaldo() ."\n";
                    echo "\n";
                    echo "Conta de Destino: ". $cd->getId() ."\n";
                    echo "Tipo: ". $cd->getTipo() ."\n";

                    $c->transferencia($val);
                    $cd->deposito($val);

                    echo "====================================================\n";
                    echo "Valor da transferência: B$ $val\n";
                    echo "Saldo após transação: B$ ". $c->getSaldo() ."\n";
                    echo "\n";
                    echo "Obrigado por nos confiar com suas finanças! :)\n";

                } else {
                    echo "====================================================\n";
                    echo "Valor maior que seu saldo disponível.\n";
                    echo "Seu saldo é de: ". $c->getSaldo();
                }

            } else {
                echo "====================================================\n";
                echo "Valor inválido para transferência.\n";
            }
        } catch (Exception $e) {
            echo $e;
        }

    }
}
