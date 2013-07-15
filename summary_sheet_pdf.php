<?php
session_start();
require_once ("includes/initialize.php");

require_once("fpdf.php");

if(!is_logged_in()){
	Header("Location: index.php");

}		
		
Class ThisPDF extends FPDF{	
	private $PG_W = 190;
	public $db;
	public function __construct($passInYourDataHere = NULL) {
		parent::__construct();
		
	}
	
	function Header(){
		include 'includes/initialize.php';
		$db = DatabaseWrapper::getInstance();
		$this->setFont('Helvetica', 'B', 12);
		$session = $db->query("select currentSession from university where name = 'Fountain University Osogbo';", "select");
		$upper = $session[0][0] + 1;
		$this->Cell(0, 2, "Fountain University, Osogbo, Nigeria", 0, 0, 'C');
		$this->ln(5);
		$this->Cell(0, 2, "Departmental Summary Sheet  ", 0,0, 'C');
		$this->ln(5);
		$this->Cell(0, 2, "{$session[0][0]} / {$upper} Academic Session", 0, 0, 'C');
		$this->ln(5);
		
	}
function FancyTable($header, $data) {
/* Layout */

		
		$this->SetFont('Helvetica','B',12);
		
		$w = array(20,45, 30,30,30,30);
	
		for($i = 0; $i < count($header); $i++) {
			
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C',false);
			
		}
		$this->ln();
		//$this->SetFont('Arial', 'B', 12);
		
	
	$this->SetFont('Arial','',10);
	//$this->setDataFont(16);
	//Data
	
		$fill=false;

		$i = 0;


		$x0=$x = $this->GetX();
		$y = $this->GetY();
		
		$i = 0;
		
if(!empty($data)){
		foreach($data as $row)
		{
			
			
			$yH = 12;
	
	$this->SetXY($x, $y);
	$this->Cell($w[0], $yH, "", 'LRB',0,'',$fill);
	$this->SetXY($x, $y);
	$this->MultiCell($w[0],6,$row["matric"],0,'L');


	$this->SetXY($x + $w[0], $y);
	$this->Cell($w[1], $yH, "", 'LRB',0,'',$fill);
	$this->SetXY($x + $w[0], $y);
	$this->MultiCell($w[1],6,$row["name"],0,'L');


	$x =$x+$w[0];
	$this->SetXY($x + $w[1], $y);
	$this->Cell($w[2], $yH, "", 'LRB',0,'',$fill);
	$this->SetXY($x + $w[1], $y);
	$this->MultiCell($w[2],6,$row["previous"],0,'L');

	$x =$x+$w[1];
	$this->SetXY($x + $w[2], $y);
$this->Cell($w[3], $yH, "", 'LRB',0,'',$fill);
$this->SetXY($x + $w[2], $y);
$this->MultiCell($w[3],6,$row["present"],0,'L');

$x =$x+$w[2];
$this->SetXY($x + $w[3], $y);
$this->Cell($w[4], $yH, "", 'LRB',0,'',$fill);
$this->SetXY($x + $w[3], $y);
$this->MultiCell($w[4],6,$row["final"],0,'L');

$x = $x + $w[3];
$this->SetXY($x + $w[4], $y);
$this->Cell($w[4], $yH, "", 'LRB',0,'',$fill);
$this->SetXY($x + $w[3], $y);
$this->MultiCell($w[4],6,$row["remarks"],0,'L');
$y=$y+$yH; //move to next row
$x=$x0; //start from firt column
//$fill=!$fill; 
$i++;
			

		}
				
		$this->ln(10);
					
				
		}
}	
		
}	
		
		
		$db = DatabaseWrapper::getInstance();
		$this_lecturer = initLecturer();
		$level = $db->query("select * from level_advisers where lecturerId = '{$this_lecturer->id}';", "select");
			
		if(!empty($level)){
		
			$list_students = $db->query("select * from student_info where entryYear = '{$level[0]["entryYear"]}' and programmeId = '{$level[0]["programmeId"]}';", "select");
			$de_entry = $level[0]["entryYear"] + 1;
			$list_students2 = $db->query("select * from student_info where entryYear = '{$de_entry}' and programmeId = '{$level[0]["programmeId"]}' and (modeOfEntry = 'DFP' or modeOfEntry = 'DE');", "select");
			$student_list = array_merge($list_students, $list_students2);
		}
		$first_class_list = array();
		$second_upper_list = array();
		$second_lower_list = array();
		$third_class_list = array();
		$pass_list = array();
			
		
		if (!empty($student_list)){
			//var_dump($student_list);
			$upper = $session[0][0] + 1 ;
			$data = array();
			$data[0] = array("header", "Fountain University Osogbo", "Departmental Results", "{$upper} Academic Session");
			//var_dump($data);
			$summary_list = array();
			$fountain_scholar_count = 0;
			$pass_count = 0;
			$overall_cso_count = 0;
			$summary_array = array();
			for($i=0;$i<count($student_list);$i++){
				$this_student = Student::instantiate($student_list[$i]);
				$CSO_count = 0;
				$outstanding_array = array();
				//var_dump($student_list[$i]);
				$current_session = $this_student->entryYear;
				$cummulative_tnu = 0;
				$cummulative_tcp = 0;
				$previous_cgpa = 0;
				$previous_tcp = 0;
				$previous_tnu = 0;
				$semester_scores_string = "";
				$outstanding_string = "";
				for($current_semester = 1; $current_semester <= $this_student->currentSemester; $current_semester++){
					$courses = array();
					$semester_tnu = 0;
					$semester_tcp = 0;
					if($current_semester ==1 || $current_semester % 2 != 0){
						$course_list = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$current_session}' and semester = 1 ;", "select");
					}
					else{
						$course_list = $db->query("select * from coursestaken where studentId = '{$this_student->id}' and session = '{$current_session}' and semester = 2 ;", "select");
						$current_session = $current_session + 1;
					}
					if(!empty($course_list)){
						for($j=0;$j<count($course_list); $j++){
		
							$course_info = $db->query("select * from courses where code = '{$course_list[$i]["courseCode"]}';", "select");
		
							$courses[$j] = $course_info[0];
		
							$semester_tnu = $semester_tnu + $courses[$j]["units"];
							if($current_semester == $this_student->currentSemester){
								$m = $j + 1;
								if($m % 2 == 0)
									$semester_scores_string .= "{$course_list[$j]["courseCode"]} {$courses[$j]["units"]}  {$course_list[$j]["finalScore"]} {$course_list[$j]["grade"]},  ";
								else
									$semester_scores_string .= "{$course_list[$j]["courseCode"]} {$courses[$j]["units"]}  {$course_list[$j]["finalScore"]} {$course_list[$j]["grade"]}, ";
								if($course_list[$j]["grade"] == "F")
									$CSO_count = $CSO_count + 1;
							}
							if(($course_list[$j]["grade"] == "O") ||($course_list[$j]["grade"] == "F")){
								$outstanding_array[] = $course_list[$j]["courseCode"];
								$CSO_count = $CSO_count + 1;
							}
							
						}
					}
					else{
						//echo "<h4> There are no records for semester {$current_semester} <br />";
						continue;
					}
		
		
					//var_dump($courses);
					for($k = 0; $k < count($courses); $k++){
						$grade_credit_point;
						switch($course_list[$k]["grade"]){
							case "A":
								$grade_credit_point = 5 * $courses[$k]["units"];
								break;
							case "B":
								$grade_credit_point = 4 * $courses[$k]["units"];
								break;
							case "C":
								$grade_credit_point = 3 * $courses[$k]["units"];
								break;
							case "D":
								$grade_credit_point = 2 * $courses[$k]["units"];
								break;
							case "E";
							$grade_credit_point = 1 * $courses[$k]["units"];
							break;
							case "F";
							$grade_credit_point = 0 * $courses[$k]["units"];
							break;
							default:
								$grade_credit_point = 0 * $courses[$k]["units"];
								break;
						}
							
						$semester_tcp = $semester_tcp + $grade_credit_point;
						//if($course)
					}
		
		
					$cummulative_tcp = $cummulative_tcp + $semester_tcp;
					$cummulative_tnu = $cummulative_tnu + $semester_tnu;
					if(($semester_tnu != 0) || ($cummulative_tnu != 0) ){
						$semester_gpa = $semester_tcp / $semester_tnu;
						$cummulative_gpa = $cummulative_tcp/$cummulative_tnu;
						if(($this_student->currentSemester - $current_semester) == 1 ){
							$previous_cgpa = $cummulative_gpa;
							$previous_tcp = $cummulative_tcp;
							$previous_tnu = $cummulative_tnu;
						}
					}
		
				}
				if(!empty($outstanding_array)){
		
					for($p=0;$p<count($outstanding_array); $p++)
						$outstanding_string .= "{$outstanding_array[$p]} ";
				}
				else
					$outstanding_string = " ";
							$fuo_scholar_score = $db->query("select fountain_scholar from university where name = 'Fountain University Osogbo';", "select");
		
							if($cummulative_gpa >= $fuo_scholar_score[0][0])
								$fountain_scholar_count = $fountain_scholar_count + 1;
								if($CSO_count > 0 )
									$overall_cso_count = $overall_cso_count + 1;
								else
									$pass_count = $pass_count + 1;
								if($semester_scores_string != ""){
								$shortened_previous_gpa = sprintf("%.2f", $previous_cgpa);
								$shortened_previous_tnu = sprintf("%.2f", $previous_tnu);
								$shortened_previous_tcp = sprintf("%.2f", $previous_tcp);
									
								$shortened_gpa = sprintf("%.2f", $semester_gpa);
								$shortened_tnu = sprintf("%.2f", $semester_tnu);
								$shortened_tcp = sprintf("%.2f", $semester_tcp);
		
								$shortened_cumm_gpa = sprintf("%.2f", $cummulative_gpa);
								$shortened_cumm_tnu = sprintf("%.2f", $cummulative_tnu);
								$shortened_cumm_tcp = sprintf("%.2f", $cummulative_tcp);
								}
								else{
									$shortened_previous_gpa = "";
									$shortened_previous_tnu = "";
									$shortened_previous_tcp = "";
										
									$shortened_gpa = "";
									$shortened_tnu = "";
									$shortened_tcp = "";
									
									$shortened_cumm_gpa = "";
									$shortened_cumm_tnu = "";
									$shortened_cumm_tcp = "";
								}
								$summary_array[$i]["matric"] = $this_student->matricNo;
								$summary_array[$i]["name"] = $this_student->lname . " " . $this_student->fname;
								$summary_array[$i]["previous"] = $shortened_previous_gpa;
								$summary_array[$i]["present"] = $shortened_gpa;
								$summary_array[$i]["final"] = $shortened_cumm_gpa;
								
								if(($cummulative_gpa >= $fuo_scholar_score[0][0]) && ($this_student->level != 400) && ($this_student->currentSemester != 1)){
									$summary_array[$i]["remarks"] = "Fountain Scholar";
								}
								elseif(($cummulative_gpa >= $fuo_scholar_score[0][0]) && ($this_student->level == 400)){
									$summary_array[$i]["remarks"] = "First Class";
								}
								if($CSO_count > 0)
									$summary_array[$i]["remarks"] =  "PCSO";
								else 
									$summary_array[$i]["remarks"] = "PASS";
										
								
								
									
								if($this_student->currentSemester == 8){
									if($cummulative_gpa >= 4.5)
										$first_class_list[] = $summary_array[$i];
									elseif(($cummulative_gpa >= 3.5) && ($cummulative_gpa < 4.5))
									$second_upper_list[] = $summary_array[$i];
									elseif(($cummulative_gpa >= 2.5) && ($cummulative_gpa < 3.5))
									$second_lower_list[] = $summary_array[$i];
									elseif(($cummulative_gpa >= 1.5) && ($cummulative_gpa < 2.5))
									$third_class_list[] = $summary_array[$i];
									elseif(($cummulative_gpa >= 1) && ($cummulative_gpa < 1.5))
									$pass_list[] = $summary_array[$i];
								}
		
		
								$remark;
								if($CSO_count > 0)
									$remark =  "PCSO";
								else
									$remark =  "PASS";
									
								$j = $i + 1;
								$previous = "{$shortened_previous_tcp}  {$shortened_previous_tnu}  {$shortened_previous_gpa}";
								$present = "{$shortened_tcp}  {$shortened_tnu}  {$shortened_gpa}";
								$final = "{$shortened_cumm_tcp}  {$shortened_cumm_tnu}  {$shortened_cumm_gpa}";
								$pre = "{$j}         {$this_student->matricNo}  \n";
								$first = $pre . $semester_scores_string; 
								$data[] = array($j, $this_student->matricNo,$semester_scores_string,$outstanding_string, $previous,$present,$final, $summary_array[$i]);
			}
		}
		
		$header = array("Matric", "Name", "Previous", "Present", "Final", "Remarks");

		$pdf = new ThisPDF();
		$j = 0;
		$i = 1;
		
		$addHeader = true;
		
		
		
		
		//$pdf->SetFont('Helvetica','B',12);
		$pdf->AddPage('L','A4');
		//$pdf->Cell(0,15, "Summary", 0,0,'C');
		$pdf->Ln(15);
		$pdf->FancyTable($header, $summary_array);
				
		if((!empty($first_class_list)) ||(!empty($second_upper_list)) || (!empty($second_lower_list)) || (!empty($third_class_list)) || (!empty($pass_list))){
			$pdf->AddPage('L','A4');
			if(!empty($first_class_list)){
				$pdf->SetFont('Helvetica','B',12);
				$pdf->Cell(0,15, "First Class", 0,0,'C');
				$pdf->ln(15);
				$pdf->FancyTable($header, $first_class_list);	
			}
			if(!empty($second_upper_list)){
				$pdf->SetFont('Helvetica','B',12);
				$pdf->Cell(0,15, "Second Class Upper", 0,0,'C');
				$pdf->ln(15);
				$pdf->FancyTable($header, $second_upper_list);
			}
			if(!empty($second_upper_list)){
				$pdf->SetFont('Helvetica','B',12);
				$pdf->Cell(0,15, "Second Class Lower", 0,0,'C');
				$pdf->ln(15);
				$pdf->FancyTable($header, $second_lower_list);
			}
			if(!empty($third_class_list)){
				$pdf->SetFont('Helvetica','B',12);
				$pdf->Cell(0,15, "Third Class", 0,0,'C');
				$pdf->ln(15);
				$pdf->FancyTable($header, $third_class_list);
			}
			if(!empty($pass_list)){
				$pdf->SetFont('Helvetica','B',12);
				$pdf->Cell(0,15, "Pass", 0,0,'C');
				$pdf->ln(15);
				$pdf->FancyTable($header, $pass_list);
			}
		}		
		
			
		$pdf->Output();
		ob_start();
		ob_end_flush();
		?>

