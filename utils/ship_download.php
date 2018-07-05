
<?php

require_once __DIR__  . '/utils.php';

function ship_download($orders, $warehouse, $from, $to, $certcards){

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

			foreach ($content['product'] as $product => $info) {
				$service_fee = Fee::getProductServiceFee($info['cnt'], $warehouse, $product);
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
		}

		foreach ($ship_info as $info) {
			if(!isset($info['date']) || $info['date'] < $from || $info['date'] > $to){
				continue;
			}

			if(isset($info['complement_cnt'])){
				foreach ($info['complement_cnt'] as $product => $cnt) {
					$service_fee = 0;
					$subtotal_service_fee += $service_fee;
					$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A'.$idx, $order['id'])
								->setCellValue('B'.$idx, $order['customer_id'])
								->setCellValue('C'.$idx, $order['customer_name'])
								->setCellValue('D'.$idx, $product.' - back order')
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

	}

	if($warehouse == 'tw'){
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$idx, 'DHL#')
			->setCellValue('B'.$idx, ' ')
			->setCellValue('C'.$idx, 'NAME')
			->setCellValue('D'.$idx, 'ITEM')
			->setCellValue('E'.$idx, 'QTY')
			->setCellValue('F'.$idx, 'T Send Date')
			->setCellValue('G'.$idx, ' ')
			->setCellValue('H'.$idx, 'SHIPPING TYPE')
			->setCellValue('I'.$idx, 'Service Fee')
			->setCellValue('J'.$idx, 'FREIGTH')
			->setCellValue('K'.$idx, 'Tracking#')
			->setCellValue('L'.$idx, ' ');
		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':L'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':L'.$idx)->getFill()->getStartColor()->setRGB('6ea9ec');
				$idx++;

		$subtotal_service_fee = 0;
		$subtotal_ship_fee = 0;

		foreach ($certcards as $certcard) {
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$idx, '#'.$certcard['DHL'])
						->setCellValue('B'.$idx, ' ')
						->setCellValue('C'.$idx, 'PADI Shenzhen')
						->setCellValue('D'.$idx, 'ID Cards')
						->setCellValue('E'.$idx, '1 carton')
						->setCellValue('F'.$idx, $certcard['t_send_date'])
						->setCellValue('G'.$idx, ' ')
						->setCellValue('H'.$idx, 'SF Express')
						->setCellValue('I'.$idx, '5')
						->setCellValue('J'.$idx, $certcard['req_fee'])
						->setCellValue('K'.$idx, '#'.$certcard['tracking'])
						->setCellValue('L'.$idx, ' ');
			$subtotal_service_fee += 5;
			$subtotal_ship_fee += $certcard['req_fee'];
			$idx++;
		}

		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, 'Cert Card Subtotal')
					->setCellValue('B'.$idx, ' ')
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
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':L'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':L'.$idx)->getFill()->getStartColor()->setRGB('FFA500');

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
			if($product == '60020C' ||
				$product == '60038C' ||
				$product == '60303C' ||
				$product == '61301SC' ||
				$product == '60303SC' ||
				$product == '60304C' ||
				$product == '60330C' ||
				$product == '60346C' ||
				$product == '61301C' ||
				$product == '70149C'
			){
				$service_fee = $info['cnt'] * 5;
				$subtotal_service_fee += $service_fee;

				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$idx, $order['id'])
							->setCellValue('B'.$idx, $order['customer_id'])
							->setCellValue('C'.$idx, $product)
							->setCellValue('D'.$idx, $info['cnt'])
							->setCellValue('E'.$idx, '')
							->setCellValue('F'.$idx, $service_fee)
							->setCellValue('G'.$idx, $order['date']);
				$idx++;
			} else {
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

		}

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

