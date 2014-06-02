//daAlert v3.0 http://cvek.ru
function daAlert(titleHTML, contentHTML, buttonText, messageClass) {
  var alertHTML = "";
  alertHTML += '<div id="daAlert" class="modal">';
  alertHTML += '    <div class="modal-dialog">';
  alertHTML += '        <div class="modal-content">';
  alertHTML += '            <div class="modal-body '+messageClass+'">';
  alertHTML += '                <button class="close" data-dismiss="modal">×</button>';
  alertHTML += '                <h3>'+titleHTML+'</h3>';
  alertHTML += '                <div style="margin-top:10px">'+contentHTML+'</div>';
  alertHTML += '            </div>';
  alertHTML += '            <div class="modal-footer '+messageClass+'">';
  alertHTML += '            <button class="btn btn-primary" data-dismiss="modal">'+buttonText+'</button>';
  alertHTML += '         </div>';
  alertHTML += '        </div>';
  alertHTML += '     </div>';
  alertHTML += '  </div>';
  $('#daAlert').remove();
  $('body').prepend(alertHTML);
  $("#daAlert").modal('show').alert();
}