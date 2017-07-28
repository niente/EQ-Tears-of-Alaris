<?php
/*************************************************************************
 * Beginning of Module
 * Filename: core.php
 * Description:
 * Change Log
 * Date		Initials	Change
 * 20150118	AAA			Cleaned up code.
 * 20150117	AAA			Ticket #123
 * 20150114	AAA			Created.
 *************************************************************************/

/*************************************************************************
 * Includes
 *************************************************************************/

/*************************************************************************
 * Begin code
 *************************************************************************/

/*************************************************************************
 * Function: Pull_GroupExp
 *************************************************************************/

function Pull_GroupExp($cur_conn, $toon_level)
{
	$query = "SELECT NuminGroup, Exp_Green, Exp_LightBlue, Exp_DarkBlue, Exp_White, Exp_Yellow, Exp_Red FROM GroupExpLevel Where Toon_Level = ?";
	$stmt = mysqli_stmt_init($cur_conn);  // prepare statement. protects from sql injections
	if (mysqli_stmt_prepare($stmt, $query)) //if we can prepare statement -
	{
		mysqli_stmt_bind_param($stmt, 'i', $toon_level);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $numingroup, $exp_green, $exp_lightblue, $exp_darkblue, $exp_white, $exp_yellow, $exp_red);
		if (mysqli_stmt_num_rows($stmt) > 0)
		{
/*
  			<table class="expchart" id="level100">
            <caption >EXP gained per Alaran kill (level 100)</caption>
            <tr>
            <th class="white_box"># group members</th>
            <th class="green_box">Green</th>
            <th class="lightblue_box">Light Blue</th>
            <th class="darkblue_box">Dark Blue</th>
            <th class="white_box">White</th>
            <th class="yellow_box">Yellow</th>
            <th class="red_box">Red</th>
            </tr>
 			<tr>
                <td>1</td>
                <td>20</td>
                <td>30</td>
                <td>71</td>
                <td>111</td>
                <td>120</td>
                <td>131</td>
            </tr>
			echo '<table style="float: right">';
			echo '<tr>';
			echo '<th>' . 'Level' . '</th>';
			echo '<th>total exp for each level</th>';
			echo '<th>exp to next level</th>';
			echo '<th>exp gained per fragment</th>';
			echo '<th># fragments to level</th>';
			echo '<th>% xp/click</th>';
			echo '</tr>';
 */
			while ($row = mysqli_stmt_fetch($stmt)) //for every row in result
			{
				echo '<tr>';
				echo '<td>' . $numingroup . '</td>';
				echo '<td>'. $exp_green . '</td>'; // each name goes in a list
				echo '<td>' . $exp_lightblue . '</td>';
				echo '<td>' . $exp_darkblue . '</td>';
				echo '<td>' . $exp_white . '</td>';
				echo '<td>' . $exp_yellow . '</td>';
				echo '<td>' . $exp_red . '</td>';
				echo '</tr>';
			}    //while
			echo '</table>';
		}    //if
		mysqli_stmt_free_result($stmt); // free memory
		mysqli_stmt_close($stmt); // close statement
	}    //if
}	//End of function Pull_GroupExp()


/*************************************************************************
 * Function: Pull_LevelExp
 *************************************************************************/

function Pull_LevelExp($cur_conn)
{
	$query = "SELECT Level, totexp, lvlexp, fragexp, numfrag, pctexp FROM TearExp";
	$stmt = mysqli_stmt_init($cur_conn);  // prepare statement. protects from sql injections
	if (mysqli_stmt_prepare($stmt, $query)) //if we can prepare statement -
	{
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $level, $totexp, $lvlexp, $fragexp, $numfrag, $pctexp);
		if (mysqli_stmt_num_rows($stmt) > 0)
		{
			echo '<table>';
			echo '<tr>';
			echo '<th>' . 'Level' . '</th>';
			echo '<th style="width: 5.5em;">total exp for each level</th>';
			echo '<th  style="width: 4.4em;">exp to next level</th>';
			echo '<th  style="width: 5.5em;">exp gained per fragment</th>';
			echo '<th  style="width: 5em;"># fragments to level</th>';
			echo '<th  style="width: 2.5em;">% xp / click</th>';
			echo '</tr>';
			while ($row = mysqli_stmt_fetch($stmt)) //for every row in result
			{
				echo '<tr>';
				echo '<td>' . $level . '</td>';
				echo '<td>'. $totexp . '</td>'; // each name goes in a list
				echo '<td>' . $lvlexp . '</td>';
				echo '<td>' . $fragexp . '</td>';
				echo '<td>' . $numfrag . '</td>';
				echo '<td>' . $pctexp . '</td>';
				echo '</tr>';
			}    //while
			echo '</table>';
		}    //if
		mysqli_stmt_free_result($stmt); // free memory
		mysqli_stmt_close($stmt); // close statement
	}    //if
}	//End of function Pull_LevelExp()

/*************************************************************************
 * Function: Pull_Single_LevelExp_OLD
 *************************************************************************/

