<?

include "../inc/common.inc"; 			// DB���ؼ�, ������ �ľ�
include "../inc/oper_info.inc"; 		// � ����
include "../inc/util.inc";		      // ��ƿlib

if($prdcode == "") error("��ǰ�ڵ尡 �������ϴ�. �����ڿ��� �����ϼ���.");
if($amount == "" || $amount == "0") error("�ֹ������� �����ǰų� 0�Դϴ�.Ȯ�����ּ���.");
if($rece_name == "") error("�����ô� �� �̸��� �������ϴ�.");
if($rece_post == "" || $rece_post2 == "") error("�����ô� �� ������ȣ�� �������ϴ�.");
if($rece_address == "" || $rece_address2 == "") error("�����ô� �� �ּҰ� �������ϴ�.");
if($rece_tphone == "" || $rece_tphone2 == "" || $rece_tphone3 == "") error("�����ô� �� ��ȭ��ȣ�� �������ϴ�.");

$send_id = $wiz_session[id];
$reserve_use = $_POST["reserve_use"];

$send_post = $send_post."-".$send_post2;
$send_address = $send_address." ".$send_address2;
$send_tphone = $send_tphone."-".$send_tphone2."-".$send_tphone3;
$send_hphone = $send_hphone."-".$send_hphone2."-".$send_hphone3;

$rece_post = $rece_post."-".$rece_post2;
$rece_address = $rece_address." ".$rece_address2;
$rece_tphone = $rece_tphone."-".$rece_tphone2."-".$rece_tphone3;
$rece_hphone = $rece_hphone."-".$rece_hphone2."-".$rece_hphone3;

// �ֹ���ȣ
$orderid = date("ymdHis").rand(100,999);


// �ֹ����� ����(��ǰ����, ��ۺ�, ������, ��ü�����ݾ�)
$sql = "SELECT * FROM wiz_product WHERE prdcode='$prdcode'";
$bkresult = mysql_query($sql) or error(mysql_error());
while($bkinfo = mysql_fetch_array($bkresult)){
		$prd_price += ($bkinfo[sellprice]);
}


// ��ۺ�
$deliver_price = deliver_price($total_price, $oper_info);

// ��۹��
$deliver_method = $oper_info->del_method;

// ȸ������ [$discount_msg �޼��� ����]
$discount_price = level_discount($wiz_session[level],$prd_price);


// ��������� ����(������,���Ű��ݺ������� ����)
if($deliver_method == "DC" || $deliver_method == "DD"){
	$tmp_post = str_replace("-","",$rece_post);
	if($oper_info->del_extrapost1 <= $tmp_post && $tmp_post <= $oper_info->del_extrapost12) $deliver_price = $deliver_price + $oper_info->del_extraprice1;
	if($oper_info->del_extrapost2 <= $tmp_post && $tmp_post <= $oper_info->del_extrapost22) $deliver_price = $deliver_price + $oper_info->del_extraprice2;
	if($oper_info->del_extrapost3 <= $tmp_post && $tmp_post <= $oper_info->del_extrapost32) $deliver_price = $deliver_price + $oper_info->del_extraprice3;
}

$total_price = $prd_price + $deliver_price - $discount_price;



// �����ݻ��� ������ ����, �����ݰ���
if($oper_info->reserve_use == "Y" && $reserve_use > 0 && $wiz_session[id] != ""){

	// ȸ�������� ��������
	$sql = "SELECT SUM(reserve) AS reserve FROM wiz_reserve WHERE memid = '$wiz_session[id]'";
	$result = mysql_query($sql) or error(mysql_error());
	$mem_info = mysql_fetch_object($result);
	if($mem_info->reserve == "") $mem_info->reserve = 0;

	// ������ ���ݾ��� ���� �����ݺ��� ���ٸ�
	if($reserve_use > $mem_info->reserve){
		error("���������� ���� ������ �����ϴ�.");
	}else{
		$total_price = $total_price - $reserve_use;
	}

}

// �������
if($coupon_use != "" && $coupon_use > 0){
	$total_price = $total_price - $coupon_use;

}

