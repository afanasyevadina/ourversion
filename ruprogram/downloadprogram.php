<?php
require_once('../connect.php');
require_once('../vendor/autoload.php');
require_once('../api/ruprogram.php');
require_once('../api/group.php');

$rf=new Ruprogram($pdo);
$gf=new Group($pdo);
//use PhpOffice\PhpWord\PhpWord;

$main=$rf->GetProgram($_GET['id']);

//разделы
$parts=$rf->GetParts($_GET['id']);

//часы, название предмета и прочая *****
$items=$rf->GetItems($main['general_id']);
$roman=['', 'I', 'II', 'III', 'IV'];
$teachers=array_unique(array_column($items, 'teacher_name'));
$items = $rf->SanitizeItems($items);

$phpWord = new PhpOffice\PhpWord\PHPWord();
$phpWord->setDefaultFontSize(13);
$phpWord->setDefaultFontName('Times New Roman');
      $section = $phpWord->addSection(array(
          'marginLeft'   => floor(56.7*30),
          'marginRight'  => floor(56.7*10),
          'marginTop'    => floor(56.7*20),
          'marginBottom' => floor(56.7*20),
      ));

      $center=array('align'=>'center');
      $bold=array('bold'=>true);
      $size12=array('size'=>12);
      $underline=array('underline'=>'single');
      $offset=array('spaceBefore'=>150);
      $styleTable = array('borderSize' => 6, 'borderColor' => '000','unit' => 'pct',
      'width' => 100 * 50);
      $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
      $cellRowContinue = array('vMerge' => 'continue');
      $cellColSpan2 = array('gridSpan' => 2, 'valign' => 'center');
      $cellColSpan4 = array('gridSpan' => 4, 'valign' => 'center');
      $cellColSpan8 = array('gridSpan' => 8, 'valign' => 'center');
      $cellVCentered = array('valign' => 'center');

      $section->addText("Қазақстан Республикасының Білім және ғылым мининстрлігі", $bold, $center);
      $section->addText("\"Павлодар бизнес-колледжі\" КМҚК", $bold, $center);
      $section->addText("Министерство образования и науки Республики Казахстан", $bold, $center);
      $section->addText("КГКП \"Павлодарский бизнес-колледж\"", $bold, $center);
      $section->addTextBreak(1);

      $section->addText("Бекітемін", null);
      $section->addText("Утверждаю", null);
      $section->addText("Басшының ОІ жөнендегі", null);
      $section->addText("орынбасары м.а.", null);
      $section->addText("И.о. зам. руководителя по УР", null);
      $section->addText("_________ Н.Н, Елисеева", null);
      $section->addText(date('Y')." . \"_______\" _________", null);
      $section->addTextBreak(1);

      $section->addText("Оқу жұмыс бағдарламасы", $bold, $center);
      $section->addText("Рабочая учебная программа", $bold, $center);
      $section->addTextBreak(1);

      $textRun=$section->createTextRun();
      $textRun->addText("Оқытушы/Преподавателя   ");
      $textRun->addText(trim(implode(', ', $teachers), ','), $underline);
      $textRun->addTextBreak(2);

      $textRun->addText('"'.$items[0]['subject_name'].'"', $underline);
      $textRun->addText(" пәні бойынша жұмыс бағдарламасы типтік бағдарлама 2015 ж. \"24\" тамыз тіркеу №4209 негізінде құрастырылған.");
      $textRun->addTextBreak(1);
      $textRun->addText("Рабочая программа разработана на основании типовой программы по дисциплине ");
      $textRun->addText('"'.$items[0]['subject_name'].'"', $underline);
      $textRun->addText(" регистрационный №4209 от \"24\" августа 2015 г.");
      $section->addTextBreak(1);

      $section->addText($items[0]['code'].' "'.$items[0]['specialization_name'].'" мамандығы үшін');
      $section->addText('Для специальности '.$items[0]['code'].' "'.$items[0]['specialization_name']);
      $section->addTextBreak(1);
       
      $section->addText("Оқыту сағаттарын бөлу", null, $center);
      $section->addText("Распределение учебного времени", null, $center);       
 
      $table = $section->addTable($styleTable);
      $table->addRow(null, array('tblHeader' => true));
      $table->addCell(2000, $cellRowSpan)->addText('Курс', $size12);
      $table->addCell(2000, $cellRowSpan)->addText('Барлық сағат/Всего часов', $size12);
      $table->addCell(2000, $cellColSpan8)->addText('Оның ішінде/из них', $size12, $center);

      $table->addRow();
      $table->addCell(null, $cellRowContinue);
      $table->addCell(null, $cellRowContinue);
      $table->addCell(2000, $cellColSpan2)->addText('Теориялық сабақ/теоретических занятий', $size12, $center);
      $table->addCell(2000, $cellColSpan2)->addText('Зертхана жұмысы/ лабораторные работы', $size12, $center);
      $table->addCell(2000, $cellColSpan2)->addText('Тәжірибе сабағы/ практические занятия', $size12, $center);
      $table->addCell(2000, $cellColSpan2)->addText('Курстық жұмыстар/ курсовых работ', $size12, $center);

      $table->addRow();
      $table->addCell(null, $cellRowContinue);
      $table->addCell(null, $cellRowContinue);
      $table->addCell(2000)->addText('Сем. №1', $size12, $center);
      $table->addCell(2000)->addText('Сем. №2', $size12, $center);
      $table->addCell(2000)->addText('Сем. №1', $size12, $center);
      $table->addCell(2000)->addText('Сем. №2', $size12, $center);
      $table->addCell(2000)->addText('Сем. №1', $size12, $center);
      $table->addCell(2000)->addText('Сем. №2', $size12, $center);
      $table->addCell(2000)->addText('Сем. №1', $size12, $center);
      $table->addCell(2000)->addText('Сем. №2', $size12, $center);

      foreach ($items as $key => $item) { 
            $current=substr($item['kurs_num'], 0, 4);
            if($items[0]['base']==9) {
                  $kurs=intval($current)-intval($item['year'])+1; 
            }
            else {
                  $kurs=intval($current)-intval($item['year'])+2;
            }
            $table->addRow();
            $table->addCell(2000)->addText($roman[$kurs], $size12, $center);
            $table->addCell(2000)->addText($item['totalkurs'], $size12, $center);
            $table->addCell(2000)->addText($item['theory1']==0?'':$item['theory1'], $size12, $center);
            $table->addCell(2000)->addText($item['theory2']==0?'':$item['theory2'], $size12, $center);
            $table->addCell(2000)->addText($item['lab1']==0?'':$item['lab1'], $size12, $center);
            $table->addCell(2000)->addText($item['lab2']==0?'':$item['lab2'], $size12, $center);
            $table->addCell(2000)->addText($item['pract1']==0?'':$item['pract1'], $size12, $center);
            $table->addCell(2000)->addText($item['pract2']==0?'':$item['pract2'], $size12, $center);
            $table->addCell(2000)->addText($item['kurs1']==0?'':$item['kurs1'], $size12, $center);
            $table->addCell(2000)->addText($item['kurs2']==0?'':$item['kurs2'], $size12, $center);
      }
      $section->addTextBreak(1);

      $section->addText("Топтарда оқылатын пән", null, $center);
      $section->addText("Предмет изучается в группах", null, $center);
      $table = $section->addTable($styleTable);
      $table->addRow();
      $table->addCell(2000)->addText("Оқу жылы/учебный год", $size12);
      $table->addCell(2000)->addText("Курстың нөмірі/номер курса", $size12);
      $table->addCell(2000)->addText("Топтың шифрі/шифр группы", $size12);
      foreach ($items as $key => $item) { 
            $d=$gf->GetName($item);
            $table->addRow();
            $table->addCell(2000)->addText($item['kurs_num'], $size12, $center);
            $table->addCell(2000)->addText($roman[$kurs], $size12, $center);
            $table->addCell(2000)->addText($d, $size12, $center);
      }

      $section->addPageBreak();

      $section->addText("СТРУКТУРА РАБОЧЕЙ ПРОГРАММЫ", $bold, $center);
      $section->addPageBreak();
      $section->addText("ПОЯСНИТЕЛЬНАЯ ЗАПИСКА", $bold, $center);
      $section->addPageBreak();

      $section->addText("2. ТЕМАТИЧЕСКИЙ ПЛАН", $bold, $center);
      $section->addTextBreak(1);

      $table = $section->addTable($styleTable);
      $table->addRow();
      $table->addCell(2000, $cellRowSpan)->addText("№ п/п", array_merge($bold, $size12), $center);
      $table->addCell(2000, $cellRowSpan)->addText("Наименование разделов и тем", array_merge($bold, $size12), $center);
      $table->addCell(2000, $cellColSpan2)->addText("Количество учебного времени", array_merge($bold, $size12), $center);
      $table->addRow();
      $table->addCell(null, $cellRowContinue);
      $table->addCell(null, $cellRowContinue);
      $table->addCell(2000)->addText("всего", array_merge($bold, $size12), $center);
      $table->addCell(2000)->addText("лпз", array_merge($bold, $size12), $center);

      foreach ($parts as $key => $part) {       
            $table->addRow();
            $table->addCell(2000, $cellColSpan4)->addText($part['part_name'], array_merge($bold, $size12), $center);
            $collection=$rf->GetPartItems($part['part_id']);
            foreach($collection as $item) {       
                  $table->addRow();
                  $table->addCell(2000)->addText($item['rupitem_num'], $size12, $center);
                  $table->addCell(2000)->addText($item['rupitem_name'], $size12, $center);
                  $table->addCell(2000)->addText($item['item_theory']+$item['item_practice']==0?'':$item['item_theory']+$item['item_practice'], $size12, $center);
                  $table->addCell(2000)->addText($item['item_practice']==0?'':$item['item_practice'], $size12, $center);
            }
      }
      $table->addRow();
      $table->addCell(2000)->addText("");
      $table->addCell(2000)->addText("Всего учебного времени по дисциплине");
      $table->addCell(2000)->addText($items[0]['totalrup']);
      $table->addCell(2000)->addText($items[0]['lprrup']);

      $section->addPageBreak();

      $section->addText("СОДЕРЖАНИЕ УЧЕБНОЙ ПРОГРАММЫ",  $bold, $center);
      $section->addTextBreak(1);
      foreach ($parts as $key => $part) { 
            $section->addText($part['part_name'], $bold, $center);
            $collection=$rf->GetPartItems($part['part_id']);
            foreach($collection as $item) {   
                  $section->addText("Тема ".$part['part_num'].".".$item['rupitem_num'].". ".$item['rupitem_name'],
                      null,
                      array(
                          'indentation' => array('left' => floor(56.7*12.5))
                      ));
            }
            $section->addTextBreak(2);
      }

      $sectionH = $phpWord->addSection(array(
          'orientation'=>'landscape',
          'marginLeft'   => floor(56.7*30),
          'marginRight'  => floor(56.7*10),
          'marginTop'    => floor(56.7*20),
          'marginBottom' => floor(56.7*20),
      ));   
      $table=$sectionH->addTable($styleTable);
      $table->addRow(null, array('tblHeader' => true));
      $table->addCell(2000, $cellRowSpan)->addText("№", $size12, $center);
      $table->addCell(2000, $cellRowSpan)->addText("Кол-во часов", $size12, $center);
      $table->addCell(2000, $cellRowSpan)->addText("Основные вопросы, темы", $size12, $center);
      $table->addCell(2000, $cellColSpan4)->addText("Цель дидактического процесса", array_merge($bold, $size12), $center);
      $table->addCell(2000, $cellRowSpan)->addText("Состав методического комплекса", $size12, $center);
      $table->addRow(null, array('tblHeader' => true));
      $table->addCell(null, $cellRowContinue);
      $table->addCell(null, $cellRowContinue);
      $table->addCell(null, $cellRowContinue);
      $table->addCell(2000)->addText("представления", $size12, $center);
      $table->addCell(2000)->addText("знания", $size12, $center);
      $table->addCell(2000)->addText("умения", $size12, $center);
      $table->addCell(2000)->addText("навыки", $size12, $center);
      $table->addCell(null, $cellRowContinue);
      foreach ($parts as $item) {
            $table->addRow();
            $table->addCell(2000)->addText($item['part_num']);
            $table->addCell(2000)->addText($item['hours']==0?'':$item['hours']);
            $table->addCell(2000)->addText($item['part_name']);
            $table->addCell(2000)->addText($item['imagine']);
            $table->addCell(2000)->addText($item['know']);
            $table->addCell(2000)->addText($item['can']);
            $table->addCell(2000)->addText($item['skills']);
            $table->addCell(2000)->addText($item['complex']);
      }

      $sectionV = $phpWord->addSection(array(
          'marginLeft'   => floor(56.7*30),
          'marginRight'  => floor(56.7*10),
          'marginTop'    => floor(56.7*20),
          'marginBottom' => floor(56.7*20),
      ));   
      $sectionV->addText("5. ПЕРЕЧЕНЬ ЛАБОРАТОРНО-ПРАКТИЧЕСКИХ РАБОТ", $bold, $center);

      $table=$sectionV->addTable($styleTable);
      $table->addRow(null, array('tblHeader' => true));
      $table->addCell(2000)->addText("№ занятия. Наименование темы", array_merge($bold, $size12), $center);
      $table->addCell(2000)->addText("Кол-во часов", array_merge($bold, $size12), $center);
      $table->addCell(2000)->addText("Содержание лабораторной работы", array_merge($bold, $size12), $center);
      $lprs=$rf->GetLpr($_GET['id']);
      foreach($lprs as $item) {
            $table->addRow();
            $table->addCell(2000)->addText("№".$item['rupitem_num']." ".$item['rupitem_name']);
            $table->addCell(2000)->addText($item['item_practice'], $bold);
            $table->addCell(2000)->addText($item['content']);
      }
      $table->addRow();
      $table->addCell(2000)->addText("Всего:", $bold);
      $table->addCell(2000)->addText($items[0]['lprrup'], $bold);
      $table->addCell(2000)->addText("");
      $sectionV->addPageBreak();
      $sectionV->addText("6. Контрольные вопросы", $bold, $center);
      $sectionV->addPageBreak();
      $sectionV->addText("7. ЛИТЕРАТУРА", $bold, $center);
       
      $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
 
      header('Content-Disposition: inline; filename="РУП.docx"');
      header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
      $objWriter->save('php://output');
?>