function invoice_download_korea($invoice, $content){

	$objPHPExcel = new \PHPExcel();


	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Kuang Lung")
								 ->setLastModifiedBy("Kuang Lung")
								 ->setTitle('PADI Inovice - '.$invoice['id'])
								 ->setSubject('PADI Inovice - '.$invoice['id'])
								 ->setDescription('PADI Inovice - '.$invoice['id']);


	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(0.5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(33);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(0.5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(0.5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12.5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(0.5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13.5);

	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
	$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(26);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:I2');
	$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','光隆印刷廠股份有限公司');
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('標楷體');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','KUANG LUNG PRINTING FACTORY CO., LTD.');
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('Arial');
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(26);
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(16);
	$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4','2F., No.8, Ln. 83, Sec. 1, Guangfu Rd., Sanchong Dist.,');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5','New Taipei City 241, Taiwan');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6','TEL: 886 2 29999099');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C6','FAX: 886 2 29991967');

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4','Date: '.$invoice['date']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G5','Order No.: '.$invoice['id']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G6','Tracking No.: '.$invoice['tracking']);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8','SHIPPING ADDRESS');
	$objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setUnderline(true);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A9',$invoice['customer_name']);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A10:C11');
	$objPHPExcel->getActiveSheet()->getStyle('A10')->getAlignment()->setWrapText(true);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A10',$invoice['addr']);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A13:I13');
	$objPHPExcel->getActiveSheet()->getStyle('A13')->getFont()->setName('Arial');
	$objPHPExcel->getActiveSheet()->getStyle('A13')->getFont()->setSize(14);
	$objPHPExcel->getActiveSheet()->getStyle('A13')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A13')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A13','INVOICE');

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A15','Product Code');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C15','Description');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E15','Quantity');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G15','Unite Price');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I15','Total Value');
	$objPHPExcel->getActiveSheet()->getStyle('A15:I15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A15')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$objPHPExcel->getActiveSheet()->getStyle('C15')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$objPHPExcel->getActiveSheet()->getStyle('E15')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$objPHPExcel->getActiveSheet()->getStyle('G15')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$objPHPExcel->getActiveSheet()->getStyle('I15')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

	$idx = 16;

	foreach ($content as $product) {
		if($product !== null){
			$objPHPExcel->getActiveSheet()->getStyle('A'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$idx, $product['id'])
						->setCellValue('C'.$idx, $product['name'])
						->setCellValue('E'.$idx, $product['cnt'])
						->setCellValue('G'.$idx, $product['inv_price'])
						->setCellValue('I'.$idx, $product['cnt'] * $product['inv_price']);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$idx)->getNumberFormat()->setFormatCode('_-* #,##0.00\ [$TWD-415]_-');
			$objPHPExcel->getActiveSheet()->getStyle('I'.$idx)->getNumberFormat()->setFormatCode('_-* #,##0.00\ [$TWD-415]_-');

			$idx++;

		}
	}

	$tot = $idx-1;
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':I'.$idx)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$idx,'Total');
	$objPHPExcel->getActiveSheet()->getStyle('I'.$idx)->getNumberFormat()->setFormatCode('_-* #,##0.00\ [$TWD-415]_-');
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$idx,'=SUM(I16:I'.$tot.')');

	$idx = $idx + 6;

	$objPHPExcel->getActiveSheet()->getStyle('E'.$idx.':I'.$idx)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$idx++;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$idx,'Ching-Lang Chen');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$idx.':I'.$idx);
	$idx++;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$idx,'Managin Director');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$idx.':I'.$idx);
	$idx++;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$idx,'Kuang Lung Printing Factory Co., Ltd.');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$idx.':I'.$idx);



	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="invoice '.$invoice['date'].'['.$invoice['id'].']'.$invoice['tracking'].'.xls"');
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


