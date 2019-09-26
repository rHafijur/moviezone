<?php 
	class Man{
		protected $name;
		protected $dateOfBirth;
		public function getName(){
			return $this->name;
		}
	}
	class Student extends Man{
		public $id;
		function __construct($id, $name, $dateOfBirth){
			$this->id=$id;
			$this->name=$name;
			$this->dateOfBirth=$dateOfBirth;
			// echo "constructor is called and executed";	
		}

		public function countCharectersOfName(){
			return $this->name." has ".strlen($this->name)." charecters";
		}


	}
	class Teacher extends Man{
		public $dept;
		private $teaches=array();
		function __construct($dept, $name, $dateOfBirth){
			$this->dept=$dept;
			$this->name=$name;
			$this->dateOfBirth=$dateOfBirth;
		}
		public function setSubject($subjectName){
			$this->teaches[]=$subjectName;
		}
		public function getName(){
			return $this->name;
		}
		public function getAllSubjects(){
			return $this->teaches;
		}


	}

	// $student1=new Student('123','Hafijur Rahaman','1/1/1996');

	// echo $student1->getName();
	// echo "<br>";
	// echo $student1->countCharectersOfName();
	$teacher1=new Teacher('computer science and engineering','Redoy','1/1/1996');
	$teacher1->setSubject("Math 1");
	$teacher1->setSubject("Math 2");
	$teacher1->setSubject("Physics");
	$teacher1->setSubject("Chemistry");
	// echo "<br>";
	// echo $teacher1->getName();
	// echo "<br>";
	// var_dump($teacher1->getAllSubjects());?
	foreach ($teacher1->getAllSubjects() as $subject) {
		print $teacher1->getName()." teaches ".$subject;
		print "<br>";
	}
	
 ?>