<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

switch($_POST["type"])
{
	case "addState": 
			
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-state-popup.tpl');
		
		break;	
		
	case "saveAddState":
			
			$state->setName($_POST['name']);			
											
			if(!$state->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resStates = $state->Enumerate();
				$states = $util->EncodeResult($resStates);
				
				$smarty->assign("states", $states);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/state.tpl');
			}
			
		break;
		
	case "deleteState":
			
			$state->setStateId($_POST['stateId']);
			if($state->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$resStates = $state->Enumerate();
				$states = $util->EncodeResult($resStates);
				
				$smarty->assign("states", $states);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/state.tpl');
			}
			
		break;
		
	case "editState":	 
			
			$state->setStateId($_POST['stateId']);
			$info = $state->Info();
				
			$smarty->assign("post", $info);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-state-popup.tpl');
		
		break;
		
	case "saveEditState":
			
			$state->setStateId($_POST['stateId']);
			$state->setName($_POST['name']);			
									
			if(!$state->Update())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resStates = $state->Enumerate();
				$states = $util->EncodeResult($resStates);
				
				$smarty->assign("states", $states);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/state.tpl');
			}
			
		break;
		
}
?>
