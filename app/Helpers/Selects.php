<?php

namespace App\Helpers;

class Selects
{
    public const SELECTYESNO = [ 1 => 'No', 2 => 'Yes' ];
    // public const LANG = [ 1 => 'FR', 2 => 'EN' ];
    public const Answer_STATUS = [ 0 => 'Error', 1 => 'Sent', 2 => 'Answered', 3 => 'Expired' ];
    public const CHATLOG_STATUS = [ 1 => 'Error', 2 => 'Success' ];
    public const Contact_STATUS = [ 1 => 'pending', 2 => 'Sent' ];
    public const CHATLOG_TYPE = [ 1 => 'Sent', 2 => 'Receive' ];
    public const OnOff = [ 1 => 'off', 2 => 'on' ];
    public const AnswerTypes = [ 
        1 => 'Number' , 
        // 2 => 'Text'
    ];
    public const QuestionTypes = [  
        1 => 'NPS' , 
        2 => 'Choices', 
        // 3 => 'Text'
    ];
    public const positiveORnegative = [  
        10 => 'negative' , 
        20 => 'positive'
    ];
}