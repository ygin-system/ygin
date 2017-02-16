//daAlert v3.1 http://cvek.ru
function daAlert(titleHTML, contentHTML, buttonText, messageClass) {
  var alertHTML = "";
  alertHTML += '<div id="daAlert" class="modal fade">';
  alertHTML += '  <div class="modal-dialog">';
  alertHTML += '    <div class="modal-content">';
  alertHTML += '      <div class="modal-body '+messageClass+'">';
  alertHTML += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
  if (titleHTML){
    alertHTML += '        <h4 class="modal-title" style="margin-bottom:10px">'+titleHTML+'</h4>';
  }
  alertHTML += '        <div>'+contentHTML+'</div>';
  alertHTML += '      </div>';
  alertHTML += '      <div class="modal-footer '+messageClass+'" style="margin-top:0">';
  alertHTML += '        <button class="btn btn-primary" data-dismiss="modal">'+buttonText+'</button>';
  alertHTML += '      </div>';
  alertHTML += '    </div>';
  alertHTML += '  </div>';
  alertHTML += '</div>';
  $('#daAlert').remove();
  $('body').prepend(alertHTML);
  $("#daAlert").modal('show').alert();
}