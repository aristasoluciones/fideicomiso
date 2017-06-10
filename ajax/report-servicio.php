<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

session_start();

switch($_POST["type"])
{
	case "goToWorkflow":
		
			$_SESSION["search"]["rfc"] = $_POST["rfc"];
			$_SESSION["search"]["responsableCuenta"] = $_POST["responsableCuenta"];
			$_SESSION["search"]["status"] = $_POST["status"];
			$_SESSION["search"]["month"] = $_POST["month"];
			$_SESSION["search"]["year"] = $_POST["year"];
			$_SESSION["search"]["from"] = $_POST["from"];
			$_SESSION["search"]["atrasados"] = $_POST["atrasados"];
			
			echo "ok";
		
		break;
		
	case "search":
	case "sendEmail":
	case "graph":
			$year = $_POST['year'];
			
			$formValues['subordinados'] = $_POST['deep'];			
			$formValues['respCuenta'] = $_POST['responsableCuenta'];
			$formValues['departamentoId'] = $_POST["departamentoId"];
			$formValues['cliente'] = $_POST["rfc"];
			$formValues['atrasados'] = $_POST["atrasados"];

			//Actualizamos la clase del workflow, porque al generar los workflows la clase esta vacia (campo Class)
								
			$sql = "UPDATE instanciaServicio SET class = 'PorIniciar' 
					WHERE class = ''";
			$db->setQuery($sql);
			$db->UpdateData();
						
			$contracts = array();
			if($User['tipoPersonal'] == 'Asistente' || $User['tipoPersonal'] == 'Socio'){
				
				//Si seleccionaron TODOS
				if($formValues['respCuenta'] == 0){
				
					$personal->setActive(1);
					$socios = $personal->ListSocios();
					
					foreach($socios as $res){
						
						$formValues['respCuenta'] = $res['personalId'];
						$formValues['subordinados'] = 1;
						
						$resContracts = $contract->BuscarContract($formValues, true);
						
						$contracts = @array_merge($contracts, $resContracts);
						
						
					}//foreach
				
				}else{
					$contracts = $contract->BuscarContract($formValues, true);
				}
			
			}else{
				$contracts = $contract->BuscarContract($formValues, true);
			}//else
			//echo count($contracts);
			//print_r($contracts);
			$idClientes = array();
			$idContracts = array();
			$contratosClte = array();
			foreach($contracts as $res){
				
				$contractId = $res['contractId'];
				$customerId = $res['customerId'];
				
				if(!in_array($customerId,$idClientes))
					$idClientes[] = $customerId;
				
				if(!in_array($contractId,$idContracts)){
					$idContracts[] = $contractId;				
					$contratosClte[$customerId][] = $res;
				}
								
			}//foreach
						
			$clientes = array();
		//	print_r($idClientes);
		//	print_r($idContracts);
		//	print_r($contratosClte);
			foreach($idClientes as $customerId){
				
				$customer->setCustomerId($customerId);
				$infC = $customer->Info();
				
				$infC['contracts'] = $contratosClte[$customerId];
				
				$clientes[] = $infC;
				
			}//foreach
			
			$resClientes = array();
			foreach($clientes as $clte){
				//echo "jere";
				
				$contratos = array();
				foreach($clte['contracts'] as $con){
					//echo "jere2";
										
					//Checamos Permisos
					$resPermisos = explode('-',$con['permisos']);
					foreach($resPermisos as $res){
						$value = explode(',',$res);
						
						$idPersonal = $value[1];
						$idDepto = $value[0];
						
						$personal->setPersonalId($idPersonal);
						$nomPers = $personal->GetDataReport();
						
						$permisos[$idDepto] = $nomPers;
						$permisos2[$idDepto] = $idPersonal;
					}	
					
					//$personal->setPersonalId($con['responsableCuenta']);					
					//$con['responsable'] = $personal->Info();					
					
					$servicios = array();
					foreach($con['servicios'] as $serv){
												
						$servicio->setServicioId($serv['servicioId']);
						$infServ = $servicio->Info();
						
						$noCompletados = 0;
						for($ii = 1; $ii <= 12; $ii++){
							$statusColor = $workflow->StatusByMonth($serv['servicioId'], $ii , $year);
							
							$month = date("m");
							if($ii < $month){
								if($statusColor["class"] == "PorIniciar" || $statusColor["class"] == "Iniciado")
								{
									$noCompletados++;
								}
							}
							
							//Si es Servicio de Domicilio Fiscal, que no lleve colores
							if($statusColor['tipoServicioId'] == 16)
								$statusColor['class'] = '';

							if($statusColor['tipoServicioId'] == 34)
								$statusColor['class'] = '';

							if($statusColor['tipoServicioId'] == 24)
								$statusColor['class'] = '';

							if($statusColor['tipoServicioId'] == 37)
								$statusColor['class'] = '';

							$serv['instancias'][$ii] = $statusColor;
						}
						
						$tipoServicio->setTipoServicioId($infServ['tipoServicioId']);
						$deptoId = $tipoServicio->GetField('departamentoId');
						
						$serv['responsable'] = $permisos[$deptoId];
						
						if($formValues['atrasados'])
						{
							if($noCompletados > 0)
							{
								$servicios[] = $serv;
							}
						}
						else
						{
							$servicios[] = $serv;
						}
						
					}//foreach
					$con['instanciasServicio'] = $servicios;
																				
					$contratos[] = $con;
					
				}//foreach
				$clte['contracts'] = $contratos;
				
				$resClientes[] = $clte;
				
			}//foreach
			
			$cleanedArray = array();
			
			//$cleanedArray = $resClientes;

			foreach($resClientes as $key => $cliente)
			{
				foreach($cliente["contracts"] as $keyContract => $contract)
				{
						foreach($contract["instanciasServicio"] as $keyServicio => $servicio)
						{
							$card["comentario"] = $servicio["comentario"];
							$card["servicioId"] = $servicio["servicioId"];
							$card["nameContact"] = $cliente["nameContact"];
							$card["tipoPersonal"] = $servicio["responsable"]["tipoPersonal"];
							$card["responsable"] = $servicio["responsable"]["name"];
							$card["name"] = $contract["name"];
							$card["instanciasServicio"] = $servicio["instancias"];;
							$card["nombreServicio"] = $servicio["nombreServicio"];;
							$cleanedArray[] = $card;
						}
				}
			}
			
			$personalOrdenado = $personal->ArrayOrdenadoPersonal();
			
			$sortedArray = array();
			foreach($personalOrdenado as $personalKey => $personalValue)
			{
				foreach($cleanedArray as $keyCleaned => $cleanedArrayValue)
				{
					if($personalValue["name"] == $cleanedArrayValue["responsable"])
					{
						$sortedArray[] = $cleanedArrayValue;
						unset($cleanedArrayValue[$keyCleaned]);
					}
				}
			}
			
			$clientesMeses = array();
			$smarty->assign("cleanedArray", $sortedArray);
			$smarty->assign("clientes", $resClientes);
			$smarty->assign("clientesMeses", $clientesMeses);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/lists/report-servicio.tpl');
			
		break;
	
	case 'doSendEmail':
			
			$email = $_POST['email'];
			$message = utf8_decode($_POST['msg']);
			$mensaje = utf8_decode($_POST['msj']);
									
			//Iniciando la clase mail
			$mail = new PHPMailer(true);
					
			$html = nl2br($mensaje);
						
			$msgHtml = '<h2 align="center">REPORTE DE OBLIGACIONES</h2>';
			$msgHtml .= '<p>&nbsp;</p>';
			$msgHtml .=  $message;
			
			//Adjuntamos el archivo PDF
			$dompdf = new DOMPDF();
			$dompdf->set_paper('letter');
			$dompdf->load_html($msgHtml);
			$dompdf->render();
			
			//Guardamos el archivo temporalmente
			$pdfoutput = $dompdf->output(); 
			$filename = DOC_ROOT.'/temp/reporte_obligaciones.pdf'; 
			$fp = fopen($filename, "a"); 
			fwrite($fp, $pdfoutput); 
			fclose($fp);
			
			try {		
			 	
				$mail->IsSMTP(); 
				$mail->SMTPAuth = true; 
				$mail->Host = SMTP_HOST;  
				$mail->Username = SMTP_USER;  
				$mail->Password = SMTP_PASS; 
				$mail->Port = SMTP_PORT;
				
			 	$mail->AddAddress($email, '');
		 	  	$mail->SetFrom('no-reply@gmail.com', 'ROQUENI');
				$mail->Subject = 'Reporte de Obligaciones';
			  	$mail->MsgHTML($html);		  
			  	$mail->AddAttachment(DOC_ROOT.'/temp/reporte_obligaciones.pdf');      // attachment
			  	$mail->Send();				
				
				$util->setError(10040, "complete");
				
			} catch (phpmailerException $e) {				
				$util->setError(10018, "error");
			} catch (Exception $e) {				
				$util->setError(10018, "error");
			}
				
			echo 'ok[#]';
			
					  
			$util->PrintErrors();
			
			$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			
		break;
	
	case 'getEmail':
			
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-email-popup.tpl');
			
		break;
	case "editComentario":
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$servicio->setServicioId($_POST['servicioId']);
		$myServicio = $servicio->Info();
		$smarty->assign("post", $myServicio);
		$smarty->display(DOC_ROOT.'/templates/boxes/edit-comentario-popup.tpl');
		break;
	case "saveEditComentario":
		$servicio->setServicioId($_POST['servicioId']);
		$servicio->UpdateComentario($_POST['comentario']);

			echo "ok[#]";
			$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			echo "[#]";
			echo $_POST['comentario'];
		break;
}

?>
