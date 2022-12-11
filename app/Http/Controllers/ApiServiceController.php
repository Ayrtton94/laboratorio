<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\ApiPerson;
use App\Models\ApiCompany;
use Illuminate\Http\Request;

class ApiServiceController extends Controller
{
	public static function ApiServices($type,$number)
    {
		$result_exist = Person::where('type', 'customers')->where('number', $number)->first();
		if (!!$result_exist) {
			$person = new ApiPerson();
			$person->number = $result_exist->number;
			$person->name_full = $result_exist->name;
			$person->address_full = $result_exist->address;
			$person->ubigeo = [
				$result_exist->department_id,
				$result_exist->province_id,
				$result_exist->district_id,
			];

			return [
				'success' => true,
				'data' => $person
			];
		}
        else{
			if ($type=="dni" && strlen($number) !== 8) {
				return [
					'success' => false,
					'message' => 'DNI tiene 8 digitos.'
				];
			}
			if ($type=="ruc" && strlen($number) !== 11) {
				return [
					'success' => false,
					'message' => 'RUC tiene 11 digitos.'
				];
			}
			$url="https://apiperu.dev/api/$type/";
			$token_luxo="374e1ae308a99aa17f68782a5e68e80247487f6a2bca2f44b822064caa4175be";
			
			$lmtg="{$url}{$number}?api_token=$token_luxo";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"{$lmtg}");      
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$respuestaLT = curl_exec ($ch);
			curl_close ($ch);
			
			if ($respuestaLT) {
				$json = json_decode($respuestaLT, true);
				
				$response_api = $json ?? null;
				
				if ($type=="dni") {
					if (isset($response_api) && count($response_api) > 0 && strlen($response_api['data']['numero']) >= 8 && $response_api['data']['nombres'] !== '') {
						$person = new ApiPerson();
						$person->number = $response_api['data']['numero'];
						$person->name = $response_api['data']['nombres'];
						$person->name_full = $response_api['data']['apellido_paterno'].' '.$response_api['data']['apellido_materno'].', '.$response_api['data']['nombres'];
						$person->first_name = $response_api['data']['apellido_paterno'];
						$person->last_name = $response_api['data']['apellido_materno'];
						$person->deparment = $response_api['data']['departamento'];
						$person->province = $response_api['data']['provincia'];
						$person->district = $response_api['data']['distrito'];
						$person->address = $response_api['data']['direccion'];
						$person->address_full = $response_api['data']['direccion_completa'];
						$person->ubigeo = $response_api['data']['ubigeo'];
						
						return [
							'success' => true,
							'data' => $person
						];
					} else {
						return [
							'success' => false,
							'message' => 'Datos no encontrados.'
						];
					}
				}else{
					
					if (isset($response_api) && count($response_api) > 0 && strlen($response_api['data']['ruc']) >= 11 && $response_api['data']['nombre_o_razon_social'] !== '') {
						$company = new ApiCompany();
						$company->number = $response_api['data']['ruc'];
						$company->name_full = $response_api['data']['nombre_o_razon_social'];
						$company->deparment = $response_api['data']['departamento'];
						$company->province = $response_api['data']['provincia'];
						$company->district = $response_api['data']['distrito'];
						$company->address = $response_api['data']['direccion'];
						$company->address_full = $response_api['data']['direccion_completa'];
						$company->ubigeo = $response_api['data']['ubigeo'];
						
						return [
							'success' => true,
							'data' => $company
						];
					} else {
						return [
							'success' => false,
							'message' => 'Datos no encontrados.'
						];
					}
				}
			}
	
			return [
				'success' => false,
				'message' => 'Conexión fallida.'
			];
		}
    }
}