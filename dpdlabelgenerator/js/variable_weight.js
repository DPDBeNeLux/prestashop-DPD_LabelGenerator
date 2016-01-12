$( document ).ready( function () {
  $('button[name=submitState]').each( function ( index, updateButton ) {
    var weightField = $('<input>').attr({
      type: 'hidden',
      name: 'parcelLabelWeight',
      id: 'parcelLabelWeight'
    }).appendTo(updateButton.closest('form'));
    
    updateButton.onclick = function ( e ) {
      if ($('#id_order_state').get(0).value == '3') {
        var inputWeight = prompt("Please enter parcel weight");
        weightField.get(0).value = inputWeight;
      }
    }
  });
});