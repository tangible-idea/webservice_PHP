<? include "../../inc/common.inc"; ?>
<? include "../../inc/util.inc"; ?>
<? include "../../inc/shop_info.inc"; ?>
<? include "../../inc/admin_check.inc"; ?>
<? include "../header.php"; ?>

<?
if($sub_mode == "update"){
   
	$sql = "select * from wiz_admin where id = '$id'";
	$result = mysql_query($sql) or error(mysql_error());
	$admin_info = mysql_fetch_object($result);
	
}
?>

<script language="JavaScript" type="text/javascript">
<!--
function inputCheck(frm){
   
   if(frm.id.value == ""){
      alert("관리자 아이디를 입력하세요");
      frm.id.focus();
      return false;
   }
   if(frm.passwd.value == ""){
      alert("관리자 비밀번호를 입력하세요");
      frm.passwd.focus();
      return false;
   }
   if(frm.name.value == ""){
      alert("관리자 이름을 입력하세요");
      frm.name.focus();
      return false;
   }
   if(frm.email.value == ""){
      alert("관리자 이메일을 입력하세요");
      frm.email.focus();
      return false;
   }
}

// 주소찾기
function searchZip(){
	var url = "../member/search_zip.php";
	window.open(url,"searchZip","height=350, width=367, menubar=no, scrollbars=yes, resizable=no, toolbar=no, status=no, top=100, left=100");
}
//-->
</script>
<script language="javascript">
<!--
function checkBasic(type){
   var check00 = document.getElementById("01-00").checked;
   document.getElementById("01-01").checked = check00;
   document.getElementById("01-02").checked = check00;
   document.getElementById("01-03").checked = check00;
   document.getElementById("01-04").checked = check00;
   document.getElementById("01-05").checked = check00;
   document.getElementById("01-06").checked = check00;
   document.getElementById("01-07").checked = check00;
   document.getElementById("01-08").checked = check00;
   document.getElementById("01-09").checked = check00;
}
function checkBasic2(ck){
   var check00 = document.getElementById("01-00").checked
   if(ck.checked == true || check00){
      document.getElementById("01-00").checked = true;
      document.getElementById("01-01").checked = true;
   }
}
function checkDesign(type){
   var check00 = document.getElementById("02-00").checked;
   document.getElementById("02-01").checked = check00;
   document.getElementById("02-02").checked = check00;
   document.getElementById("02-03").checked = check00;
   document.getElementById("02-04").checked = check00;
}
function checkDesign2(ck){
   var check00 = document.getElementById("02-00").checked
   if(ck.checked == true || check00){
      document.getElementById("02-00").checked = true;
      document.getElementById("02-01").checked = true;
   }
}
function checkPage(type){
   var check00 = document.getElementById("03-00").checked;
   document.getElementById("03-01").checked = check00;
   document.getElementById("03-02").checked = check00;
   document.getElementById("03-03").checked = check00;
   document.getElementById("03-04").checked = check00;
   document.getElementById("03-05").checked = check00;
   document.getElementById("03-06").checked = check00;
   document.getElementById("03-07").checked = check00;
   document.getElementById("03-08").checked = check00;
   document.getElementById("03-09").checked = check00;
}
function checkPage2(ck){
   var check00 = document.getElementById("03-00").checked
   if(ck.checked == true || check00){
      document.getElementById("03-00").checked = true;
      document.getElementById("03-01").checked = true;
   }
}
function checkProduct(type){
   var check00 = document.getElementById("04-00").checked;
   document.getElementById("04-01").checked = check00;
   document.getElementById("04-02").checked = check00;
   document.getElementById("04-03").checked = check00;
   document.getElementById("04-04").checked = check00;
   document.getElementById("04-05").checked = check00;
   document.getElementById("04-06").checked = check00;
   document.getElementById("04-07").checked = check00;
   document.getElementById("04-08").checked = check00;
   document.getElementById("04-09").checked = check00;
}
function checkProduct2(ck){
   var check00 = document.getElementById("04-00").checked
   if(ck.checked == true || check00){
      document.getElementById("04-00").checked = true;
      document.getElementById("04-01").checked = true;
   }
}
function checkOneday(type){
	var check00 = document.getElementById("05-00").checked;
	if(check00==true){
		document.getElementById("05-01").checked = true;
		document.getElementById("05-02").checked = true;
		document.getElementById("05-03").checked = true;
		document.getElementById("05-04").checked = true;
		document.getElementById("05-05").checked = true;
		document.getElementById("05-06").checked = true;
		document.getElementById("05-07").checked = true;
		document.getElementById("05-08").checked = true;
		document.getElementById("05-09").checked = true;
		document.getElementById("05-10").checked = true;
		document.getElementById("05-11").checked = true;
		document.getElementById("05-12").checked = true;
	}else{
		document.getElementById("05-01").checked = false;
		document.getElementById("05-02").checked = false;
		document.getElementById("05-03").checked = false;
		document.getElementById("05-04").checked = false;
		document.getElementById("05-05").checked = false;
		document.getElementById("05-06").checked = false;
		document.getElementById("05-07").checked = false;
		document.getElementById("05-08").checked = false;
		document.getElementById("05-09").checked = false;
		document.getElementById("05-10").checked = false;
		document.getElementById("05-11").checked = false;
		document.getElementById("05-12").checked = false;
	}
}
function checkOneday2(ck){
   var check00 = document.getElementById("05-00").checked
   if(ck.checked == true || check00){
      document.getElementById("05-00").checked = true;
   }
}
function checkMember(type){
   var check00 = document.getElementById("06-00").checked;
   document.getElementById("06-01").checked = check00;
   document.getElementById("06-02").checked = check00;
   document.getElementById("06-03").checked = check00;
   document.getElementById("06-04").checked = check00;
   document.getElementById("06-05").checked = check00;
   document.getElementById("06-06").checked = check00;
}
function checkMember2(ck){
   var check00 = document.getElementById("06-00").checked
   if(ck.checked == true || check00){
      document.getElementById("06-00").checked = true;
      document.getElementById("06-01").checked = true;
   }
}
function checkMarketing(type){
   var check00 = document.getElementById("07-00").checked;
   document.getElementById("07-01").checked = check00;
   document.getElementById("07-02").checked = check00;
   document.getElementById("07-03").checked = check00;
   document.getElementById("07-04").checked = check00;
   document.getElementById("07-05").checked = check00;
}
function checkMarketing2(ck){
   var check00 = document.getElementById("07-00").checked
   if(ck.checked == true || check00){
      document.getElementById("07-00").checked = true;
      document.getElementById("07-01").checked = true;
   }
}
function checkBbs(type){
   var check00 = document.getElementById("08-00").checked;
   document.getElementById("08-01").checked = check00;
   document.getElementById("08-02").checked = check00;
   document.getElementById("08-03").checked = check00;
}
function checkBbs2(ck){
   var check00 = document.getElementById("08-00").checked
   if(ck.checked == true || check00){
      document.getElementById("08-00").checked = true;
      document.getElementById("08-01").checked = true;
   }
}

