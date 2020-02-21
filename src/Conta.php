<?php
namespace Reweb\Job\Backend;

class Conta
{
    private $id;
    private $autenticado;
    private $tipo;
    private $limiteSaque;
    private $taxaSaque;
    private $saldo;

    public function __construct(int $id, $options = array()) {
        $this->id = $id;
        
        if ( isset($options['pass']) ){
            $this->autenticado = $this->autenticarConta($id, $options['pass']);
        } else {
            $this->autenticado = false;
        }

        $conta = $this->buscarConta($id);
        $this->tipo = $conta['tipo'];
        $this->saldo = $this->autenticado ? $conta['saldo'] : 0;
        switch ($this->tipo) {
            case 'corrente':
                $this->limiteSaque = 600;
                $this->taxaSaque = 2.5;
                break;

            case 'poupança':
                $this->limiteSaque = 1000;
                $this->taxaSaque = 0.8;
                break;

            default:
                $this->limiteSaque = 0;
                $this->taxaSaque = 0;
                break;
        }
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
    *   Busca conta no banco de dados e retorna array com $tipo e $saldo caso autenticado
    *   ou somente $tipo caso não autenticado. Retorna erro caso a conta não seja encontrada.
    *
    *   @return array
    */
    private function buscarConta(int $id) {
        
        if ($this->autenticado) {
            // Aqui ficariam as funções de busca autenticada no banco.
            switch ( $id ) {
                case 1:
                    return $conta = array(
                        "tipo" => "corrente",
                        "saldo" => '4800'
                    );
                    break;
                case 2:
                    return $conta = array(
                        "tipo" => "poupança",
                        "saldo" => '10000'
                    );
                    break;
                default:
                    return $erro = array(
                        "401 - Usuário não encontrado"
                    );
            }
        } else {
            // Aqui ficariam funções de busca não autenticada no banco.

            switch ( $id ) {
                case 1:
                    return $conta = array(
                        "tipo" => "corrente"
                    );
                    break;
                case 2:
                    return $conta = array(
                        "tipo" => "poupança"
                    );
                    break;
                default:
                    return $erro = array(
                        "401 - Usuário não encontrado"
                    );
            }
        }
        
    }

    /**
     * Validação de senha. Retorna true para sucesso e false para falha.
     * 
     * @return bool
     */
    private function autenticarConta(int $id, string $pass) {
        //Aqui ficaria a validação da conta no BD
        switch ($id) {
            case 1:
                if ($pass == "pass1") {
                    return true;
                }
                return false;
                break;
            case 2:
                if ($pass == "pass2") {
                    return true;
                }
                return false;
                break;
            default:
                return false;
                break;
        }
    }

    /**
    *   Recebe valor e o adiciona ao saldo da conta.
    */
    public function deposito(float $val) {
        $this->saldo += $val;
    }

    /**
    *   Recebe valor + taxa de saque e subtrai do saldo da Conta
    */
    public function saque(float $val) {
        $this->saldo -= ($val + $this->getTaxaSaque());
    }

    /**
    *   Recebe valor e subtrai do saldo da Conta
    */
    public function transferencia(float $val) {
        $this->saldo -= $val;
    }
}
