<?php

namespace NS\APIs\DDFe\DesacordoCTe;

use NS\Support\BaseRequest;
use NS\Support\DadosEntrada;
use NS\Support\Exceptions\DessacordoNaoEfetuadoException;

/**
 * Evento para que o tomador possa informar ao fisco que o documento CT-e
 * que o relaciona está em desacordo com a prestação de serviço.
 * @link http://confluence.ns.eti.br/pages/viewpage.action?pageId=20611854
 */
class Desacordo extends BaseRequest
{
    use DadosEntrada;

    protected $baseUrl = 'https://ddfe.ns.eti.br/events/cte/';

    protected $dadosEntrada = [
        'CNPJInteressado' => null,
        'infEvento' => [
            'chCTe' => null,
            'tpAmb' => 1,
            'dhEvento' => null,
            'xObs' => null,
            'indDesacordoOper' => null
        ]
    ];

    public function enviar()
    {
        if (is_null($this->dadosEntrada['infEvento']['dhEvento'])) {
            $this->definirDataPadrao();
        }

        $response = $this->sendRequest('post', 'disagree', $this->dadosEntrada);
        if ($response['status'] != 200) {
            throw new DessacordoNaoEfetuadoException($response['motivo'], $response['status']);
        }

        return $response;
    }

    private function definirDataPadrao()
    {
        $dt = new \DateTime();
        $dt->setTimeZone(new \DateTimeZone('America/Sao_paulo'));
        $this->dadosEntrada['infEvento']['dhEvento'] = $dt->format('Y-m-d\TH:i:sP');
    }
}