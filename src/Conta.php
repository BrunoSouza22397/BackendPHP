<?php
namespace Reweb\Job\Backend;

// TODO: criar validação com senha
class Conta
{
    private $id;
    private $tipo;
    private float $limiteSaque;
    private float $taxaSaque;
    private float $saldo;

    public function __construct($id) {
        $this->id = $id;
        $conta = $this->buscarConta($id);
        $this->tipo = $conta['tipo'];
        $this->saldo = $conta['saldo'];
        switch ($this->tipo) {
            case 'corrente':
                $this->limiteSaque = 600;
                $this->taxaSaque = 2,5;
                break;

            case 'poupança':
                $this->limiteSaque = 1000;
                $this->taxaSaque = 0,8;
                break;

            default:
                $this->limiteSaque = 0;
                $this->taxaSaque = 0;
                break;
        }
    }

    /**
    *   Busca conta no banco de dados e retorna array com $tipo e $saldo
    *   ou erro caso a conta não seja encontrada.
    *
    *   @return array
    */
    // TODO: CRIAR MIDDLEWARE PARA BD
    private function buscarConta($id) {
        // [...]Funções de busca no banco.
        if (!$conta[]) {
            return $erro;
        }

        return $conta[];
    }

    public function getId() {
        return $this->id;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getLimiteSaque() {
        return $this->limiteSaque;
    }

    public function getTaxaSaque() {
        return $this->taxaSaque;
    }

    public function getSaldo() {
        return $this->saldo;
    }

    /**
    *   Recebe valor e o adiciona ao saldo da conta.
    */
    public function deposito($val) {
        $this->saldo += $val;
    }

    /**
    *   Recebe valor + taxa de saque e subtrai do saldo da Conta
    */
    public function saque($val) {
        $this->saldo -= ($val + $this->getTaxaSaque());
    }

    /**
    *   Recebe valor + taxa de saque e subtrai do saldo da Conta
    */
    public function transferencia($val) {
        $this->saldo -= $val;
    }
}