function checkSchedule(type){
   var check00 = document.getElementById("09-00").checked;
   document.getElementById("09-01").checked = check00;
   document.getElementById("09-02").checked = check00;
}
function checkSchedule2(ck){
   var check00 = document.getElementById("09-00").checked;
   if(ck.checked == true || check00){
      document.getElementById("09-00").checked = true;
   }
}

function checkPoll(type){
   var check00 = document.getElementById("10-00").checked;
   document.getElementById("10-01").checked = check00;
   document.getElementById("10-02").checked = check00;
}
function checkPoll2(ck){
   var check00 = document.getElementById("10-01").checked;
   if(ck.checked == true || check00){
      document.getElementById("10-00").checked = true;
   }
}

-->
</script>

<table border="0" cellspacing="0" cellpadding="2">
	<tr>
		<td><img src="../image/ic_tit.gif"></td>
		<td valign="bottom" class="tit">관리자설정</td>
		<td width="2"></td>
		<td valign="bottom" class="tit_alt">관리자정보를 설정합니다.</td>
	</tr>
</table>

<br>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<form name="frm" action="shop_save.php" method="post" onSubmit="return inputCheck(this);">
	<input type="hidden" name="tmp">
	<input type="hidden" name="mode" value="shop_admin">
	<input type="hidden" name="sub_mode" value="<?=$sub_mode?>">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="1" cellpadding="6" class="t_style">
				<tr>
					<td width="15%" class="t_name">아이디 <font color=red>*</font></td>
					<td width="35%" class="t_value"><input name="id" type="text" value="<?=$admin_info->id?>" class="input" <? if($mode == "update") echo "readonly"; ?>></td>
					<td width="15%" class="t_name">비밀번호 <font color=red>*</font></td>
					<td width="35%" class="t_value"><input name="passwd" type="text" value="<?=$admin_info->passwd?>" class="input"></td>
				</tr>
				<tr>
					<td class="t_name">이름 <font color=red>*</font></td>
					<td class="t_value"><input name="name" type="text" value="<?=$admin_info->name?>" class="input"></td>
					<td class="t_name">이메일 <font color=red>*</font></td>
					<td class="t_value"><input name="email" type="text" value="<?=$admin_info->email?>" class="input"></td>
				</tr>
				<tr>
					<td class="t_name">주민번호</td>
					<td class="t_value">
					<? list($resno, $resno2) = explode("-",$admin_info->resno); ?>
						<input type="text" name="resno" value="<?=$resno?>" size="9" class="input">- 
						<input type="text" name="resno2" value="<?=$resno2?>" size="9" class="input">
					</td>
					<td class="t_name">전화번호</td>
					<td class="t_value">
					<? list($tphone, $tphone2, $tphone3) = explode("-",$admin_info->tphone); ?>
						<input type="text" name="tphone" value="<?=$tphone?>" size="5" class="input">- 
						<input type="text" name="tphone2" value="<?=$tphone2?>" size="5" class="input">- 
						<input type="text" name="tphone3" value="<?=$tphone3?>" size="5" class="input">
					</td>
				</tr>
				<tr>
					<td class="t_name">휴대폰</td>
					<td class="t_value">
					<? list($hphone, $hphone2, $hphone3) = explode("-",$admin_info->hphone); ?>
						<input type="text" name="hphone" value="<?=$hphone?>"  size="5" class="input">- 
						<input type="text" name="hphone2" value="<?=$hphone2?>"  size="5" class="input">- 
						<input type="text" name="hphone3" value="<?=$hphone3?>"  size="5" class="input">
					</td>
					<td class="t_name">회원등급</td>
					<td class="t_value">관리자</td>
				</tr>
				<tr>
					<td class="t_name">우편번호</td>
					<td class="t_value" colspan="3">
					<? list($post, $post2) = explode("-",$admin_info->post); ?>
						<input name="post" type="text" value="<?=$post?>" size="5" class="input">- 
						<input name="post2" type="text" value="<?=$post2?>" size="5" class="input">
						<img src="../image/btn_post.gif" style="cursor:hand" align="absmiddle" onClick="searchZip();">
					</td>
				</tr>
				<tr>
					<td class="t_name">주소</td>
					<td class="t_value" colspan="3">
						<input name="address" type="text" value="<?=$admin_info->address?>" size="60" class="input"><br>
						<input name="address2" type="text" value="<?=$admin_info->address2?>" size="60" class="input">
					</td>
				</tr>
				<tr>
					<td height="25" class="t_name">접근권한</td>
					<td class="t_value" colspan="3">
