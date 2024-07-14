<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Redis;

class RedisHelper
{
    public static function getOffice(): array
    {
        $offices = [];
        $officesArr = json_decode(Redis::get('office'), true);
        if (!empty($officesArr)){
            foreach ($officesArr as $item){
                if(!empty($item['name'])){
                    $offices[$item['id']] = $item['name'];
                }
            }
        }
        return $offices;
    }

    public static function getMinistry(): array
    {
        $ministryOffices = [];
        $ministryOfficesArr = json_decode(Redis::get('officeministry'), true);
        if (!empty($ministryOfficesArr)){
            foreach ($ministryOfficesArr as $item){
                if(!empty($item['name'])){
                    $ministryOffices[$item['id']] = $item['name'];
                }
            }
        }
        return $ministryOffices;
    }

    public static function getOfficeLayerByMinistryId($ministryId): array
    {
        try{
            $officeLayers = [];
            $filteredOfficeLayersArr = json_decode(Redis::get('officeLayerByMinistryId'), true)[$ministryId];
            if (isset($filteredOfficeLayersArr['status']) && $filteredOfficeLayersArr['status'] == 'error') {
                return ['responseCode' => 0];
            }else{
                foreach ($filteredOfficeLayersArr as $item){
                    if(!empty($item['name'])){
                        $officeLayers[$item['id']] = $item['name'];
                    }
                }
            }
            return $officeLayers;
        } catch (\Exception $e) {
            $errorData = $e->getMessage();
            return ['responseCode' => 0, 'message' => $errorData];
        }
    }

    public static function getOfficeOriginByLayerId($ministryDivisionId): array
    {
        try{
            $officeOrigins = [];
            $filteredOfficeOriginArr = json_decode(Redis::get('officeOriginByLayerId'), true)[$ministryDivisionId];
            if (isset($filteredOfficeOriginArr['status']) && $filteredOfficeOriginArr['status'] == 'error') {
                return ['responseCode' => 0];
            }else{
                foreach ($filteredOfficeOriginArr as $item){
                    if(!empty($item['name'])){
                        $officeOrigins[$item['id']] = $item['name'];
                    }
                }
            }
            return $officeOrigins;
        } catch (\Exception $e) {
            $errorData = $e->getMessage();
            return ['responseCode' => 0, 'message' => $errorData];
        }
    }

    public static function getOfficeByOriginId($ministryDepartmentId): array
    {
        try{

            $filteredOfficeOriginArr = json_decode(Redis::get('officeByOfficeOriginId'), true)[$ministryDepartmentId];
            if (isset($filteredOfficeOriginArr['status']) && $filteredOfficeOriginArr['status'] == 'error') {
                return ['responseCode' => 0];
            }else{
                foreach ($filteredOfficeOriginArr as $item){
                    if(!empty($item['name'])){
                        $officeOrigins[$item['id']] = $item['name'];
                    }
                }
            }
            return $officeOrigins;
        } catch (\Exception $e) {
            $errorData = $e->getMessage();
            return ['responseCode' => 0, 'message' => $errorData];
        }
    }

    public static function getOfficeUnitOrganogramByOfficeId($ministryOfficeId): array
    {
        try{
            $designation = [];
            $filteredDesignationArr = json_decode(Redis::get('officeUnitOrganogramByOfficeId'), true)[$ministryOfficeId];
            if (isset($filteredDesignationArr['status']) && $filteredDesignationArr['status'] == 'error') {
                return ['responseCode' => 0];
            }else{
                foreach ($filteredDesignationArr as $item){
                    if(!empty($item['name'])){
                        $designation[$item['id']] = $item['name'];
                    }
                }
            }
            return $designation;
        } catch (\Exception $e) {
            $errorData = $e->getMessage();
            return ['responseCode' => 0, 'message' => $errorData];
        }
    }
}
