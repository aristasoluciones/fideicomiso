<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');


switch($_POST["type"])
{
		
	case 'doSearch':
			
					
			$sql = '';
			
			if($_POST['name'])
				$sql .= ' AND name LIKE "%'.$_POST['name'].'%"';
			if($_POST['folio'])
				$sql .= ' AND folio = "'.$_POST['folio'].'"';
			if($_POST['contCatId'])
				$sql .= ' AND contCatId = "'.$_POST['contCatId'].'"';
			if($_POST['status'])
				$sql .= ' AND status = "'.$_POST['status'].'"';

			$stOblig = $_POST['stOblig'];
											
			$resContracts = $contract->Search($sql);
			
			$contracts = array();
			foreach($resContracts as $key => $val){
				
				$card = $val;
				
				$card['name'] = utf8_encode($val['name']);
				
				$contCat->setContCatId($val['contCatId']);
				$card['tipo'] = $contCat->GetNameById();
				
				$contract->setContractId($val['contractId']);
				$card['stOblig'] = $contract->GetStatusOblig();
								
				$card['status'] = ucfirst($card['status']);
				
				if($stOblig){
					
					if($stOblig == $card['stOblig'])
						$contracts[$key] = $card;	
						
				}else
					$contracts[$key] = $card;
				
			}
			
			$totalRegs = count($contracts);
			
			echo 'ok[#]';
			
			$smarty->assign("contracts", $contracts);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/lists/report-cobranza.tpl');
			
			echo '[#]';
			
			echo 'Total de Registros: <b>'.$totalRegs.'</b>';
			
		break;
		
}
?>
