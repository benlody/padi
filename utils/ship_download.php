
<?php

require_once __DIR__  . '/utils.php';

function ship_download($orders, $warehouse, $from, $to){

	$objPHPExcel = new \PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Kuang Lung")
								 ->setLastModifiedBy("Kuang Lung")
								 ->setTitle('Freight and Service Fee ('.$warehouse.') '.date("Y-m", strtotime($to)))
								 ->setSubject('Freight and Service Fee ('.$warehouse.') '.date("Y-m", strtotime($to)))
								 ->setDescription('Freight and Service Fee ('.$warehouse.') '.date("Y-m", strtotime($to)));

	$idx = 1;
	$total_service_fee = 0;
	$total_ship_fee = 0;

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, 'PO#')
				->setCellValue('B'.$idx, 'DC#')
				->setCellValue('C'.$idx, 'NAME')
				->setCellValue('D'.$idx, 'ITEM#')
				->setCellValue('E'.$idx, 'QTY')
				->setCellValue('F'.$idx, 'Req Date')
				->setCellValue('G'.$idx, 'SHIP TO')
				->setCellValue('H'.$idx, 'SHIPPING TYPE')
				->setCellValue('I'.$idx, 'Service Fee')
				->setCellValue('J'.$idx, 'FREIGTH')
				->setCellValue('K'.$idx, 'Tracking#')
				->setCellValue('L'.$idx, 'Date');

	$idx++;

	foreach ($orders as $order) {
		$content = json_decode($order['content'], true);
		$ship_info = json_decode($order['shipping_info'], true);

		$subtotal_service_fee = 0;
		$subtotal_ship_fee = 0;
		foreach ($content['crewpak'] as $crewpak => $info) {
			$service_fee = Fee::getCrewpackServiceFee($info['cnt'], $warehouse);
			$subtotal_service_fee += $service_fee;

			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$idx, $order['id'])
						->setCellValue('B'.$idx, $order['customer_id'])
						->setCellValue('C'.$idx, get_customer_name($order['customer_id']))
						->setCellValue('D'.$idx, $crewpak)
						->setCellValue('E'.$idx, $info['cnt'])
						->setCellValue('F'.$idx, $order['date'])
						->setCellValue('G'.$idx, $order['english_addr'])
						->setCellValue('H'.$idx, ShippingType::getShippingType($order['ship_type']))
						->setCellValue('I'.$idx, $service_fee)
						->setCellValue('J'.$idx, ' ')
						->setCellValue('K'.$idx, ' ')
						->setCellValue('L'.$idx, $order['done_date']);
			$idx++;
		}

		foreach ($content['product'] as $product => $info) {
			$service_fee = Fee::getProductServiceFee($info['cnt'], $warehouse);
			$subtotal_service_fee += $service_fee;

			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$idx, $order['id'])
						->setCellValue('B'.$idx, $order['customer_id'])
						->setCellValue('C'.$idx, get_customer_name($order['customer_id']))
						->setCellValue('D'.$idx, $product)
						->setCellValue('E'.$idx, $info['cnt'])
						->setCellValue('F'.$idx, $order['date'])
						->setCellValue('G'.$idx, $order['english_addr'])
						->setCellValue('H'.$idx, ShippingType::getShippingType($order['ship_type']))
						->setCellValue('I'.$idx, $service_fee)
						->setCellValue('J'.$idx, ' ')
						->setCellValue('K'.$idx, ' ')
						->setCellValue('L'.$idx, $order['done_date']);
			$idx++;
		}

		foreach ($ship_info as $info) {

			$ship_fee = $info['request_fee'];
			$subtotal_ship_fee += $ship_fee;

			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$idx, $order['id'])
						->setCellValue('B'.$idx, $order['customer_id'])
						->setCellValue('C'.$idx, get_customer_name($order['customer_id']))
						->setCellValue('D'.$idx, ' ')
						->setCellValue('E'.$idx, ' ')
						->setCellValue('F'.$idx, ' ')
						->setCellValue('G'.$idx, $order['english_addr'])
						->setCellValue('H'.$idx, ShippingType::getShippingType($order['ship_type']))
						->setCellValue('I'.$idx, ' ')
						->setCellValue('J'.$idx, $ship_fee)
						->setCellValue('K'.$idx, substr($info['id'], 0, strpos($info['id'], '_')))
						->setCellValue('L'.$idx, $order['done_date']);
			$idx++;

		}

		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $order['id'].' Subtotal')
					->setCellValue('B'.$idx, $order['id'].' Subtotal')
					->setCellValue('C'.$idx, ' ')
					->setCellValue('D'.$idx, ' ')
					->setCellValue('E'.$idx, ' ')
					->setCellValue('F'.$idx, ' ')
					->setCellValue('G'.$idx, ' ')
					->setCellValue('H'.$idx, ' ')
					->setCellValue('I'.$idx, $subtotal_service_fee)
					->setCellValue('J'.$idx, $subtotal_ship_fee)
					->setCellValue('K'.$idx, ' ')
					->setCellValue('L'.$idx, ' ');

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':B'.$idx);

		$idx++;

		$total_service_fee += $subtotal_service_fee;
		$total_ship_fee += $subtotal_ship_fee;

	}

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, 'Total')
				->setCellValue('B'.$idx, 'Total')
				->setCellValue('C'.$idx, ' ')
				->setCellValue('D'.$idx, ' ')
				->setCellValue('E'.$idx, ' ')
				->setCellValue('F'.$idx, ' ')
				->setCellValue('G'.$idx, ' ')
				->setCellValue('H'.$idx, ' ')
				->setCellValue('I'.$idx, $total_service_fee)
				->setCellValue('J'.$idx, $total_ship_fee)
				->setCellValue('K'.$idx, ' ')
				->setCellValue('L'.$idx, ' ');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);

	$idx++;

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Freight and Service Fee');
	$objPHPExcel->getActiveSheet()->getStyle('D2:D'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('A2:A'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.'Freight and Service Fee ('.$warehouse.') '.date("Y-m", strtotime($to)).'.xls"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	ob_end_clean(); 

	$objWriter->save('php://output');

}

?>