function invoice_download($invoice, $content){

	$objPHPExcel = new \PHPExcel();


	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Kuang Lung")
								 ->setLastModifiedBy("Kuang Lung")
								 ->setTitle('PADI Inovice - '.$invoice['id'])
								 ->setSubject('PADI Inovice - '.$invoice['id'])
								 ->setDescription('PADI Inovice - '.$invoice['id']);


	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(0.5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(33);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(0.5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(0.5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12.5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(0.5);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13.5);

	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
	$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(26);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:I2');
	$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','光隆印刷廠股份有限公司');
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('標楷體');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','KUANG LUNG PRINTING FACTORY CO., LTD.');
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('Arial');
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(26);
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(16);
	$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4','2F., No.8, Ln. 83, Sec. 1, Guangfu Rd., Sanchong Dist.,');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5','New Taipei City 241, Taiwan');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6','TEL: 886 2 29999099');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C6','FAX: 886 2 29991967');

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4','Date: '.$invoice['date']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G5','Order No.: '.$invoice['id']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G6','Tracking No.: '.$invoice['tracking']);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8','SHIPPING ADDRESS');
	$objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setUnderline(true);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A9',$invoice['customer_name']);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A10:C11');
	$objPHPExcel->getActiveSheet()->getStyle('A10')->getAlignment()->setWrapText(true);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A10',$invoice['addr']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A12',$invoice['contact']);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C12',$invoice['tel']);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A14:I14');
	$objPHPExcel->getActiveSheet()->getStyle('A14')->getFont()->setName('Arial');
	$objPHPExcel->getActiveSheet()->getStyle('A14')->getFont()->setSize(14);
	$objPHPExcel->getActiveSheet()->getStyle('A14')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A14')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A14','INVOICE');

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A16','Product Code');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C16','Description');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E16','Quantity');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G16','Unite Price');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I16','Total Value');
	$objPHPExcel->getActiveSheet()->getStyle('A16:I16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A16')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$objPHPExcel->getActiveSheet()->getStyle('C16')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$objPHPExcel->getActiveSheet()->getStyle('E16')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$objPHPExcel->getActiveSheet()->getStyle('G16')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$objPHPExcel->getActiveSheet()->getStyle('I16')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

	$idx = 17;

	foreach ($content as $product) {
		if($product !== null){
			$objPHPExcel->getActiveSheet()->getStyle('A'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$price = $product['inv_price'] / 30;
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$idx, $product['id'])
						->setCellValue('C'.$idx, $product['name'])
						->setCellValue('E'.$idx, $product['cnt'])
						->setCellValue('G'.$idx, $price)
						->setCellValue('I'.$idx, $product['cnt'] * $price);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$idx)->getNumberFormat()->setFormatCode('_-* #,##0.000\ [$USD-415]_-');
			$objPHPExcel->getActiveSheet()->getStyle('I'.$idx)->getNumberFormat()->setFormatCode('_-* #,##0.00\ [$USD-415]_-');

			$idx++;

		}
	}

	$tot = $idx-1;
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':I'.$idx)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$idx,'Total');
	$objPHPExcel->getActiveSheet()->getStyle('I'.$idx)->getNumberFormat()->setFormatCode('_-* #,##0.00\ [$USD-415]_-');
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$idx,'=SUM(I16:I'.$tot.')');

	$idx = $idx + 6;

	$objPHPExcel->getActiveSheet()->getStyle('E'.$idx.':I'.$idx)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
	$idx++;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$idx,'Ching-Lang Chen');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$idx.':I'.$idx);
	$idx++;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$idx,'Managin Director');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$idx.':I'.$idx);
	$idx++;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$idx,'Kuang Lung Printing Factory Co., Ltd.');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$idx.':I'.$idx);



	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="invoice '.$invoice['date'].'['.$invoice['id'].']'.$invoice['tracking'].'.xls"');
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


