<?
	include "../../inc/common.inc"; 				// DB컨넥션, 접속자 파악
	include "../../inc/util.inc"; 					// 유틸 라이브러리
	include "../../inc/oper_info.inc"; 		// 운영 정보


    /* ============================================================================== */
    /* =   PAGE : 지불 요청 및 결과 처리 PAGE                                       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2006   KCP Inc.   All Rights Reserverd.                   = */
    /* ============================================================================== */


    // 테스트 체크
		if(!strcmp($oper_info->pay_test, "Y")) {
			$oper_info->pay_id = "T0007";
			$oper_info->pay_key = "3CRB7XHFjUp6fjf1FLEM.g6__";

		}
		if(!strcmp($site_cd, "T0000") || !strcmp($site_cd, "T0007")) {
			$payplus = "testpaygw.kcp.co.kr";
		} else {
			$payplus = "paygw.kcp.co.kr";
		}

?>
<?
    /* ============================================================================== */
    /* =   01. 지불 데이터 셋업 (업체에 맞게 수정)                                  = */
    /* = -------------------------------------------------------------------------- = */
    $g_conf_home_dir    = $DOCUMENT_ROOT."/oneday/kcp/payplus";   // BIN 절대경로 입력

    $g_conf_log_level   = "3";                                  // 변경불가
    $g_conf_pa_url  = $payplus;                    // real url : paygw.kcp.co.kr , test url : testpaygw.kcp.co.kr
    $g_conf_pa_port = "8090";                                   // 포트번호 , 변경불가
    $g_conf_mode    = 0;                                        // 변경불가

    require "pp_ax_hub_lib.php";                                // library [수정불가]
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   02. 지불 요청 정보 설정                                                  = */
    /* = -------------------------------------------------------------------------- = */
    $site_cd        = $_POST[  "site_cd"         ];             // 사이트 코드
    $site_key       = $_POST[  "site_key"        ];             // 사이트 키
    $req_tx         = $_POST[  "req_tx"          ];             // 요청 종류
    $cust_ip        = getenv(  "REMOTE_ADDR"     );             // 요청 IP
    $ordr_idxx      = $_POST[  "ordr_idxx"       ];             // 쇼핑몰 주문번호
    $good_name      = $_POST[  "good_name"       ];             // 상품명
    /* = -------------------------------------------------------------------------- = */
    $good_mny       = $_POST[  "good_mny"        ];             // 결제 총금액
    $tran_cd        = $_POST[  "tran_cd"         ];             // 처리 종류
    /* = -------------------------------------------------------------------------- = */
    $res_cd         = "";                                       // 응답코드
    $res_msg        = "";                                       // 응답메시지
    $tno            = $_POST[  "tno"             ];             // KCP 거래 고유 번호
    /* = -------------------------------------------------------------------------- = */
    $buyr_name      = $_POST[  "buyr_name"       ];             // 주문자명
    $buyr_tel1      = $_POST[  "buyr_tel1"       ];             // 주문자 전화번호
    $buyr_tel2      = $_POST[  "buyr_tel2"       ];             // 주문자 핸드폰 번호
    $buyr_mail      = $_POST[  "buyr_mail"       ];             // 주문자 E-mail 주소
    /* = -------------------------------------------------------------------------- = */
    $bank_name      = "";                                       // 은행명
    $bank_issu      = $_POST[  "bank_issu"       ];             // 계좌이체 서비스사
    /* = -------------------------------------------------------------------------- = */
    $mod_type       = $_POST[  "mod_type"        ];             // 변경TYPE VALUE 승인취소시 필요
    $mod_desc       = $_POST[  "mod_desc"        ];             // 변경사유
    /* = -------------------------------------------------------------------------- = */
    $use_pay_method = $_POST[  "use_pay_method"  ];             // 결제 방법
    $bSucc          = "";                                       // 업체 DB 처리 성공 여부
    $acnt_yn        = $_POST[  "acnt_yn"         ];             // 상태변경시 계좌이체, 가상계좌 여부
    /* = -------------------------------------------------------------------------- = */
    $card_cd        = "";                                       // 신용카드 코드
    $card_name      = "";                                       // 신용카드 명
    $app_time       = "";                                       // 승인시간 (모든 결제 수단 공통)
    $app_no         = "";                                       // 신용카드 승인번호
    $noinf          = "";                                       // 신용카드 무이자 여부
    $quota          = "";                                       // 신용카드 할부개월
    $bankname       = "";                                       // 은행명
    $depositor      = "";                                       // 입금 계좌 예금주 성명
    $account        = "";                                       // 입금 계좌 번호
    /* = -------------------------------------------------------------------------- = */
    $escw_used      = $_POST[  "escw_used"       ];             // 에스크로 사용 여부
    $pay_mod        = $_POST[  "pay_mod"         ];             // 에스크로 결제처리 모드
    $deli_term      = $_POST[  "deli_term"       ];             // 배송 소요일
    $bask_cntx      = $_POST[  "bask_cntx"       ];             // 장바구니 상품 개수
    $good_info      = $_POST[  "good_info"       ];             // 장바구니 상품 상세 정보
    $rcvr_name      = $_POST[  "rcvr_name"       ];             // 수취인 이름
    $rcvr_tel1      = $_POST[  "rcvr_tel1"       ];             // 수취인 전화번호
    $rcvr_tel2      = $_POST[  "rcvr_tel2"       ];             // 수취인 휴대폰번호
    $rcvr_mail      = $_POST[  "rcvr_mail"       ];             // 수취인 E-Mail
    $rcvr_zipx      = $_POST[  "rcvr_zipx"       ];             // 수취인 우편번호
    $rcvr_add1      = $_POST[  "rcvr_add1"       ];             // 수취인 주소
    $rcvr_add2      = $_POST[  "rcvr_add2"       ];             // 수취인 상세주소
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   03. 인스턴스 생성 및 초기화 (단, 계좌이체 및 교통카드는 제외)            = */
    /* = -------------------------------------------------------------------------- = */
    /* =       결제에 필요한 인스턴스를 생성하고 초기화 합니다. 단, 계좌이체 및     = */
    /* =       교통카드의 경우는 결제 모듈을 통한 전문통신을 하지 않기 때문에       = */
    /* =       결제 모듈을 사용하는 과정에서 제외됩니다.                            = */
    /* = -------------------------------------------------------------------------- = */
    if ( ( $use_pay_method != "010000000000" && $use_pay_method != "0000000000100" ) || $bank_issu == "SCMF" )    // 계좌이체, 교통카드를 제외한 모든 결제수단의 경우, 또는 모바일안심결제의 경우
    {
        $c_PayPlus = new C_PP_CLI;
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   04. 처리 요청 정보 설정, 실행                                            = */
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   04-1. 승인 요청                                                          = */
    /* = -------------------------------------------------------------------------- = */
        if ( $req_tx == "pay" )
        {
            $c_PayPlus->mf_set_encx_data( $_POST[ "enc_data" ] , $_POST[ "enc_info" ] );
        }

    /* = -------------------------------------------------------------------------- = */
    /* =   04-2. 매입 요청                                                          = */
    /* = -------------------------------------------------------------------------- = */
        else if ( $req_tx == "mod" )
        {
            $tran_cd = "00200000";

            $c_PayPlus->mf_set_modx_data( "tno",        $tno            );          // KCP 원거래 거래번호
            $c_PayPlus->mf_set_modx_data( "mod_type",   $mod_type       );          // 원거래 변경 요청 종류
            $c_PayPlus->mf_set_modx_data( "mod_ip",     $cust_ip        );          // 변경 요청자 IP
            $c_PayPlus->mf_set_modx_data( "mod_desc",   $mod_desc       );          // 변경 사유
        }

    /* = -------------------------------------------------------------------------- = */
    /* =   04-3. 에스크로 상태변경 요청                                              = */
    /* = -------------------------------------------------------------------------- = */
        else if ( $req_tx == "mod_escrow" )
        {
            $tran_cd = "00200000";

            $c_PayPlus->mf_set_modx_data( "tno",        $tno            );          // KCP 원거래 거래번호
            $c_PayPlus->mf_set_modx_data( "mod_type",   $mod_type       );          // 원거래 변경 요청 종류
            $c_PayPlus->mf_set_modx_data( "mod_ip",     $cust_ip        );          // 변경 요청자 IP
            $c_PayPlus->mf_set_modx_data( "mod_desc",   $mod_desc       );          // 변경 사유
            if ($mod_type == "STE1")                                                // 상태변경 타입이 [배송요청]인 경우
            {
                $c_PayPlus->mf_set_modx_data( "deli_numb",   $_POST[ "deli_numb" ] );          // 운송장 번호
                $c_PayPlus->mf_set_modx_data( "deli_corp",   $_POST[ "deli_corp" ] );          // 택배 업체명
            }
            else if ($mod_type == "STE2" || $mod_type == "STE4")                    // 상태변경 타입이 [즉시취소] 또는 [취소]인 계좌이체, 가상계좌의 경우
            {
                if ($acnt_yn == "Y")
                {
                    $c_PayPlus->mf_set_modx_data( "refund_account",   $_POST[ "refund_account" ] );      // 환불수취계좌번호
                    $c_PayPlus->mf_set_modx_data( "refund_nm",        $_POST[ "refund_nm"      ] );      // 환불수취계좌주명
                    $c_PayPlus->mf_set_modx_data( "bank_code",        $_POST[ "bank_code"      ] );      // 환불수취은행코드
                }
            }
        }

    /* = -------------------------------------------------------------------------- = */
    /* =   04-4. 실행                                                               = */
    /* = -------------------------------------------------------------------------- = */
        if ( $tran_cd != "" )
        {
            $c_PayPlus->mf_do_tx( $trace_no,  $g_conf_home_dir, $site_cd,
                          $site_key,  $tran_cd,    "", $g_conf_pa_url,  $g_conf_pa_port,  "payplus_cli_slib",
                          $ordr_idxx, $cust_ip,    $g_conf_log_level, 0, $g_conf_mode );

            $tno       = $c_PayPlus->mf_get_res_data( "tno" );
        }
        else
        {
            $c_PayPlus->m_res_cd  = "9562";
            $c_PayPlus->m_res_msg = "연동 오류";
        }

        $res_cd    = $c_PayPlus->m_res_cd;
        $res_msg   = $c_PayPlus->m_res_msg;
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   05. 승인 결과 처리                                                       = */
    /* = -------------------------------------------------------------------------- = */

        if ( $req_tx == "pay" )
        {
            if( $res_cd == "0000" )
            {
							// 주문정보
							$sql = "SELECT * FROM wiz_dayorder WHERE orderid = '$ordr_idxx'";
							$result = mysql_query($sql) or error(mysql_error());
							$order_info = mysql_fetch_object($result);
    /* = -------------------------------------------------------------------------- = */
    /* =   05-1. 신용카드 승인 결과 처리                                            = */
    /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "100000000000" )
                {
                    $card_cd          = $c_PayPlus->mf_get_res_data( "card_cd"   );  // 카드 코드
                    $card_name        = $c_PayPlus->mf_get_res_data( "card_name" );  // 카드 종류
                    $app_time         = $c_PayPlus->mf_get_res_data( "app_time"  );  // 승인 시간
                    $app_no           = $c_PayPlus->mf_get_res_data( "app_no"    );  // 승인 번호
                    $noinf            = $c_PayPlus->mf_get_res_data( "noinf"     );  // 무이자 여부 ( 'Y' : 무이자 )
                    $quota            = $c_PayPlus->mf_get_res_data( "quota"     );  // 할부 개월

			     					////////////////////////////////////////////////////////////////////////////
			     				 	// 주문정보 업데이트
			     				 	////////////////////////////////////////////////////////////////////////////
			     				 	$_Payment[status] = "OY"; //결제상태
			     					$_Payment[orderid] = $ordr_idxx; //주문번호
			     					$_Payment[paymethod] = "PC"; //결제종류
			     					$_Payment[ttno] = $tno; //거래번호
			     					$_Payment[bankkind] = ""; //은행코드(가상계좌일경우)
			     					$_Payment[accountno] = ""; //계좌번호(가상계좌일경우)
			     					$_Payment[pgname] = "kcp";//PG사 종류
			     					$_Payment[tprice]		=	$good_mny; //결제금액

			     					//결제처리(상태변경,주문 업데이트)
			     					Exe_payment2($_Payment);
			     					// 적립금 처리 : 적립금 사용시 적립금 감소
			     					Exe_reserve();
			     					// 재고처리
			     					Exe_stock();
			     					// 장바구니 삭제
			     			    Exe_delbasket();
                }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-2. 가상계좌 승인 결과 처리                                            = */
    /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "001000000000" )
                {
                    $bankname         = $c_PayPlus->mf_get_res_data( "bankname"  );  // 입금할 은행 이름
                    $depositor        = $c_PayPlus->mf_get_res_data( "depositor" );  // 입금할 계좌 예금주
                    $account          = $c_PayPlus->mf_get_res_data( "account"   );  // 입금할 계좌 번호
	
		                $Payment[status] = "OR"; //결제상태
										$Payment[orderid] = $ordr_idxx; //주문번호
										$Payment[paymethod] = "PV"; //결제종류
										$Payment[ttno] = $tno; //승인번호
										$Payment[bankkind] = $bankname; //은행코드(가상계좌일경우)
										$Payment[accountno] = $account; //계좌번호(가상계좌일경우)
										$Payment[accountname] = $account; //예금주(가상계좌일경우)
										$Payment[pgname] = "kcp";//PG사 종류
										$Payment[es_check]	= $oper_info->pay_escrow;//에스크로 사용여부
										$Payment[es_stats]	= "IN";//에스크로 상태(데이콤으로 기본정보 발송)
										$Payment[tprice]		=	$good_mny; //결제금액
										//결제처리(상태변경,주문 업데이트)
			     					Exe_payment2($Payment);
			     					// 적립금 처리 : 적립금 사용시 적립금 감소
			     					Exe_reserve();
			     					// 재고처리
			     					//Exe_stock();
			     					// 장바구니 삭제
			   			    	Exe_delbasket();
			           }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-3. 휴대폰 승인 결과 처리                                              = */
    /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "000010000000" )
                {
                    $app_time         = $c_PayPlus->mf_get_res_data( "hp_app_time"  );  // 승인 시간

                    $_Payment[status] = "OY"; //결제상태
										$_Payment[orderid] = $ordr_idxx; //주문번호
										$_Payment[paymethod] = "PH"; //결제종류
										$_Payment[ttno] = $app_time; //승인시간
										$_Payment[bankkind] = ""; //은행코드(가상계좌일경우)
										$_Payment[accountno] = ""; //계좌번호(가상계좌일경우)
										$_Payment[accountname] = ""; //예금주(가상계좌일경우)
										$_Payment[pgname] = "kcp";//PG사 종류
										$_Payment[tprice]		=	$good_mny; //결제금액
										//결제처리(상태변경,주문 업데이트)
			     					Exe_payment2($_Payment);
			     					// 적립금 처리 : 적립금 사용시 적립금 감소
			     					Exe_reserve();
			     					// 재고처리
			     					Exe_stock();
			     					// 장바구니 삭제
			     			    Exe_delbasket();
                }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-4. 카드사 포인트 승인 결과 처리                                       = */
    /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "000100000000" )
                {
                    $app_time         = $c_PayPlus->mf_get_res_data( "app_time"  );  // 승인 시간
                }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-5. ARS 승인 결과 처리                                                 = */
    /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "000000000010" )
                {
                    $app_time         = $c_PayPlus->mf_get_res_data( "app_time"  );  // 승인 시간
                }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-6. 승인 결과를 업체 자체적으로 DB 처리 작업하시는 부분입니다.         = */
    /* = -------------------------------------------------------------------------- = */
    /* =         승인 결과를 DB 작업 하는 과정에서 정상적으로 승인된 건에 대해      = */
    /* =         DB 작업을 실패하여 DB update 가 완료되지 않은 경우, 자동으로       = */
    /* =         승인 취소 요청을 하는 프로세스가 구성되어 있습니다.                = */
    /* =         DB 작업이 실패 한 경우, bSucc 라는 변수(String)의 값을 "false"     = */
    /* =         로 세팅해 주시기 바랍니다. (DB 작업 성공의 경우에는 "false" 이외의 = */
    /* =         값을 세팅하시면 됩니다.)                                           = */
    /* = -------------------------------------------------------------------------- = */





                	$bSucc = "";             // DB 작업 실패일 경우 "false" 로 세팅

    /* = -------------------------------------------------------------------------- = */
    /* =   05-7. DB 작업 실패일 경우 자동 승인 취소                                 = */
    /* = -------------------------------------------------------------------------- = */
                if ( $bSucc == "false" )
                {
                    $c_PayPlus->mf_clear();

                    $tran_cd = "00200000";

                    $c_PayPlus->mf_set_modx_data( "tno",      $tno                  );         // KCP 원거래 거래번호
                    $c_PayPlus->mf_set_modx_data( "mod_type", "STE2"                );         // 원거래 변경 요청 종류
                    $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip              );         // 변경 요청자 IP
                    $c_PayPlus->mf_set_modx_data( "mod_desc", "결과 처리 오류 - 자동 취소" );  // 변경 사유

                    $c_PayPlus->mf_do_tx( $tno,  $g_conf_home_dir, $site_cd,
                                          $site_key,  $tran_cd,    "",
                                          $g_conf_pa_url,  $g_conf_pa_port,  "payplus_cli_slib",
                                          $ordr_idxx, $cust_ip,    $g_conf_log_level,
                                          0,    $g_conf_mode );

                    $res_cd  = $c_PayPlus->m_res_cd;
                    $res_msg = $c_PayPlus->m_res_msg;
                }

            }    // End of [res_cd = "0000"]

    /* = -------------------------------------------------------------------------- = */
    /* =   05-8. 승인 실패를 업체 자체적으로 DB 처리 작업하시는 부분입니다.         = */
    /* = -------------------------------------------------------------------------- = */
            else
            {
            }
        }
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   06. 매입 결과 처리                                                       = */
    /* = -------------------------------------------------------------------------- = */
        else if ( $req_tx == "mod" )
        {
        }
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   07. 에스크로 상태변경 결과 처리                                          = */
    /* = -------------------------------------------------------------------------- = */
        else if ( $req_tx == "mod_escrow" )
        {
        }
    } // End of Process
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   08. 계좌이체 및 교통카드 결과 처리 (전문통신을 하지 않는 경우)           = */
    /* = -------------------------------------------------------------------------- = */
    else
    {
        $res_cd    = $_POST[ "res_cd"  ];                       // 응답코드
        $res_msg   = $_POST[ "res_msg" ];                       // 응답메시지

        if ( $use_pay_method == "010000000000" )
        {
            $bank_name = $_POST[ "bank_name" ];                 // 은행명

            $Payment[status] = "OY"; //결제상태
						$Payment[orderid] = $ordr_idxx; //주문번호
						$Payment[paymethod] = "PN"; //결제종류
						$Payment[ttno] = $tno; //승인번호
						$Payment[bankkind] = $bankname; //은행코드(입금한 은행명)
						$Payment[accountno] = ""; //계좌번호(가상계좌일경우)
						$Payment[accountname] = ""; //예금주(가상계좌일경우)
						$Payment[pgname] = "kcp";//PG사 종류
						$Payment[es_check]	= $oper_info->pay_escrow;//에스크로 사용여부
						$Payment[es_stats]	= "IN";//에스크로 상태(데이콤으로 기본정보 발송)
						$Payment[tprice]		=	$good_mny; //결제금액
						//결제처리(상태변경,주문 업데이트)
						Exe_payment2($Payment);
						// 적립금 처리 : 적립금 사용시 적립금 감소
						Exe_reserve();
						// 재고처리
						Exe_stock();
						// 장바구니 삭제
		    		Exe_delbasket();
        }
    }
    /* ============================================================================== */


