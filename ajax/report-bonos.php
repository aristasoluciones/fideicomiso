<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

session_start();

switch($_POST["type"])
{


	case "search":
			$trimestre = explode(' ',$_POST['trimestre']);
			$anio = $_POST['anio'];


			$reportebonos->setAnio($anio);

			$reportebonos->setMesUno($trimestre[0]);
			$reportebonos->setMesDos($trimestre[1]);
			$reportebonos->setMesTres($trimestre[2]);

			$reportebonos->setPersonalId($_POST['personalId']);
			$reportebonos->setDepartamentoId($_POST['departamentoId']);

			if ($_POST['personalId'] == "" || $_POST['personalId'] == 0) {
				echo "<o style='color:red'>Selecciona Supervisor.....</o><br>";
			}
			if ($_POST['departamentoId'] == "") {
				echo "<o style='color:red'>Selecciona Departamento.....</o><br>";
			}

			if ($_POST['personalId'] != 0 && $_POST['personalId'] != '' && $_POST['departamentoId'] != '') {
				$INFO = $reportebonos->DATOS_REPORTE_BONO();
				echo "ok[#]";
				$smarty->assign("DATOS", $INFO['DATOS']);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/report-bonos.tpl');
			}

		break;

}

?>
