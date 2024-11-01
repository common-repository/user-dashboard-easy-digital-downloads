/*
* Edd User Dash
* since ver 1.0.0
*
*/

jQuery(document).ready(function () {
  jQuery(document).on('click', '.edd-user-dashboard .nav-tabs a[data-toggle="tab"]', function (event) {
	event.preventDefault();
	let $href = jQuery(this).attr('href');
    jQuery('.nav-tabs li').removeClass('active');
    jQuery(this).addClass('active');

    jQuery('.tab-content div').removeClass('active');
    jQuery($href).addClass('active');
  });
});

// console.log('test')