/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Andrew Stromnov (stromnov@gmail.com). */
( function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define( [ "../widgets/datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}( function( datepicker ) {

datepicker.regional.ru = {
	closeText: "�������",
	prevText: "&#x3C;����",
	nextText: "����&#x3E;",
	currentText: "�������",
	monthNames: [ "������","�������","����","������","���","����",
	"����","������","��������","�������","������","�������" ],
	monthNamesShort: [ "���","���","���","���","���","���",
	"���","���","���","���","���","���" ],
	dayNames: [ "�����������","�����������","�������","�����","�������","�������","�������" ],
	dayNamesShort: [ "���","���","���","���","���","���","���" ],
	dayNamesMin: [ "��","��","��","��","��","��","��" ],
	weekHeader: "���",
	dateFormat: "dd.mm.yy",
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: "" };
datepicker.setDefaults( datepicker.regional.ru );

return datepicker.regional.ru;

} ) );