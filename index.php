<?php
 /**
     * @author Pankaj Kumar Jha
     * @version $1.0.0$
     * @copyright Global Codester
     * @access Public
     * @uses This is an ATM process program. User will enter amount and program will execute. 
     		After completion of execution of program it will display all information.
     */
@session_start();
$notes=array(  		1=>0,
					2=>0,
					5=>0,
					10=>0,
					20=>0,
					50=>0,
					100=>0,
					500=>0,
					1000=>0
				);

function transaction($amountForTransaction,$atmAmount)
{
	$notesInATM=setAtmAmount();
	if($notesInATM[$atmAmount] > 0){
		$noOfNotes = floor($amountForTransaction/$atmAmount);
		if($noOfNotes > 0){
			$noOfNotes = ($notesInATM[$atmAmount] < $noOfNotes) ? $notesInATM[$atmAmount] : $noOfNotes;  
			$amountForTransaction=($amountForTransaction - $noOfNotes*$atmAmount);
			$notes[$atmAmount]=$noOfNotes;
		}
		return isset($notes[$atmAmount]) ? $notes[$atmAmount] : 0; 
	}
}

function setAtmAmount()
{
	if(!isset($_SESSION['noteInAtm'])){
		$notesInATM=array(  1=>10,
							2=>10,
							5=>10,
							10=>10,
							20=>10,
							50=>10,
							100=>10,
							500=>10,
							1000=>10
						);
	}else{
		$notesInATM = $_SESSION['noteInAtm'];
	}
		return $notesInATM;
}

function setAmountForTransaction($notes, $amountForTransaction)
{
	$amt=calculateAmountFromArray($notes);
	return ($amountForTransaction - $amt);
}

function calculateAmountFromArray($notes)
{
	$amt=0;
	foreach($notes as $key=>$val){
		$amt +=$key*$val;
	}
	return $amt;
}

function printAvaliableAmountInATM($userInputAmount)
{
	$noteInAtm=setAtmAmount();
	echo "**************************************************<br />";	
	echo "<b>Amount avaliable in ATM after Transaction for amount $userInputAmount.</b><br />";
		foreach($noteInAtm as $key=>$val){
			echo $key."x".$val ."=" . $val."<br />";
		}		
}

function updateAtmAmount($notesInATM, $notes)
{
		$notesInATM[1000]=$notesInATM[1000]- $notes[1000];
		$notesInATM[500]=$notesInATM[500]- $notes[500];
		$notesInATM[100]=$notesInATM[100]- $notes[100];
		$notesInATM[50]=$notesInATM[50]- $notes[50];
		$notesInATM[20]=$notesInATM[20]- $notes[20];
		$notesInATM[10]=$notesInATM[10]- $notes[10];
		$notesInATM[5]=$notesInATM[5]- $notes[5];
		$notesInATM[2]=$notesInATM[2]- $notes[2];
		$notesInATM[1]=$notesInATM[1]- $notes[1];	
		return $notesInATM;
}

function startTransactionProcess($userInputAmount)
{
	$noteInAtm=setAtmAmount();
	$totalNoteCount=calculateAmountFromArray($noteInAtm);
	if($totalNoteCount > $userInputAmount){
	$amountForTransaction=$userInputAmount;
	$notes[1000]=transaction($amountForTransaction,1000);
	$amountTransaction=setAmountForTransaction($notes,$amountForTransaction);
	$notes[500]=transaction($amountTransaction,500);
	$amountTransaction=setAmountForTransaction($notes,$amountForTransaction);
	$notes[100]=transaction($amountTransaction,100);
	$amountTransaction=setAmountForTransaction($notes,$amountForTransaction);
	$notes[50]=transaction($amountTransaction,50);
	$amountTransaction=setAmountForTransaction($notes,$amountForTransaction);
	$notes[20]=transaction($amountTransaction,20);
	$amountTransaction=setAmountForTransaction($notes,$amountForTransaction);
	$notes[10]=transaction($amountTransaction,10);
	$amountTransaction=setAmountForTransaction($notes,$amountForTransaction);
	$notes[5]=transaction($amountTransaction,5);
	$amountTransaction=setAmountForTransaction($notes,$amountForTransaction);
	$notes[2]=transaction($amountTransaction,2);
	$amountTransaction=setAmountForTransaction($notes,$amountForTransaction);
	$notes[1]=transaction($amountTransaction,1);
	$_SESSION['noteInAtm']=updateAtmAmount($noteInAtm, $notes);
		echo "**************************************************<br />";	
		echo "<b>Transaction for amount $userInputAmount Completed Successfully.</b><br />";
		foreach($notes as $key=>$val){
			echo $key."x".$val ."=" . $key*$val."<br />";
		}	

		printAvaliableAmountInATM($userInputAmount);
		echo "<br />**************************************************<br />";		
	}
	else
	{
		echo "**************************************************<br />";
		echo "<b>InSufficient Transaction Amount $userInputAmount , Try with less amount</b><br />";
		echo "<br />**************************************************<br />";	
	}
}
startTransactionProcess(3045);
startTransactionProcess(1045);
startTransactionProcess(505);

/* Output:

**************************************************
Transaction for amount 3045 Completed Successfully.
1000x3=3000
500x0=0
100x0=0
50x0=0
20x2=40
10x0=0
5x1=5
2x0=0
1x0=0
**************************************************
Amount avaliable in ATM after Transaction for amount 3045.
1x10=10
2x10=10
5x9=9
10x10=10
20x8=8
50x10=10
100x10=10
500x10=10
1000x7=7

*/

?>
