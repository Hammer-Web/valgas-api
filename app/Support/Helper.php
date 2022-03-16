<?php


namespace App\Support;


use Illuminate\Support\Facades\DB;

class Helper
{

    public static function getMonthPortuguese($month)
    {

        switch ($month) {
            case '01':
                $m = 'Janeiro';
                break;
            case '02':
                $m = 'Fevereiro';
                break;
            case '03':
                $m = 'Março';
                break;
            case '04':
                $m = 'Abril';
                break;
            case '05':
                $m = 'Maio';
                break;
            case '06':
                $m = 'Junho';
                break;
            case '07':
                $m = 'Julho';
                break;
            case '08':
                $m = 'Agosto';
                break;
            case '09':
                $m = 'Setembro';
                break;
            case '10':
                $m = 'Outubro';
                break;
            case '11':
                $m = 'Novembro';
                break;
            case '12':
                $m = 'Dezembro';
                break;
        }

        return $m;
    }

    public static function isCPF($cpf)
    {
        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex:
        // 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public static function isCNPJ($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', (string)$cnpj);
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }

    public static function validaDocumento($documento)
    {
        try {
            $cpf = static::isCPF($documento);

            $cnpj = static::isCNPJ($documento);

            if ($cpf == FALSE && $cnpj == FALSE) {
                return FALSE;
            }

            return TRUE;
        } catch (Exception $e) {
        }
    }

    public static function limitWords($string, $limit, $pointer = null)
    {
        $arrWords = explode(' ', $string);
        $numWords = count($arrWords);

        $newWords = implode(' ', array_slice($arrWords, 0, $limit));

        $pointer = (empty($pointer) ? '...' : ' ' . $pointer);

        $result = ($limit < $numWords ? $newWords . $pointer : $string);

        return $result;
    }

    public static function limitCharacters($str, $max, $pointer = '')
    {
        if (strlen($str) > $max) {
            $str = substr($str, 0, $max) . $pointer;
        }
        return $str;
    }

    public static function formatarPlaca($placa)
    {
        $placa = strtoupper($placa);
        $placa = str_replace(' ', '', $placa);
        $placa = str_replace('-', '', $placa);
        $placa = str_replace('.', '', $placa);

        $proibidos = array(
            '/',
            '&',
            '%',
            '(',
            '?',
            '.',
            '\\',
            '#',
            ')',
            '�'
        );

        $placa = str_replace($proibidos, '', $placa);

        return $placa;
    }

    public static function nextToTheQueue()
    {
        $query = DB::select("SELECT
                                            usu_id as 'usu_id_usu', usu_nome, usu_tipo,
                                            (SELECT count(id) FROM pesquisas_a_t WHERE status in (2,3) AND operador_analise = usu_id_usu) as 'qnt_pesquisas'
                                        FROM
                                            usuarios
                                        WHERE
                                            usu_status = 1 AND usu_deleted = 0 AND
                                                usu_tipo in (2,3) AND usu_id not in (1,2)");

        $array = array();
        $arrayVol = array();

        if ($query == null){
            return false;
        }


        foreach ($query as $usu) {

            $arrayVol = array(
                'qnt_pesquisas' => $usu->qnt_pesquisas,
                'user' => array(
                'usu_id_usu' => $usu->usu_id_usu)
            );

            array_push($array, $arrayVol);
        }

        asort($array);

        $array = array_values($array);

        return $array[0]['user']['usu_id_usu'];

    }


}