if($res_cd=="0000"){

		$sql = "select * from wiz_basket where orderid = '$ordr_idxx'";
		$result = mysql_query($sql);
		while($basket_info = mysql_fetch_array($result)){
			$optcode = explode("^",$basket_info[optcode]);
			$sql = "select * from wiz_dayproduct where prdcode='$basket_info[prdcode]'";
			$stm = mysql_query($sql)or die($sql);
			$prdinfo=mysql_fetch_array($stm);
			$arrOptCode = explode("^",$prdinfo[optcode]);
			$arrOptValue = explode("^^",$prdinfo[optvalue]);
			$arrAmount = explode(",",$basket_info[amount]);
			$changeOptValue = "";

			for($i=0; $i<count($arrOptValue); $i++){
				$arrOptValue2 = explode("^",$arrOptValue[$i]);
				if($arrOptValue2[0] != ""){
					if($arrOptCode[$i]==$optcode[0]){
							if($arrOptValue2[2] != 0){
								$changeOptValue .= $arrOptValue2[0]."^".$arrOptValue2[1]."^".($arrOptValue2[2]-$basket_info[amount])."^".$arrOptValue2[3]."^".$arrOptValue2[4]."^^";
								//echo $arrAmount[$i]."<br />";
							}else{
								$changeOptValue .= $arrOptValue2[0]."^".$arrOptValue2[1]."^".($arrOptValue2[2])."^".$arrOptValue2[3]."^".$arrOptValue2[4]."^^";
							}
					}else{
						$changeOptValue .= $arrOptValue2[0]."^".$arrOptValue2[1]."^".($arrOptValue2[2])."^".$arrOptValue2[3]."^".$arrOptValue2[4]."^^";
					}
				}
			}
			$sql = "update wiz_dayproduct set optvalue = '$changeOptValue' where prdcode='$basket_info[prdcode]'";
			mysql_query($sql)or die($sql);
		}


}


    /* ============================================================================== */
    /* =   09. 폼 구성 및 결과페이지 호출                                           = */
    /* ============================================================================== */




