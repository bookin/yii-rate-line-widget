<?php

/**
 * Created by PhpStorm.
 * User: Bookin
 * Date: 25.10.2015
 * Time: 23:49
 */
class RateLine extends CWidget
{
    public $rates = [];

    public function init()
    {
        if(empty($this->rates) || !is_array($this->rates) || count($this->rates) != 2){
            throw new CException('You need set two numerical params');
        }
        /* @var $cs CClientScript*/
        $cs = Yii::app()->clientScript;
        $cs->registerCss('rate-line','
            .rate-progress {
                display: block;
                width: 100%;
                padding: 10px 20px 20px;
                border-top: 1px solid #eee;
                font-size: 13px;
                position: relative;
            }
            .rate-progress-bg {
                display: block;
                vertical-align: middle;
                position: relative;
                height: 4px;
                border-radius: 2px;
                overflow: hidden;
                background: #eee;
                margin-top: 10px;
            }
            .rate-progress-fg {
                position: absolute;
                top: 0;
                bottom: 0;
                height: 100%;
                left: 0;
                margin: 0;
                background: #8DC63F;
            }
            .rate-progress-labels {
                float: right;
                margin-left: 15px;
            }

            .rate-progress-label {
                line-height: 21px;
                font-size: 13px;
                font-weight: 400;
            }

            .rate-progress-label {
                vertical-align: middle;
                margin: 0 10px;
                color: #8DC63F;
            }

            .rate-completes {
                line-height: 21px;
                font-size: 13px;
                vertical-align: middle;
            }
        ');
    }

    public function run()
    {
        $html = [];
        $html[] = CHtml::openTag('span',['class'=>'rate-progress']);
            $html[] = CHtml::openTag('span',['class'=>'rate-progress-labels']);
                $html[] = CHtml::tag('span',['class'=>'rate-progress-label'], $this->getPercent().'%');
                $html[] = CHtml::tag('span',['class'=>'rate-completes'], implode('/',$this->rates));
            $html[] = CHtml::closeTag('span');
            $html[] = CHtml::openTag('span',['class'=>'rate-progress-bg']);
                $html[] = CHtml::tag('span',['class'=>'rate-progress-fg', 'style'=>'width:'.$this->getPercent().'%;'], '');
            $html[] = CHtml::closeTag('span');
        $html[] = CHtml::closeTag('span');
        echo implode(' ', $html);
    }

    protected function getPercent(){
        $percent = ceil(($this->rates[0]*100)/($this->rates[0]+$this->rates[1]));
        return $percent<=100?$percent:100;
    }
}