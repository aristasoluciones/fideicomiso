<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
switch($_POST["type"])
{
	case "addSociedad": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-sociedad-popup.tpl');
		break;	
	case "saveAddSociedad":
			$sociedad->setNombreSociedad($_POST['nombreSociedad']);
			if(!$sociedad->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resSociedad = $sociedad->Enumerate();
				$smarty->assign("resSociedad", $resSociedad);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/sociedad.tpl');
			}
		break;
	case "deleteSociedad":
			$sociedad->setSociedadId($_POST['sociedadId']);
			if($sociedad->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$resSociedad = $sociedad->Enumerate();
				$smarty->assign("resSociedad", $resSociedad);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/sociedad.tpl');
			}
		break;
	case "editSociedad": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$sociedad->setSociedadId($_POST['sociedadId']);
			$mySociedad = $sociedad->Info();
			$smarty->assign("post", $mySociedad);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-sociedad-popup.tpl');
		break;
	case "saveEditSociedad":
			$sociedad->setSociedadId($_POST['sociedadId']);
			$sociedad->setNombreSociedad($_POST['nombreSociedad']);
			if(!$sociedad->Edit())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resSociedad = $sociedad->Enumerate();
				$smarty->assign("resSociedad", $resSociedad);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/sociedad.tpl');
			}
		break;
}
?>
