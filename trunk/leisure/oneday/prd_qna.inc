<? 
	$code = "qna";
	
	// �Խ��� ����
	$sql = "select * from wiz_bbsinfo where code = '$code'";
	$result = mysql_query($sql) or error(mysql_error());
	$total = mysql_num_rows($result);
	$bbs_info = mysql_fetch_array($result);
	if($total <= 0 || $bbs_info[usetype] != "Y") {
		$qna_hide_start = "<!--"; $qna_hide_end = "-->";
	}
?>
<script language="javascript">
<!--
var clickvalue='';
function qnaShow(idnum) {

	qna=eval("qna"+idnum+".style");

	if(clickvalue != qna) {
		if(clickvalue!='') {
			clickvalue.display='none';
		}

		qna.display='block';
		clickvalue=qna;
	} else {
		qna.display='none';
		clickvalue='';
	}

}

function qnaCheck(frm) {
	if(frm.passwd.value == "") {
		alert("��й�ȣ�� �Է��ϼ���.");
		frm.passwd.focus();
		return false;
	}
}
-->
</script>
<?=$qna_hide_start?>
<table width=100% border=0 cellpadding=0 cellspacing=0>
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="/images/bar_prdqna.gif"></td>
          <td align="right" style="padding-right:5;"><a href="/bbs/input.php?code=<?=$code?>&mode=write&prdcode=<?=$prdcode?>"><img src="/images/btn_qnawrite.gif" border="0" align="absmiddle"></a> <a href="/bbs/list.php?code=<?=$code?>"><img src="/images/btn_qnalist.gif" border="0" align="absmiddle"></a></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr><td bgcolor="#999999" height="3"></td></tr>
</table>
<table border=0 cellpadding="0" cellspacing="0" width="100%">
	<tr><td height="10"></td></tr>
  <tr>
    <td width="12"><img src="/images/list_bar_front.gif"></td>
    <td width="5%" align="center" bgcolor="f6f6f6" class="11gray_01"><strong>��ȣ</strong></td>
    <td width="65%" align="center" bgcolor="f6f6f6" class="11gray_01"><strong>����</strong></td>
    <td width="10%" align="center" bgcolor="f6f6f6" class="11gray_01"><strong>�ۼ���</strong></td>
    <td width="10%" align="center" bgcolor="f6f6f6" class="11gray_01"><strong>�ۼ���</strong></td>
    <td width="10%" align="center" bgcolor="f6f6f6" class="11gray_01"><strong>��ȸ��</strong></td>
    <td width="12" align="right"><img src="/images/list_bar_back.gif"></td>
  </tr>
	<?
	$sql = "select idx from wiz_bbs where code = '$code' and prdcode='$prdcode' order by prino desc";
	$result = mysql_query($sql) or error(mysql_error());
	 
	$rows = 30;
	$lists = 5;
	$total = mysql_num_rows($result);
	$page_count = ceil($total/$rows);
	if(!$page || $page > $page_count) $page = 1;
	$start = ($page-1)*$rows;
	$no = $total-$start;
	
	$sql = "select *, DATE_FORMAT(FROM_UNIXTIME(wdate), '%Y.%m.%d') as wdate from wiz_bbs where code = '$code' and prdcode='$prdcode' order by prino desc limit $start, $rows";
	$result = mysql_query($sql) or error(mysql_error());
	
	while(($row = mysql_fetch_object($result)) && $rows){
	 	
	 	
	 	$catname=""; $re_space=""; $depno=""; $lock=""; $new=""; $hot="";
	 	
	 	$qna_display = "none";
	 	
	 	$subject = "<a href=\"javascript:qnaShow('$no');\">$row->subject</a>";
	 	
	 	if($row->privacy == "Y"){
	 		
			$grp_sql = "select idx from wiz_bbs where code='$code' and grpno='$row->grpno' and passwd='$passwd' and idx = '$idx'";
			$grp_result = mysql_query($grp_sql) or error(mysql_error());
			$grp_passwd = mysql_num_rows($grp_result);
			
			if(
			$mem_level == 0 ||																																				// ��ü������
			($bbs_info[bbsadmin] != "" && strpos($bbs_info[bbsadmin],$wiz_session[id]) !== false)  ||	// �Խ��ǰ�����
			($row->memid != "" && $row->memid == $wiz_session[id]) || 												// �ڽ��Ǳ�
			($row->passwd != "" && $row->passwd == $passwd && !strcmp($idx, $row->idx)) ||																// ��й�ȣ��ġ
			($wiz_session[id] != "" && strpos($row->memgrp,$wiz_session[id]) !== false) ||				// �׷��Ǳ�
			($grp_passwd > 0)																																					// �׷���
			){
			}else{
				$subject = "<a href='../bbs/auth.php?mode=view&idx=$row->idx&code=$code&page=$page&$param'>$row->subject</a>";	 			
			}
			
	 		$lock = "<img src='/images/lock.gif' align='absmiddle'>";
	 		
	 	}
	
	 	$re_space = ""; for($ii=0; $ii < $row->depno; $ii++) $re_space .= "&nbsp;&nbsp;";				// respace
	 	if($row->depno != 0) $depno = "<img src='/images/re.gif' align='absmiddle'>";												// re
	 	
 ?>
	<tr>
		<td></td>
	  <td align="center" height="25"><?=$no?></td>
	  <td>&nbsp;<?=$re_space?><?=$depno?> <?=$subject?> <?=$lock?></td>
	  <td align="center"><?=$row->name?></td>
	  <td align="center"><?=$row->wdate?></td>
	  <td align="center"><?=$row->count?></td>
	  <td></td>
	</tr>
	<tr>
	  <td></td>
	  <td colspan="5">
		  <table width="100%" border="0"  bgcolor="f5f5f5" cellspacing="2" cellpadding="10" id="qna<?=$no?>" style="display:<?=$qna_display?>">
		  <tr><td bgcolor="ffffff"><?=str_replace("\n","<br>",$row->content)?></td></tr>
		  </table>
    </td>
    <td></td>
  </tr>
  <tr>
    <td></td>
	  <td colspan="5" height="1" background='/images/dot_line.gif'></td>
	  <td></td>
  </tr>
	<?
		$no--;
		$rows--;
	}
	if($total <= 0){
	?>
	<tr>
	  <td align="center" colspan="10" height="30">��ϵ� �Խù��� �����ϴ�.</td>
	</tr>
	<tr>
	  <td></td>
	  <td colspan="5" height="1" background="/images/dot_line.gif"></td>
	  <td></td>
	</tr>
	<?
	}
	?>
</table>
<table border=0 cellpadding="0" cellspacing="0" width="100%">
	<tr><td height="5"></td></tr>
  <tr>
    <td><? print_pagelist($page, $lists, $page_count, "&prdcode=$prdcode"); ?></td>
  </tr>
</table>
<br>
<?=$qna_hide_end?>