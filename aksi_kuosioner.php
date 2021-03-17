<link href="css/bootstrap.min.css" rel="stylesheet">
<?php
error_reporting(0);
include "koneksi.php";
include "fungsi/fungsi_indotgl.php";
$companyName	= $_POST[companyName];
$companyProduct = $_POST[companyProduct];
$companyAddress	= $_POST[companyAddress1];
$companyPhone	= $_POST[companyPhone];
$companyFax		= $_POST[companyHp];
$companyPF		= $companyPhone." ".$companyFax;
$suggestion		= $_POST[suggestion];
$agreeCity		= $_POST[agreeCity];
$date			= date('Y-m-d');
$companyId = date('Ymd his');

$no_hitung = 1;
$sql_hitung = mysqli_query($conn ,"SELECT * FROM tgroup");
while($data_hitung = mysqli_fetch_array($sql_hitung)){
	$id_hitung = $data_hitung[groupId];		
	$hasil_hitung = mysqli_query($conn , "SELECT * FROM tdescription, tgroup WHERE tdescription.groupId = '$id_hitung' AND tdescription.groupId = tgroup.groupId ORDER BY tgroup.groupId");
	$i_hitung = 1;
	while ($r_hitung = mysqli_fetch_array($hasil_hitung)){
		$id_hitung = $data_hitung[groupId];
		$asfa_hitung = $_POST['asfa'.$i_hitung.$id_hitung];
		if (empty($asfa_hitung)){
			echo "<script lang=javascript>
		 		window.alert('Anda belum mengisi kuisioner atau ada kuisioner yang belum terisi..!');
		 		history.back();
		 		</script>";
  			exit;
		}
		
		$i_hitung++;
	}
	echo "<br>";
	$no_hitung++;
}

if (empty($companyName)){
	echo "<script lang=javascript>
		 		window.alert('Isi Nama Anda');
		 		history.back();
		 		</script>";
  			exit;
}

elseif (empty($companyAddress)){
	echo "<script lang=javascript>
		 		window.alert('Isi Alamat Anda');
		 		history.back();
		 		</script>";
  			exit;
}



else{
	$no = 1;
	$sql = mysqli_query($conn , "SELECT * FROM tgroup");
	mysqli_query($conn , "INSERT INTO tcompany(companyId,companyName,companyAddress,dateSurvey,suggestion,product)
	VALUES('$companyId','$companyName','$companyAddress','$date','$suggestion','$companyProduct')");
	while($data = mysqli_fetch_array($sql)){
		$id = $data[groupId];		
		$hasil = mysqli_query($conn , "SELECT * FROM tdescription, tgroup WHERE tdescription.groupId = '$id' AND tdescription.groupId = tgroup.groupId ORDER BY tgroup.groupId");
		$i = 1;
		while ($r = mysqli_fetch_array($hasil)){
			$id = $data[groupId];
			$asfa = $_POST['asfa'.$i.$id];
			// echo "$i $asfa<br>";
			if ($asfa == 'A'){
				mysqli_query($conn , "INSERT INTO tanswer (descriptionId,groupId,companyId,jawaban,jawabanA,jawabanB,jawabanC,jawabanD,jawabanE) 
				VALUES('$r[descriptionId]','$r[groupId]','$companyId','$asfa','1','0','0','0','0')");
			}	
			elseif($asfa == 'B'){
				mysqli_query($conn , "INSERT INTO tanswer (descriptionId,groupId,companyId,jawaban,jawabanA,jawabanB,jawabanC,jawabanD,jawabanE) 
				VALUES('$r[descriptionId]','$r[groupId]','$companyId','$asfa','0','1','0','0','0')");
			}
			elseif($asfa == 'C'){
				mysqli_query($conn , "INSERT INTO tanswer (descriptionId,groupId,companyId,jawaban,jawabanA,jawabanB,jawabanC,jawabanD,jawabanE) 
				VALUES('$r[descriptionId]','$r[groupId]','$companyId','$asfa','0','0','1','0','0')");
			}
			elseif($asfa == 'D'){
				mysqli_query($conn , "INSERT INTO tanswer (descriptionId,groupId,companyId,jawaban,jawabanA,jawabanB,jawabanC,jawabanD,jawabanE) 
				VALUES('$r[descriptionId]','$r[groupId]','$companyId','$asfa','0','0','0','1','0')");
			}
			else{
				mysqli_query($conn , "INSERT INTO tanswer (descriptionId,groupId,companyId,jawaban,jawabanA,jawabanB,jawabanC,jawabanD,jawabanE) 
				VALUES('$r[descriptionId]','$r[groupId]','$companyId','$asfa','0','0','0','0','0')");
			}
			$i++;
		}
		echo "<br>";
		$no++;
	}
	
	echo "<center><font face='Tahoma' size='2'>
			Pengunjung yang terhormat,<br><br>
			Terima kasih atas waktu yang telah diluangkan untuk melengkapi survey yang kami sediakan. <br>
			Pendapat Anda sangat berarti bagi kami untuk meningkatkan pelayanan. <br><br>
			Hormat kami, <br><br>
			
			SMA Negeri 3 Purwokerto</font><br><br>
			<a href='./index.php'>
			<button  class='btn btn-lg btn-info'><span class='glyphicon glyphicon-arrow-left'></span> Kembali</button>
			</a>
			</center>";
	
}
	
?>