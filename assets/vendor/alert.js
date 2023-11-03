// Comingsoon link
$('.coming-soon').click(function(){
	swal({
	  title: "Coming Soon",
	  text: "Fitur Sedang Dalam Pengembangan.",
	  type: "warning"
	});
	return false;
});
$('.not-allowed').click(function(){
	swal({
	  title: "Tidak Diizinkan",
	  text: "Hubungi admin, anda tidak dapat menggunakan fitur ini.",
	  type: "warning"
	});
	return false;
});