<?
$permi_list = explode("/",$admin_info->permi);
for($ii=0; $ii<count($permi_list); $ii++){
	$tmp_permi[$permi_list[$ii]] = true;
}
?>
						<table border="0" cellpadding="5" width="100%" class="t_name">
							<tr>
								<td valign="top"><input type="checkbox" size="20" name="permi[]" value="00-00" checked disabled><b>관리자(인트라넷)접근</b><br><br></td>
								<td valign="top">
									<input type="checkbox" size="20" name="permi[]" id="01-00" value="01-00" onClick="checkBasic();" <? if($tmp_permi["01-00"]==true || $sub_mode == "insert") echo "checked"; ?>><b>상점관리</b><br>
									<input type="checkbox" size="20" name="permi[]" id="01-01" value="01-01" onClick="checkBasic2(this);" <? if($tmp_permi["01-01"]==true || $sub_mode == "insert") echo "checked"; ?>>기본정보설정<br>
									<input type="checkbox" size="20" name="permi[]" id="01-02" value="01-02" onClick="checkBasic2(this);" <? if($tmp_permi["01-02"]==true || $sub_mode == "insert") echo "checked"; ?>>운영정보설정 <br>
									<input type="checkbox" size="20" name="permi[]" id="01-03" value="01-03" onClick="checkBasic2(this);" <? if($tmp_permi["01-03"]==true || $sub_mode == "insert") echo "checked"; ?>>메일/SMS설정<br>
									<input type="checkbox" size="20" name="permi[]" id="01-04" value="01-04" onClick="checkBasic2(this);" <? if($tmp_permi["01-04"]==true || $sub_mode == "insert") echo "checked"; ?>>SMS관리<br>
									<input type="checkbox" size="20" name="permi[]" id="01-05" value="01-05" onClick="checkBasic2(this);" <? if($tmp_permi["01-05"]==true || $sub_mode == "insert") echo "checked"; ?>>관리자설정<br>
									<input type="checkbox" size="20" name="permi[]" id="01-06" value="01-06" onClick="checkBasic2(this);" <? if($tmp_permi["01-06"]==true || $sub_mode == "insert") echo "checked"; ?>>거래처관리<br>
									<input type="checkbox" size="20" name="permi[]" id="01-07" value="01-07" onClick="checkBasic2(this);" <? if($tmp_permi["01-07"]==true || $sub_mode == "insert") echo "checked"; ?>>쿠폰관리<br>
									<input type="checkbox" size="20" name="permi[]" id="01-08" value="01-08" onClick="checkBasic2(this);" <? if($tmp_permi["01-08"]==true || $sub_mode == "insert") echo "checked"; ?>>팝업관리<br>
								</td>
								<td valign="top">
									<input type="checkbox" size="20" name="permi[]" id="03-00" onClick="checkPage();" value="03-00" <? if($tmp_permi["03-00"]==true || $sub_mode == "insert") echo "checked"; ?>><b>페이지설정</b><br>
									<input type="checkbox" size="20" name="permi[]" id="03-01" onClick="checkPage2(this);" value="03-01" <? if($tmp_permi["03-01"]==true || $sub_mode == "insert") echo "checked"; ?>>회사소개<br>
									<input type="checkbox" size="20" name="permi[]" id="03-02" onClick="checkPage2(this);" value="03-02" <? if($tmp_permi["03-02"]==true || $sub_mode == "insert") echo "checked"; ?>>회원가입<br>
									<input type="checkbox" size="20" name="permi[]" id="03-04" onClick="checkPage2(this);" value="03-04" <? if($tmp_permi["03-04"]==true || $sub_mode == "insert") echo "checked"; ?>>장바구니<br>
									<input type="checkbox" size="20" name="permi[]" id="03-05" onClick="checkPage2(this);" value="03-05" <? if($tmp_permi["03-05"]==true || $sub_mode == "insert") echo "checked"; ?>>고객센터<br>
									<input type="checkbox" size="20" name="permi[]" id="03-06" onClick="checkPage2(this);" value="03-06" <? if($tmp_permi["03-06"]==true || $sub_mode == "insert") echo "checked"; ?>>이용안내<br>
									<input type="checkbox" size="20" name="permi[]" id="03-07" onClick="checkPage2(this);" value="03-07" <? if($tmp_permi["03-07"]==true || $sub_mode == "insert") echo "checked"; ?>>개인정보보호정책<br>
									<input type="checkbox" size="20" name="permi[]" id="03-08" onClick="checkPage2(this);" value="03-08" <? if($tmp_permi["03-08"]==true || $sub_mode == "insert") echo "checked"; ?>>기타페이지<br>
								</td>
							</tr>
							<tr>
								<td valign="top">
									
									<input type="checkbox" size="20" name="permi[]" id="08-00" onClick="checkBbs();" value="08-00" <? if($tmp_permi["08-00"]==true || $sub_mode == "insert") echo "checked"; ?>><b>게시판관리</b><br>
									<input type="checkbox" size="20" name="permi[]" id="08-01" onClick="checkBbs2(this);" value="08-01" <? if($tmp_permi["08-01"]==true || $sub_mode == "insert") echo "checked"; ?>>게시판설정<br>
									<input type="checkbox" size="20" name="permi[]" id="08-03" onClick="checkBbs2(this);" value="08-03" <? if($tmp_permi["08-03"]==true || $sub_mode == "insert") echo "checked"; ?>>게시판등록<br>
									<input type="checkbox" size="20" name="permi[]" id="08-02" onClick="checkBbs2(this);" value="08-02" <? if($tmp_permi["08-02"]==true || $sub_mode == "insert") echo "checked"; ?>>게시물관리<br>
								</td>
								<td valign="top">
									<input type="checkbox" size="20" name="permi[]" id="06-00" onClick="checkMember();" value="06-00" <? if($tmp_permi["06-00"]==true || $sub_mode == "insert") echo "checked"; ?>><b>회원관리</b><br>
									<input type="checkbox" size="20" name="permi[]" id="06-01" onClick="checkMember2(this);" value="06-01" <? if($tmp_permi["06-01"]==true || $sub_mode == "insert") echo "checked"; ?>>회원목록<br>
									<input type="checkbox" size="20" name="permi[]" id="06-02" onClick="checkMember2(this);" value="06-02" <? if($tmp_permi["06-02"]==true || $sub_mode == "insert") echo "checked"; ?>>등급관리<br>
									<input type="checkbox" size="20" name="permi[]" id="06-03" onClick="checkMember2(this);" value="06-03" <? if($tmp_permi["06-03"]==true || $sub_mode == "insert") echo "checked"; ?>>1:1 상담관리<br>
									<input type="checkbox" size="20" name="permi[]" id="06-04" onClick="checkMember2(this);" value="06-04" <? if($tmp_permi["06-04"]==true || $sub_mode == "insert") echo "checked"; ?>>탈퇴회원<br>
									<input type="checkbox" size="20" name="permi[]" id="06-05" onClick="checkMember2(this);" value="06-05" <? if($tmp_permi["06-05"]==true || $sub_mode == "insert") echo "checked"; ?>>메일발송<br>
									<input type="checkbox" size="20" name="permi[]" id="06-06" onClick="checkMember2(this);" value="06-06" <? if($tmp_permi["06-06"]==true || $sub_mode == "insert") echo "checked"; ?>>SMS발송<br>
								</td>
								<td valign="top">
									<input type="checkbox" size="20" name="permi[]" id="07-00" onClick="checkMarketing();" value="07-00" <? if($tmp_permi["07-00"]==true || $sub_mode == "insert") echo "checked"; ?>><b>마케팅분석</b><br>
									<input type="checkbox" size="20" name="permi[]" id="07-01" onClick="checkMarketing2(this);" value="07-01" <? if($tmp_permi["07-01"]==true || $sub_mode == "insert") echo "checked"; ?>>접속자분석<br>
									<input type="checkbox" size="20" name="permi[]" id="07-02" onClick="checkMarketing2(this);" value="07-02" <? if($tmp_permi["07-02"]==true || $sub_mode == "insert") echo "checked"; ?>>접속경로분석<br>
									<input type="checkbox" size="20" name="permi[]" id="07-03" onClick="checkMarketing2(this);" value="07-03" <? if($tmp_permi["07-03"]==true || $sub_mode == "insert") echo "checked"; ?>>매출통계분석<br>
									<input type="checkbox" size="20" name="permi[]" id="07-04" onClick="checkMarketing2(this);" value="07-04" <? if($tmp_permi["07-04"]==true || $sub_mode == "insert") echo "checked"; ?>>상품통계분석<br>
									<input type="checkbox" size="20" name="permi[]" id="07-05" onClick="checkMarketing2(this);" value="07-05" <? if($tmp_permi["07-05"]==true || $sub_mode == "insert") echo "checked"; ?>>회원통계<br>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<input type="checkbox" size="20" name="permi[]" id="05-00" onClick="checkOneday();" value="05-00" <? if($tmp_permi["05-00"]==true || $sub_mode == "insert") echo "checked"; ?>><b>원데이몰관리</b><br>
									<input type="checkbox" size="20" name="permi[]" id="05-01" onClick="checkOneday2(this);" value="05-01" <? if($tmp_permi["05-01"]==true || $sub_mode == "insert") echo "checked"; ?>>원데이몰설정<br>
									<input type="checkbox" size="20" name="permi[]" id="05-02" onClick="checkOneday2(this);" value="05-02" <? if($tmp_permi["05-02"]==true || $sub_mode == "insert") echo "checked"; ?>>지역관리<br>
									<input type="checkbox" size="20" name="permi[]" id="05-03" onClick="checkOneday2(this);" value="05-03" <? if($tmp_permi["05-03"]==true || $sub_mode == "insert") echo "checked"; ?>>상품목록<br>
									<input type="checkbox" size="20" name="permi[]" id="05-04" onClick="checkOneday2(this);" value="05-04" <? if($tmp_permi["05-04"]==true || $sub_mode == "insert") echo "checked"; ?>>상품등록<br>
									<input type="checkbox" size="20" name="permi[]" id="05-05" onClick="checkOneday2(this);" value="05-05" <? if($tmp_permi["05-05"]==true || $sub_mode == "insert") echo "checked"; ?>>전체주문목록<br>
									<!--
									<input type="checkbox" size="20" name="permi[]" id="05-06" onClick="checkOneday2(this);" value="05-06" <? if($tmp_permi["05-06"]==true || $sub_mode == "insert") echo "checked"; ?>>주문취소목록<br>
									-->
									<input type="checkbox" size="20" name="permi[]" id="05-07" onClick="checkOneday2(this);" value="05-07" <? if($tmp_permi["05-07"]==true || $sub_mode == "insert") echo "checked"; ?>>공급업체관리<br>
									<input type="checkbox" size="20" name="permi[]" id="05-08" onClick="checkOneday2(this);" value="05-08" <? if($tmp_permi["05-08"]==true || $sub_mode == "insert") echo "checked"; ?>>구독신청관리<br>
									<input type="checkbox" size="20" name="permi[]" id="05-09" onClick="checkOneday2(this);" value="05-09" <? if($tmp_permi["05-09"]==true || $sub_mode == "insert") echo "checked"; ?>>MD관리<br>
									<input type="checkbox" size="20" name="permi[]" id="05-10" onClick="checkOneday2(this);" value="05-10" <? if($tmp_permi["05-10"]==true || $sub_mode == "insert") echo "checked"; ?>>홍보관리<br>
									<input type="checkbox" size="20" name="permi[]" id="05-11" onClick="checkOneday2(this);" value="05-11" <? if($tmp_permi["05-11"]==true || $sub_mode == "insert") echo "checked"; ?>>메일발송폼작성<br>
									<input type="checkbox" size="20" name="permi[]" id="05-12" onClick="checkOneday2(this);" value="05-12" <? if($tmp_permi["05-12"]==true || $sub_mode == "insert") echo "checked"; ?>>SMS메일링<br>
								</td>
								<td></td>
								<td></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="25" class="t_name">메모</td>
					<td class="t_value" colspan="3"><textarea name="descript" rows="5" cols="90" class="textarea" style="width:100%"><?=$admin_info->descript ?></textarea></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<br>

<table align="center" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<input type="image" src="../image/btn_confirm_l.gif">&nbsp; 
			<img src="../image/btn_list_l.gif" style="cursor:hand" onclick="document.location='shop_admin.php';">
		</td>
	</tr>
</form>
</table>

<? include "../footer.php"; ?>