function assemble_bill_download($orders, $warehouse, $from, $to){

	$objPHPExcel = new \PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Kuang Lung")
								 ->setLastModifiedBy("Kuang Lung")
								 ->setTitle('Freight and Service Fee ('.$warehouse.') '.date("Y-m", strtotime($to)))
								 ->setSubject('Freight and Service Fee ('.$warehouse.') '.date("Y-m", strtotime($to)))
								 ->setDescription('Freight and Service Fee ('.$warehouse.') '.date("Y-m", strtotime($to)));

	$idx = 1;
	$total_service_fee = 0;


	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, 'Assemble Order#')
				->setCellValue('B'.$idx, 'Item#')
				->setCellValue('C'.$idx, 'Qty')
				->setCellValue('D'.$idx, 'Req Date')
				->setCellValue('E'.$idx, 'Done Date')
				->setCellValue('F'.$idx, 'Service Fee');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':F'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':F'.$idx)->getFill()->getStartColor()->setRGB('6ea9ec');


	$idx++;

	foreach ($orders as $order) {

		$service_fee = Fee::getAssembleServiceFee($order['qty'], $warehouse, $order['assemble']);
		$total_service_fee += $service_fee;

		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $order['id'])
					->setCellValue('B'.$idx, $order['assemble'])
					->setCellValue('C'.$idx, $order['qty'])
					->setCellValue('D'.$idx, $order['date'])
					->setCellValue('E'.$idx, $order['done_date'])
					->setCellValue('F'.$idx, $service_fee);
		$idx++;

	}

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, 'Total')
				->setCellValue('B'.$idx, 'Total')
				->setCellValue('C'.$idx, ' ')
				->setCellValue('D'.$idx, ' ')
				->setCellValue('E'.$idx, ' ')
				->setCellValue('F'.$idx, $total_service_fee);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':F'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':F'.$idx)->getFill()->getStartColor()->setRGB('FFA500');

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Freight and Service Fee');
	$objPHPExcel->getActiveSheet()->getStyle('B2:B'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('C2:C'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('D2:D'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('E2:E'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('F2:F'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A2:A'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:F'.$idx)->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.'Assemble Service Fee ('.$warehouse.') '.date("Y-m", strtotime($to)).'.xls"');
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


function market_bill_download($orders, $from, $to){

	$objPHPExcel = new \PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Kuang Lung")
								 ->setLastModifiedBy("Kuang Lung")
								 ->setTitle('Freight and Service Fee (marketing) '.date("Y-m", strtotime($from)).' to '.date("Y-m", strtotime($to)))
								 ->setSubject('Freight and Service Fee (marketing) '.date("Y-m", strtotime($from)).' to '.date("Y-m", strtotime($to)))
								 ->setDescription('Freight and Service Fee (marketing) '.date("Y-m", strtotime($from)).' to '.date("Y-m", strtotime($to)));

	$idx = 2;
	$total_service_fee = 0;
	$total_req_fee = 0;

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'PADI SZ 行銷宣傳品寄送明細'.date("Y-m", strtotime($from)).' to '.date("Y-m", strtotime($to)));
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(22);

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '項次')
				->setCellValue('B'.$idx, '日期')
				->setCellValue('C'.$idx, '寄送地點')
				->setCellValue('D'.$idx, '運單編號')
				->setCellValue('E'.$idx, '重量')
				->setCellValue('F'.$idx, '運費(含稅)')
				->setCellValue('G'.$idx, '處理費(含稅)');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':G'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':G'.$idx)->getFill()->getStartColor()->setRGB('6ea9ec');


	$idx++;

	foreach ($orders as $order) {

		$service_fee = 80;
		$total_service_fee += $service_fee;
		$total_req_fee += $order['req_fee'];

		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $idx-2)
					->setCellValue('B'.$idx, $order['date'])
					->setCellValue('C'.$idx, $order['content'])
					->setCellValue('D'.$idx, '#'.$order['tracking'])
					->setCellValue('E'.$idx, $order['weight'])
					->setCellValue('F'.$idx, $order['req_fee'])
					->setCellValue('G'.$idx, $service_fee);
		$idx++;
	}

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '小計')
				->setCellValue('B'.$idx, ' ')
				->setCellValue('C'.$idx, ' ')
				->setCellValue('D'.$idx, ' ')
				->setCellValue('E'.$idx, ' ')
				->setCellValue('F'.$idx, $total_req_fee)
				->setCellValue('G'.$idx, $total_service_fee);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':D'.$idx);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':G'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':G'.$idx)->getFill()->getStartColor()->setRGB('FFA500');

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Freight and Service Fee');
	$objPHPExcel->getActiveSheet()->getStyle('B2:B'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('C2:C'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('D2:D'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('E2:E'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('F2:F'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('G2:G'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A2:A'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:G'.$idx)->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.'Freight and Service Fee (marketing) '.date("Y-m", strtotime($from)).' to '.date("Y-m", strtotime($to)).'.xls"');
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



function match_download($hiyes, $sf, $globlas, $post, $other, $to, $from){

	$objPHPExcel = new \PHPExcel();

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Kuang Lung")
								 ->setLastModifiedBy("Kuang Lung")
								 ->setTitle('PADI運費對帳單 '.date("Y-m", strtotime($to)))
								 ->setSubject('PADI運費對帳單 '.date("Y-m", strtotime($to)))
								 ->setDescription('PADI運費對帳單 '.date("Y-m", strtotime($to)));

	$idx = 1;
	$total_ship_fee = 0;

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '日期')
				->setCellValue('B'.$idx, '地址')
				->setCellValue('C'.$idx, '快遞')
				->setCellValue('D'.$idx, '單號')
				->setCellValue('E'.$idx, '運費');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('6ea9ec');

	$idx++;


	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '新航快遞')
				->setCellValue('B'.$idx, '')
				->setCellValue('C'.$idx, '')
				->setCellValue('D'.$idx, '')
				->setCellValue('E'.$idx, '');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);

	$idx++;

	foreach ($hiyes as $shipment) {
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $shipment['date'])
					->setCellValue('B'.$idx, $shipment['addr'])
					->setCellValue('C'.$idx, $shipment['type_chi'])
					->setCellValue('D'.$idx, $shipment['tracking'])
					->setCellValue('E'.$idx, $shipment['fee']);


		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');

		$idx++;
		$total_ship_fee += $shipment['fee'];

	}

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '新航快遞 Total')
				->setCellValue('E'.$idx, $total_ship_fee);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':D'.$idx);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('FFA500');
	$idx++;
	$idx++;


