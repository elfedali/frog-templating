document.addEventListener("DOMContentLoaded", function () {
  var textarea = document.getElementById("frog_description");
  var indicator = document.getElementById("frog_description_indicator");

  if (textarea) {
    var editor = CodeMirror.fromTextArea(textarea, {
      lineNumbers: true,
      mode: "yaml",
      theme: "default",
      indentWithTabs: false, // Use spaces instead of tabs
      indentUnit: 2, // Number of spaces for each indentation level
      extraKeys: {
        Tab: function (cm) {
          cm.replaceSelection("  ", "end"); // Inserts two spaces on Tab
        },
      },
    });

    editor.setSize("100%", "100%");

    editor.on("change", function (cm) {
      textarea.value = cm.getValue();
      var yamlContent = textarea.value;
      console.log(yamlContent);
      jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        data: {
          action: "validate_frog_yaml",
          yaml_content: yamlContent,
        },
        success: function (response) {
          indicator.innerHTML = response.data;
        },
      });
    });
  }
});
