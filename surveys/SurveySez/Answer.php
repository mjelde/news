<?php
//Answer.php
namespace SurveySez;

class Answer
{
	 public $AnswerID = 0;
	 public $Text = "";
	 public $Description = "";
	/**
	 * Constructor for Answer class. 
	 *
	 * @param integer $AnswerID ID number of answer 
	 * @param string $Text The text of the answer
	 * @param string $Description Additional description info
	 * @return void 
	 * @todo none
	 */ 
    function __construct($AnswerID,$answer,$description)
	{#constructor sets stage by adding data to an instance of the object
		$this->AnswerID = (int)$AnswerID;
		$this->Text = $answer;
		$this->Description = $description;
	}#end Answer() constructor
}#end Answer class