function Pull_Single_LevelExp_OLD($cur_conn, $mylevel)
{
	$query = "SELECT Level, totexp, lvlexp, fragexp, numfrag, pctexp FROM TearExp WHERE Level=?";
	$query2 = "SELECT SUM(numfrag) FROM TearExp WHERE Level > ?";

	$stmt = mysqli_stmt_init($cur_conn);  // prepare statement. protects from sql injections

	if (mysqli_stmt_prepare($stmt, $query2)) //if we can prepare statement -
	{
		mysqli_stmt_bind_param($stmt, 'i', $mylevel);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $tot_num_frags);
		if (mysqli_stmt_fetch($stmt))
		{
//			$tot_num_frags = ceil($tot_num_frags);
//			echo 'HERE 2 ' . $tot_num_frags;
		}	//if

	}	//if

	if (mysqli_stmt_prepare($stmt, $query)) //if we can prepare statement -
	{
		$max_level_num = 20;
		mysqli_stmt_bind_param($stmt, 'i', $max_level_num);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $level, $totexp, $lvlexp, $fragexp, $numfrag, $pctexp);
		mysqli_stmt_fetch($stmt);
		$max_exp = $totexp;

		mysqli_stmt_bind_param($stmt, 'i', $mylevel);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $level, $totexp, $lvlexp, $fragexp, $numfrag, $pctexp);

		if (mysqli_stmt_num_rows($stmt) > 0)
		{
			if (mysqli_stmt_fetch($stmt))
			{
				echo '<table class="resultchart" >';
				echo '<tr>';
				echo '<th>' . 'Level:' . '</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . $level . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<th>Current experience:</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>'. $totexp . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<th>Exp to level:</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . $lvlexp . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<th>Clicks to level:</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . round(($lvlexp / $fragexp), 1, PHP_ROUND_HALF_UP) . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<th>Exp to max:</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . ($max_exp - $totexp) . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<th>Alarans to level (LB)</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . ceil($lvlexp / 3) . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<th>Alarans to max (LB)</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . ceil(($max_exp - $totexp) / 3) . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<th>Alarans to level (LB) - solo</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . ceil($lvlexp / 8) . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<th>Alarans to max (LB) - solo</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . ceil(($max_exp - $totexp) / 8) . '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<th>Clicks to max</th>';
				echo '</tr>';
				echo '<tr>';
				// replace $numfrag with query2 result
				echo '<td>' . ceil(round(($lvlexp / $fragexp), 1, PHP_ROUND_HALF_UP) + $tot_num_frags) . '</td>';
				echo '</tr>';
				echo '</table>';
			}	//if
		}    //if
		mysqli_stmt_free_result($stmt); // free memory
		mysqli_stmt_close($stmt); // close statement
	}    //if
}	//End of function Pull_Single_LevelExp_OLD()

/*************************************************************************
 * Function: Pull_Single_LevelExp
 *************************************************************************/

