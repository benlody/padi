
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
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':L'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':L'.$idx)->getFill()->getStartColor()->setRGB('6ea9ec');


	$idx++;

	foreach ($orders as $order) {
		$content = json_decode($order['content'], true);
		$ship_info = json_decode($order['shipping_info'], true);

		$subtotal_service_fee = 0;
		$subtotal_ship_fee = 0;

		$cnt_service = true;
		foreach ($ship_info as $info) {
			if(!isset($info['date']) || $info['date'] < $from || $info['date'] > $to){
				$cnt_service = false;
				break;
			}
		}

		if($cnt_service){

			foreach ($content['crewpak'] as $crewpak => $info) {
				if(strpos($crewpak, '61301C') == false && strcmp($crewpak, '61301C') !== 0){
					continue;
				}
				$service_fee = Fee::getCrewpackServiceFee($info['cnt'], $warehouse, $crewpak);
				$subtotal_service_fee += $service_fee;

				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$idx, $order['id'])
							->setCellValue('B'.$idx, $order['customer_id'])
							->setCellValue('C'.$idx, $order['customer_name'])
							->setCellValue('D'.$idx, $crewpak)
							->setCellValue('E'.$idx, $info['cnt'])
							->setCellValue('F'.$idx, $order['date'])
							->setCellValue('G'.$idx, $order['english_addr'])
							->setCellValue('H'.$idx, ' ')
							->setCellValue('I'.$idx, $service_fee)
							->setCellValue('J'.$idx, ' ')
							->setCellValue('K'.$idx, ' ')
							->setCellValue('L'.$idx, $order['done_date']);
				$idx++;
			}
/*
			foreach ($content['product'] as $product => $info) {
				$service_fee = Fee::getProductServiceFee($info['cnt'], $warehouse);
				$subtotal_service_fee += $service_fee;

				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$idx, $order['id'])
							->setCellValue('B'.$idx, $order['customer_id'])
							->setCellValue('C'.$idx, $order['customer_name'])
							->setCellValue('D'.$idx, $product)
							->setCellValue('E'.$idx, $info['cnt'])
							->setCellValue('F'.$idx, $order['date'])
							->setCellValue('G'.$idx, $order['english_addr'])
							->setCellValue('H'.$idx, ' ')
							->setCellValue('I'.$idx, $service_fee)
							->setCellValue('J'.$idx, ' ')
							->setCellValue('K'.$idx, ' ')
							->setCellValue('L'.$idx, $order['done_date']);
				$idx++;
			}
			*/
		}
/*
		foreach ($ship_info as $info) {
			if(!isset($info['date']) || $info['date'] < $from || $info['date'] > $to){
				continue;
			}

			if(isset($info['complement_cnt'])){
				foreach ($info['complement_cnt'] as $product => $cnt) {
					$service_fee = Fee::getProductServiceFee($cnt, $warehouse);
					$subtotal_service_fee += $service_fee;
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A'.$idx, $order['id'])
								->setCellValue('B'.$idx, $order['customer_id'])
								->setCellValue('C'.$idx, $order['customer_name'])
								->setCellValue('D'.$idx, $product.' - 補寄')
								->setCellValue('E'.$idx, $info['cnt'])
								->setCellValue('F'.$idx, $order['date'])
								->setCellValue('G'.$idx, $order['english_addr'])
								->setCellValue('H'.$idx, ' ')
								->setCellValue('I'.$idx, $service_fee)
								->setCellValue('J'.$idx, ' ')
								->setCellValue('K'.$idx, ' ')
								->setCellValue('L'.$idx, $order['done_date']);
					$idx++;
				}
			}

			$ship_fee = isset($info['req_fee']) ? $info['req_fee'] : Fee::getShipFreightFee($info['fee'], $region, $warehouse, $info['type'], $info['weight'], $info['box']);
			$subtotal_ship_fee += $ship_fee;

			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$idx, $order['id'])
						->setCellValue('B'.$idx, $order['customer_id'])
						->setCellValue('C'.$idx, $order['customer_name'])
						->setCellValue('D'.$idx, ' ')
						->setCellValue('E'.$idx, ' ')
						->setCellValue('F'.$idx, $order['date'])
						->setCellValue('G'.$idx, $order['english_addr'])
						->setCellValue('H'.$idx, ShippingType::getShippingType($order['ship_type'], 'enu'))
						->setCellValue('I'.$idx, ' ')
						->setCellValue('J'.$idx, $ship_fee)
						->setCellValue('K'.$idx, '#'.substr($info['id'], 0, strpos($info['id'], '_')))
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

		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':L'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':L'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');

		$idx++;

		$total_service_fee += $subtotal_service_fee;
		$total_ship_fee += $subtotal_ship_fee;
*/
	}
