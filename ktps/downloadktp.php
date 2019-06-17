<?php
require_once('../connect.php');
require_once('../vendor/autoload.php');
require_once('../api/ktp.php');
require_once('../api/group.php');
$ktpf=new Ktp($pdo);
$gf=new Group($pdo);
//use PhpOffice\PhpWord\PhpWord;

$item=$ktpf->GetKtp($_GET['id']);
$d=$gf->GetName($item);
$end1='';
$end2='';
if($item['zachet']==($kurs-1)*2+1) {
      $end1='зачет';
}
if($item['zachet']==($kurs-1)*2+2) {
      $end2='зачет';
}
if($item['exam']==($kurs-1)*2+1) {
      $end1='экзамен';
}
if($item['exam']==($kurs-1)*2+2) {
      $end2='экзамен';
}
$roman=['', 'I', 'II', 'III', 'IV'];
$topicsarr=$ktpf->GetItems($_GET['id']);
$partids=array_unique(array_column($topicsarr, 'part_id'));
$parts=[];
foreach ($topicsarr as $key => $topic) {
      $index=array_search($topic['part_id'], $partids);
      $parts[$index][]=$topic;
}

$phpWord = new PhpOffice\PhpWord\PHPWord();
$phpWord->setDefaultFontSize(12);
$phpWord->setDefaultFontName('Times New Roman');
      $section = $phpWord->addSection(array(
          'marginLeft'   => floor(56.7*30),
          'marginRight'  => floor(56.7*10),
          'marginTop'    => floor(56.7*20),
          'marginBottom' => floor(56.7*20),
      ));

      $center=array('align'=>'center');
      $right=array('align'=>'right');
      $bold=array('bold'=>true);
      $italic=array('italic'=>true);
      $underline=array('underline'=>'single');
      $offset=array('spaceBefore'=>150);
      $styleTable = array('borderSize' => 6, 'borderColor' => '000','unit' => 'pct',
      'width' => 100 * 50);
      $rotate=array('textDirection'=>'btLr');
      $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
      $cellRowContinue = array('vMerge' => 'continue');
      $cellColSpan2 = array('gridSpan' => 2, 'valign' => 'center');
      $cellColSpan4 = array('gridSpan' => 4, 'valign' => 'center');
      $cellColSpan8 = array('gridSpan' => 8, 'valign' => 'center');
      $cellColSpan10 = array('gridSpan' => 10, 'valign' => 'center');
      $cellVCentered = array('valign' => 'center');

      $section->addText("Қазақстан Республикасының Білім және ғылым мининстрлігі", array_merge($bold, $italic), $center);
      $section->addText("\"Павлодар бизнес-колледжі\" КМҚК", array_merge($bold, $italic), $center);
      $section->addText("Министерство образования и науки Республики Казахстан", array_merge($bold, $italic), $center);
      $section->addText("КГКП \"Павлодарский бизнес-колледж\"", array_merge($bold, $italic), $center);
      $section->addTextBreak(1);

      $section->addText("Бекітемін", null);
      $section->addText("Утверждаю", null);
      $section->addText("Басшының ОІ жөнендегі", null);
      $section->addText("орынбасары м.а.", null);
      $section->addText("И.о. зам. руководителя по УР", null);
      $section->addText("_________ Н.Н, Елисеева", null);
      $section->addText(date('Y')." . \"_______\" _________", null);
      $section->addTextBreak(1);

      $section->addText($item['subject_name'], $bold, $center);
      $section->addText("пәнінің күнтізбелік-тақырыптық жоспары", $bold, $center);
      $section->addText($item['kurs_num']." оқу жылының I, II семестрі", $bold, $center);
      $section->addTextBreak(1);
      $section->addText("Календарно-тематический план по предмету", $bold, $center);
      $section->addText($item['subject_name'], $bold, $center);
      $section->addText("на I, II семестр ".$item['kurs_num']." учебного года", $bold, $center);
      $section->addTextBreak(1);

      $textRun=$section->createTextRun();
      $textRun->addText("Оқытушы/Преподавателя     ");
      $textRun->addText($item['teacher_name']);
      $textRun->addTextBreak(2);

      $textRun->addText("Курс, группа, специальность ");
      $textRun->addText($roman[$kurs]."курс, гр.".$d." ".$item['code'].' "'.$item['specialization_name'].'"');
      $textRun->addTextBreak(1);

      $table=$section->addTable(array('unit' => 'pct',
      'width' => 100 * 50));
      $table->addRow();
      $table->addCell(2000)->addText("Пәнге бөлінген жалпы сағат саны Общее количество часов на предмет");
      $table->addCell(2000)->addText($item['totalkurs']);
      $table->addCell(2000)->addText("о.і. теор. в т.ч. теор.");
      $table->addCell(2000)->addText($item['theory']);
      $table->addCell(2000)->addText("зерт.тәж. лаб.прак.");
      $table->addCell(2000)->addText($item['lpr']);

      $table->addRow();
      $table->addCell(2000)->addText("Семестр басталғанға дейін берілді Дано до начала семестра");
      $table->addCell(2000)->addText("");
      $table->addCell(2000)->addText("о.і. теор. в т.ч. теор.");
      $table->addCell(2000)->addText("");
      $table->addCell(2000)->addText("зерт.тәж. лаб.прак.");
      $table->addCell(2000)->addText("");

      $table->addRow();
      $table->addCell(2000)->addText("Осы оқу жылына жоспарланды Планируется на текущий уч.год");
      $table->addCell(2000)->addText($item['totalkurs']);
      $table->addCell(2000)->addText("о.і. теор. в т.ч. теор.");
      $table->addCell(2000)->addText($item['theory']);
      $table->addCell(2000)->addText("зерт.тәж. лаб.прак.");
      $table->addCell(2000)->addText($item['lpr']);

      $table->addRow();
      $table->addCell(2000)->addText("1 семестрге жоспарланып отыр Планируется на 1 семестр");
      $table->addCell(2000)->addText($item['sem1']);
      $table->addCell(2000)->addText("о.і. теор. в т.ч. теор.");
      $table->addCell(2000)->addText($item['theory1']);
      $table->addCell(2000)->addText("зерт.тәж. лаб.прак.");
      $table->addCell(2000)->addText(intval($item['lab1'])+intval($item['pract1']));

      $table->addRow();
      $table->addCell(2000)->addText("2 семестрге жоспарланып отыр Планируется на 2 семестр");
      $table->addCell(2000)->addText($item['sem2']);
      $table->addCell(2000)->addText("о.і. теор. в т.ч. теор.");
      $table->addCell(2000)->addText($item['theory2']);
      $table->addCell(2000)->addText("зерт.тәж. лаб.прак.");
      $table->addCell(2000)->addText(intval($item['lab2'])+intval($item['pract2']));

      $table->addRow();
      $table->addCell(2000)->addText("I семестр аяғында На конец 1 семестра");
      $table->addCell(2000)->addText($end1);
      $table->addCell(2000, $cellColSpan4)->addText("");
      $table->addRow();
      $table->addCell(2000)->addText("II семестр аяғында На конец 2 семестра");
      $table->addCell(2000)->addText($end2);
      $table->addCell(2000, $cellColSpan4)->addText("");


      $sectionH = $phpWord->addSection(array(
          'orientation'=>'landscape',
          'marginLeft'   => floor(56.7*30),
          'marginRight'  => floor(56.7*10),
          'marginTop'    => floor(56.7*20),
          'marginBottom' => floor(56.7*20),
      ));   
      $table=$sectionH->addTable($styleTable);
      $table->addRow();
      $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Сабақтың реттік №\nПорядковый № урока", null, $center);
      $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Бөлімдер мен тақырыптардың аттары\nНаименование разделов и тем", null, $center);
      $table->addCell(2000, $cellColSpan2)->addText("Сағат саны Кол-во часов", null, $center);
      $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Оқудың күнтізбелік мерзімдері\nКалендарные сроки", null, $center);
      $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Оқу тұрпаты және түрі\nТип и вид занятия", null, $center);
      $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Пәнаралық байланыс\nМежпредметные связи", null, $center);
      $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Көрнекі оқу мен техникалық құралдар\nУчебные, наглядные пособия и ТСО", null, $center);
      $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Өздік жұмысының түрі\nВид самостоятельной работы", null, $center);
      $table->addCell(2000, array_merge($rotate, $cellRowSpan))->addText("Негізгі және қосымша әдебиеттер көрсетілген үй тапсырмасы\nДом. задание с указанием основной и дополнительной литературы", null, $center);
      $table->addRow();
      $table->addCell(null, $cellRowContinue);
      $table->addCell(null, $cellRowContinue);
      $table->addCell(2000)->addText("теор.", null, $center);
      $table->addCell(2000)->addText("практ.", null, $center);
      $table->addCell(null, $cellRowContinue);
      $table->addCell(null, $cellRowContinue);
      $table->addCell(null, $cellRowContinue);
      $table->addCell(null, $cellRowContinue);
      $table->addCell(null, $cellRowContinue);
      $table->addCell(null, $cellRowContinue);
      $num=1;
      foreach ($parts as $key => $part) {
            $table->addRow();
            $table->addCell(2000, $cellColSpan10)->addText($ktpf->GetPartName($partids[$key]));
            foreach($part as $topic) {
                  $table->addRow();
                  $table->addCell(2000)->addText($num);
                  $table->addCell(2000)->addText($topic['rupitem_name']);
                  $table->addCell(2000)->addText($topic['item_theory']==0?'':$topic['item_theory']);
                  $table->addCell(2000)->addText($topic['item_practice']==0?'':$topic['item_practice']);
                  $table->addCell(2000)->addText($topic['time']);
                  $table->addCell(2000)->addText($topic['type']==''?(intval($topic['item_practice'])>0?'Лабораторно-практическое занятие':'Комбинированная лекция с элементами беседы'):$topic['type']);
                  $table->addCell(2000)->addText($topic['connections']);
                  $table->addCell(2000)->addText($topic['helpers']);
                  $table->addCell(2000)->addText($topic['worktype']);
                  $table->addCell(2000)->addText($topic['homework']);
                  $num++;
            }
      }
      $table->addRow();
      $table->addCell(2000)->addText("");
      $table->addCell(2000)->addText("Всего");
      $table->addCell(2000)->addText($item['totalkurs']);
      $table->addCell(2000)->addText($item['lpr']==0?'':$item['lpr']);
      $table->addCell(2000)->addText("");
      $table->addCell(2000)->addText("");
      $table->addCell(2000)->addText("");
      $table->addCell(2000)->addText("");
      $table->addCell(2000)->addText("");
      $table->addCell(2000)->addText("");

      $sectionV = $phpWord->addSection(array(
          'marginLeft'   => floor(56.7*30),
          'marginRight'  => floor(56.7*10),
          'marginTop'    => floor(56.7*20),
          'marginBottom' => floor(56.7*20),
      ));   

      $sectionV->addText("Комплект методического обеспечения", $bold, $center);
      $sectionV->addText("Әдістемелік қамтамасыздандыру комплектісі", $bold, $center);
      $sectionV->addTextBreak(1);

      $sectionV->addText("Приложение 1", $bold, $right);
      $sectionV->addTextBreak(1);

      $sectionV->addText("Негізгі әдебиет", $bold, $center);
      $sectionV->addText("Основная литература", $bold, $center);
      $sectionV->addTextBreak(1);

      $sectionV->addText("Қосымша әдебиет", $bold, $center);
      $sectionV->addText("Дополнительная литература", $bold, $center);
      $sectionV->addTextBreak(1);

      $sectionV->addText("Приложение 2", $bold, $right);
      $sectionV->addTextBreak(1);

      $sectionV->addText("Нұсқаулық карталар", $bold, $center);
      $sectionV->addText("Инструкционные карты к выполнению лабораторно-практических работ", $bold, $center);
      $sectionV->addPageBreak();

      $sectionV->addText("Приложение 3", $bold, $right);
      $sectionV->addTextBreak(1);

      $sectionV->addText("Көрнекі құралдар", $bold, $center);
      $sectionV->addText("Наглядные пособия", $bold, $center);
      $sectionV->addPageBreak();

      $sectionV->addText("Приложение 4", $bold, $right);
      $sectionV->addTextBreak(1);

      $sectionV->addText("Пәнаралық байланыс", $bold, $center);
      $sectionV->addText("Межпредметные связи", $bold, $center);
       
      $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
 
      header('Content-Disposition: inline; filename="КТП.docx"');
      header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
      $objWriter->save('php://output');
?>