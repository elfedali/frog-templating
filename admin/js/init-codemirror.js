document.addEventListener("DOMContentLoaded", function () {
  var textarea = document.getElementById("frog_description");

  if (textarea) {
    CodeMirror.fromTextArea(textarea, {
      lineNumbers: true,
      mode: "yaml", // Choose a mode
      theme: "default", // Choose a theme or add custom styling
      // height
    });
  }
});