/******************************************************/

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '順豐快遞')
				->setCellValue('B'.$idx, '')
				->setCellValue('C'.$idx, '')
				->setCellValue('D'.$idx, '')
				->setCellValue('E'.$idx, '');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);

	$total_ship_fee = 0;
	$idx++;

	foreach ($sf as $shipment) {
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $shipment['date'])
					->setCellValue('B'.$idx, $shipment['addr'])
					->setCellValue('C'.$idx, $shipment['type_chi'])
					->setCellValue('D'.$idx, $shipment['tracking'])
					->setCellValue('E'.$idx, $shipment['fee']);


		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');

		$idx++;
		$total_ship_fee += $shipment['fee'];

	}

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '順豐快遞 Total')
				->setCellValue('E'.$idx, $total_ship_fee);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':D'.$idx);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('FFA500');
	$idx++;
	$idx++;


/******************************************************/

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '全球快遞')
				->setCellValue('B'.$idx, '')
				->setCellValue('C'.$idx, '')
				->setCellValue('D'.$idx, '')
				->setCellValue('E'.$idx, '');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);

	$total_ship_fee = 0;
	$idx++;

	foreach ($globlas as $shipment) {
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $shipment['date'])
					->setCellValue('B'.$idx, $shipment['addr'])
					->setCellValue('C'.$idx, $shipment['type_chi'])
					->setCellValue('D'.$idx, $shipment['tracking'])
					->setCellValue('E'.$idx, $shipment['fee']);


		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');

		$idx++;
		$total_ship_fee += $shipment['fee'];

	}

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '全球快遞 Total')
				->setCellValue('E'.$idx, $total_ship_fee);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':D'.$idx);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('FFA500');
	$idx++;
	$idx++;


/******************************************************/

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '中華郵政')
				->setCellValue('B'.$idx, '')
				->setCellValue('C'.$idx, '')
				->setCellValue('D'.$idx, '')
				->setCellValue('E'.$idx, '');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);

	$total_ship_fee = 0;
	$idx++;

	foreach ($post as $shipment) {
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $shipment['date'])
					->setCellValue('B'.$idx, $shipment['addr'])
					->setCellValue('C'.$idx, $shipment['type_chi'])
					->setCellValue('D'.$idx, $shipment['tracking'])
					->setCellValue('E'.$idx, $shipment['fee']);


		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');

		$idx++;
		$total_ship_fee += $shipment['fee'];

	}

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '中華郵政 Total')
				->setCellValue('E'.$idx, $total_ship_fee);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':D'.$idx);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('FFA500');
	$idx++;
	$idx++;


