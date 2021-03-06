<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

session_start();

switch($_POST["type"])
{
    case 'showTask':
        $user->setUserId($User['userId']);
        $infU = $user->Info();
        $tipoPersonal = $infU['tipoPersonal'];

        $workflow->setInstanciaServicioId($_POST["instanciaServicioId"]);
        $data =  $workflow->getTasks();
        $smarty->assign("tipoPersonal", $tipoPersonal);
        $smarty->assign("stepId", $_POST['stepId']);
        $smarty->assign("data", $data);
        $smarty->assign("workFlowId", $_POST["instanciaServicioId"]);
        $smarty->display(DOC_ROOT.'/templates/lists/list-tasks.tpl');
    break;
    case 'showSixLevel':
        $_SESSION["search"]["rfc"] = $_POST["rfc"];
        $_SESSION["search"]["responsableCuenta"] = $_POST["responsableCuenta"];
        $_SESSION["search"]["status"] = $_POST["status"];
        $_SESSION["search"]["month"] = $_POST["month"];
        $_SESSION["search"]["year"] = $_POST["year"];
        $_SESSION["search"]["from"] = $_POST["from"];

        $workflow->setTipoOperacion('workflow');

        $workflow->setInstanciaServicioId($_POST["id"]);
        $myWorkflow = $workflow->Info();

        $result = $workflow->StatusById($_POST["id"]);

        $db->setQuery("UPDATE instanciaServicio SET class = '".$result["class"]."' 
        		   WHERE instanciaServicioId = '".$_POST["id"]."'");
        $db->UpdateData();

        $smarty->assign("dia", date("d"));

        $smarty->assign("myWorkflow", $myWorkflow);
        $smarty->assign('mainMnu','servicios');

        $from = $_SESSION["search"]["from"];

        if(!$from){
            $from = "servicios";
        }

        $user->setUserId($User['userId']);
        $infU = $user->Info();
        $tipoPersonal = $infU['tipoPersonal'];

        $smarty->assign("from", $from);
        $smarty->assign("uplToken", $_SESSION['uplToken']);
        $smarty->assign("tipoPersonal", $tipoPersonal);
        $smarty->assign("stepId", $_POST["stepId"]);
        $smarty->assign("workFlowId", $_POST["id"]);

        echo "ok[#]";
        $smarty->display(DOC_ROOT.'/templates/lists/list-six-level.tpl');
        echo "[#]";
        $smarty->display(DOC_ROOT.'/templates/lists/detail-six-level.tpl');


    break;
	case "goToWorkflow":
		
		$_SESSION["search"]["rfc"] = $_POST["rfc"];
		$_SESSION["search"]["responsableCuenta"] = $_POST["responsableCuenta"];
		$_SESSION["search"]["status"] = $_POST["status"];
		$_SESSION["search"]["month"] = $_POST["month"];
		$_SESSION["search"]["year"] = $_POST["year"];
		$_SESSION["search"]["from"] = $_POST["from"];
		echo "ok";
		break;
	case "search":
	case "sendEmail":
	case "graph":
			//print_r($_POST);
			if($_POST["rfc"] == "")
			{
				$_POST["cliente"] = 0;
			}
			$clientes = $customer->Enumerate("subordinado", $_POST["cliente"]);
//			echo "<pre>";
//			print_r($clientes);
			$clientes = $workflow->EnumerateWorkflows($clientes, $_POST["month"], $_POST["year"]);
			$smarty->assign("clientes", $clientes);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			
			if($_POST["type"] == "graph")
			{
				//echo "create graph";
				include_once(DOC_ROOT."/libs/graph/graph.php");
				?>
        <div style="text-align:center; float:left"">
        <img src="<?php echo WEB_ROOT ?>/imagefile.png" />
        </div>
        <?php

				include_once(DOC_ROOT."/libs/graph/graphContract.php");
				?>
        <div style="text-align:left; float:left">
        <img src="<?php echo WEB_ROOT ?>/imagefile_contract.png" />
        </div>
        <?php

				include_once(DOC_ROOT."/libs/graph/graphServices.php");
				?>
        <div style="text-align:left; float:left">
        <img src="<?php echo WEB_ROOT ?>/imagefile_services.png" />
        </div>
        <?php

				include_once(DOC_ROOT."/libs/graph/graphSteps.php");
				?>
        <div style="text-align:left; float:left">
        <img src="<?php echo WEB_ROOT ?>/imagefile_steps.png" />
        </div>
        <?php

				$smarty->display(DOC_ROOT.'/templates/lists/report-obligaciones.tpl');
			}
			else
			{
				$smarty->display(DOC_ROOT.'/templates/lists/report-obligaciones.tpl');
			}
								
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
    case 'uploadFile':
            $workflow->setInstanciaServicioId($_POST["servicioId"]);
            if($workflow->UploadControl())
            {
                echo 'ok[#]';
                $user->setUserId($User['userId']);
                $infU = $user->Info();
                $tipoPersonal = $infU['tipoPersonal'];

                $workflow->setInstanciaServicioId($_POST["instanciaId"]);
                $data =  $workflow->getTasks();
                $smarty->assign("tipoPersonal", $tipoPersonal);
                $smarty->assign("msgRes", "Archivo guardado correctamente");
                $smarty->assign("stepId", $_POST['stepId']);
                $smarty->assign("data", $data);
                $smarty->assign("workFlowId", $_POST["instanciaId"]);
                $smarty->display(DOC_ROOT.'/templates/lists/list-tasks.tpl');

            }else{
                echo 'fail[#]';
                echo "[#]";
                echo "Hubo un error al guardar archivo intente de nuevo";
            }

    break;
				
}

?>