// �ֹ����� ����
$sql = "INSERT INTO wiz_order(
				orderid,prdcode,amount,send_id,send_name,send_tphone,send_hphone,send_email,send_post,send_address,demand,message,cancelmsg,
				rece_name,rece_tphone,rece_hphone,rece_post,rece_address,pay_method,account_name,account,coupon_use,coupon_idx,reserve_use,
				reserve_price,deliver_method,deliver_price,deliver_num,discount_price,prd_price,total_price,status,order_date,
				pay_date,send_date,cancel_date,descript,tax_type
				)VALUES(
				'".$orderid."','".$prdcode."','".$amount."','".$send_id."', '".$send_name."', '".$send_tphone."', '".$send_hphone."', '".$send_email."', '".$send_post."', '".$send_address."', '".$demand."', '".$message."', '$cancelmsg ',
				'".$rece_name."', '".$rece_tphone."', '".$rece_hphone."', '".$rece_post."', '".$rece_address."',
				'".$pay_method."', '".$account_name."', '".$account."', '".$coupon_use."','".$coupon_idx."',
				'".$reserve_use."', '".$reserve_price."', '".$deliver_method."', '".$deliver_price."', '".$deliver_num."', '".$discount_price."','".$prd_price."', '".$total_price."',
				'".$status."', now(), '".$paydate."', '".$sendddate."', '".$canceldate."', '".$descript."','".$tax_type."')";

mysql_query($sql) or error(mysql_error());

$prd_info = "";

// �ֹ���ǰ ����
/*
$sql = "SELECT wb.*, wp.del_type, wp.del_price FROM wiz_basket_tmp as wb left join wiz_product as wp on wb.prdcode = wp.prdcode WHERE wb.uniq_id='".$_COOKIE["uniq_id"]."'";
$bkiresult = mysql_query($sql) or error(mysql_error());
while($bkirow = mysql_fetch_array($bkiresult)){
	$sql = "INSERT INTO wiz_basket(idx,orderid,prdcode,prdname,prdimg,prdprice,prdreserve,
				opttitle,optcode,opttitle2,optcode2,opttitle3,optcode3,
				opttitle4,optcode4,opttitle5,optcode5,opttitle6,optcode6,
				opttitle7,optcode7,amount,wdate,status,del_type,del_price
				)VALUES(
				'','".$orderid."','".$bkirow[prdcode]."','".$bkirow[prdname]."','".$bkirow[prdimg]."','".$bkirow[prdprice]."','".$bkirow[prdreserve]."',
	        '".$bkirow[opttitle]."','".$bkirow[optcode]."','".$bkirow[opttitle2]."','".$bkirow[optcode2]."','".$bkirow[opttitle3]."','".$bkirow[optcode3]."',
	        '".$bkirow[opttitle4]."','".$bkirow[optcode4]."','".$bkirow[opttitle5]."','".$bkirow[optcode5]."','".$bkirow[opttitle6]."','".$bkirow[optcode6]."',
	        '".$bkirow[opttitle7]."','".$bkirow[optcode7]."','".$bkirow[amount]."',now(),'','".$bkirow[del_type]."','".$bkirow[del_price]."')";
	mysql_query($sql) or error(mysql_error());

	$prd_info .= $bkirow[prdname]."^".$bkirow[prdprice]."^".$bkirow[amount]."^^";
}
*/
// ���ݰ�꼭 ����
if(!strcmp($oper_info->tax_use, "Y")) {
		
	//$supp_price = intval($total_price/1.1);
	$supp_price = ($total_price/1.1);
	$tax_price = $total_price - $supp_price;

	$sql = "INSERT INTO wiz_tax(orderid,com_num,com_name,com_owner,com_address,com_kind,com_class,com_tel,com_email,prd_info,supp_price,tax_price,tax_pub)
					VALUES ('".$orderid."','".$com_num."','".$com_name."','".$com_owner."','".$com_address."','".$com_kind."','".$com_class."','".$com_tel."','".$com_email."','".$prd_info."','".$supp_price."','".$tax_price."','N')";
	mysql_query($sql) or error(mysql_error());
	
}

//Header("location: http://".$HTTP_HOST."/shop/order_pay.php?orderid=".$orderid."&pay_method=".$pay_method);
Header("location: http://".$HTTP_HOST."/");
?>