/******************************************************/

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '其他')
				->setCellValue('B'.$idx, '')
				->setCellValue('C'.$idx, '')
				->setCellValue('D'.$idx, '')
				->setCellValue('E'.$idx, '');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);

	$idx++;

	foreach ($other as $shipment) {
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $shipment['date'])
					->setCellValue('B'.$idx, $shipment['addr'])
					->setCellValue('C'.$idx, $shipment['type_chi'])
					->setCellValue('D'.$idx, $shipment['tracking'])
					->setCellValue('E'.$idx, $shipment['fee']);


		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');

		$idx++;
		$total_ship_fee += $shipment['fee'];

	}

/******************************************************/
	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('服務費');
	$objPHPExcel->getActiveSheet()->getStyle('A2:A'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:E'.$idx)->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.'PADI運費對帳單 '.date("Y-m", strtotime($to)).'.xls"');
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




function custom_download($orders_export, $orders_dhl, $transfer_dhl_send, $transfer_dhl_recv, $transfer_seaair_send,
			$transfer_seaair_recv, $certcard_dhl_recv, $to, $from){

	$objPHPExcel = new \PHPExcel();

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(13);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Kuang Lung")
								 ->setLastModifiedBy("Kuang Lung")
								 ->setTitle('PADI進出口報單 '.date("Y-m", strtotime($to)))
								 ->setSubject('PADI進出口報單 '.date("Y-m", strtotime($to)))
								 ->setDescription('PADI進出口報單 '.date("Y-m", strtotime($to)));

	$idx = 1;


	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '訂單出口-海/空運')
				->setCellValue('B'.$idx, '')
				->setCellValue('C'.$idx, '')
				->setCellValue('D'.$idx, '')
				->setCellValue('E'.$idx, '');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);

	$idx++;

	foreach ($orders_export as $shipment) {
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $shipment['done_date'])
					->setCellValue('B'.$idx, $shipment['id'])
					->setCellValue('C'.$idx, $shipment['customer_id'])
					->setCellValue('D'.$idx, $shipment['customer_name']);


		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);

		$idx++;

	}

	$idx++;

/******************************************************/
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '庫存轉移出口-海/空運')
				->setCellValue('B'.$idx, '')
				->setCellValue('C'.$idx, '')
				->setCellValue('D'.$idx, '')
				->setCellValue('E'.$idx, '');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);

	$idx++;

	foreach ($transfer_seaair_send as $shipment) {
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $shipment['send_date'])
					->setCellValue('B'.$idx, $shipment['id'])
					->setCellValue('C'.$idx, $shipment['dst_warehouse'])
					->setCellValue('D'.$idx, ' ')
					->setCellValue('E'.$idx, ' ');

		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$idx++;
	}

	$idx++;

/******************************************************/
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '訂單出口-DHL')
				->setCellValue('B'.$idx, '')
				->setCellValue('C'.$idx, '')
				->setCellValue('D'.$idx, '')
				->setCellValue('E'.$idx, '');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);

	$idx++;

	foreach ($orders_dhl as $shipment) {
		$ship_info = json_decode($shipment['shipping_info'], true);
		foreach ($ship_info as $info) {
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$idx, $shipment['done_date'])
						->setCellValue('B'.$idx, $shipment['id'])
						->setCellValue('C'.$idx, $shipment['customer_id'])
						->setCellValue('D'.$idx, $shipment['customer_name'])
						->setCellValue('E'.$idx, '#'.substr($info['id'], 0, strpos($info['id'], '_')));

		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$idx++;
		}
	}

	$idx++;

/******************************************************/
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '庫存轉移出口-DHL')
				->setCellValue('B'.$idx, '')
				->setCellValue('C'.$idx, '')
				->setCellValue('D'.$idx, '')
				->setCellValue('E'.$idx, '');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);

	$idx++;

	foreach ($transfer_dhl_send as $shipment) {
		$ship_info = json_decode($shipment['shipping_info'], true);
		foreach ($ship_info as $info) {
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$idx, $shipment['send_date'])
						->setCellValue('B'.$idx, $shipment['id'])
						->setCellValue('C'.$idx, $shipment['dst_warehouse'])
						->setCellValue('D'.$idx, ' ')
						->setCellValue('E'.$idx, '#'.$info['id']);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$idx++;
		}
	}

	$idx++;

