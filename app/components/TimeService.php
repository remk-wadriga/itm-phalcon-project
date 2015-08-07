<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 03-08-2015
 * Time: 13:15 PM
 */

namespace components;

use abstracts\ServiceAbstract;

class TimeService extends ServiceAbstract
{
    public $dateFormat;
    public $dateTimeFormat;

    /**
     * @var \DateTime[]
     */
    private $_dates = [];


    // Public functions

    /**
     * currentDate
     * @param string $date
     * @param string $format
     * @return string
     */
    public function currentDate($date = 'now', $format = null)
    {
        if($format === null){
            $format = $this->dateFormat;
        }

        return $this->date($date, $format);
    }

    /**
     * currentDateTime
     * @param string $date
     * @param string $format
     * @return string
     */
    public function currentDateTime($date = 'now', $format = null)
    {
        if($format === null){
            $format = $this->dateTimeFormat;
        }

        return $this->date($date, $format);
    }

    // END Public functions



    // Private functions

    /**
     * date
     * @param string $date
     * @return \DateTime|string
     */
    private function date($date = 'now', $format = null)
    {
        if(!isset($this->_dates[$date])){
            $this->_dates[$date] = new \DateTime($date);
        }

        $date = $this->_dates[$date];

        return is_null($format) ? $date : $date->format($format);
    }

    // END Private functions
}