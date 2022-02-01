function deleteRow(r) {
  var i = r.parentNode.parentNode.rowIndex;

  if (confirm("Have you handled this?")) {
    document.getElementById("msgTable").deleteRow(i);
  }
}
