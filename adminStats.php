<?php
include('biblioPOO.php');

	
if (!empty($_SESSION['status']) && ($_SESSION['status'] == 'admin')) {
		$idUser = $_SESSION['login'];
		$content = "";

		$months = array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December');
		
		
		
		$sqlStatsBuying = new SQL();
			
		$content .= "<table><tr>
		<th>Month</th>
		<th>Sum of Total $ receiving in this month</th>
		</tr>";
		$reqStatsBuying = $sqlStatsBuying->command("SELECT EXTRACT(MONTH FROM dateRegistration) as month, SUM(`sumTotal`) as Total FROM orders WHERE status = 2 GROUP BY month");
		
		foreach($reqStatsBuying as $rowStatsBuying) {
			$month = $months[$rowStatsBuying['month']];
			$content .= "<tr>
			<td>$month</td>
			<td>$rowStatsBuying[Total]$</td>			
			</tr>";
		}

		$content .= '</table>';




	$title = 'ADMIN STATS OF BUYING';
	
	include('assets/elems/layout.php');
}
else {
	$_SESSION['message'] = [
					'text' => 'This Page only for admins!', 
					'status' => 'danger'
					];
	header('Location: login.php'); die();
}