/******************************************************/
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '庫存轉移進口-海/空運')
				->setCellValue('B'.$idx, '')
				->setCellValue('C'.$idx, '')
				->setCellValue('D'.$idx, '')
				->setCellValue('E'.$idx, '');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);

	$idx++;

	foreach ($transfer_seaair_recv as $shipment) {
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $shipment['recv_date'])
					->setCellValue('B'.$idx, $shipment['id'])
					->setCellValue('C'.$idx, $shipment['src_warehouse'])
					->setCellValue('D'.$idx, ' ')
					->setCellValue('E'.$idx, ' ');

		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$idx++;
	}

	$idx++;

/******************************************************/


	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '庫存轉移進口-DHL')
				->setCellValue('B'.$idx, '')
				->setCellValue('C'.$idx, '')
				->setCellValue('D'.$idx, '')
				->setCellValue('E'.$idx, '');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);

	$idx++;

	foreach ($transfer_dhl_recv as $shipment) {
		$ship_info = json_decode($shipment['shipping_info'], true);
		foreach ($ship_info as $info) {
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$idx, $shipment['recv_date'])
						->setCellValue('B'.$idx, $shipment['id'])
						->setCellValue('C'.$idx, $shipment['src_warehouse'])
						->setCellValue('D'.$idx, ' ')
						->setCellValue('E'.$idx, '#'.$info['id']);

		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$idx++;
		}
	}

	$idx++;

/******************************************************/
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, '潛水卡進口-DHL')
				->setCellValue('B'.$idx, '')
				->setCellValue('C'.$idx, '')
				->setCellValue('D'.$idx, '')
				->setCellValue('E'.$idx, '');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->getStartColor()->setRGB('F0E68C');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$idx.':E'.$idx);

	$idx++;

	foreach ($certcard_dhl_recv as $shipment) {
		if($dhl == $shipment['DHL']){
			continue;
		}
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $shipment['t_send_date'])
					->setCellValue('B'.$idx, ' ')
					->setCellValue('C'.$idx, ' ')
					->setCellValue('D'.$idx, ' ')
					->setCellValue('E'.$idx, '#'.$shipment['DHL']);

		$dhl = $shipment['DHL'];

		$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':E'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$idx++;
	}

	$idx++;


/******************************************************/

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('服務費');
	$objPHPExcel->getActiveSheet()->getStyle('A2:A'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:E'.$idx)->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.'PADI進出口明細 '.date("Y-m", strtotime($to)).'.xls"');
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


function kpi_download($kpis, $warehouse, $from, $to){

	$objPHPExcel = new \PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Kuang Lung")
								 ->setLastModifiedBy("Kuang Lung")
								 ->setTitle('KPI report ('.$warehouse.') '.date("Y-m", strtotime($from)))
								 ->setSubject('KPI report ('.$warehouse.') '.date("Y-m", strtotime($from)))
								 ->setDescription('KPI report ('.$warehouse.') '.date("Y-m", strtotime($from)));

	$idx = 2;
	$total_service_fee = 0;
	$total_req_fee = 0;

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'KPI report ('.$warehouse.') '.date("Y-m", strtotime($from)));
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(22);

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$idx, 'No')
				->setCellValue('B'.$idx, 'Order#')
				->setCellValue('C'.$idx, 'Create Time')
				->setCellValue('D'.$idx, 'Delivery Time')
				->setCellValue('E'.$idx, 'Pass')
				->setCellValue('F'.$idx, 'Remark');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':F'.$idx)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx.':F'.$idx)->getFill()->getStartColor()->setRGB('6ea9ec');


	$idx++;

	foreach ($kpis as $kpi) {

		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$idx, $idx-2)
					->setCellValue('B'.$idx, $kpi['id'])
					->setCellValue('C'.$idx, $kpi['ctime'])
					->setCellValue('D'.$idx, $kpi['dtime'])
					->setCellValue('E'.$idx, $kpi['pass'] ? 'TRUE' : 'FALSE');
		$idx++;
	}


	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('kpi '.date("Y-m", strtotime($from)));
	$objPHPExcel->getActiveSheet()->getStyle('A2:E'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('F2:F'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:F'.$idx)->getBorders()->getAllborders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.'KPI report ('.$warehouse.') '.date("Y-m", strtotime($from)).'.xls"');
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