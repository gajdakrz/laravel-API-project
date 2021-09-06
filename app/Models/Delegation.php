<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateInterval;
use DatePeriod;

class Delegation extends Model
{
    protected $fillable = [
        'id', 'id_user', 'country', 'amount_due', 'currency', 'updated_at' , 'created_at', 'start', 'end'
    ];
    
    protected $filterScopes = [];
    
    public static function validate($input, $countries) {
        $error_message = '';

        if(!self::checkDate($input)) {
            $error_message = 'Start date is after end date';
            return array($error_message, $input);
        }
        
        if(self::checkOtherDelegation($input)) {
            $error_message = 'There is other delegation in this period for user: ' . $input['id_user'];
            return array($error_message, $input);
        }
        
        $rate_per_day = self::getCountryRate($input, $countries);             
        if(!$rate_per_day) {
            $error_message = 'Wrong country';
            return array($error_message, $input);
        } else {
            $input['amount_due'] = self::setAmountDue($input, $rate_per_day);
        }
        return array($error_message, $input);
    }
    
    private static function getCountryRate($input, $countries) {
        $rate_per_day = FALSE;
        foreach ($countries as $country) {
            if ($country->attributes['country'] == $input['country']) {
                $rate_per_day =  $country->attributes['rate_per_day'];
                break;
            }
        }
        return $rate_per_day;
    }
    
    private static function checkDate($input) {
        if ($input['start'] > $input['end']) {
            return FALSE;
        }
        return TRUE;
    }
    
    private static function checkOtherDelegation($input) {
        
        $user_delegations = Delegation::
                where('id_user', $input['id_user'])
                ->whereBetween('start', [$input['start'], $input['end']])
                ->orWhereBetween('end', [$input['start'], $input['end']])
                ->where('id_user', $input['id_user'])
                ->first();

        if($user_delegations) {
            return TRUE;
        }
        return FALSE;
    }
    
    private static function setAmountDue($input, $rate_per_day) {
        $amount_due = 0;

        $timestamp_start = strtotime($input['start']);
        $timestamp_end = strtotime($input['end']);
        
        $timestamp_start_last_day = DateTime::createFromFormat('Y-m-d H:i:s', (new DateTime())->setTimestamp($timestamp_end)->format('Y-m-d 00:00:00'))->getTimestamp();
        $timestamp_end_first_day = DateTime::createFromFormat('Y-m-d H:i:s', (new DateTime())->setTimestamp($timestamp_start)->format('Y-m-d 23:59:59'))->getTimestamp();     
        
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod((new DateTime())->setTimestamp($timestamp_end_first_day), $interval, (new DateTime())->setTimestamp(strtotime('+1 day', $timestamp_start_last_day)));

        foreach ($period as $key => $date) {   
            $timestamp = strtotime($date->format("Y-m-d H:i:s\n"));
            $isweekend = (date('N', $timestamp) >= 6);
            if($isweekend) {
                continue;
            }
            $double_price = 1;
            if ($key > 6) {//8th day in period
                $double_price = 2;
            }
            if (date("Y-m-d", $timestamp) === date("Y-m-d", $timestamp_start)) {
                $first_day_hours = abs($timestamp_start - $timestamp_end_first_day)/(60*60);
                if ($first_day_hours >= 8) {
                    $amount_due += $rate_per_day*$double_price;
                }
                
            } elseif (date("Y-m-d", $timestamp) === date("Y-m-d", $timestamp_end)){
                $last_day_hours = abs($timestamp_end - $timestamp_start_last_day)/(60*60);
                if ($last_day_hours >= 8) {
                    $amount_due += $rate_per_day*$double_price;
                }
            } else {
                $amount_due += $rate_per_day*$double_price; //another day than start or end day - so it will be one all day
            }
            
        }

        return $amount_due;
    }
    
    public function scopeFilter($query, $params) {
        if ( isset($params['id_user']) && trim($params['id_user'] !== '') ) {
            $query->where('id_user', '=', trim($params['id_user']));
        }
        return $query;
    }
}
