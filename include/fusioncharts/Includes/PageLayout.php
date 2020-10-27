<?php
include_once("Functions.php");

// This page just contains functions to render page layout.
function render_pageHeader() {
	//This function renders the page header. It includes headers too.
	$htmldata = <<<HTMLINFO
	<table width="960" align="center" cellpadding="0" cellspacing="0" border="0" background="images/PageBg.jpg">
		

		<tr>
			<td width="33">		
			</td>
			<td height="1" colspan="2" bgColor="#EEEEEE">
			</td>
			<td width="37">		
			</td>
		</tr>
HTMLINFO;

	return $htmldata;
}

//This function renders the page table open
function render_pageTableOpen() {
	$htmldata = <<< HTMLINFO
	<tr>
		<td height="10" colspan="4">
		</td>
	</tr>

	<tr>
		<td width="33">	
		</td>
		<td colspan="2">		
HTMLINFO;

	return $htmldata;
}

//This function renders the page table closing tags
function render_pageTableClose() {
	$htmldata = <<<HTMLINFO
			<br>
			</td>
			<td width="37">
			&nbsp;
			</td>
		</tr>	
		
		<tr>
			<td width="33" height="10">		
			</td>
			<td align="center" colspan="2">
			
           	</td>
			<td width="33">
			</td>
		</tr>		
		
		
		<tr>
			<td height="4" colspan="4">		
			</td>			
		</tr>
	</table>
HTMLINFO;

	return $htmldata;
}

//This function draws a separator line between two tables
function drawSepLine() {
	$htmldata = <<<HTMLINFO
	<table width="875">
		<tr>
			<td width="33">		
			</td>
			<td height="1" colspan="2" bgColor="#EEEEEE">
			</td>
			<td width="37">		
			</td>
		</tr>
	</table>
HTMLINFO;

	return $htmldata;
}

//This function renders the year selection form
function render_yearSelectionFrm($intYear) {
    	global $dsql;
if (getAnimationState()=="1") {
        $animateYes = "checked";
        $animateNo  = "";
    } else {
        $animateYes = "";
        $animateNo  = "checked";
    }

    // Function to connect to the DB

    //Retrieve the years
    $strSQL = "SELECT DISTINCT FROM_UNIXTIME(mtime,'%Y') As Year FROM dede_crm ORDER BY 1";
	$dsql->SetQuery($strSQL);
    $dsql->Execute();
     $strYears = "";
   while($ors = $dsql->GetArray())
    {
    //Render them in drop down box	
            if ($intYear == $ors['Year'])
                $checked="checked";
            else
                $checked="";

            $strYears .= "<input type='radio' name='year' value='" . $ors['Year'] . "' " . $checked . "><span class='text'>" . $ors['Year'] . "</span>";
    }


    $htmldata = <<<HTMLINFO

<!-- Code to render the form for year selection and animation selection -->
<table>

<form name="frmYr" action="fx.php" method="post" id="frmYr">
<tr height="30">
	<td width="33">		
	</td>
	<td height="22" colspan="2" align="center"  valign="middle">
	<nobr>
	<span class="textbolddark">选择年: </span>
$strYears
	<span class="textbolddark"><span class='text'>&nbsp;&nbsp;&nbsp;</span>动画: </span>

    <input type="radio" name="animate" value="1" $animateYes><span class="text">是</span>
	<input type="radio" name="animate" value="0" $animateNo><span class="text">否</span>

    <span class='text'>&nbsp;&nbsp;</span>
	<input type="submit" class="button" value="Go" id="submit" 1 name="submit" 1>
	
	</nobr>	
	</td>
	<td width="37">		
	</td>
</tr>
</form>	
</table>
<!-- End code to render form -->

HTMLINFO;

	return $htmldata;
}
?>