/*
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
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':L'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':L'.$idx)->getFill()->getStartColor()->setRGB('FFA500');
*/
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Freight and Service Fee');
	$objPHPExcel->getActiveSheet()->getStyle('D2:D'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('A2:A'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:L'.$idx)->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

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



function ship_download_service($orders, $warehouse, $from, $to){

	$objPHPExcel = new \PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Kuang Lung")
								 ->setLastModifiedBy("Kuang Lung")
								 ->setTitle('金璽服務費 '.date("Y-m", strtotime($to)))
								 ->setSubject('金璽服務費 '.date("Y-m", strtotime($to)))
								 ->setDescription('金璽服務費 '.date("Y-m", strtotime($to)));

	$idx = 1;
	$total_service_fee = 0;
	$total_ship_fee = 0;

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '訂單編號')
				->setCellValue('B'.$idx, '會員編號')
				->setCellValue('C'.$idx, '項目')
				->setCellValue('D'.$idx, '套裝數量')
				->setCellValue('E'.$idx, '單品數量')
				->setCellValue('F'.$idx, '服務費')
				->setCellValue('G'.$idx, '訂單日期');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':G'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':G'.$idx)->getFill()->getStartColor()->setRGB('6ea9ec');


	$idx++;

	foreach ($orders as $order) {
		$content = json_decode($order['content'], true);
		$ship_info = json_decode($order['shipping_info'], true);

		$subtotal_service_fee = 0;
		$subtotal_ship_fee = 0;

		$cnt_service = true;

		foreach ($content['crewpak'] as $crewpak => $info) {
			$service_fee = $info['cnt'] * 5;
			$subtotal_service_fee += $service_fee;

			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$idx, $order['id'])
						->setCellValue('B'.$idx, $order['customer_id'])
						->setCellValue('C'.$idx, $crewpak)
						->setCellValue('D'.$idx, $info['cnt'])
						->setCellValue('E'.$idx, '')
						->setCellValue('F'.$idx, $service_fee)
						->setCellValue('G'.$idx, $order['date']);
			$idx++;
		}

		foreach ($content['product'] as $product => $info) {
			$service_fee = $info['cnt'] * 1.5;
			$subtotal_service_fee += $service_fee;

			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$idx, $order['id'])
						->setCellValue('B'.$idx, $order['customer_id'])
						->setCellValue('C'.$idx, $product)
						->setCellValue('D'.$idx, '')
						->setCellValue('E'.$idx, $info['cnt'])
						->setCellValue('F'.$idx, $service_fee)
						->setCellValue('G'.$idx, $order['date']);
			$idx++;
		}

/*
		foreach ($ship_info as $info) {
			if(!isset($info['date']) || $info['date'] < $from || $info['date'] > $to){
				continue;
			}

			if(isset($info['complement_cnt'])){
				foreach ($info['complement_cnt'] as $product => $cnt) {
					$service_fee = Fee::getProductServiceFee($cnt, $warehouse);
					$subtotal_service_fee += $service_fee;
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A'.$idx, $order['id'])
								->setCellValue('B'.$idx, $order['customer_id'])
								->setCellValue('C'.$idx, $order['customer_name'])
								->setCellValue('D'.$idx, $product.' - 補寄')
								->setCellValue('E'.$idx, $info['cnt'])
								->setCellValue('F'.$idx, $order['date'])
								->setCellValue('G'.$idx, $order['english_addr'])
								->setCellValue('H'.$idx, ' ')
								->setCellValue('I'.$idx, $service_fee)
								->setCellValue('J'.$idx, ' ')
								->setCellValue('K'.$idx, ' ')
								->setCellValue('L'.$idx, $order['done_date']);
					$idx++;
				}
			}
		}
*/
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $order['id'].' Subtotal')
					->setCellValue('B'.$idx, $order['id'].' Subtotal')
					->setCellValue('C'.$idx, ' ')
					->setCellValue('D'.$idx, ' ')
					->setCellValue('E'.$idx, ' ')
					->setCellValue('F'.$idx, $subtotal_service_fee)
					->setCellValue('G'.$idx, ' ');

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':B'.$idx);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':G'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':G'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');

		$idx++;

		$total_service_fee += $subtotal_service_fee;

	}

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, 'Total')
				->setCellValue('B'.$idx, 'Total')
				->setCellValue('C'.$idx, ' ')
				->setCellValue('D'.$idx, ' ')
				->setCellValue('E'.$idx, ' ')
				->setCellValue('F'.$idx, $total_service_fee)
				->setCellValue('G'.$idx, ' ');

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':G'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':G'.$idx)->getFill()->getStartColor()->setRGB('FFA500');

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('服務費');
	$objPHPExcel->getActiveSheet()->getStyle('A2:A'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:G'.$idx)->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.'金璽服務費 '.date("Y-m", strtotime($to)).'.xls"');
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


function stat_download($orders, $from, $to){

	$objPHPExcel = new \PHPExcel();


	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Kuang Lung")
								 ->setLastModifiedBy("Kuang Lung")
								 ->setTitle('PADI訂單統計'.date("Y-m", strtotime($to)))
								 ->setSubject('PADI訂單統計'.date("Y-m", strtotime($to)))
								 ->setDescription('PADI訂單統計'.date("Y-m", strtotime($to)));

	$idx = 1;


	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, 'PO#')
				->setCellValue('B'.$idx, 'DC#')
				->setCellValue('C'.$idx, 'DATE')
				->setCellValue('D'.$idx, 'REGION')
				->setCellValue('E'.$idx, 'CHINESE ADDR')
				->setCellValue('F'.$idx, 'WEIGHT');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':F'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':F'.$idx)->getFill()->getStartColor()->setRGB('6ea9ec');


	$idx++;

	foreach ($orders as $order) {
		$ship_info = json_decode($order['shipping_info'], true);

		$subtotal_weight = 0;

		if($ship_info !== null){
			foreach ($ship_info as $info) {
				$subtotal_weight += $info['weight'];
			}

			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$idx, $order['id'])
						->setCellValue('B'.$idx, $order['customer_id'])
						->setCellValue('C'.$idx, $order['date'])
						->setCellValue('D'.$idx, ShippingRegion::getRegion($order['region']))
						->setCellValue('E'.$idx, $order['chinese_addr'])
						->setCellValue('F'.$idx, $subtotal_weight);


			$idx++;

		}
	}

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('PADI訂單統計');
//	$objPHPExcel->getActiveSheet()->getStyle('D2:D'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('A2:A'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:L'.$idx)->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.'PADI訂單統計'.date("Y-m", strtotime($to)).'.xls"');
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