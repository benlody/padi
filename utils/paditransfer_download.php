
<?php

require_once __DIR__  . '/utils.php';

function paditransfer_download($id, $content, $src_warehouse, $dst_warehouse, $date){

	$objPHPExcel = new \PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Kuang Lung")
								 ->setLastModifiedBy("Kuang Lung")
								 ->setTitle('Packing List ('.$id.')')
								 ->setSubject('Packing List ('.$id.')')
								 ->setDescription('Packing List ('.$id.')');


	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(9);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(12);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(55);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(11);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(11);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(11);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(8);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(8);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(15);

	$objPHPExcel->setActiveSheetIndex(0)->getRowDimension('1')->setRowHeight(30);
	$objPHPExcel->setActiveSheetIndex(0)->getRowDimension('2')->setRowHeight(30);
	$objPHPExcel->setActiveSheetIndex(0)->getRowDimension('4')->setRowHeight(30);
	$objPHPExcel->setActiveSheetIndex(0)->getRowDimension('7')->setRowHeight(10);
	$objPHPExcel->setActiveSheetIndex(0)->getRowDimension('8')->setRowHeight(70);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
	if($src_warehouse == 'tw_padi'){
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','KUANG LUNG PRINTING FACTORY CO., LTD.');
	} else {
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','PADI Asia Pacific (Shenzhen) Counsulting Limited');
	}
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:I2');
	if($src_warehouse == 'tw_padi'){
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','光隆印刷廠股份有限公司');
	} else {
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','派迪管理咨询(深圳)有限公司');
	}
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(18);
	if($src_warehouse == 'tw_padi'){
		$objPHPExcel->setActiveSheetIndex(0)->getRowDimension('3')->setRowHeight(70);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:I3');
		$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3',"Merchandise List\nSender: KUANG LUNG PRINTING FACTORY CO., LTD.\nAddress: 2F., No.8, Ln. 83, Sec. 1, Guangfu Rd., Sanchong Dist., New Taipei City 241, Taiwan\n Tel: +886 2 2999 9099");
	}
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:I4');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4','Packing List');
	$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setSize(18);

	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E5:I5');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E6:I6');
	$objPHPExcel->getActiveSheet()->getStyle('C5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->getActiveSheet()->getStyle('C6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->getActiveSheet()->getStyle('E5:I5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->getActiveSheet()->getStyle('E6:I6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B5','Invoice No.:');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5',$id);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D5','DATE:');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E5',$date);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B6','From:');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C6',get_warehouse_location($src_warehouse));
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D6','To:');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E6',get_warehouse_location($dst_warehouse));
	$objPHPExcel->getActiveSheet()->getStyle('B5:E6')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('B5:E6')->getFont()->setSize(12);
	$objPHPExcel->getActiveSheet()->getStyle('B5:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('B5:E6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$objPHPExcel->getActiveSheet()->getStyle('A8:I8')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A8:I8')->getFont()->setSize(12);
	$objPHPExcel->getActiveSheet()->getStyle('A8:I8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A8:I8')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A8:I8')->getAlignment()->setWrapText(true);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8',"Pallet\n托盤");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B8',"No.\n箱號");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8',"Description of Goods");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D8',"Quantity per Carton\n每箱數量");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E8',"Cartons\n箱數");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8',"Quantity\n總數");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G8',"Net Weight\n淨重");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H8',"Gross Weight\n毛重");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I8',"Measurement\n規格");


	$content_array = json_decode($content, true);

	$packings = $content_array['packing'];
	$mixs = $content_array['mix'];

	$idx = 9;
	$box_cnt = 1;

	foreach ($packings as $packing) {
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$idx, "");
		if(1 == $packing['cnt']){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$idx, strval($box_cnt));
		} else {
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$idx, strval($box_cnt)."-".strval($box_cnt + $packing['cnt'] - 1));
		}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$idx, $packing['id'].' '.$packing['chinese_name']."\n".$packing['english_name']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$idx, $packing['qty']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$idx, $packing['cnt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$idx, $packing['cnt']*$packing['qty']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$idx, strval($packing['cnt'] * $packing['net_weight']));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$idx, strval($packing['cnt'] * ($packing['net_weight'] + 0.5)));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$idx, $packing['measurement']);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$idx)->getAlignment()->setWrapText(true);

		$idx++;
		$box_cnt = $box_cnt + $packing['cnt'];
	}

	foreach ($mixs as $mix) {
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$idx, "");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$idx, "");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$idx, $mix['id'].' '.$mix['chinese_name']."\n".$mix['english_name']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$idx, "");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$idx, "");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$idx, $mix['cnt']);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$idx, "");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$idx, "");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$idx, "");
		$objPHPExcel->getActiveSheet()->getStyle('C'.$idx)->getAlignment()->setWrapText(true);

		$idx++;
	}

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$idx, "Total");

	$styleArray = array(
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array(‘argb’ => ‘000000’),
			),
		),
	);
	$objPHPExcel->getActiveSheet(0)->getStyle('A8:I'.$idx)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('A8:I'.$idx)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A8:I'.$idx)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$idx++;
	$idx++;
	$idx++;
	$objPHPExcel->getActiveSheet()->getStyle('A'.$idx)->getAlignment()->setWrapText(true);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$idx,
		"Mark:\n\nC/No.:\nProduct No.:\n\nQty:");



	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.'Packing List ('.$id.') '.'.xls"');
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