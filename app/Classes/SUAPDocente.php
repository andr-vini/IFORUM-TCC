<?php

namespace App\Classes;

use GuzzleHttp\Client;

/**
 * Adaptação da biblioteca de Ivanilson Melo para docentes.
 *
 * @author Equipe Aoga
 */
class SUAPDocente
{
    /**
     * O token de acesso do usuário. Tokens tem 24 horas de validade.
     *
     * @var string Token de acesso.
     */
    private $token;

    /**
     * Endpoint do SUAP.
     *
     * @var string Endpoint de acesso ao suap.
     */
    private $endpoint = 'https://suap.ifrn.edu.br/api/v2/';

    /**
     * Um cliente GuzzleHttp para fazer os requests HTTP.
     *
     * @var GuzzleHttp\Client Cliente GuzzleHttp.
     */
    private $client;

    /**
     * Construtor. Pode ser vazio ou receber um token de acesso.
     *
     * @param string $token Token de acesso.
     */
    public function __construct($token = false)
    {
        if ($token) {
            $this->setToken($token);
        }

        // Create and use a guzzle client instance that will time out after 10 seconds
        $this->client = new Client([
            'timeout'         => 10,
            'connect_timeout' => 10,
        ]);
    }

    /**
     * Autentica o usuário e retorna um token de acesso.
     * Pode-se usar a senha ou chave de acesso do aluno.
     *
     * @param string $username  Matrícula do aluno.
     * @param string $password  Senha do aluno ou chave de acesso do responsável.
     * @param bool   $accessKey Define se o login é por chave de acesso.
     * @param bool   $setToken  Define se deve salvar o token para requests subsequentes.
     *
     * @return array $data Array contendo o token de acesso.
     */
    public function autenticar($username, $password, $accessKey = false, $setToken = true)
    {
        // Se estiver acessando com uma chave de acesso...
        if ($accessKey) {
            $url = $this->endpoint . 'autenticacao/acesso_responsaveis/';

            $params = [
                'matricula' => $username,
                'chave'     => $password,
            ];
        } else {
            $url = $this->endpoint . 'autenticacao/token/';

            $params = [
                'username' => $username,
                'password' => $password,
            ];
        }

        $response = $this->client->request('POST', $url, [
            'form_params' => $params,
        ]);

        $data = false;

        if ($response->getStatusCode() == 200) {
            // Decodifica a resposta JSON para um array.
            $data = json_decode($response->getBody(), true);

            // Seta o token se solicitado. Padrão é true.
            if ($setToken && isset($data['token'])) {
                $this->setToken($data['token']);
            }
        }

        return $data;
    }

    /**
     * Renova o token de acesso a API.
     */
    public function refresh()
    {
        if ($this->token != null) {
            $url = $this->endpoint . 'autenticacao/token/refresh/';

            $params = [
                'token' => $this->token,
            ];

            $response = $this->client->request('POST', $url, [
                'form_params' => $params,
            ]);

            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true);

                if (isset($data['token'])) {
                    $this->setToken($data['token']);
                }

                return $data;
            }
        }
        return false;
    }

    /**
     * Seta o token para acesso a API.
     *
     * @param string $token Token de acesso.
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Pega os dados pessoais do aluno autenticado.
     *
     * @return array $data Dados pessoais do aluno.
     */
    public function getMeusDados()
    {
        $url = $this->endpoint . 'minhas-informacoes/meus-dados/';

        return $this->doGetRequest($url);
    }

    /**
     * Pega os dados pessoais de um determinado aluno a partir de sua matrícula.
     *
     * @param string $matricula Matrícula do aluno.
     *
     * @return array $data Dados pessoais do aluno.
     */
    public function getDadosAluno($matricula)
    {
        $url = $this->endpoint . 'edu/alunos/' . $matricula . '/';

        return $this->doGetRequest($url);
    }

    /**
     * Pega os diários do docente para.
     *
     * @param int $ano Ano letivo.
     * @param int $periodo Período letivo.
     *
     * @return array $data Boletim do aluno.
     */
    public function getMeusDiarios($ano, $periodo)
    {
        $url = $this->endpoint . 'minhas-informacoes/meus-diarios/' . $ano . '/' . $periodo . '/';
        $diarios = $this->doGetRequest($url);
        $turmas = [];

        foreach ($diarios as $diario) {
            $turmas[] = [
                'id' => $diario['id'],
                'componente_curricular' => $diario['componente_curricular'],
                'participantes' => $diario['participantes']
            ];
        }

        return $turmas;
    }

    /**
     * Faz um request GET para um endpoint definido.
     *
     * @param string $url Url para fazer o request.
     *
     * @return array $data Dados retornados pela API.
     */
    private function doGetRequest($url)
    {
        $response = $this->client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'JWT ' . $this->token,
            ],
        ]);

        $data = false;

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getBody(), true);
        }

        return $data;
    }
}
