$(function() {
  'use strict'
 $(":input").inputmask();


  var colors = {
    primary        : "#ade0f2",
    secondary      : "#7987a1",
    success        : "#05a34a",
    info           : "#66d1d1",
    warning        : "#fbbc06",
    danger         : "#ff3366",
    light          : "#e9ecef",
    dark           : "#060c17",
    muted          : "#7987a1",
    gridBorder     : "rgba(77, 138, 240, .15)",
    bodyColor      : "#000",
    cardBg         : "#fff"
  }

  var fontFamily = "'Roboto', Helvetica, sans-serif"

  // Date Picker
  if($('#dashboardDate').length) {
    
    $('#dashboardDate').datepicker({
      closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    });
  }
  // Date Picker - END





 if ($('#apexBar').length) {
    var options = {
      chart: {
        type: 'bar',
        height: '320',
        parentHeightOffset: 0,
        foreColor: colors.bodyColor,
        background: colors.cardBg,
        toolbar: {
          show: false
        },
      },
      theme: {
        mode: 'light'
      },
      tooltip: {
        theme: 'light'
      },
      colors: [colors.primary],    
      grid: {
        padding: {
          bottom: -4
        },
        borderColor: colors.gridBorder,
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      series: [{
        name: 'Usuarios',
        data: [30,40,45,50,49,60,70,0,125,20,80,40]
      }],
      xaxis: {
        type: 'txt',
        categories: ['Ene 2022','Feb 2022','Mar 2022','Abr 2022','May 2022','Jun 2022','Jul 2022', 'Ago 2022','Sep 2022','Oct 2022','Nov 2022','Dic 2022'],
        axisBorder: {
          color: colors.gridBorder,
        },
        axisTicks: {
          color: colors.gridBorder,
        },
      },
      legend: {
        show: true,
        position: "top",
        horizontalAlign: 'center',
        fontFamily: fontFamily,
        itemMargin: {
          horizontal: 8,
          vertical: 0
        },
      },
      stroke: {
        width: 0
      },
      plotOptions: {
        bar: {
          borderRadius: 4
        }
      }
    }
    
    var apexBarChart = new ApexCharts(document.querySelector("#apexBar"), options);
    apexBarChart.render();
  }
  // Apex Bar chart end

 $.validator.setDefaults({
    submitHandler: function() {
      alert("submitted!");
    }
  });
  $(function() {
    // validate signup form on keyup and submit
    $("#signupForm").validate({
      rules: {
        name: {
          required: true,
          minlength: 3
        },
        last_name: {
          required: true,
          minlength: 3
        },
        dni: {
          required: true,
          number:  true,
          minlength: 8,
        },
         phone: {
          required: true,
          number:  true,
          minlength: 9,
        },
        email: {
          required: true,
          email: true
        },
        
        gender_radio: {
          required: true
        },
        country: {
          required: true
        },
        state: {
          required: true
        },
        channel_comunication: {
          required: true
        },
        date_birth:{
          required: true
        },
        address:{
          required: true
        },
       
        terms_agree: "required"
      },
      messages: {
        name: {
          required: "Ingrese sus nombres",
          minlength: "Ingrese al menos 3 caracteres"
        },
          last_name: {
          required: "Ingrese sus apellidos",
          minlength: "Ingrese al menos 3 caracteres"
        },
         dni: {
          required: "Ingrese su DnI",
          number:  "Ingrese sólo números",
          minlength: "Mínimo 8 caracteres",
        },
         phone: {
          required: "Ingrese su DnI",
          number:  "Ingrese sólo números",
          minlength: "Mínimo 9 caracteres",
        },
        email: "Ingrese un correo válido",
         date_birth: "Ingrese su fecha de nacimiento",
         address: "Ingrese su dirección",
          country: "Ingrese su nacionalidad",
           state: "Ingrese su lugar de nacimiento",
        
        channel_comunication: "Elige por cual canal llegó el cliente",
        gender_radio: "Seleccione el género",
        
        
        terms_agree: "Acepte los términos"
      },
      errorPlacement: function(error, element) {
        error.addClass( "invalid-feedback" );

        if (element.parent('.input-group').length) {
          error.insertAfter(element.parent());
        }
        else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
          error.insertAfter(element.parent().parent());
        }
        else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
          error.appendTo(element.parent().parent());
        }
        else {
          error.insertAfter(element);
        }
      },
      highlight: function(element, errorClass) {
        if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
          $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
        }
      },
      unhighlight: function(element, errorClass) {
        if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
          $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
        }
      }
    });
  });



});