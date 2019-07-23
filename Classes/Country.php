<?php 
trait Country
{
	public static function showSelectCountry($countryId = null){
	$sqlSelectCountry = new SQL;
	$reqSelectCountry = $sqlSelectCountry->selectAll('countries');
			$select = "<select name=\"country\">";	
				foreach ($reqSelectCountry as $rowSelectCountry){
					
					if ($rowSelectCountry['id'] == $countryId)					
						$selected = 'selected';
					else $selected = '';					
					
						$select .= "<option $selected value=\"$rowSelectCountry[id]\" name=\"$rowSelectCountry[name]\">$rowSelectCountry[name]</option>";
					

				}
			$select .= '</select>';
			return $select;
	}
	
}