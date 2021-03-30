<?php

namespace App\Services\Impl\Order;

use App\Services\CommonServices;

class DataDisplayServicesImpl extends CommonServices
{
    static public function getexcel($datearray,$type,$typename) {
        $hhdd[]=array($typename,'日期','成功关注','当日取关量','当日取关率','取关量','取关率');
        foreach ($datearray as $value){
            $hhd=$value;
            unset($value['list']);
            $hhdd[]=array(
                $value[$type],'',$value['nowfollow'],$value['unnowfollow'],$value['unnowfollowrate'].'%',$value['unfollow'],$value['unfollowrate'].'%'
            );
            foreach ($hhd['list'] as $value2) {
                $hhdd[]=array(
                    '',$value2['datetime'],$value2['nowfollow'],$value2['unnowfollow'],$value2['unnowfollowrate'].'%',$value2['unfollow'],$value2['unfollowrate'].'%'
                );
            }
        }
        return $hhdd;
    }
    
    static public function getexcel2($datearray,$type,$typename) {
        $hhdd[]=array($typename,'日期','成功关注','取关量','取关率');
        foreach ($datearray as $value){
            $hhd=$value;
            unset($value['list']);
            $hhdd[]=array(
                $value[$type],'',$value['nowfollow'],$value['unfollow'],$value['unfollowrate'].'%'
            );
            foreach ($hhd['list'] as $value2) {
                $hhdd[]=array(
                    '',$value2['datetime'],$value2['nowfollow'],$value2['unfollow'],$value2['unfollowrate'].'%'
                );
            }
        }
        return $hhdd;
    }

    static public function getBussexcel($datearray) {
        $hhdd[]=array('渠道','日期','成功关注','当日取关量','当日取关率','取关量','取关率');
        foreach ($datearray as $value3) {
            foreach ($value3 as $value){
                $hhd=$value;
                unset($value['list']);
                $hhdd[]=array(
                    $value['buss_name'],'',$value['nowfollow'],$value['unnowfollow'],$value['unnowfollowrate'].'%',$value['unfollow'],$value['unfollowrate'].'%'
                );
                foreach ($hhd['list'] as $value2) {
                    $hhdd[]=array(
                        '',$value2['datetime'],$value2['nowfollow'],$value2['unnowfollow'],$value2['unnowfollowrate'].'%',$value2['unfollow'],$value2['unfollowrate'].'%'
                    );
                }
            }
        }
        return $hhdd;
    }
    

    static public function getBussexcel2($datearray) {
        $hhdd[]=array('渠道','日期','成功关注','取关量','取关率');
        foreach ($datearray as $value3) {
            foreach ($value3 as $value){
                $hhd=$value;
                unset($value['list']);
                $hhdd[]=array(
                    $value['buss_name'],'',$value['nowfollow'],$value['unfollow'],$value['unfollowrate'].'%'
                );
                foreach ($hhd['list'] as $value2) {
                    $hhdd[]=array(
                        '',$value2['datetime'],$value2['nowfollow'],$value2['unfollow'],$value2['unfollowrate'].'%'
                    );
                }
            }
        }
        return $hhdd;
    }
    
    static public function getBussReportExcel($datearray) {
        $hhdd[]=array('渠道','成功关注','取关量','取关率');
        foreach ($datearray as $value){
            $hhd=$value;
            unset($value['list']);
            $hhdd[]=array(
                $value['buss_name'],'',$value['nowfollow'],$value['unfollow'],$value['unfollowrate'].'%'
            );
            foreach ($hhd['list'] as $value2) {
                $hhdd[]=array(
                    '',$value2['datetime'],$value2['nowfollow'],$value2['unfollow'],$value2['unfollowrate'].'%'
                );
            }
        }
        return $hhdd;
    }
    
    static public function getInitialValue($type,$val) {
        switch ($type) {
            case 'startdate':
                if($val==''){
                    return date('Y-m-d',strtotime("-7 day"));
                }
                return $val;
            case 'enddate':
                if($val==''){
                    return date('Y-m-d',strtotime("-1 day"));
                }
                return $val;
            default:
                return $val;
        }
    }
}