?>
    <html>
    <head>
    <script>
        function goResult()
        {
            var openwin = window.open( 'proc_win.html', 'proc_win', '' );
            document.pay_info.submit();
            openwin.close();
        }
    </script>
    </head>
    <body onload="goResult()">
	<body>
    <form name="pay_info" method="post" action="/oneday/order_ok.php">
        <input type="hidden" name="req_tx"            value="<?=$req_tx?>">            <!-- 요청 구분 -->
        <input type="hidden" name="use_pay_method"    value="<?=$use_pay_method?>">    <!-- 사용한 결제 수단 -->
        <input type="hidden" name="bSucc"             value="<?=$bSucc?>">             <!-- 쇼핑몰 DB 처리 성공 여부 -->

        <input type="hidden" name="rescode"            value="<?=$res_cd?>">            <!-- 결과 코드 -->
        <input type="hidden" name="resmsg"           value="<?=$res_cd.':'.$res_msg?>">           <!-- 결과 메세지 -->
        <input type="hidden" name="orderid"         value="<?=$ordr_idxx?>">         <!-- 주문번호 -->
        <input type="hidden" name="tno"               value="<?=$tno?>">               <!-- KCP 거래번호 -->
        <input type="hidden" name="good_mny"          value="<?=$good_mny?>">          <!-- 결제금액 -->
        <input type="hidden" name="good_name"         value="<?=$good_name?>">         <!-- 상품명 -->
        <input type="hidden" name="buyr_name"         value="<?=$buyr_name?>">         <!-- 주문자명 -->
        <input type="hidden" name="buyr_tel1"         value="<?=$buyr_tel1?>">         <!-- 주문자 전화번호 -->
        <input type="hidden" name="buyr_tel2"         value="<?=$buyr_tel2?>">         <!-- 주문자 휴대폰번호 -->
        <input type="hidden" name="buyr_mail"         value="<?=$buyr_mail?>">         <!-- 주문자 E-mail -->

        <input type="hidden" name="escw_used"         value="<?=$escw_used?>">         <!-- 에스크로 사용 여부 -->
        <input type="hidden" name="pay_mod"           value="<?=$pay_mod?>">           <!-- 에스크로 결제처리 모드 -->
        <input type="hidden" name="deli_term"         value="<?=$deli_term?>">         <!-- 배송 소요일 -->
        <input type="hidden" name="bask_cntx"         value="<?=$bask_cntx?>">         <!-- 장바구니 상품 개수 -->
        <input type="hidden" name="good_info"         value="<?=$good_info?>">         <!-- 장바구니 상품 상세 정보 -->
        <input type="hidden" name="rcvr_name"         value="<?=$rcvr_name?>">         <!-- 수취인 이름 -->
        <input type="hidden" name="rcvr_tel1"         value="<?=$rcvr_tel1?>">         <!-- 수취인 전화번호 -->
        <input type="hidden" name="rcvr_tel2"         value="<?=$rcvr_tel2?>">         <!-- 수취인 휴대폰번호 -->
        <input type="hidden" name="rcvr_mail"         value="<?=$rcvr_mail?>">         <!-- 수취인 E-Mail -->
        <input type="hidden" name="rcvr_zipx"         value="<?=$rcvr_zipx?>">         <!-- 수취인 우편번호 -->
        <input type="hidden" name="rcvr_add1"         value="<?=$rcvr_add1?>">         <!-- 수취인 주소 -->
        <input type="hidden" name="rcvr_add2"         value="<?=$rcvr_add2?>">         <!-- 수취인 상세주소 -->

        <input type="hidden" name="card_cd"           value="<?=$card_cd?>">           <!-- 카드코드 -->
        <input type="hidden" name="card_name"         value="<?=$card_name?>">         <!-- 카드명 -->
        <input type="hidden" name="app_time"          value="<?=$app_time?>">          <!-- 승인시간 -->
        <input type="hidden" name="app_no"            value="<?=$app_no?>">            <!-- 승인번호 -->
        <input type="hidden" name="quota"             value="<?=$quota?>">             <!-- 할부개월 -->

        <input type="hidden" name="bank_name"         value="<?=$bank_name?>">         <!-- 은행명 -->

        <input type="hidden" name="bankname"          value="<?=$bankname?>">          <!-- 입금 은행 -->
        <input type="hidden" name="depositor"         value="<?=$depositor?>">         <!-- 입금계좌 예금주 -->
        <input type="hidden" name="account"           value="<?=$account?>">           <!-- 입금계좌 번호 -->

    </form>
    </body>
    </html>

