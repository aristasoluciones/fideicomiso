<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

session_start();

switch($_POST["type"])
{
	case "addCity": 
			
			$stateId = $_SESSION['idState'];
			
			$smarty->assign("stateId", $stateId);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-city-popup.tpl');
		
		break;	
		
	case "saveAddCity":
			
			$stateId = $_SESSION['idState'];
			
			$city->setStateId($stateId);
			$city->setName($_POST['name']);			
											
			if(!$city->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$city->setStateId($stateId);
				$resCities = $city->Enumerate();
				$cities = $util->EncodeResult($resCities);
				
				$smarty->assign("cities", $cities);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/city.tpl');
			}
			
		break;
		
	case "deleteCity":
			
			$stateId = $_SESSION['idState'];
			
			$city->setCityId($_POST['cityId']);
			
			if($city->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$city->setStateId($stateId);
				$resCities = $city->Enumerate();
				$cities = $util->EncodeResult($resCities);
				
				$smarty->assign("cities", $cities);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/city.tpl');
			}
			
		break;
		
	case "editCity":	 
			
			$city->setCityId($_POST['cityId']);
			$info = $city->Info();
				
			$smarty->assign("post", $info);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-city-popup.tpl');
		
		break;
		
	case "saveEditCity":
			
			$stateId = $_SESSION['idState'];
			
			$city->setCityId($_POST['cityId']);
			$city->setName($_POST['name']);			
									
			if(!$city->Update())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$city->setStateId($stateId);
				$resCities = $city->Enumerate();
				$cities = $util->EncodeResult($resCities);
				
				$smarty->assign("cities", $cities);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/city.tpl');
			}
			
		break;
		
}
?>