function Pull_Single_LevelExp($cur_conn, $mylevel, $mypercent)
{

	if ($mylevel <= 0)
	{
		echo '<br />';
		echo '<table>';//****
		echo '<tr>';//****
		echo '<td>';//****
		echo 'Level needs to be greater than zero';
		echo '</td></tr></table>';
		return;
	}	//if
	else if ($mylevel > 19)
	{
		echo '<br />';
		echo '<table>';//****
		echo '<tr>';//****
		echo '<td>';//****
		echo 'Level needs to be less than 20';
		echo '</td></tr></table>';
		return;
	}	//else if
	//Force $mypercent to be a number. If someone puts in 025 it use to display 025, but adding 0 means
	//even a blank becomes a number 0.
	$mypercent += 0;
	if ($mypercent >= 100)
	{
		//we can't / shouldn't support numbers greater than 100 so error
		echo '<br />';
		echo '<table>';//****
		echo '<tr>';//****
		echo '<td>';//****
		echo 'Percent needs to be less than 100';
		echo '</td></tr></table>';
		return;
	}	//if
	$query = "SELECT Level, totexp, lvlexp, fragexp, numfrag, pctexp FROM TearExp WHERE Level=?";
	$query2 = "SELECT SUM(numfrag) FROM TearExp WHERE Level > ?";

	$stmt = mysqli_stmt_init($cur_conn);  // prepare statement. protects from sql injections

	if (mysqli_stmt_prepare($stmt, $query2)) //if we can prepare statement -
	{
		mysqli_stmt_bind_param($stmt, 'i', $mylevel);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $tot_num_frags);
		if (mysqli_stmt_fetch($stmt))
		{
//			$tot_num_frags = ceil($tot_num_frags);
		}	//if

	}	//if

	if (mysqli_stmt_prepare($stmt, $query)) //if we can prepare statement -
	{
		$max_level_num = 20;
		mysqli_stmt_bind_param($stmt, 'i', $max_level_num);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $level, $totexp, $lvlexp, $fragexp, $numfrag, $pctexp);
		mysqli_stmt_fetch($stmt);
		$max_exp = $totexp;

		$next_level = $mylevel + 1; // look up exp of NEXT level
		mysqli_stmt_bind_param($stmt, 'i', $next_level);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $level, $totexp, $lvlexp, $fragexp, $numfrag, $pctexp);
		mysqli_stmt_fetch($stmt);
		$next_level_exp = $totexp; // OK

		mysqli_stmt_bind_param($stmt, 'i', $mylevel);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $level, $totexp, $lvlexp, $fragexp, $numfrag, $pctexp);
		$curr_level_exp = $lvlexp;

		if (mysqli_stmt_num_rows($stmt) > 0)
		{
			if (mysqli_stmt_fetch($stmt))
			{
				// calculate variables
				// current experience = exp for this level + % entered by user / 100 * exp needed for next level
				$curr_exp = round(($totexp + ($mypercent/100)*$lvlexp), 0, PHP_ROUND_HALF_UP);
				// exp to next level = total xp for next level - current exp
				$exp_to_level = ($next_level_exp - $curr_exp);
				// exp to max = total exp for entire tear - current exp
				$exp_to_max = ($max_exp - $curr_exp);
				// tablets to level = exp to next level / exp gained per fragment
				$tablets_to_level = round(($exp_to_level/$fragexp), 0, PHP_ROUND_HALF_UP);
				// tablets to max = tablets to level + $tot_num_frags (sum of fragments for all levels OVER the current level)
				$tablets_to_max = ceil($tablets_to_level + $tot_num_frags);
				// alarans to level = exp to level / exp per alaran. group ~= 3 exp per alaran, solo = 8 exp
				// could change to let user input # group members, con, player level

				// debugging
				/*
				echo '<br />';
				echo 'DEBUG: ';
				echo '<br />';
				echo '$curr_exp: ' . $curr_exp;
				echo '<br />';
				echo '$max_exp: ' . $max_exp;
				echo '<br />';
				echo '$next_level_exp: ' . $next_level_exp;
				echo '<br />';
				echo '$exp_to_level: ' . $exp_to_level;
				echo '<br />';
				echo '$exp_to_max: ' . $exp_to_max;
				echo '<br />';
				echo '$tablets_to_level: ' . $tablets_to_level;
				echo '<br />';
				echo '$tablets_to_max: ' . $tablets_to_max;
				echo '<br />';
				*/

				//build table 1 (col 1) //****
				echo '<br />';
				echo '<table>';//****
				echo '<tr>';//****
				echo '<td>';//****
				echo '<table class="resultchart" >';
				echo '<tr>';
				echo '<th>' . 'Level:' . '</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . $level . '&nbsp&nbsp&nbsp&nbsp&nbsp' . $mypercent . '%' . '</td>'; // Level:
				echo '</tr>';
				echo '<tr>';
				echo '<th>Exp to level:</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . $exp_to_level . '</td>'; // xp to level
				echo '</tr>';
				echo '<tr>';
				echo '<th>Tablets to level:</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . $tablets_to_level . '</td>'; // clicks to level
				echo '</tr>';
				echo '<tr>';
				echo '<th>Alarans to level (LB) - group</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . ceil($exp_to_level / 3) . '</td>'; // alarans to level (group) assuming lvl 105
				echo '</tr>';
				echo '<tr>';
				echo '<th>Alarans to level (LB) - solo</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . ceil($exp_to_level / 8) . '</td>'; // alarans to level (solo) assuming lvl 105
				echo '</tr>';
				echo '</table>';
				echo '</td>'; //****
				// build table 2 (col 2) //****
				echo '<td>'; //****
				echo '<table class="resultchart" >';
				echo '<tr>';
				echo '<th>Current experience:</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>'. $curr_exp . '</td>'; // Current xp:
				echo '</tr>';
				echo '<tr>';
				echo '<th>Exp to max:</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . $exp_to_max . '</td>'; // exp to max
				echo '</tr>';
				echo '<tr>';
				echo '<th>Tablets to max:</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . $tablets_to_max . '</td>'; // clicks to max
				echo '</tr>';
				echo '<tr>';
				echo '<th>Alarans to max (LB) - group</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . ceil($exp_to_max / 3) . '</td>'; // alarans to max (group) assuming lvl 105
				echo '</tr>';
				echo '<tr>';
				echo '<th>Alarans to max (LB) - solo</th>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>' . ceil($exp_to_max / 8) . '</td>'; // alarans to max (solo) assuming lvl 105
				echo '</tr>';
				echo '</table>';
				echo '</td>';//****
				echo '</table>';//****
			}	//if
		}    //if
		mysqli_stmt_free_result($stmt); // free memory
		mysqli_stmt_close($stmt); // close statement
	}    //if
}	//End of function Pull_Single_LevelExp()

/*************************************************************************
 * End code
 *************************************************************************/

/*************************************************************************
 * End of Module
 *************************************************************************/
?>
