<?php

// ========================================

// ** CALENDAR FUNCTIONS **

// -> calendar()

// -> next_day()
// -> prev_day()

// -> next_month()
// -> prev_month()

// -> date_suffix()

// ========================================



function calendar($y,$m,$d) {


	$curYear = date('Y');
	$curMonth = date('n');
	$curDay = date('j');

	$day = $d;
	$month = $m;
	$year = $y;

	if(isset($_GET['day'])) {
		$dayGet = $_GET['day'];
	}

	$headings = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

	$firstDay = date("l", mktime(0,0,0,$m, 1, $y)); // FIRST DAY OF THE MONTH
	$days = date("t", mktime(0,0,0,$m, 1, $y)); // NUMBER OF DAYS IN THE MONTH
	$dayStart = array_search($firstDay, $headings); // MATCHES FIRST DAY TO HEADINGS ARRAY

	// SETS VARIABLE IF WEEK REQUIRES BLANKS
	if ($dayStart > 0) {
		$blanks = TRUE;
	}

	// LOOP TO PRINT OUT CALENDAR

	$calendar = "<table>";
	$calendar .= "<tr>";

	// PRINTS WEEKDAYS TO ROW

	for ($i = 0; $i < count($headings); $i++) {
		$calendar .= '<th>' .substr($headings[$i], 0,3). '</th>';
	}

	$calendar .= "</tr>";

	// PRINTS ALL DATES

	for ($i = 1; $i <= $days; $i++) {
		$rows = count($headings);
		$calendar .= "<tr>";
		$blankCount = 0; // START OF MONTH BLANKS
		$endCal = 1; // END OF MONTH BLANKS

		// PRINTS DATES TO EACH ROW

		for ($d = 0; $d < $rows; $d++) {
			if ($i > $days) {
				$calendar .= '<td><div><p class="blanks">'.$endCal.'</p></div></td>';
				$endCal++;

			} else if (isset($blanks) && $blanks == TRUE) {
				$startCal = date("t", mktime(0,0,0,$m, 0, $y));
				$startCal = $startCal - ($dayStart - 1);

				// PRINTS BLANKS TO START OF MONTH

				for ($c = 0; $c < $dayStart; $c++) {
					$calendar .= '<td><div><p class="blanks">'.$startCal.'</p></div></td>';
					$startCal++;
					$blankCount++;
				}

				$blankCount = ($rows - $blankCount);

				// PRINTS REMAINDER OF MONTH AFTER BLANKS

				if ($blankCount > 0) {

					for ($a = 0; $a < $blankCount; $a++) {

						if (isset($dayGet) && $dayGet == $i) {
							$calendar .= '<td><div><a class="selected" href="' .BASE_URL.'/';

						} else {
							$calendar .= '<td><div><a href="' .BASE_URL.'/';
						}

						if ($month) {
							$calendar .= $year.'/'.$month;

						} else {
							$calendar .= $curYear.'/'.$curMonth;
						}

						$calendar .= '/'.$i.'"><span>' .$i. '</span></a></div></td>';

						$i++;
					}
				}

				$rows++;
				$calendar .= "</tr><tr>";
				$blanks = FALSE;

			} else {

				// PRINTS REMAINDER OF MONTH

				if (isset($dayGet) && $dayGet == $i) {
					$calendar .= '<td><div><a class="selected" href="' .BASE_URL.'/';

				} else {
					$calendar .= '<td><div><a href="' .BASE_URL.'/';
				}

				if ($month) {
					$calendar .= $year.'/'.$month;

				} else {
					$calendar .= $curYear.'/'.$curMonth;
				}

				$calendar .= '/'.$i.'"><span>' .$i. '</span></a></div></td>';

				$i++;
			}
		}

		$calendar .= "</tr>";
		$i--;
	}

	$calendar .= "</table>";
	print $calendar;
}





function next_day($y,$m,$d) {

	$nextDay = $d + 1;
	$lastDay =  date("t", mktime(0,0,0,$m, 1, $y));

	if($nextDay > $lastDay) {
		$m = $m + 1;
		$nextDay = 1;

		if($m == 13) {
			$nextYear = $y + 1;
			$nextMonth = 1;

		} else {
			$nextYear = $y;
			$nextMonth = $m;
		}

	} else {
		$nextMonth = $m;
		$nextYear = $y;
	}

	$newDate = $nextYear.'/'.$nextMonth.'/'.$nextDay;
	return $newDate;
}





function prev_day($y,$m,$d) {

	$prevDay = $d - 1;

	if ($d == 1) {
		$m = $m - 1;
		$prevDay =  date("t", mktime(0,0,0,$m, 1, $y));

		if ($m == 0) {
			$prevYear = $y - 1;
			$prevMonth = 12;

		} else {
			$prevYear = $y;
			$prevMonth = $m;
		}

	} else {
		$prevMonth = $m;
		$prevYear = $y;
	}

	$newDate = $prevYear.'/'.$prevMonth.'/'.$prevDay;
	return $newDate;

}





function prev_month($y,$m) {

	$month = $m - 1;

	if ($month == 0) {
		$month = 12;
		$year = $y - 1;

	} else {
		$year = $y;
	}

	return $year.'/'.$month;
}





function next_month($y,$m) {

	$month = $m + 1;

	if ($month == 13) {
		$month = 1;
		$year = $y + 1;

	} else {
		$year = $y;
	}

	return $year.'/'.$month;
}




function date_suffix($num) {

	if (!in_array(($num % 100),array(11,12,13))){
		switch ($num % 10) {
			case 1:
			return $num.'st';
			break;
			case 2:
			return $num.'nd';
			break;
			case 3:
			return $num.'rd';
			break;
		}
	}

	return $num.'th';
}
