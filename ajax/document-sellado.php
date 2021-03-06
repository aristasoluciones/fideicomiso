<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

switch($_POST["type"])
{
	case "addDocument": 
			
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-document-sellado-popup.tpl');
		
		break;	
		
	case "saveAddDocument":
			
			$docSellado->setName($_POST['name']);
											
			if($_POST['active'])
				$docSellado->setActive(1);
			else
				$docSellado->setActive(0);
			
			if(!$docSellado->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resDocuments = $docSellado->Enumerate();
				$documents = $util->EncodeResult($resDocuments);
				
				$smarty->assign("documents", $documents);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/document-sellado.tpl');
			}
			
		break;
		
	case "deleteDocument":
			
			$docSellado->setDocSelladoId($_POST['docSelladoId']);
			if($docSellado->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$resDocuments = $docSellado->Enumerate();
				$documents = $util->EncodeResult($resDocuments);
				
				$smarty->assign("documents", $documents);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/document-sellado.tpl');
			}
			
		break;
		
	case "editDocument":	 
			
			$docSellado->setDocSelladoId($_POST['docSelladoId']);
			$info = $docSellado->Info();
						
			$smarty->assign("post", $info);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-document-sellado-popup.tpl');
		
		break;
		
	case "saveEditDocument":
			
			$docSellado->setDocSelladoId($_POST['docSelladoId']);
			$docSellado->setName($_POST['name']);
									
			if($_POST['active'])
				$docSellado->setActive(1);
			else
				$docSellado->setActive(0);
			
			if(!$docSellado->Update())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resDocuments = $docSellado->Enumerate();
				$documents = $util->EncodeResult($resDocuments);
				
				$smarty->assign("documents", $documents);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/document-sellado.tpl');
			}
			
		break;
		
}
?>
