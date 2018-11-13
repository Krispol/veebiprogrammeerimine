<?php
	class Test
	{
		// muutujujad - properties, funktsioonid - methods 
		private $secretNumber;
		public $publicNumber;
		
		// eriline funktsioon on konstruktor. Klassi muutujal ja meetodil tuleb "$this->" ette panna
		public function __construct($givenNumber){
			$this->secretNumber = 4;
			$this->publicNumber = $this->secretNumber * $givenNumber;
			$this->tellSecrets();
		}
		
		//kui töö lõppeb
		public function __destruct() {
			echo "Lõpetame!";
		}
		
		private function tellSecrets(){
			echo "Klassi salajane arv on: " .$this->secretNumber ."\n";
		}
		
		public function tellThings() {
			echo "Saladustele (" .$this->secretNumber .") pääseb ligi vaid klass ise! ";
		}
		
		
	} // class lõppeb
?>