<?php

namespace NS\APIs\Painel\Licencas;

use NS\Support\BaseRequest;
use NS\Support\DadosEntrada;
use NS\Support\Exceptions\LicencaNaoCadastradaException;

/**
 * Insere um nova licença (CNPJ + Projeto) ou
 * vincula um CNPJ já existente a outro projeto para ser utilizado
 * pelas aplicações de integração da NS Tecnologia.
 * @link http://confluence.ns.eti.br/pages/viewpage.action?pageId=15171776
 */
class CadastrarLicenca extends BaseRequest
{
    use DadosEntrada;

    protected $baseUrl = 'http://painelapi.ns.eti.br/licenca/';

    protected $dadosEntrada = [
        'licenca' => [
            'situacao' => 1,
            'manifestaAuto' => false,
            'buscaCTe' => false,
            'projeto' => [
                'idProjeto' => null
            ],
            'pessoa' => [
                'cnpj' => null,
                'ie' => null,
                'razao' => null,
                'fantasia' => null,
                'tpICMS' => null,
                'site' => null,
                'dataNasc' => null,
                'skype' => null,
                'pessoaEmails' => [
                    'email' => ''
                ],
                'pessoaEnderecos' => [
                    'endereco' => null,
                    'numero' => null,
                    'bairro' => null,
                    'cep' => null,
                    'cidade' => [
                        'cIBGE' => null
                    ]
                ],
                'pessoaTelefones' => [
                    'telefone' => null
                ]
            ],
            'certificado' => [
                'certificado' => null,
                'senha' => null
            ]
        ]
    ];

    public function enviar()
    {
        $response = $this->sendRequest('post', 'addLicense', $this->dadosEntrada);
        if ($response['status'] != 200) {
            throw new LicencaNaoCadastradaException($response['msg'], $response['status']);
        }

        return $response;
    }
}