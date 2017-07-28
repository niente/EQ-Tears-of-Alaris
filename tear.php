<?php
include 'core/core.php';
include 'core/core_tear.php';
$my_conn = Connect_DB('blank', 'blank');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB">
<head>
	<title>The Tears of Alaris</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta name="description" content="The Tears of Alaris" />
	<meta name="keywords" content="The Tears of Alaris" />
	<meta name="robots" content="index, follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="css/tear.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/tear1.css" media="screen" />
</head>
<body>
<div id="header">
	<h1>The Tears of Alaris</h1>
</div>
<div class="colmask threecol">
	<div class="colmid">
		<div class="colleft">
			<div class="col1">
				<!-- Column 1 start -->
            <?php
            Pull_LevelExp($my_conn);
            ?>
				<!-- Column 1 end -->
			</div>
			<div class="col2">
				<!-- Column 2 start -->
            <div id="formdiv">
                <form name='tearinputform' action="http://<?php echo $_SERVER['HTTP_HOST'], $_SERVER['PHP_SELF']; ?>" method='post'>
                    <fieldset>
                        <legend>Character Tear Stats</legend>
                        <label for="editlevelfield">Current Level:</label>
                        <input type="text" size="5" maxlength="2" id="editlevelfield" name="editlevel" value="1" />
                        <label for="editpercentfield">% of Next Level:</label>
                        <input type="text" size="5" maxlength="3" id="editpercentfield" name="editpercent" value="0" />
                        <label for="tearinput" ></label>
                        <input type="submit" name="tearinput" value="Submit" />
                    </fieldset>
                </form>
            </div>
            <?php
            if (isset($_POST['tearinput']))
            {
                Pull_Single_LevelExp($my_conn, $_POST['editlevel'], $_POST['editpercent']);
            }
            ?>
                                <!-- Column 2 end -->
			</div>
			<div class="col3">
				<!-- Column 3 start -->
            <table class="expchart" id="level100">
                <caption >EXP gained per Alaran kill (level 100)</caption>
                <tr>
                    <th># group members</th>
                    <th class="green_box">Green</th>
                    <th class="lightblue_box">Light Blue</th>
                    <th class="darkblue_box">Dark Blue</th>
                    <th class="white_box">White</th>
                    <th class="yellow_box">Yellow</th>
                    <th class="red_box">Red</th>
                </tr>
                <?php
                Pull_GroupExp($my_conn, 100);
                ?>
            </table>
            <table class="expchart" id="level105">
                <caption >EXP gained per Alaran kill (level 105)</caption>
                <tr>
                    <th># group members</th>
                    <th class="green_box">Green</th>
                    <th class="lightblue_box">Light Blue</th>
                    <th class="darkblue_box">Dark Blue</th>
                    <th class="white_box">White</th>
                    <th class="yellow_box">Yellow</th>
                    <th class="red_box">Red</th>
                </tr>
                <?php
                Pull_GroupExp($my_conn, 105);
                ?>
            </table>
                                <!-- Column 3 end -->
			</div>
		</div>
	</div>
</div>
<div id="footer">
    <?php
    if ($my_conn != null)
    {
        Disconnect_DB($my_conn);
    }
    ?>
    <br />
    <a href="http://validator.w3.org/check?uri=referer" onclick="target='_blank';">
        <img src="images/HTML5_Logo_32.png" width="33" height="32" alt="HTML5 Powered with CSS3 / Styling" title="HTML5 Powered with CSS3 / Styling">
    </a>
    <a href="http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fwww.info2059.com" onclick="target='_blank';">
    <img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" /></a>
</div>
</body>
</html>

