<?
include_once "$DOCUMENT_ROOT/inc/common.inc";
include_once "$DOCUMENT_ROOT/inc/util.inc";

if(!empty($sch_code)) $code = $sch_code;
else if(!empty($_REQUEST["code"])) $code = $_REQUEST["code"];

if($sch_info[titleimg] != "") $subimg = "<img src=/data/bbs/$code/$sch_info[titleimg]>";

$upfile_max = 3;	// ����÷�� : �ִ�12��������, ����������� skin���� ������� ����

// ��Ų��ġ
$skin_dir = "/schedule/skin/".$sch_info[skin];

// �Խ��� ���ٱ���
$level_info = level_info();
$mem_level = $level_info[$wiz_session[level]][level];

$lpermi = $level_info[$sch_info[lpermi]][level];
$rpermi = $level_info[$sch_info[rpermi]][level];
$wpermi = $level_info[$sch_info[wpermi]][level];
$apermi = $level_info[$sch_info[apermi]][level];
$cpermi = $level_info[$sch_info[cpermi]][level];

// ���Ͼ��ε� ����
$upfile_path = $DOCUMENT_ROOT."/data/bbs/".$code;		// ���ε����� ��ġ
$upfile_idx = date('ymdhis').rand(1,9);						// ���ε����ϸ�
$imgsize_s = $sch_info[simgsize];
$imgsize_m = $sch_info[mimgsize];

if($imgsize_s == 0) $imgsize_s = 120;
if($imgsize_m == 0) $imgsize_m = 500;

// �Խ��� ������ �ش� �������� ����� ���� �߻� ����
$idx = $_REQUEST[idx];

?>