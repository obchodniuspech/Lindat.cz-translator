$( document ).ready(function() {


    $( "#translateButton" ).on( "click", function() {


      /* $.getJSON( './api/translate/uk/cs/'+$( "#textFrom" ).val(), {
        text: $( "#textFrom" ).val(),
        format: "json",
        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
            //$('#loader').removeClass('hidden')
            $( "#translation" ).html("loading....");
        },
      }) */

      var url = './api/translate/'+$( "#langFrom" ).val()+'/'+$( "#langTo" ).val()+'/'+$( "#storing" ).val()+'/'+$( "#textFrom" ).val();
      $.ajax({
        method: "GET",
        url: url,
        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
            //$('#loader').removeClass('hidden')
            $( "#translation" ).html("loading....");
        },
        data: { from: "uk", to: "cs",text: $( "#textFrom" ).val() }
      })
        .done(function( data ) {
            //alert(data);
          $( "#translation" ).html(data);
          $( "#translationSaveFromText" ).val($( "#textFrom" ).val());
        });



    });

    $( "#translateSwitchSides" ).on( "click", function() {
            //https://stackoverflow.com/questions/16351910/how-to-swap-the-options-of-two-select-boxes
            var v1 = $('#langFrom').val(),
                v2 = $('#langTo').val();
            $('#langFrom').val(v2);
            $('#langTo').val(v1);

    });

    $( "#translateStar" ).on( "click", function() {
           var actualClass = $('#translateStar').attr('class');
           //alert(actualClass);
           if (actualClass==="bi bi-star") {
               $('#translateStar').removeClass('bi bi-star');
               $('#translateStar').addClass('bi bi-star-fill');
               saveFavourite();
           }
           else {
               $('#translateStar').removeClass('bi bi-star-fill');
               $('#translateStar').addClass('bi bi-star');
               UnSaveFavourite();
           }

    });

    $( "#idoagree" ).on( "click", function() {

            if ($('#idoagree').is(":checked"))
            {
              var storeSetting = "true";
              $('#storing').val("true");
            }
            else {
                var storeSetting = "false";
                $('#storing').val("false");
            }
           var url = './api/saveSettings/'+storeSetting;

      $.ajax({
        method: "GET",
        url: url,
      })
        .done(function( data ) {
            //alert(data);
          //$( "#translation" ).html(data);
        });

    });

    $( "#translateCopy" ).on( "click", function() {
           //alert(actualClass);
               $('#translateCopy').removeClass('bi bi-clipboard');
               $('#translateCopy').addClass('bi bi-clipboard-check-fill');
               setTimeout(function() {
                   $('#translateCopy').removeClass('bi bi-clipboard-check-fill');
                   $('#translateCopy').addClass('bi bi-clipboard');
               }, 2000);
    });



});


function saveFavourite() {
    //var url = './api/saveFavourite/';
    var url = './api/saveFavourite/'+$( "#langFrom" ).val()+'/'+$( "#langTo" ).val()+'/'+$( "#textFrom" ).val();

  $.ajax({
    method: "GET",
    url: url,
  })
    .done(function( data ) {
        //alert(data);
      //$( "#translation" ).html(data);
    });
}
function UnSaveFavourite() {
    //var url = './api/saveFavourite/';
    var url = './api/deleteFavourite/'+$( "#langFrom" ).val()+'/'+$( "#langTo" ).val()+'/'+$( "#textFrom" ).val();

  $.ajax({
    method: "GET",
    url: url,
  })
    .done(function( data ) {
        //alert(data);
      //$( "#translation" ).html(data);
    });
}

function swapByOptionValue( selector1, selector2 ) {
  var elem1 = document.querySelector(selector1),
      elem2 = document.querySelector(selector2),
      selectedOption1 = getSelectedOption( elem1 ),
      selectedOption2 = getSelectedOption( elem2 );
  setSelectedOption( elem1, selectedOption2 );
  setSelectedOption( elem2, selectedOption1 );
}


function copyToClipboard(element) {
    // Create temporary variable
    var $temp = $("<input>");
    $("body").append($temp);
    // Select all content from element
    $temp.val($(element).html()).select();
    // Copy selected content
    document.execCommand("copy");
    // Remove temporary variable
    $temp.remove();
}
